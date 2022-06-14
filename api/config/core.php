<?php

//show error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

//Check if the code is for test or server
$is_test = true;

//NSE url link
$base_url = "https://archives.nseindia.com/products/content/";

if($is_test == true){
    //home page url for testing
    $home_url = "http://localhost/stock_analysis_API/api/";

    //API root folder
    $api_root = "..\api\\";
}
else{
    //home page url for server
    $home_url = "www.arijitganguly.com/api/";
    
    //API root folder
    $api_root = "..\api\\";
}

//home page url
//$home_url = "http://localhost/api/";

//page given in URL parameter, default page one
$page = isset($_GET['page']) ? $_GET['page'] : 1;

//set record numbers per page
$records_per_page = 10;

//calculate for the query LIMIT clause
$from_record_num = ($records_per_page * $page) - $records_per_page;

?>