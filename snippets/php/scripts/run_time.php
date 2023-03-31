<?php

if (!function_exists('runCalculateExecTime')) {
    function runCalculateExecTime(callable $callable, $asFloat = true)
    {
        $start = microtime($asFloat);

        $callable();

        $end = microtime($asFloat);

        return $end - $start;
    }
}