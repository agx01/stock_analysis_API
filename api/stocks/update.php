<?php

//required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

//include database and object files
include_once '../config/database.php';
include_once '../config/stocks.php';

//get database connection
$database = new Database();
$db = $database->getConnection();

//prepare product object
$stock = new Stocks($db);

//get the record ID that needs to be edited
$data = json_decode(file_get_contents("php://input"));

//set the key IDs
$stock->symbol = $data->symbol;
$stock->trading_date = $data->trading_date;
$stock->series = $data->series;

//Update the stock record
if($stock->update()){

    //set response code - 200 OK
    http_response_code(200);

    //tell the user
    echo json_encode(array("message"=>"Record is updated"));

}
else{

    //set the reponse code - 503 unavailable
    http_response_code(503);

    echo json_encode(array("message"=>"Unable to update the record"));
}
?>