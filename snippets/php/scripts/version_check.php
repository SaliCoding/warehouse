<?php

if (!function_exists('checkSupportedVersions')) {
    function checkSupportedVersions($versions)
    {
        if (is_object($versions)) {
            $versions = (array)$versions;
        }

        if (is_int($versions) || is_float($versions)) {
            $versions = (string)$versions;
        }

        if (!is_array($versions)) {
            $versions = [$versions];
        }

        foreach ($versions as $version) {
            if (strpos(phpversion(), $version) !== false) {
                return true;
            }
        }

        throw new \Exception('Your php version is not supported by script, supported versions: '.json_encode($versions).'your php version is '.PHP_VERSION);
    }
}

if (!function_exists('checkUnSupportedVersions')) {
    function checkUnSupportedVersions($versions)
    {
        if (is_object($versions)) {
            $versions = (array)$versions;
        }

        if (is_int($versions) || is_float($versions)) {
            $versions = (string)$versions;
        }

        if (!is_array($versions)) {
            $versions = [$versions];
        }

        foreach ($versions as $version) {
            if (strpos(phpversion(), $version) !== false) {
                throw new \Exception('Your php version is not supported by script, unsupported versions: '.json_encode($versions).'your php version is '.PHP_VERSION);
            }
        }

       return true;
    }
}