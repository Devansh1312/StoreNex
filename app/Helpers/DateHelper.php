<?php

if (!function_exists('formatDate')) {
    /**
     * Format the date using moment.js format.
     *
     * @param string $dateString
     * @return string
     */
    function formatDate($dateString)
    {
        return \Illuminate\Support\Carbon::parse($dateString)->format('DD-MMM-YYYY hh:mm A');
    }
}
