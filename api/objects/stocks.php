<?php

class Stocks{

    //database connection table name
    private $conn;
    private $table_name = "daily_stock_price";

    //stock properties
    public $symbol;
    public $trading_date;
    public $series;
    public $prev_close;
    public $open;
    public $high;
    public $low;
    public $close;
    public $last_price;
    public $avg_price;
    public $ttl_trd_qnty;
    public $turnover_lacs;
    public $no_of_trades;
    public $deliv_qty;
    public $deliv_per;

    //contructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    //read stocks
    function read(){

        //select all query
        $query = "SELECT s.SYMBOL, s.TRADING_DATE, s.SERIES, s.PREV_CLOSE, s.OPEN, s.HIGH, s.LOW, s.CLOSE, s.LAST_PRICE, s.AVG_PRICE, s.TTL_TRD_QNTY, s.TURNOVER_LACS, s.NO_OF_TRADES, s.DELIV_QTY, s.DELIV_PER FROM ".$this->table_name." s";
        
        
        //prepare query statement
        $stmt = $this->conn->prepare($query);

        //execute query
        $stmt->execute();

        return $stmt;
    }

    function create(){

        //query to insert record
        $query = "INSERT INTO ".$this->table_name. 
                 " SET symbol=:symbol,
                       trading_date=:trading_date,
                       series=:series,
                       prev_close=:prev_close,
                       open=:open,
                       high=:high,
                       low=:low,
                       close=:close,
                       last_price=:last_price,
                       avg_price=:avg_price,
                       ttl_trd_qnty=:ttl_trd_qnty,
                       turnover_lacs=:turnover_lacs,
                       no_of_trades=:no_of_trades,
                       deliv_qty=:deliv_qty,
                       deliv_per=:deliv_per";
        
        //prepare query
        $stmt = $this->conn->prepare($query);

        //sanitize the data
        $this->symbol = htmlspecialchars(strip_tags($this->symbol));
        $this->trading_date = htmlspecialchars(strip_tags($this->trading_date));
        $this->series = htmlspecialchars(strip_tags($this->series));
        $this->prev_close = htmlspecialchars(strip_tags($this->prev_close));
        $this->open = htmlspecialchars(strip_tags($this->open));
        $this->high = htmlspecialchars(strip_tags($this->high));
        $this->low = htmlspecialchars(strip_tags($this->low));
        $this->close = htmlspecialchars(strip_tags($this->close));
        $this->last_price = htmlspecialchars(strip_tags($this->last_price));
        $this->avg_price = htmlspecialchars(strip_tags($this->avg_price));
        $this->ttl_trd_qnty = htmlspecialchars(strip_tags($this->ttl_trd_qnty));
        $this->turnover_lacs = htmlspecialchars(strip_tags($this->turnover_lacs));
        $this->no_of_trades = htmlspecialchars(strip_tags($this->no_of_trades));
        $this->deliv_qty = htmlspecialchars(strip_tags($this->deliv_qty));
        $this->deliv_per = htmlspecialchars(strip_tags($this->deliv_per));

        //bind values
        $stmt->bindParam(":symbol", $this->symbol);
        $stmt->bindParam(":trading_date", $this->trading_date);
        $stmt->bindParam(":series", $this->series);
        $stmt->bindParam(":prev_close", $this->prev_close);
        $stmt->bindParam(":open", $this->open);
        $stmt->bindParam(":high", $this->high);
        $stmt->bindParam(":low", $this->low);
        $stmt->bindParam(":close", $this->close);
        $stmt->bindParam(":last_price", $this->last_price);
        $stmt->bindParam(":avg_price", $this->avg_price);
        $stmt->bindParam(":ttl_trd_qnty", $this->ttl_trd_qnty);
        $stmt->bindParam(":turnover_lacs", $this->turnover_lacs);
        $stmt->bindParam(":no_of_trades", $this->no_of_trades);
        $stmt->bindParam(":deliv_qty", $this->deliv_qty);
        $stmt->bindParam(":deliv_per", $this->deliv_per);

        //execute query
        if($stmt->execute()){
            return true;
        }

        return false;
    }


