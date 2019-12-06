<?php namespace App;

class Request {
    protected $request;

    function __construct($request) {
        $this->request = $request;
    }

    function get($key) {
        return !empty($this->request[$key]) ? $this->request[$key] : NULL;
    }
}