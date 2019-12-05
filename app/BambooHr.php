<?php

namespace App;

use BambooHR\API\BambooAPI;

class BambooHr extends BambooAPI {
    function getTimeOffPolicies($employeeId) {
        $request = $this->getBambooHttpRequest();
        $request->method = "GET";
        $request->url = $this->baseUrl . "/v1_1/employees/" . intval($employeeId) . "/time_off/policies";
        return $this->httpHandler->sendRequest( $request );
    }
 
}
 