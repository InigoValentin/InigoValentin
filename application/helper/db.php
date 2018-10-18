<?php


    /**
     * Creates a database connection using the data in the config files.
     * 
     * @return MySQL_connection Connection to the database.
     */
    function start_db(){
        global $auth;
        $db = mysqli_connect($auth["host"], $auth["user"], $auth["pass"], $auth["name"]);

        // Check connection
        if (mysqli_connect_errno()){
            error_log("Failed to connect to database: " . mysqli_connect_error());
            return -1;
        }

        //Set encoding options
        mysqli_set_charset($db, "utf-8");
        header("Content-Type: text/html; charset=utf8");
        mysqli_query($db, "SET NAMES utf8;");

        return $db;
    }

?>
