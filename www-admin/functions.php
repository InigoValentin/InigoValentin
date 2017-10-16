<?php

    $IMG_SIZE_PREVIEW = 600;
    $IMG_SIZE_MINIATURE = 200;


    /*****************************************************
     * This function is called from almost everywhere at *
     * the beggining of the page. It initializes the     *
     * session variables, connect to the db, enabling    *
     * the variable $con for futher use everywhere in    *
     * the php code, and populates the arrays $user      *
     * and $permission, with info about the user.        *
     *                                                   *
     * @return: (db connection): The connection handler. *
     *****************************************************/
    function start_db(){
        //Include the db configuration file. It's somehow like this
        /*
        <?php
            $db_host = "XXXX";
            $db_name = "XXXX";
            $db_user = "XXXX";
            $db_pass = "XXXX";
        ?>
        */
        include ".htpasswd";

        $con = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

        // Check connection
        if (mysqli_connect_errno()){
            error_log("Failed to connect to database: " . mysqli_connect_error());
            return -1;
        }

        //Set encoding options
        mysqli_set_charset($con, "utf-8");
        header("Content-Type: text/html; charset=utf8");
        mysqli_query($con, "SET NAMES utf8;");

        //Return the db connection
        return $con;
    }


    /*****************************************************
     * Finds out the protocol the user is connecting to  *
     * the site with (http or https)                     *
     * @return: (string): "http://" or "https://".       *
     ****************************************************/
    function get_protocol(){
        if (isset($_SERVER["HTTPS"]) && ($_SERVER["HTTPS"] == "on" || $_SERVER["HTTPS"] == 1) || isset($_SERVER["HTTP_X_FORWARDED_PROTO"]) && $_SERVER["HTTP_X_FORWARDED_PROTO"] == "https") {
            $protocol = "https://";
        }
        else {
            $protocol = "http://";
        }
        return $protocol;
    }


    /****************************************************
    * This function turns a date string into a human    *
    * readable string, deppending o the specified       *
    * language.                                         *
    * @params:                                          *
    *    strdate: (string): Date string.                *
    *    lang: (string): Language code (es, en, eu).    *
    *    http_accept_language: (string) Raw header with *
    *                          info about client        *
    *                          language preferences.    *
    *    time: (boolean): Append the time at the end.   *
    * @return: (string array) List of the languages     *
    *          offered, sorted by prefference.          *
    ****************************************************/
    function format_date($strdate, $lang, $time = true){
        $date = strtotime($strdate);
        $year = date('o', $date);
        $month = date('n', $date);
        $month --;
        $day = date('j', $date);
        $wday = date('N', $date);
        $wday --;
        $hour = date('H', $date);
        $minute = date('i', $date);
        switch ($lang){
            case 'en':
                $week = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
                $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
                if ($time){
                    $str = "$week[$wday], $months[$month] $day, $year at $hour:$minute";
                }
                else{
                    $str = "$week[$wday], $months[$month] $day, $year";
                }
                break;
            case 'eu':
                $week = ['astelehena', 'asteartea', 'asteazkena', 'osteguna', 'ostirala', 'larumbata', 'igandea'];
                $months = ['urtarrilaren', 'otsailaren', 'martxoaren', 'apirilaren', 'maiatzaren', 'ekainaren', 'uztailaren', 'abuztuaren', 'irailaren', 'urriaren', 'azaroaren', 'abenduaren'];
                if ($time){
                    $str = $year . "ko $months[$month] $day" . "an, $week[$wday], $hour:$minute";
                }
                else{
                    $str = $year . "ko $months[$month] $day" . "an, $week[$wday]";
                }
                break;
            default:
                $week = ['Lunes', 'Martes', 'Mi&eacute;rcoles', 'Jueves', 'Viernes', 'S&aacute;bado', 'Domingo'];
                $months = ['enero', ' febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'];
                if ($time){
                    $str = "$week[$wday] $day de $months[$month] de $year a las $hour:$minute";
                }
                else{
                    $str = "$week[$wday] $day de $months[$month] de $year";
                }
        }
        return $str;
    }


    /*****************************************************
     * Generates a URL-valid string from a regular one.  *
     *                                                   *
     * @params:                                          *
     *    text: (string): Original string.               *
     * @return: (string): URL-valid string.              *
     *****************************************************/
    function permalink($text){
        $unwanted_array = array("Š"=>"S", "š"=>"s", "Ž"=>"Z", "ž"=>"z", "À"=>"A", "Á"=>"A", "Â"=>"A", "Ã"=>"A", "Ä"=>"A", "Å"=>"A", "Æ"=>"A", "Ç"=>"C", "È"=>"E", "É"=>"E",
                            "Ê"=>"E", "Ë"=>"E", "Ì"=>"I", "Í"=>"I", "Î"=>"I", "Ï"=>"I", "Ñ"=>"N", "Ò"=>"O", "Ó"=>"O", "Ô"=>"O", "Õ"=>"O", "Ö"=>"O", "Ø"=>"O", "Ù"=>"U",
                            "Ú"=>"U", "Û"=>"U", "Ü"=>"U", "Ý"=>"Y", "Þ"=>"B", "ß"=>"Ss", "à"=>"a", "á"=>"a", "â"=>"a", "ã"=>"a", "ä"=>"a", "å"=>"a", "æ"=>"a", "ç"=>"c",
                            "è"=>"e", "é"=>"e", "ê"=>"e", "ë"=>"e", "ì"=>"i", "í"=>"i", "î"=>"i", "ï"=>"i", "ð"=>"o", "ñ"=>"n", "ò"=>"o", "ó"=>"o", "ô"=>"o", "õ"=>"o",
                            "ö"=>"o", "ø"=>"o", "ù"=>"u", "ú"=>"u", "û"=>"u", "ý"=>"y", "þ"=>"b", "ÿ"=>"y" );
        $str = strtr( $text, $unwanted_array );
        $str = preg_replace("/[^\da-zA-Z ]/i", "", $str);
        $str = str_replace(" ", "-", $str);
        return $str;
    }


    /*****************************************************
     * Retrieves a text fragment from the database.      *
     *                                                   *
     * @params:                                          *
     *    con (Mysql connection): Connection handler.    *
     *    id: (string): Text identifier.                 *
     *    lang: (string): Language identifier.           *
     * @return: (string): Text.                          *
     *****************************************************/
    function text($con, $id, $lang){
        $q = mysqli_query($con, "SELECT text, file FROM text WHERE id = '$id' AND lang = '$lang';");
        $r = mysqli_fetch_array($q);
        if (strlen($r["file"]) > 0){
            return file_get_contents($_SERVER["DOCUMENT_ROOT"] . "string/" . $r["file"]);
        }
        else{
            return $r["text"];
        }
    }


    /*****************************************************
     * This function closes all the opened HTML tags in  *
     * a given string.                                   *
     *                                                   *
     * @params:                                          *
     *    html: (string): The string with HTML tags.     *
     * @return: (string): HTML with closed tags.         *
     *****************************************************/
    function close_tags($html) {
        preg_match_all("#<(?!meta|img|br|hr|input\b)\b([a-z]+)(?: .*)?(?<![/|/ ])>#iU", $html, $result);
        $openedtags = $result[1];
        preg_match_all("#</([a-z]+)>#iU", $html, $result);
        $closedtags = $result[1];
        $len_opened = count($openedtags);
        if (count($closedtags) == $len_opened) {
            return $html;
        }
        $openedtags = array_reverse($openedtags);
        for ($i=0; $i < $len_opened; $i++) {
            if (!in_array($openedtags[$i], $closedtags)) {
                $html .= "</".$openedtags[$i].">";
            } else {
                unset($closedtags[array_search($openedtags[$i], $closedtags)]);
            }
        }
        return $html;
    }



    /*****************************************************
     * Text shortener. Given a string, it trims in the   *
     * proximity of the desired string, ut to the next   *
     * white character. If indicated, it will append a   *
     * link to the full text.                            *
     *                                                   *
     * @params:                                          *
     *    text: (string): The text to shorten.           *
     *    length: (int): The desired length.             *
     *    linktext: (string): Text fot the link.         *
     *    link: (string): URI of the full text.          *
     * @return: (string): Cutted text.                   *
     *****************************************************/
     function cut_text($text, $length, $linktext, $link){
        if (strlen($text) < $length){
            return $text;
        }
        $cut = substr($text, 0, strpos($text, " ", $length));
        $cut = closeTags($cut);
        if (strlen($cut) == 0){
            $cut = $text;
        }
        if (strlen($text) != strlen($cut)){
            $cut = $cut . "... <a href='$link'>$linktext</a>";
        }
        return $cut;
    }


    /*****************************************************
     * Finds out the IP address of the client.           *
     *                                                   *
     * @return: (String): Client IP address.             *
     *****************************************************/
    function get_ip(){
        $client  = @$_SERVER["HTTP_CLIENT_IP"];
        $forward = @$_SERVER["HTTP_X_FORWARDED_FOR"];
        $remote  = $_SERVER["REMOTE_ADDR"];
        if(filter_var($client, FILTER_VALIDATE_IP)){
            $ip = $client;
        }
        elseif(filter_var($forward, FILTER_VALIDATE_IP)){
            $ip = $forward;
        }
        else{
            $ip = $remote;
        }
        return $ip;
    }


    /*****************************************************
     * Tries to login a user to the internal page.       *
     *                                                   *
     * @params:                                          *
     *    con (Mysql connection): Connection handler.    *
     *    user (string): Username, plain text.           *
     *    pass (string): Password SHA-1 sum.             *
     * @return: (boolean): True if user pass/match,      *
     *          false otherwise.                         *
     *****************************************************/
    function login($con, $user, $pass){
        session_start();
        $q = mysqli_query($con,"SELECT id, salt, username AS username, sha1(salt) AS s FROM user WHERE (lower(username) = lower('$user') OR lower(email) = lower('$user')) AND password = sha1(concat('$pass', sha1(salt)));");
        if (mysqli_num_rows($q) == 1){
            $r = mysqli_fetch_array($q);
            $_SESSION['id'] = $r['id'];
            $_SESSION['salt'] = $r['s'];
            $_SESSION['name'] = $r['username'];
            return true;
        }
        else{
            error_log("Invalid login. username = $user, id = $r[id];");
            return false;
        }
    }


    /*****************************************************
     * Checks if a user is logged in.                    *
     *                                                   *
     * @params:                                          *
     *    con (Mysql connection): Connection handler.    *
     * @return: (boolean): True if the user is signed    *
     *          in, false otherwise.                     *
     *****************************************************/
    function check_session($con){
        session_start(['cookie_lifetime' => 1800,]);
        $qr = mysqli_query($con, "SELECT id FROM user WHERE id = '$_SESSION[id]' AND sha1(salt) = '$_SESSION[salt]';");
        //error_log("SELECT id FROM user WHERE id = '$_SESSION[id]' AND md5(salt) = '$_SESSION[salt]';");
        if (mysqli_num_rows($qr) == 1)
            return true;
        else{
            return false;
            error_log("Invalid session. username = $_SESSION[name], id = $_SESSION[id]");
        }
    }


    /*****************************************************
     * Performs an update in the database.               *
     *                                                   *
     * @params:                                          *
     *    con (Mysql connection): Connection handler.    *
     *    s_table (string): Table name.                  *
     *    s_column (string): Column name.                *
     *    type (string): Column type (VARCHAR, NUMBER,   *
     *         DATE or TIME. If the value to insert in   *
     *         null, type must be NULL).                 *
     *    s_value (string): New value. Ignoered if type  *
     *            is NULL.                               *
     *    id (string): Row id. If the table doesn't have *
     *       a column named 'id', this can't be used.    *
     *****************************************************/
    function db_update($con, $s_table, $s_column, $type, $s_value, $id){
        $table = mysqli_real_escape_string($con, $s_table);
        $column = mysqli_real_escape_string($con, $s_column);
        switch (strtoupper($type)){
            case "NULL":
                $value = "null";
                break;
            case "VARCHAR":
                $value = "'" . mysqli_real_escape_string($con, $s_value) . "'";
                break;
            case "NUMBER":
                $value = intval(mysqli_real_escape_string($con, $s_value));
                break;
            case "DATE":
                if (!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1]) \d{2}:\d{2}:\d{2}$/",$s_value)){
                    return -2;
                }
                $value = "str_to_date('$s_value', '%Y-%m-%d')";
                break;
            case "TIME":
                if (!preg_match("^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1]) (0[0-9]|1[0-9]|2[0-3]):([0-5][0-9]):([0-5][0-9])$",$s_value)){
                    return -2;
                }
                $value = "str_to_date('$s_value', '%Y-%m-%d %H:%i:%s')";
                break;
            default:
                return -1;
        }
        $q = mysqli_query($con, "UPDATE $table SET $column = $value WHERE id = $id;");
        return 0;
    }


    /*****************************************************
     * Performs a delete                .                *
     *                                                   *
     * @params:                                          *
     *    con (Mysql connection): Connection handler.    *
     *    s_table (string): Table name.                  *
     *    id (string): Row id. If the table doesn't have *
     *       a column named 'id', this can't be used.    *
     *****************************************************/
    function db_delete($con, $s_table, $id){
        $table = mysqli_real_escape_string($con, $s_table);
        $q = mysqli_query($con, "DELETE FROM $table WHERE id = $id;");
        return 0;
    }
?>
