<?php

//require headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

//include database and object files
include_once '../config/core.php';
include_once '../config/database.php';
include_once '../objects/stocks.php';

//instantiate database and stock object
$database = new Database();
$db = $database->getConnection();

//initalize stock
$stock = new Stocks($db);

//get keywords
$keywords = isset($_GET["s"]) ? $_GET["s"] : "";

//query stocks data
$stmt = $stock->search($keywords);
$num = $stmt->rowCount();

//check if more than 0 record found
if($num>0){

    //stocks array
    $stocks_arr = array();
    $stocks_arr["records"]=array();

    //retrieve the table contents
    while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);

        $stock_item = array(
            "symbol" => $SYMBOL,
            "trading_date" => $TRADING_DATE,
            "series" => $SERIES,
            "prev_close" => $PREV_CLOSE,
            "open" => $OPEN,
            "high" => $HIGH,
            "low" => $LOW,
            "close" => $CLOSE,
            "last_price" => $LAST_PRICE,
            "avg_price" => $AVG_PRICE,
            "ttl_trd_qnty" => $TTL_TRD_QNTY,
            "turnover_lacs" => $TURNOVER_LACS,
            "no_of_trades" => $NO_OF_TRADES,
            "deliv_qty" => $DELIV_QTY,
            "deliv_per" => $DELIV_PER
        );

        array_push($stocks_arr["records"], $stock_item);
    }

    //set response code
    http_response_code(200);

    echo json_encode($stocks_arr);

}
else{

    //set response code 
    http_response_code(404);

    echo json_encode(array("message" => "No stocks records found."));
}

?>