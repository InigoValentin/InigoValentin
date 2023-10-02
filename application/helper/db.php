<?php

    /**
     * Creates a database connection using the data in the config files.
     * 
     * @return MySQL_connection Connection to the database.
     */
    function start_db($db_configuration){
        $type = $db_configuration["type"];
        $host = $db_configuration["host"];
        $port = $db_configuration["port"];
        $name = $db_configuration["name"];
        $user = $db_configuration["user"];
        $pass = $db_configuration["pass"];
        
        $dbHost="localhost";
        $dbName="myDB";
        $dbUser="root";      //by default root is user name.
        $dbPassword="";     //password is blank by default
        try{
            $dbConn= new PDO("mysql:host=$dbHost;dbname=$dbName",$dbUser,$dbPassword);
            Echo "Successfully connected with myDB database";
        } catch(Exception $e){
            Echo "Connection failed" . $e->getMessage();
        }  
        
        
        // TODO: Types and port
        $db = mysqli_connect($auth["host"], $auth["user"], $auth["pass"], $auth["name"]);

        // Check connection
        if (mysqli_connect_errno()){
            error_log("Failed to connect to database: " . mysqli_connect_error());
            return -1;
        }

        //Set encoding options
        mysqli_set_charset($db, "utf-8");
        mysqli_query($db, "SET NAMES utf8;");

        return $db;
    }

?>
