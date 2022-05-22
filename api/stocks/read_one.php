<?php
//require headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

//include database and object files
include_once '../config/database.php';
include_once '../objects/stocks.php';

//get the database connection
$database = new Database();
$db = $database->getConnection();

//prepare the stocks object
$stock = new Stocks($db);

//Set symbol, trading_date and series for the record to be read
$stock->symbol = isset($_GET['symbol']) ? $_GET['symbol'] : die();
$stock->trading_date = isset($_GET['trading_date']) ? $_GET['trading_date'] : die();
$stock->series = isset($_GET['series']) ? $_GET['series'] : die();

//Read details of stocks to be editted
$stock->readOne();

if($stock->symbol!=null &&
    $stock->trading_date!=null &&
    $stock->series!=null){
        //create array
        $stocks_arr = array(
            "symbol" => $stock->symbol,
            "trading_date" => $stock->trading_date,
            "series" => $stock->series,
            "prev_close" => $stock->prev_close,
            "open" => $stock->open,
            "high" => $stock->high,
            "low" => $stock->low,
            "close" => $stock->close,
            "last_price" => $stock->last_price,
            "avg_price" => $stock->avg_price,
            "ttl_trd_qnty" => $stock->ttl_trd_qnty,
            "turnover_lacs" => $stock->turnover_lacs,
            "no_of_trades" => $stock->no_of_trades,
            "deliv_qty" => $stock->deliv_qty,
            "deliv_per" => $stock->deliv_per
        );

        http_response_code(200);

        echo json_encode($stocks_arr);
    }
else{

    http_response_code(404);

    echo json_encode(array("message" => "Stock Record does not exist"));
}


?>