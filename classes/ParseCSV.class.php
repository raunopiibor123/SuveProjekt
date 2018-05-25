<?php
    class CSV{

        function __construct($CSV){
            $this->file = fopen($CSV,"r");
        }

        public function getMonthlyValues($year){
            $monthlyValues=array(0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0);
            $months=array("01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12");
            fseek($this->file, 0);
            while(! feof($this->file))
            {
            $array = fgetcsv($this->file, 0, ";");
            $month = substr($array[0], -13, 2);
            $yearValue = substr($array[0], -10, 4);
                if($year == $yearValue){
                    foreach($months as $key=>$value){
                        if($month == $value){
                            $monthlyValues[$key] += floatval(preg_replace("/[^-0-9\.]/",".",$array[2]));
                        }
                    }
                }
            
            }
            
            return $monthlyValues;

        }

        public function getYearlyValues(){
            $yearValues = array();
            $years = array();
            $yearlyValues = array();
            fseek($this->file, 0);
            while(! feof($this->file)){
                $array = fgetcsv($this->file, 0, ";");
                $yearValue = substr($array[0], -10, 4);
                if(!in_array($yearValue, $years)){
                    array_push($years, $yearValue);
                }
            }
            $years = array_filter($years); //Workaround for 1 empty key in the end
            fseek($this->file, 0);
            while(! feof($this->file)){
                $array = fgetcsv($this->file, 0, ";");
                foreach($years as $key=>$value){
                    if(substr($array[0], -10, 4) == $value){ 
                        if(!isset($yearlyValues[$key])) { //Workaround for undefined offset notice
                            $yearlyValues[$key] = 0;
                        }
                        $yearlyValues[$key] += floatval(preg_replace("/[^-0-9\.]/",".",$array[2]));
                    }
                }
            }
            array_push($yearValues, $yearlyValues);
            array_push($yearValues, $years);
            return $yearValues ;   
        }

        public function getWeeklyValues(){
            $weekDays = array(1, 2, 3, 4, 5, 6, 7);
            $dailyValues = array(0, 0, 0, 0, 0, 0, 0);
            $dayCount = array(0, 0, 0, 0, 0, 0, 0);
            $average = array(0, 0, 0, 0, 0, 0, 0);
            fseek($this->file, 0);
            while(! feof($this->file)){
                $array = fgetcsv($this->file, 0, ";");
                $date = (substr($array[0], 0, 10));
                //echo $date;
                $weekDay = date("N", strtotime($date));
                foreach($weekDays as $key=>$day){
                    if($weekDay == $day){
                        $dailyValues[$key] += floatval(preg_replace("/[^-0-9\.]/",".",$array[2]));
                        $dayCount[$key] += 1;
                    }
                }

            }
            foreach($dayCount as $key=>$count){
                $average[$key] = $dailyValues[$key]/$count*24;
            }
            return $average;
        }

        public function getDailyValues(){
            $times = array('00', '01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23');
            $hourlyValues = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
            $hourCount = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
            $average = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
            fseek($this->file, 0);
            while(! feof($this->file)){
                $array = fgetcsv($this->file, 0, ";");
                $time = (substr($array[0], 11, 2));
                foreach($times as $key=>$hour){
                    if($time == $hour){
                        $hourlyValues[$key] += floatval(preg_replace("/[^-0-9\.]/",".",$array[2]));
                        $hourCount[$key] += 1;
                    }
                }

            }
            foreach($hourCount as $key=>$count){
                $average[$key] = $hourlyValues[$key]/$count;
            }
            return $average;
        }

    }