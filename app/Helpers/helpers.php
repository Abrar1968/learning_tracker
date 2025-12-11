<?php

if (!function_exists('activity')) {
    function activity(): \App\Helpers\ActivityLogger
    {
        return new \App\Helpers\ActivityLogger();
    }
}
