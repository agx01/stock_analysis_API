<?php

//required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

//include database and object files
include_once '../config/database.php';
include_once '../objects/stocks.php';

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

//set the remaining record values
$stock->prev_close = $data->prev_close;
$stock->open = $data->open;
$stock->high = $data->high;
$stock->low = $data->low;
$stock->close = $data->close;
$stock->last_price = $data->last_price;
$stock->avg_price = $data->avg_price;
$stock->ttl_trd_qnty = $data->ttl_trd_qnty;
$stock->turnover_lacs = $data->turnover_lacs;
$stock->no_of_trades = $data->no_of_trades;
$stock->deliv_qty = $data->deliv_qty;
$stock->deliv_per = $data->deliv_per;

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