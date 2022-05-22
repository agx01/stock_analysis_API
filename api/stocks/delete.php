<?php

//required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

//include database and object file
include_once '../config/database.php';
include_once '../objects/stocks.php';

//get database connection
$database = new Database();
$db = $database->getConnection();

//prepare new stock
$stock = new Stocks($db);

//get the stock info
$data = json_decode(file_get_contents("php://input"));

//set the stock keys to be a deleted
$stock->symbol = $data->symbol;
$stock->trading_date = $data->trading_date;
$stock->series = $data->series;

//delete the stock record
if($stock->delete()){

    //set response code 
    http_response_code(200);

    echo json_encode(array("message"=>"Stock record deleted"));
}
else{
    http_response_code(503);

    echo json_encode(array("message"=>"Unable to delete the record"));
}

?>