<?php

namespace App\Http\Controllers;

use App\Exports\AttendanceReportExport;
use App\Exports\CommitteeReportExport;
use App\Exports\MeetingReportExport;
use App\Exports\MemberReportExport;
use App\Http\Requests\ReportRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function index()
    {
        return view('reports.index');
    }

    public function attendance(ReportRequest $request)
    {
        $filters = $request->validated();

        if (! Schema::hasTable('attendances')) {
            return view('reports.attendance', ['data' => collect(), 'chart' => []]);
        }

        $query = DB::table('attendances')->select('status', DB::raw('DATE(created_at) as day'), DB::raw('count(*) as total'));

        if (! empty($filters['from'])) {
            $query->whereDate('created_at', '>=', $filters['from']);
        }
        if (! empty($filters['to'])) {
            $query->whereDate('created_at', '<=', $filters['to']);
        }
        if (! empty($filters['committee_id'])) {
            // assumes attendances table has committee_id or can be joined via meeting
            if (Schema::hasColumn('attendances', 'committee_id')) {
                $query->where('committee_id', $filters['committee_id']);
            } else {
                $query->join('meetings', 'attendances.meeting_id', '=', 'meetings.id')
                    ->where('meetings.committee_id', $filters['committee_id']);
            }
        }
        if (! empty($filters['member_id'])) {
            $query->where('member_id', $filters['member_id']);
        }

        $data = $query->groupBy('day', 'status')->orderBy('day')->get();

        // prepare chart series (dates and counts per status)
        $dates = $data->pluck('day')->unique()->values()->toArray();
        $present = [];
        $absent = [];
        foreach ($dates as $d) {
            $present[] = $data->where('day', $d)->where('status', 'present')->first()->total ?? 0;
            $absent[] = $data->where('day', $d)->where('status', 'absent')->first()->total ?? 0;
        }

        if ($request->get('export') === 'excel') {
            return Excel::download(new AttendanceReportExport($filters), 'attendance_report.xlsx');
        }

        if ($request->get('export') === 'pdf') {
            $pdf = Pdf::loadView('reports.attendance_pdf', ['data' => $data, 'dates' => $dates, 'present' => $present, 'absent' => $absent, 'filters' => $filters]);
            return $pdf->download('attendance_report.pdf');
        }

        return view('reports.attendance', ['data' => $data, 'chart' => ['labels' => $dates, 'present' => $present, 'absent' => $absent], 'filters' => $filters]);
    }

    public function meetings(ReportRequest $request)
    {
        $filters = $request->validated();

        if (! Schema::hasTable('meetings')) {
            return view('reports.meetings', ['data' => collect(), 'chart' => []]);
        }

        $query = DB::table('meetings')->select(DB::raw('DATE(scheduled_at) as day'), 'status', DB::raw('count(*) as total'));

        if (! empty($filters['from'])) {
            $query->whereDate('scheduled_at', '>=', $filters['from']);
        }
        if (! empty($filters['to'])) {
            $query->whereDate('scheduled_at', '<=', $filters['to']);
        }
        if (! empty($filters['committee_id'])) {
            $query->where('committee_id', $filters['committee_id']);
        }

        $data = $query->groupBy('day', 'status')->orderBy('day')->get();

        $dates = $data->pluck('day')->unique()->values()->toArray();
        $counts = [];
        foreach ($dates as $d) {
            $counts[$d] = $data->where('day', $d)->sum('total');
        }

        if ($request->get('export') === 'excel') {
            return Excel::download(new MeetingReportExport($filters), 'meeting_report.xlsx');
        }
        if ($request->get('export') === 'pdf') {
            $pdf = Pdf::loadView('reports.meetings_pdf', ['data' => $data, 'dates' => $dates, 'counts' => $counts, 'filters' => $filters]);
            return $pdf->download('meeting_report.pdf');
        }

        return view('reports.meetings', ['data' => $data, 'chart' => ['labels' => array_values($dates), 'counts' => array_values($counts)], 'filters' => $filters]);
    }

    public function committees(ReportRequest $request)
    {
        $filters = $request->validated();

        if (! Schema::hasTable('committees')) {
            return view('reports.committees', ['data' => collect(), 'chart' => []]);
        }

        $query = DB::table('committees')->select('committees.id', 'committees.name', DB::raw('COUNT(committee_members.member_id) as member_count'))
            ->leftJoin('committee_members', 'committees.id', '=', 'committee_members.committee_id')
            ->groupBy('committees.id', 'committees.name');

        if (! empty($filters['committee_id'])) {
            $query->where('committees.id', $filters['committee_id']);
        }

        $data = $query->get();

        if ($request->get('export') === 'excel') {
            return Excel::download(new CommitteeReportExport($filters), 'committee_report.xlsx');
        }
        if ($request->get('export') === 'pdf') {
            $pdf = Pdf::loadView('reports.committees_pdf', ['data' => $data, 'filters' => $filters]);
            return $pdf->download('committee_report.pdf');
        }

        return view('reports.committees', ['data' => $data, 'chart' => ['labels' => $data->pluck('name')->toArray(), 'counts' => $data->pluck('member_count')->toArray()], 'filters' => $filters]);
    }

    public function members(ReportRequest $request)
    {
        $filters = $request->validated();

        if (! Schema::hasTable('users')) {
            return view('reports.members', ['data' => collect(), 'chart' => []]);
        }

        $query = DB::table('users')->select('id', 'name', 'email', 'is_active', 'created_at');

        if (! empty($filters['from'])) {
            $query->whereDate('created_at', '>=', $filters['from']);
        }
        if (! empty($filters['to'])) {
            $query->whereDate('created_at', '<=', $filters['to']);
        }

        if (! empty($filters['committee_id'])) {
            $query->whereExists(function ($q) use ($filters) {
                $q->select(DB::raw(1))->from('committee_members')->whereRaw('committee_members.member_id = users.id')->where('committee_members.committee_id', $filters['committee_id']);
            });
        }

        $data = $query->orderBy('created_at', 'desc')->paginate(50);

        if ($request->get('export') === 'excel') {
            return Excel::download(new MemberReportExport($filters), 'member_report.xlsx');
        }
        if ($request->get('export') === 'pdf') {
            $pdf = Pdf::loadView('reports.members_pdf', ['data' => $data, 'filters' => $filters]);
            return $pdf->download('member_report.pdf');
        }

        return view('reports.members', ['data' => $data, 'filters' => $filters]);
    }

    public function export(Request $request, $type)
    {
        // convenience route to map type to export
        $valid = ['attendance', 'meetings', 'committees', 'members'];
        if (! in_array($type, $valid)) abort(404);

        $params = $request->all();
        $params['export'] = $request->get('format', 'excel');

        switch ($type) {
            case 'attendance':
                return $this->attendance(new ReportRequest());
            case 'meetings':
                return $this->meetings(new ReportRequest());
            case 'committees':
                return $this->committees(new ReportRequest());
            case 'members':
                return $this->members(new ReportRequest());
        }
    }
}
