<?php

if (!function_exists('timeToSeconds')) {
    function timeToSeconds($time)
    {
        $timeParts = explode(':', $time);
        if (count($timeParts) === 3) {
            list($hours, $minutes, $seconds) = $timeParts;
        } elseif (count($timeParts) === 2) {
            list($minutes, $seconds) = $timeParts;
            $hours = 0;
        } else {
            return 0; // Invalid format, return 0 seconds
        }

        return ($hours * 3600) + ($minutes * 60) + $seconds;
    }
}

if (!function_exists('secondsToTime')) {
    function secondsToTime($seconds)
    {
        $hours = floor($seconds / 3600);
        $minutes = floor(($seconds % 3600) / 60);
        $seconds = $seconds % 60;

        return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
    }
}
