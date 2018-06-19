<?php

/**
 * This file handles the ajax call when user selects a month to draw in raport
 *
 * PHP version 5.6.30-0+deb8u1
 *
 * @category Tarkvaraarenduse_Praktika
 * @package  Roheline
 * @author   Rasmus Kello <rasmus.kello@tlu.ee>
 * @license  [https://opensource.org/licenses/MIT] [MIT]
 * @link     ...
 */

$chosenDate = $_REQUEST["date"];
$chosenYear = date("Y", strtotime($chosenDate));
$chosenMonth = date("m", strtotime($chosenDate));
$filerequest = $_REQUEST["file"];
$file = fopen($filerequest, "r");
$dailyValues = array(0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0);
$days = array("01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23", "24", "25", "26", "27", "28", "29", "30", "31");
fseek($file, 0);
while (!feof($file)) {
    $array = fgetcsv($file, 0, ";");
    $day = substr($array[0], 0, 2);
    $monthValue = substr($array[0], -13, 2);
    $yearValue = substr($array[0], -10, 4);
    if ($chosenYear == $yearValue && $chosenMonth == $monthValue) {
        foreach ($days as $key => $value) {
            if ($day == $value) {
                $dailyValues[$key] += floatval(preg_replace("/[^-0-9\.]/", ".", $array[2]));
            }
        }
    }
}
echo json_encode($dailyValues);