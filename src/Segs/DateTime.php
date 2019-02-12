<?php
/**
 * Created by PhpStorm.
 * User: jcicak
 * Date: 11/14/2018
 * Time: 05:15 PM
 */

namespace Segs;

class DateTime
{
    public function __construct($timezone)
    {
        // Set timezone
        date_default_timezone_set($timezone);
    }

    // Time format is UNIX timestamp or
    // PHP strtotime compatible strings
    public function dateDiff($time1, $time2, $precision = 6, $interval_type = 0) {
        // If not numeric then convert texts to unix timestamps
        if (!is_int($time1)) {
            $time1 = strtotime($time1);
        }
        if (!is_int($time2)) {
            $time2 = strtotime($time2);
        }

        // If time1 is bigger than time2
        // Then swap time1 and time2
        if ($time1 > $time2) {
            $ttime = $time1;
            $time1 = $time2;
            $time2 = $ttime;
        }

        // Set up intervals and diffs arrays
        $intervals = array('year','month','day','hour','minute','second');
        $diffs = array();

        // Loop thru all intervals
        foreach ($intervals as $interval) {
            // Create temp time from time1 and interval
            $ttime = strtotime('+1 ' . $interval, $time1);
            // Set initial values
            $add = 1;
            $looped = 0;
            // Loop until temp time is smaller than time2
            while ($time2 >= $ttime) {
                // Create new temp time from time1 and interval
                $add++;
                $ttime = strtotime("+" . $add . " " . $interval, $time1);
                $looped++;
            }

            $time1 = strtotime("+" . $looped . " " . $interval, $time1);
            if($interval_type == 1){
                if($interval == "month" || $interval == "year" ){
                    $interval_name = strtoupper(substr($interval, 0, 1));
                } else {
                    $interval_name = substr($interval, 0, 1);
                }
            } else{
                $interval_name = $interval;
            }
            $diffs[$interval_name] = $looped;
        }

        $count = 0;
        $times = array();
        // Loop thru all diffs

        foreach ($diffs as $interval => $value) {
            // Break if we have needed precision
            if ($count >= $precision) {
                break;
            }
            // Add value and interval
            // if value is bigger than 0
            if ($value > 0) {
                // Add s if value is not 1
                if ($value != 1 && $interval_type == 0) {
                    $interval .= "s";
                } else {
                    //$interval = $interval_short[$value];
                }


                // Add value and interval to times array
                $times[] = $value . $interval;
                $count++;
            }
        }

        // Return string with times
        return implode(", ", $times);
    }
}



