<?php

/**
 * This file handles the ajax call when user selects a day to draw in raport
 *
 * PHP version 5.6.30-0+deb8u1
 *
 * @category Tarkvaraarenduse_Praktika
 * @package  Roheline
 * @author   Rasmus Kello <rasmus.kello@tlu.ee>
 * @license  [https://opensource.org/licenses/MIT] [MIT]
 * @link     ...
 */

$day = $_REQUEST["day"];
$filerequest = $_REQUEST["file"];
$file = fopen($filerequest, "r");
$times = array('00', '01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23');
$hourlyValues = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
$hourCount = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

fseek($file, 0);
while (!feof($file)) {
    $array = fgetcsv($file, 0, ";");
    $time = (substr($array[0], 11, 2));
    $dayValue = (substr($array[0], 0, 10));
    foreach ($times as $key => $hour) {
        if ($time == $hour && $day == $dayValue) {
            $hourlyValues[$key] = floatval(preg_replace("/[^-0-9\.]/", ".", $array[2]));
        }
    }

}

echo json_encode($hourlyValues);
