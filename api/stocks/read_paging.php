<html>
    <head>
        <title>Stock Market Daily Records</title>
        <link rel="stylesheet"  
            href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <style>   
            table {  
                border-collapse: collapse;  
            }  
                .inline{   
                    display: inline-block;   
                    float: right;   
                    margin: 20px 0px;   
                }   
                
                input, button{   
                    height: 34px;   
                }   
        
            .pagination {   
                display: inline-block;   
            }   
            .pagination a {   
                font-weight:bold;   
                font-size:18px;   
                color: black;   
                float: left;   
                padding: 8px 16px;   
                text-decoration: none;   
                border:1px solid black;   
            }   
            .pagination a.active {   
                    background-color: pink;   
            }   
            .pagination a:hover:not(.active) {   
                background-color: skyblue;   
            }   
        </style>   
</head>
<?php
//required headers
header("Access-Control-Allow-Origin: *");
//header("Content-Type: application/json");


//include database and object files
include_once '../config/core.php';
include_once '../shared/utilities.php';
include_once '../config/database.php';
include_once '../objects/stocks.php';

//utilities
$utilities = new Utilities();

//instantiate database and stock object
$database = new Database();
$db = $database->getConnection();

//initialize stocks
$stock = new Stocks($db);

//stocks records
$stmt = $stock->readPaging($from_record_num, $records_per_page);
$num = $stmt->rowCount();
?>

<div class="container">   
      <br>   
      <div>   
        <h1>Paginated Data Records</h1>   
        <table class="table table-striped table-condensed    
                                          table-bordered">   
          <thead>   
            <tr>   
              <th width="10%">Symbol</th>   
              <th>Trading Date</th>   
              <th>Series</th>   
              <th>Previous Close</th>
              <th>Open</th>
              <th>High</th>
              <th>Low</th>
              <th>Close</th>
              <th>Last Price</th>
              <th>Average Price</th>
              <th>Total Traded Quantity</th>
              <th>Turnover (Lacs)</th>
              <th>No of Trades</th>
              <th>Delivered Quantity</th>
              <th>Delivered Per Trade</th>   
            </tr>   
          </thead>   
          <tbody>   
<?php
//check if more than 0 record found
if($num>0){
    
    //stocks array
    $stocks_arr = array();
    $stocks_arr["records"] = array();
    $stocks_arr["paging"] = array();

    //retrieve the contents
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        ?>
        <tr>     
             <td><?php echo $SYMBOL; ?></td>     
            <td><?php echo $TRADING_DATE; ?></td>   
            <td><?php echo $SERIES; ?></td>   
            <td><?php echo $PREV_CLOSE; ?></td>
            <td><?php echo $OPEN; ?></td>
            <td><?php echo $HIGH; ?></td>
            <td><?php echo $LOW; ?></td>
            <td><?php echo $CLOSE; ?></td>
            <td><?php echo $LAST_PRICE; ?></td>
            <td><?php echo $AVG_PRICE; ?></td>
            <td><?php echo $TTL_TRD_QNTY; ?></td>
            <td><?php echo $TURNOVER_LACS; ?></td>
            <td><?php echo $NO_OF_TRADES; ?></td>
            <td><?php echo $DELIV_QTY; ?></td>
            <td><?php echo $DELIV_PER; ?></td>                                           
            </tr>     
        <?php
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
    ?>
     </tbody>   
        </table>   
  
     <div class="pagination">

    <?php

    //include paging
    $total_rows = $stock->count();
    $page_url = "{$home_url}stocks/read_paging.php?";
    $paging = $utilities->getPaging($page, $total_rows, $records_per_page, $page_url);
    $stocks_arr["paging"]=$paging;

    $pages_end = end($paging["pages"]);
    $pagLink = "";

    $start_pagination = $paging["pages"][0]["page"];
    $end_pagination = $pages_end["page"];

    for($i=0; $i<=($end_pagination - $start_pagination); $i++ ){
        if($paging["pages"][$i]["current_page"] == "yes"){
            $pagLink .= "<a class = 'active' href='".$paging["pages"][$i]["url"]."'>".$paging["pages"][$i]["page"]."</a>";   
        }
        else{
            $pagLink .= "<a href='".$paging["pages"][$i]["url"]."'>".$paging["pages"][$i]["page"]."</a>";
        }

    };
    echo $pagLink;

    //set response code
    http_response_code(200);
}
else{

    //set the response code
    http_response_code(404);

    echo json_encode(array("message"=>"No stocks records exist"));
}

?>