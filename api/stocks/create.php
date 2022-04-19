<?php
//require headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

//get database connection
include_once '../config/database.php';

//instantiate stocks object
include_once '../objects/stocks.php';

$database = new Database();
$db = $database->getConnection();

$stock = new Stocks($db);

//get the posted data
$data = json_encode(file_get_contents("php://input"));

//make sure data is not empty
if(
    !empty($data->symbol) &&
    !empty($data->trading_date) &&
    !empty($data->series)
){

    //set stocks values
    $stock->symbol = $data->symbol;
    $stock->trading_date = $data->trading_date;
    $stock->series = $data->series;
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

    //create the stock record
    if($stock->create()){
        
        //set response code
        http_response_code(201);

        echo json_encode(array("message" => "Stock Record was created"));
    }
    else{

        //set response code - 503 service unavailable
        http_response_code(503);

        echo json_encode(array("message" => "Unable to create stock record"))
    }
}

else{

    //set response code - 400 bad request
    http_response_code(400);

    echo json_encode(array("message" => "Unable to create product. Data is incomplete"))
}

?>