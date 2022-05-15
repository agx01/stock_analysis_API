<?php

Class Indices {

    private $conn;
    private $table_name = "daily_index_data"

    public $index_name;
    public $trading_date;
    public $open;
    public $high;
    public $close;
    public $pts_change;
    public $change_percent;
    public $volume;
    public $turnover;
    public $p_by_e;
    public $p_by_b;
    public $div_yield;

    //contructor with db connection
    public function __construct($db){
        $this->conn = $db;
    }

    public function read(){
        
        //Select all query
        $query = "SELECT s.INDEX_NAME, s.TRADING_DATE, s.OPEN, s.HIGH, s.LOW, s.CLOSE, s.PTS_CHANGE, s.CHANGE_PERCENT, s.VOLUME, s.TURNOVER, s.P_BY_E, s.P_BY_B, s.DIV_YIELD FROM ".$this->table_name." s";

        //Prepare query statement
        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        return $stmt;
    }

    public function create(){

        //query to insert record 
        $query = "INSERT INTO ".$this->table_name.
                 "SET "
    }

}

?>