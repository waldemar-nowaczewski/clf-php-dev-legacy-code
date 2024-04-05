<?php
// LEFT FOR DEBUGGING
// ini_set('display_errors', '1');
// ini_set('display_startup_errors', '1');
// error_reporting(E_ALL);

$access_array = ['krzysztof_jarzyna' => ['dostep_koordynator']];

function mysqlConnect() {
    return new mysqli("localhost", "root", "", "clf");
}
