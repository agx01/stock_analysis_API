<?php

$base_url = "https://archives.nseindia.com/products/content/";
$file_date = date("dmY",mktime(0, 0, 0, date("m"), date("d"),date("Y")));
//$file_date = date("Y-m-d", strtotime("yesterday"));
$bhavcopy_name = "sec_bhavdata_full_".$file_date.".csv";

//Initialize our url
//$url = 'https://media.geeksforgeeks.org/wp-content/uploads/gfg-40.png';
$url = $base_url.$bhavcopy_name;

$ch = curl_init($url);

 if($ch !== false){
    //Initialize directory
    $dir = dirname(__DIR__, 1) . "\data\\";
    
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
            echo httPost("localhost/stock_analysis_API/api/stocks/create.php", json_encode($conv_data));
        }
        $row++;
        for ($c=0; $c < $num; $c++){
            echo $data[$c]."</br>\n";
            
        }
    }
    fclose($handle);
}


?>