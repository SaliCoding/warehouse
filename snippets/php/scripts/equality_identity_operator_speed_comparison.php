<?php
declare(strict_types=1);
ini_set('memory_limit', '-1');

include 'version_check.php';

checkSupportedVersions([8.0, 8.1, 8.2]);

include 'run_time.php';

const EQUALITY_CHECK_ITERATION = 2 * (10 ** 7);
const AVERAGE_NORMALIZATION_RATE = 100;

function equalOperation(mixed $a, mixed $b, int $iteration): void
{
    for ($i = 0; $i < $iteration; $i++) {
        $result = $a == $b;
    }
}

function identicalOperation(mixed $a, mixed $b, int $iteration): void
{
    for ($i = 0; $i < $iteration; $i++) {
        $result = $a === $b;
    }
}

function runMulti(mixed $a, mixed $b, int $iteration): void
{
    $equalExecTime = 0;
    $identicalExecTime = 0;
    for ($i = 0; $i < $iteration; $i++) {
        $equalExecTime += runCalculateExecTime(fn() => equalOperation($a, $b, EQUALITY_CHECK_ITERATION));
        $identicalExecTime += runCalculateExecTime(fn() => identicalOperation($a, $b, EQUALITY_CHECK_ITERATION));
    }


    if (is_array($a) || is_object($a)) {
        $aStringValue = json_encode($a);
    } else {
        $aStringValue = $a;
    }

    if (is_array($b) || is_object($b)) {
        $bStringValue = json_encode($b);
    } else {
        $bStringValue = $b;
    }

    $equalExecTimeAvg = round($equalExecTime / $iteration, 5) / $iteration * AVERAGE_NORMALIZATION_RATE;
    $identicalExecTimeAvg = round($identicalExecTime / $iteration, 5) / $iteration * AVERAGE_NORMALIZATION_RATE;

    echo 'Compare'.' ('.gettype($a).') '.$aStringValue.' VS'.' ('.gettype($b).') '.$bStringValue."\n";
    echo "Run time for equal (==): ".$equalExecTimeAvg."\n";
    echo "Run time for identical (===): ".$identicalExecTimeAvg."\n";
    echo "-------------------------------------"."\n";

}

function runMultiInBulk(array $values, int $iteration): void
{
    foreach ($values as $value) {
        runMulti($value['a'], $value['b'], $iteration);
    }
}

runMultiInBulk([
    [
        'a' => 1000,
        'b' => 1000,
    ],
    [
        'a' => 1000,
        'b' => '1000',
    ],
    [
        'a' => '1000',
        'b' => '1000',
    ],
    [
        'a' => 1000,
        'b' => ['1000'],
    ],
    [
        'a' => ['2000'],
        'b' => ['1000'],
    ],
    [
        'a' => (object)['1000'],
        'b' => ['1000'],
    ],
    [
        'a' => (object)['1000'],
        'b' => (object)['2000'],
    ],
], 10);