    function readOne(){
        //For this function always send data using get without any quotes, quotes added when retrieving through GET method
        //query to read a single record
        $query = "SELECT s.SYMBOL, 
                        s.TRADING_DATE, 
                        s.SERIES, 
                        s.PREV_CLOSE, 
                        s.OPEN, 
                        s.HIGH, 
                        s.LOW, 
                        s.CLOSE, 
                        s.LAST_PRICE, 
                        s.AVG_PRICE, 
                        s.TTL_TRD_QNTY, 
                        s.TURNOVER_LACS, 
                        s.NO_OF_TRADES, 
                        s.DELIV_QTY, 
                        s.DELIV_PER FROM ".$this->table_name." s 
                    WHERE s.SYMBOL LIKE ? AND s.TRADING_DATE LIKE ? AND s.SERIES LIKE ?";

        //prepare query statement
        $stmt = $this->conn->prepare($query);

        //sanitize
        $this->symbol = htmlspecialchars(strip_tags($this->symbol));
        $this->trading_date = htmlspecialchars(strip_tags($this->trading_date));
        $this->series = htmlspecialchars(strip_tags($this->series));

        //bind symbol, trading_date and series of stocks to be updated
        $stmt->bindParam(1, $this->symbol);
        $stmt->bindParam(2, $this->trading_date);
        $stmt->bindparam(3, $this->series);

        //execute query
        $stmt->execute();

        //Get the retrieved row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        //set values to object properties
        if($row == true){
            $this->symbol = $row['SYMBOL'];
            $this->trading_date = $row['TRADING_DATE'];
            $this->series = $row['SERIES'];
            $this->prev_close = $row['PREV_CLOSE'];
            $this->open = $row['OPEN'];
            $this->high = $row['HIGH'];
            $this->low = $row['LOW'];
            $this->close = $row['CLOSE'];
            $this->last_price = $row['LAST_PRICE'];
            $this->avg_price = $row['AVG_PRICE'];
            $this->ttl_trd_qnty = $row['TTL_TRD_QNTY'];
            $this->turnover_lacs = $row['TURNOVER_LACS'];
            $this->no_of_trades = $row['NO_OF_TRADES'];
            $this->deliv_qty = $row['DELIV_QTY'];
            $this->deliv_per = $row['DELIV_PER'];
        }
        
        
    }


    //Update the record
    function update(){

        //update query
        $query = "UPDATE ".$this->table_name." 
                    SET 
                    prev_close = :prev_close,
                    open = :open,
                    high = :high,
                    low = :low,
                    close = :close,
                    last_price = :last_price,
                    avg_price = :avg_price,
                    ttl_trd_qnty = :ttl_trd_qnty,
                    turnover_lacs = :turnover_lacs,
                    no_of_trades = :no_of_trades,
                    deliv_qty = :deliv_qty,
                    deliv_per = :deliv_per 
                    WHERE 
                    symbol LIKE :symbol AND
                    trading_date LIKE :trading_date AND
                    series LIKE :series";

        //prepare the query statement
        $stmt = $this->conn->prepare($query);

        //sanitize
        $this->symbol = htmlspecialchars(strip_tags($this->symbol));
        $this->trading_date = htmlspecialchars(strip_tags($this->trading_date));
        $this->series = htmlspecialchars(strip_tags($this->series));
        $this->prev_close = htmlspecialchars(strip_tags($this->prev_close));
        $this->open = htmlspecialchars(strip_tags($this->open));
        $this->high = htmlspecialchars(strip_tags($this->high));
        $this->low = htmlspecialchars(strip_tags($this->low));
        $this->close = htmlspecialchars(strip_tags($this->close));
        $this->last_price = htmlspecialchars(strip_tags($this->last_price));
        $this->avg_price = htmlspecialchars(strip_tags($this->avg_price));
        $this->ttl_trd_qnty = htmlspecialchars(strip_tags($this->ttl_trd_qnty));
        $this->turnover_lacs = htmlspecialchars(strip_tags($this->turnover_lacs));
        $this->no_of_trades = htmlspecialchars(strip_tags($this->no_of_trades));
        $this->deliv_qty = htmlspecialchars(strip_tags($this->deliv_qty));
        $this->deliv_per = htmlspecialchars(strip_tags($this->deliv_per));
        
        //bind new values
        $stmt->bindParam(':symbol', $this->symbol);
        $stmt->bindParam(':trading_date', $this->trading_date);
        $stmt->bindParam(':series', $this->series);
        $stmt->bindParam(':prev_close', $this->prev_close);
        $stmt->bindParam(':open', $this->open);
        $stmt->bindParam(':high', $this->high);
        $stmt->bindParam(':low', $this->low);
        $stmt->bindParam(':close', $this->close);
        $stmt->bindParam(':last_price', $this->last_price);
        $stmt->bindParam(':avg_price', $this->avg_price);
        $stmt->bindParam(':ttl_trd_qnty', $this->ttl_trd_qnty);
        $stmt->bindParam(':turnover_lacs', $this->turnover_lacs);
        $stmt->bindParam(':no_of_trades', $this->no_of_trades);
        $stmt->bindParam(':deliv_qty', $this->deliv_qty);
        $stmt->bindParam(':deliv_per', $this->deliv_per);

        //execute the query
        if($stmt->execute()){
            return true;
        }

        return false;
    }


