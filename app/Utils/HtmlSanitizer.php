<?php

namespace App\Utils;

class HtmlSanitizer
{
    /**
     * Basic sanitizer to remove script/style tags and dangerous attributes, and strip unwanted tags.
     * This is intentionally conservative. For full sanitization use HTMLPurifier.
     */
    public static function sanitize(string $html): string
    {
        if (trim($html) === '') return $html;

        // Remove script/style blocks
        $html = preg_replace('#<script(.*?)>(.*?)</script>#is', '', $html);
        $html = preg_replace('#<style(.*?)>(.*?)</style>#is', '', $html);

        // Remove event handler attributes (onxxx=)
        $html = preg_replace('/on[a-z]+\s*=\s*("[^"]*"|\'[^\']*\'|[^\s>]+)/i', '', $html);

        // Remove javascript: URIs
        $html = preg_replace_callback('/(href|src)\s*=\s*("[^"]*"|\'[^\']*\'|[^\s>]+)/i', function ($m) {
            $attr = $m[1];
            $val = $m[2];
            $valStripped = trim($val, "'\"");
            if (preg_match('/^javascript:/i', $valStripped)) {
                return ""; // drop unsafe attribute entirely
            }
            return sprintf('%s="%s"', $attr, htmlspecialchars($valStripped, ENT_QUOTES, 'UTF-8'));
        }, $html);

        // Allow a small set of tags
        $allowed = '<p><a><ul><ol><li><strong><b><em><i><br><img><blockquote><h1><h2><h3><h4><h5><h6>';
        $html = strip_tags($html, $allowed);

        // Remove any remaining javascript: occurrences
        $html = str_ireplace('javascript:', '', $html);

        return $html;
    }
}
