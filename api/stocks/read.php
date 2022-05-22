<?php
//required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database and object files
include_once '../config/database.php';
include_once '../objects/stocks.php';

//instantiate database and product object
$database = new Database();
$db = $database->getConnection();

//Initialize the stocks class
$stock = new Stocks($db);


//query stocks
$stmt = $stock->read();
$num = $stmt->rowCount();

print_r($num);
//check if more than 0 record found
if($num>0){

    //products array
    $stocks_arr = array();
    $stocks_arr["records"] = array();

    //retreive our table contents
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        //extract row
        extract($row);
        
        $stock_item=array(
            "SYMBOL" => $SYMBOL,
            "TRADING_DATE" => $TRADING_DATE,
            "SERIES" => $SERIES,
            "PREV_CLOSE" => $PREV_CLOSE,
            "OPEN" => $OPEN,
            "HIGH" => $HIGH,
            "LOW" => $LOW,
            "CLOSE" => $CLOSE,
            "LAST_PRICE" => $LAST_PRICE,
            "AVG_PRICE" => $AVG_PRICE,
            "TTL_TRD_QNTY" => $TTL_TRD_QNTY,
            "TURNOVER_LACS" => $TURNOVER_LACS,
            "NO_OF_TRADES" => $NO_OF_TRADES,
            "DELIV_QTY" => $DELIV_QTY,
            "DELIV_PER" => $DELIV_PER
        );

        array_push($stocks_arr["records"], $stock_item);
    }

    //set response code - 200 
    http_response_code(200);

    //show stocks data in json data
    echo json_encode($stocks_arr);
}
else{

    //set response code - 404
    http_response_code(404);

    //tell the user no products found
    echo json_encode(array("message" => "No Stocks records found"));
}
?>