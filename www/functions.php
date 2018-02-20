<?php


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


    /*****************************************************
     * This function selects the language the page will  *
     * be displayed inf the page. Several methods are    *
     * used: cookie detection, and browser language      *
     * preferences.                                      *
     * @return: (string): Language code.                 *
     *****************************************************/
    // TODO: Redo using database
    function select_language(){

        // Check for language in uri
        $lang = substr($_SERVER['REQUEST_URI'], 1, 2);
        if ($lang == "es" || $lang == "en" || $lang == "eu"){
            return $lang;
        }
        else{
            // Language is not in url. Find it out and redirect
            // Is passed on the URL?
            $lang = $_GET["lang"];
            if ($lang == "es" || $lang == "en" || $lang == "eu"){
                header("Location: " . get_protocol() . $_SERVER["HTTP_HOST"] . "/" . $lang . $_SERVER["REQUEST_URI"]);
                return $lang;
            }

            // Try to read cookie.
            header("Cache-control: private");
            if (isSet($_COOKIE["lang"])){
                $lang = $_COOKIE["lang"];
                if ($lang == "es" || $lang == "en" || $lang == "eu"){
                    header("Location: " . get_protocol() . $_SERVER["HTTP_HOST"] . "/" . $lang . $_SERVER["REQUEST_URI"]);
                    return $lang;
                }
            }

            //If no cookie, select from client browser preferences.
            else{
                $available_languages = array("en", "eu", "es");
                $langs = prefered_language($available_languages, $_SERVER["HTTP_ACCEPT_LANGUAGE"]);
                $lang = $langs[0];
                if ($lang == "es" || $lang == "en" || $lang == "eu"){
                    header("Location: " . get_protocol() . $_SERVER["HTTP_HOST"] . "/" . $lang . $_SERVER["REQUEST_URI"]);
                    return $lang;
                }
            }

            // If no method was succesfull, default language
            $lang = "es";
            header("Location: " . get_protocol() . $_SERVER["HTTP_HOST"] . "/" . $lang . $_SERVER["REQUEST_URI"]);
            return $lang;
        }
    }


    /*****************************************************
     * This function parses the language prefrences of   *
     * the client broser, comparing them to th languages *
     * offered by the site.                              *
     *                                                   *
     * @params:                                          *
     *    available_languages: (string array) Contains   *
     *                         a list of strins offered  *
     *                         by the site.              *
     *    http_accept_language: (string) Raw header with *
     *                          info about client        *
     *                          language preferences.    *
     * @return: (string array) List of the languages     *
     *          offered, sorted by prefference.          *
     *****************************************************/
    function prefered_language(array $available_languages, $http_accept_language) {

        $available_languages = array_flip($available_languages);

        $langs;
        preg_match_all("~([\w-]+)(?:[^,\d]+([\d.]+))?~", strtolower($http_accept_language), $matches, PREG_SET_ORDER);
        foreach($matches as $match) {

            list($a, $b) = explode("-", $match[1]) + array("", "");
            $value = isset($match[2]) ? (float) $match[2] : 1.0;

            if(isset($available_languages[$match[1]])) {
                $langs[$match[1]] = $value;
                continue;
            }

            if(isset($available_languages[$a])) {
                $langs[$a] = $value - 0.1;
            }

        }
        arsort($langs);

        return $langs;
    }


    /*****************************************************
     * This function turns a date string into a human    *
     * readable string, deppending o the specified       *
     * language.                                         *
     *                                                   *
     * @params:                                          *
     *    strdate: (string): Date string.                *
     *    lang: (string): Language code (es, en, eu).    *
     *    time: (boolean): Append the time at the end.   *
     * @return: (string): Formatted date string.         *
     *****************************************************/
    function format_date($strdate, $lang, $time = true){
        $date = strtotime($strdate);
        $year = date("o", $date);
        $month = date("n", $date);
        $month --;
        $day = date("j", $date);
        $wday = date("N", $date);
        $wday --;
        $hour = date("H", $date);
        $minute = date("i", $date);
        switch ($lang){
            case "en":
                $week = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"];
                $months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
                if ($time){
                    $str = "$week[$wday], $months[$month] $day, $year at $hour:$minute";
                }
                else{
                    $str = "$week[$wday], $months[$month] $day, $year";
                }
                break;
            case "eu":
                $week = ["astelehena", "asteartea", "asteazkena", "osteguna", "ostirala", "larumbata", "igandea"];
                $months = ["urtarrilaren", "otsailaren", "martxoaren", "apirilaren", "maiatzaren", "ekainaren", "uztailaren", "abuztuaren", "irailaren", "urriaren", "azaroaren", "abenduaren"];
                if ($time){
                    $str = $year . "ko $months[$month] $day" . "an, $week[$wday], $hour:$minute";
                }
                else{
                    $str = $year . "ko $months[$month] $day" . "an, $week[$wday]";
                }
                break;
            default:
                $week = ["Lunes", "Martes", "Mi&eacute;rcoles", "Jueves", "Viernes", "S&aacute;bado", "Domingo"];
                $months = ["enero", " febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre"];
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
        $cut = close_tags($cut);
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
     * Registers the page viewed by the user. If it is   *
     * first page shown in his visit, it also registers  *
     * the visit. It will also increase the ad views     *
     * count (if any was shown).                         *
     *                                                   *
     * @params:                                          *
     *    con (Mysql connection): Connection handler.    *
     *    section: (string): Site section being visited. *
     *    id: (int): ID of the entri being visited       *
     *****************************************************/
    function stats($con, $section, $id){

        // Get client data
        $ip = get_ip();
        $browser_data = get_browser(null, true);
        $os = $browser_data["platform"];
        $browser = $browser_data["browser"];
        $uagent = $browser_data["browser_name_pattern"];
        //If bot, do nothing
        $bot_kw = Array();
        $bot_kw[0] = "bot";
        $bot_kw[1] = "spider";
        $bot_kw[2] = "crawl";
        $bot_kw[3] = ".com";
        $bot_kw[4] = ".ru";
        $bot_kw[5] = "baidu";
        $bot_kw[6] = "survey";
        $bot_kw[7] = "scan";
        $bot_kw[8] = "feed";
        $bot_kw[9] = "bing";
        $bot_kw[10] = "yahoo";
        $bot_kw[11] = "engine";
        $bot_kw[12] = "preview";
        $bot_kw[13] = "checker";
        $bot_kw[14] = "catalog";
        $bot_kw[15] = "accelerator";
        $bot_kw[16] = "python";
        $bot_kw[14] = "qt";
        $bot_kw[15] = "webdav";
        $bot_kw[16] = "http";
        $bot_kw[17] = "url";
        $bot_kw[18] = "fake";
        $bot_kw[19] = "library";
        $bot_kw[20] = "commerce";
        $bot_kw[21] = "htmlbot";
        $bot_kw[22] = "fetch";
        $bot_kw[23] = "googleb";
        $bot_kw[24] = "facebook";
        $bot_kw[25] = "whatsapp";
        $bot_kw[26] = "pinterest";
        $bot_kw[27] = "scrapy";
        $bot_kw[28] = "libwww";
        $bot_kw[29] = "java standard library";
        $bot_kw[30] = "default browser";
        $bot_kw[31] = "twingly recon";
        $bot_kw[32] = "siteexplorer";
        $bot_kw[33] = "yandex";
        $bot_kw[34] = "wotbox";
        $bot_kw[35] = "apache synapse";
        $bot_kw[36] = "catexplorador";
        $bot_kw[37] = "internet archive";

        $i = 0;
        while ($i < sizeof($bot_kw)) {
            if (strpos(strtolower($uagent), $bot_kw[$i]) !== false || strpos(strtolower($browser), $bot_kw[$i]) !== false){
                mysqli_close($con);
                return;
            }
            $i ++;
        }
        if (strlen($os) == 0 || strlen($browser) == 0){ // Certain chinese hosting provider makes a lot of requests...
            mysqli_close($con);
            return;
        }

        //Look for a visit with the same IP in the last 30 mins.
        $q = mysqli_query($con, "SELECT stat_visit.id AS visitid FROM stat_view, stat_visit WHERE visit = stat_visit.id AND dtime > DATE_SUB(now(), INTERVAL 30 MINUTE) AND ip = '$ip' AND uagent = '$uagent';");
        if (mysqli_num_rows($q) == 0){
            mysqli_query($con, "INSERT INTO stat_visit (ip, uagent, os, browser) VALUES ('$ip', '$uagent', '$os', '$browser');");
            $q = mysqli_query($con, "SELECT stat_visit.id AS visitid FROM stat_visit WHERE ip = '$ip' AND uagent = '$uagent' ORDER BY stat_visit.id DESC LIMIT 1;");
        }
        $r = mysqli_fetch_array($q);
        $visit = $r['visitid'];
        mysqli_query($con, "INSERT INTO stat_view (visit, section, entry) VALUES ($visit, '$section', '$id');");

    }
?>

