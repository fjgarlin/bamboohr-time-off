<?php namespace App;

class Calendar {
    static function parseData(array $data) {
        $calendar = [];
        foreach ($data as $v) {
            if (empty($calendar[$v->start]) || !in_array($v->name, $calendar[$v->start])) {
                $calendar[$v->start][] = $v->name;
            }
            
            $first_date = strtotime($v->start);
            $end_date = strtotime($v->end);
            $time = $first_date;
            while (($time = strtotime('+1 day', $time)) && ($time <= $end_date)) {
                $date = date('Y-m-d', $time);
                if (empty($calendar[$date]) || !in_array($v->name, $calendar[$date])) {
                    $calendar[$date][] = $v->name;
                }
            }
        }

        return $calendar;
    }
}