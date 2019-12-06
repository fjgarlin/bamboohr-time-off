<?php namespace App;

class Request {
    protected $request;

    function __construct($request) {
        $this->request = $request;
    }

    function get($key) {
        return !empty($this->request[$key]) ? $this->request[$key] : NULL;
    }

    function getAsDate($key, $today_if_empty = TRUE) {
        $date = $this->get($key);
        if (!strtotime($date) && $today_if_empty) {
            $date = date('Y-m-d');
        }
        return $date;
    }
}