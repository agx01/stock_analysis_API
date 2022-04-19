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
        $query = "SELECT s.SYMBOL, s.TRADING_DATE, s.SERIES, s.PREV_CLOSE, s.OPEN, s.HIGH, s.LOW, s.CLOSE, s.LAST_PRICE, s.AVG_PRICE, s.TTL_TRD_QNTY, s.TURNOVER_LACS, s.NO_OF_TRADES, s.DELIV_QTY, s.DELIV_PER FROM `".$this->table_name."` s";
        
        
        //prepare query statement
        $stmt = $this->conn->prepare($query);

        //execute query
        $stmt->execute();

        return $stmt;
    }

    function create(){

        //query to insert record
        $query = "INSERT INTO ".$this->table_name. 
                 " SET symbol:=symbol,
                       trading_date:=trading_date,
                       series:=series,
                       prev_close:=prev_close,
                       open:=open,
                       high:=high,
                       low:=low,
                       close:=close,
                       last_price:=last_price,
                       avg_price:=avg_price,
                       ttl_trd_qnty:=ttl_trd_qnty,
                       turnover_lacs:=turnover_lacs,
                       no_of_trades:=no_of_trades,
                       deliv_qty:=deliv_qty,
                       deliv_per:=deliv_per";
        
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
        $this->deliv_qty = htmlspcecialchars(strip_tags($this->deliv_qty));
        $this->deliv_per = htmlspecialchars(strip_tags($this->deliv_per));

        //bind values
        
    }

}

?>