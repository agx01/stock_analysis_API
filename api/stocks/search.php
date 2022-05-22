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
            "symbol" => $symbol,
            "trading_date" => $trading_date,
            "series" => $series,
            "prev_close" => $prev_close,
            "open" => $open,
            "high" => $high,
            "low" => $low,
            "close" => $close,
            "last_price" => $last_price,
            "avg_price" => $avg_price,
            "ttl_trd_qnty" => $ttl_trd_qnty,
            "turnover_lacs" => $turnover_lacs,
            "no_of_trades" => $no_of_trades,
            "deliv_qty" => $deliv_qty,
            "deliv_per" => $deliv_per
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