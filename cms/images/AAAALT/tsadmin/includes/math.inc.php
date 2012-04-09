<?php
    function byte_calculation($bytes) {
        if ($bytes > pow(2,10)) {
            if ($bytes > pow(2,40)) {
                $size = '<b>'.number_format(($bytes / pow(2,40)), 2, ",", ".").'</b>';
                $size .= " TB";
                return $size;
            } elseif ($bytes > pow(2,30)) {
                $size = '<b>'.number_format(($bytes / pow(2,30)), 2, ",", ".").'</b>';
                $size .= " GB";
                return $size;
            } elseif ($bytes > pow(2,20)) {
                $size = '<b>'.number_format(($bytes / pow(2,20)), 2, ",", ".").'</b>';
                $size .= " MB";
                return $size;
            } else {
                $size = '<b>'.number_format(($bytes / pow(2,10)), 2, ",", ".").'</b>';
                $size .= " KB";
                return $size;
            }
        } else {
            $size = (string) $bytes . " Bytes";
            return $size;
        }
    }
?>