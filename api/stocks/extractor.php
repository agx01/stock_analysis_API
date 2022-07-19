<?php

//Including the core file to access folder and url names
require_once '../config/core.php';
require_once '../config/database.php';
require_once '../objects/stocks.php';

$file_date = date("dmY",mktime(-1, 0, 0, date("m"), date("d"),date("Y")));
//$file_date = date("Y-m-d", strtotime("yesterday"));
$bhavcopy_name = "sec_bhavdata_full_".$file_date.".csv";

//Initialize our url
$url = $base_url.$bhavcopy_name;

$ch = curl_init($url);

if($ch !== false){
    //Initialize directory
    $dir = "..\data\\";
    
    //Get the base name of the file
    $file_name = basename($url);
    
    //Save file location
    $save_file_loc = $dir . $file_name;
    
    //Open file
    $fp = fopen($save_file_loc, 'wb');
    
    //It set an option for a cURL transfer
    curl_setopt($ch, CURLOPT_FILE, $fp);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    
    //Perform cURL session
    curl_exec($ch);
    
    //Closes a cURL session and frees all resources
    curl_close($ch);
    
    //Close file
    fclose($fp);
    
    echo "File downloaded successfully; File downloaded: $file_name";
 }
 else{
     echo "File download incomplete";
 }

$row = 1;

function httPost($url, $data){
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    curl_close($curl);
    return $response;
}

if(($handle = fopen($save_file_loc, "r")) !== FALSE){
    echo "\nFile opened successfully";
    while(($data = fgetcsv($handle, 1000, ",")) !== FALSE){
        $conv_data = array(
            "symbol" => $data[0],
            "series" => $data[1],
            "trading_date" => date('Y-m-d', strtotime($data[2])),
            "prev_close" => $data[3],
            "open" => $data[4],
            "high" => $data[5],
            "low" => $data[6],
            "last_price" => $data[7],
            "close" => $data[8],
            "avg_price" => $data[9],
            "ttl_trd_qnty" => $data[10],
            "turnover_lacs" => $data[11],
            "no_of_trades" => $data[12],
            "deliv_qty" => $data[13],
            "deliv_per" => $data[14]
        );
        $num = count($data);
        echo "\n$num";
        echo "<p> $num fields in line $row: <br /></p>\n";
        if($row !== 1){
            $database = new Database();
            $db = $database->getConnection();

            $stock = new Stocks($db);
            if(!empty($data[0])&&
                !empty($data[1])&&
                !empty($data[2])){
                    $stock->symbol = $data[0];
                    $stock->series = $data[1];
                    $stock->trading_date = date('Y-m-d', strtotime($data[2]));
                    $stock->prev_close = $data[3];
                    $stock->open = $data[4];
                    $stock->high = $data[5];
                    $stock->low = $data[6];
                    $stock->close = $data[8];
                    $stock->last_price = $data[7];
                    $stock->avg_price = $data[9];
                    $stock->ttl_trd_qnty = $data[10];
                    $stock->turnover_lacs = $data[11];
                    $stock->no_of_trades = $data[12];
                    $stock->deliv_qty = $data[13];
                    $stock->deliv_per = $data[14];

                    //create the stock record
                    if($stock->create()){
                        
                        //set response code
                        http_response_code(201);

                        echo json_encode(array("message" => "Stock Record was created"));
                    }
                    else{

                        //set response code - 503 service unavailable
                        http_response_code(503);

                        echo json_encode(array("message" => "Unable to create stock record"));
                    }
                }
            //echo $home_url."stocks/create.php";
            //echo httPost($home_url."/stocks/create.php", json_encode($conv_data));
        }
        $row++;
        for ($c=0; $c < $num; $c++){
            echo $data[$c]."</br>\n";
            
        }
    }
    fclose($handle);
}


?>