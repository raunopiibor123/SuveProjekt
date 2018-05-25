<?php
$year = $_REQUEST["year"];
$week = $_REQUEST["week"];
$file = fopen("csv/tarbimisteatis.csv","r");
$weekDays = array(1, 2, 3, 4, 5, 6, 7);
            $dailyValues = array(0, 0, 0, 0, 0, 0, 0);
            fseek($file, 0);
            while(! feof($file)){
                $array = fgetcsv($file, 0, ";");
                $date = (substr($array[0], 0, 10));
                //echo $date;
                $weekDay = date("N", strtotime($date));
                $yearnum = date("Y", strtotime($date));
                $weeknum = date("W", strtotime($date));
                foreach($weekDays as $key=>$day){
                    if($weekDay == $day && $year == $yearnum && $week == $weeknum){
                        $dailyValues[$key] += floatval(preg_replace("/[^-0-9\.]/",".",$array[2]));
                    }
                }

            }
            echo json_encode($dailyValues);
?>