    //Delete the record
    function delete(){

        //delete query
        $query = "DELETE FROM ".$this->table_name." WHERE symbol = ? AND trading_date = ? AND series = ?";

        //prepare query
        $stmt = $this->conn->prepare($query);

        //sanitize
        $this->symbol = htmlspecialchars(strip_tags($this->symbol));
        $this->trading_date = htmlspecialchars(strip_tags($this->trading_date));
        $this->series = htmlspecialchars(strip_tags($this->series));

        //bind the symbol, trading_date and series to delete
        $stmt->bindParam(1, $this->symbol);
        $stmt->bindParam(2, $this->trading_date);
        $stmt->bindParam(3, $this->series);

        //execute query
        if($stmt->execute()){
            return true;
        }

        return false;
    }


    function search($keywords){

        //select all query
        $query = "SELECT 
        s.SYMBOL, 
        s.TRADING_DATE,
        s.SERIES,
        s.PREV_CLOSE,
        s.OPEN,
        s.HIGH,
        s.LOW,
        s.CLOSE, 
        s.LAST_PRICE,
        s.AVG_PRICE,
        s.TTL_TRD_QNTY,
        s.TURNOVER_LACS,
        s.NO_OF_TRADES,
        s.DELIV_QTY,
        s.DELIV_PER FROM ".$this->table_name." s WHERE 
        s.SYMBOL LIKE ? OR s.TRADING_DATE LIKE ? OR s.SERIES LIKE ?";

        //prepare query statement
        $stmt = $this->conn->prepare($query);

        //sanitize
        $keywords = htmlspecialchars(strip_tags($keywords));
        $keywords = "%{$keywords}%";

        //bind
        $stmt->bindParam(1, $keywords);
        $stmt->bindParam(2, $keywords);
        $stmt->bindParam(3, $keywords);

        //execute query
        $stmt->execute();

        return $stmt;

    }

    //Read the stock records with pagination
    public function readPaging($from_record_num, $records_per_page){

        //select query
        $query = "SELECT s.SYMBOL, 
                        s.TRADING_DATE, 
                        s.SERIES, 
                        s.PREV_CLOSE,
                        s.OPEN,
                        s.HIGH,
                        s.LOW,
                        s.CLOSE,
                        s.LAST_PRICE,
                        s.AVG_PRICE,
                        s.TTL_TRD_QNTY,
                        s.TURNOVER_LACS,
                        s.NO_OF_TRADES,
                        s.DELIV_QTY,
                        s.DELIV_PER FROM ".$this->table_name." s 
                        ORDER BY s.TRADING_DATE
                        LIMIT ? OFFSET ?";
        
        //prepare query statement
        $stmt = $this->conn->prepare($query);

        //bind variable values
        $stmt->bindParam(1, $records_per_page, PDO::PARAM_INT);
        $stmt->bindParam(2, $from_record_num, PDO::PARAM_INT);

        //execute query
        $stmt->execute();

        //return the values
        return $stmt;
    }

    //Get the count of records; Used for read paging script
    public function count(){
        $query = "SELECT COUNT(*) AS total_rows FROM ".$this->table_name."";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row['total_rows'];
    }

}


?>