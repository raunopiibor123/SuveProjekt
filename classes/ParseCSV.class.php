<?php

/**
 * This class handles the parsing of CSV to draw different charts
 *
 * PHP version 5.6.30-0+deb8u1
 *
 * @category Tarkvaraarenduse_Praktika
 * @package  Roheline
 * @author   Rasmus Kello <rasmus.kello@tlu.ee>
 * @license  [https://opensource.org/licenses/MIT] [MIT]
 * @link     ...
 */

class CSV
{

    public function __construct($CSV)
    {
        $this->file = fopen($CSV, "r");
    }

    /*public function getMonthlyMarketPrices($year)
    {
        $file = fopen("prices/Elspot $year.csv", "r");
        fseek($this->file, 0);
        fgetcsv($this->file, 0, ";");
        $first = fgetcsv($this->file, 0, ";");
        $firstDate = substr($first[0], 0, 6) . substr($first[0], 8, 2) . " " . "00-01";
        print_r($firstDate);
        fseek($this->file, 0);
        //Find first date of usage CSV in elspot
        while (!feof($file)) {
            $current = fgetcsv($file, 0, ",");
            $dateTimeCurrent = str_replace("-", ".", $current[0]) . " " . $current[1];
            echo $dateTimeCurrent;
            if ($dateTimeCurrent == $firstDate) {
                echo "loop broken";
                break;
            }
        }
        fgetcsv($this->file, 0, ";");

        while (!feof($this->file)) {
            $array1 = fgetcsv($file, 0, ",");
            $array2 = fgetcsv($this->file, 0, ";");
            $dateTimes = array();
            $dateTimes2 = array();
            $dateTime = str_replace("-", ".", $array1[0]) . " " . $array1[1];
            $dateTime2 = substr($array2[0], 0, 6) . substr($array2[0], 8, 2) . " " . substr($array2[0], 11, 2) . "-" . substr($array2[1], 11, 2);
            $time1 = substr($array2[0], 11, 2);
            $time2 = substr($array2[1], 11, 2);
            if ($time1 == $time2) {
                fgetcsv($this->file, 0, ";");
                echo "ERRRRROOOOOOOOOOOORRRRR";
            }
            $prices = array();
            echo $dateTime;
            echo "Break";
            echo $dateTime2;
            if ($dateTime != $dateTime2) {
                fgetcsv($file, 0, ";");
            }
            if ($dateTime == $dateTime2) {
                echo "SAME";
            }
        }
        fseek($this->file, 0);
        while (!feof($this->file)) {
            $array = fgetcsv($this->file, 0, ";");
            $dateTimes2 = array();
            $usages = array();
            $dateTime2 = substr($array[0], 0, 6) . substr($array[0], 8, 2) . " " . substr($array[0], 11, 2) . "-" . substr($array[1], 11, 2);
            array_push($dateTimes2, $dateTime2);
            array_push($usages, $array[2]);
        }

    }*/

    public function getMonthlyValues($year)
    {
        if ($this->file != false) {
            $monthlyValues = array(0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0);
            $months = array("01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12");
            fseek($this->file, 0);
            while (!feof($this->file)) {
                $array = fgetcsv($this->file, 0, ";");
                $month = substr($array[0], -13, 2);
                $yearValue = substr($array[0], -10, 4);
                if ($year == $yearValue) {
                    foreach ($months as $key => $value) {
                        if ($month == $value) {
                            $monthlyValues[$key] += floatval(preg_replace("/[^-0-9\.]/", ".", $array[2]));
                        }
                    }
                }

            }

            return $monthlyValues;
        } else {
            echo "File not found";
        }
    }

    public function getMonthlyDailyValues($year, $month)
    {
        if ($this->file != false) {
            $dailyValues = array(0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0);
            $days = array("01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23", "24", "25", "26", "27", "28", "29", "30", "31");
            fseek($this->file, 0);
            while (!feof($this->file)) {
                $array = fgetcsv($this->file, 0, ";");
                $day = substr($array[0], 0, 2);
                $monthValue = substr($array[0], -13, 2);
                $yearValue = substr($array[0], -10, 4);
                if ($year == $yearValue && $month == $monthValue) {
                    foreach ($days as $key => $value) {
                        if ($day == $value) {
                            $dailyValues[$key] += floatval(preg_replace("/[^-0-9\.]/", ".", $array[2]));
                        }
                    }
                }

            }

            return $dailyValues;
        } else {
            echo "File not found";
        }
    }

    public function getYearlyValues()
    {
        if ($this->file != false) {
            $yearValues = array();
            $years = array();
            $yearlyValues = array();
            fseek($this->file, 0);
            while (!feof($this->file)) {
                $array = fgetcsv($this->file, 0, ";");
                $yearValue = substr($array[0], -10, 4);
                if (!in_array($yearValue, $years)) {
                    array_push($years, $yearValue);
                }
            }
            $years = array_filter($years); //Workaround for 1 empty key in the end
            fseek($this->file, 0);
            while (!feof($this->file)) {
                $array = fgetcsv($this->file, 0, ";");
                foreach ($years as $key => $value) {
                    if (substr($array[0], -10, 4) == $value) {
                        if (!isset($yearlyValues[$key])) { //Workaround for undefined offset notice
                            $yearlyValues[$key] = 0;
                        }
                        $yearlyValues[$key] += floatval(preg_replace("/[^-0-9\.]/", ".", $array[2]));
                    }
                }
            }
            array_push($yearValues, $yearlyValues);
            array_push($yearValues, $years);
            return $yearValues;
        }
    }

    public function getWeeklyValues()
    {
        if ($this->file != false) {
            $weekDays = array(1, 2, 3, 4, 5, 6, 7);
            $dailyValues = array(0, 0, 0, 0, 0, 0, 0);
            $dayCount = array(0, 0, 0, 0, 0, 0, 0);
            $average = array(0, 0, 0, 0, 0, 0, 0);
            fseek($this->file, 0);
            while (!feof($this->file)) {
                $array = fgetcsv($this->file, 0, ";");
                $date = (substr($array[0], 0, 10));
                //echo $date;
                $weekDay = date("N", strtotime($date));
                foreach ($weekDays as $key => $day) {
                    if ($weekDay == $day) {
                        $dailyValues[$key] += floatval(preg_replace("/[^-0-9\.]/", ".", $array[2]));
                        $dayCount[$key] += 1;
                    }
                }

            }
            foreach ($dayCount as $key => $count) {
                $average[$key] = $dailyValues[$key] / $count * 24;
            }
            return $average;
        }
    }

    public function getDailyValues()
    {
        if ($this->file != false) {
            $times = array('00', '01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23');
            $hourlyValues = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
            $hourCount = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
            $average = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
            fseek($this->file, 0);
            while (!feof($this->file)) {
                $array = fgetcsv($this->file, 0, ";");
                $time = (substr($array[0], 11, 2));
                foreach ($times as $key => $hour) {
                    if ($time == $hour) {
                        $hourlyValues[$key] += floatval(preg_replace("/[^-0-9\.]/", ".", $array[2]));
                        $hourCount[$key] += 1;
                    }
                }

            }
            foreach ($hourCount as $key => $count) {
                $average[$key] = $hourlyValues[$key] / $count;
            }
            return $average;
        }
    }

}
