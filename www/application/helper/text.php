<?php


    /**
     * Selects the language the page will be displayed on.
     * 
     * First, it tries to read the language cookie in the client. If none is
     * set, get the browser language preference list. If none is provided or
     * they are not supported, it will use the default language.
     * 
     * @param MySQL_connection $db Connection to the database.
     * @return string Lowercase, two-letter language code.
     */
    function select_language($db){

        // Get available languages from db
        $available_languages = array();
        $q_lang = mysqli_query($db, "SELECT code FROM lang WHERE active = 1;");
        while ($r_lang = mysqli_fetch_array($q_lang)){
            array_push($available_languages, $r_lang["code"]);
        }

        // Is there a language cookie installed on the client?.
        header("Cache-control: private");
        if (isSet($_COOKIE["lang"])){
            $lang = $_COOKIE["lang"];
            if (in_array($lang, $available_languages)){
                header("Location: " . get_protocol() . $_SERVER["HTTP_HOST"] . "/" . $lang . $_SERVER["REQUEST_URI"]);
                return $lang;
            }
        }

        // If no cookie, select from client browser preferences.
        $lang = prefered_language($available_languages, $_SERVER["HTTP_ACCEPT_LANGUAGE"]);
        if (in_array($lang, $available_languages)){
            header("Location: " . get_protocol() . $_SERVER["HTTP_HOST"] . "/" . $lang . $_SERVER["REQUEST_URI"]);
            return $lang;
        }

        // If no method was succesfull, default language
        $lang = $available_languages[0];
        header("Location: " . get_protocol() . $_SERVER["HTTP_HOST"] . "/" . $lang . $_SERVER["REQUEST_URI"]);
        return $lang;
    }


    /**
     * Parses the language prefrences of the client broser, comparing them to
     * the languages offered by the site and selects the prefered one among
     * the ones supported.
     * 
     * @param string[] available_languages List of lowercase, two-letter
     *                                      language codes allowed by the site.
     * @param string http_accept_language Raw header with info about client
     *                                    language preferences.
     * @return string Lowercase, two-letter code of the prefered available
     *                language.
     */
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
        return $langs[0];
    }


    /**
     * Tturns a date string into a human readable string on the specified
     * language. Only works for spanish, basque and english.
     * 
     * @param string $str_date Date string ('yyyy-mm-dd' or 'yyyy-mm-dd HH:MM:SS')
     * @param string $lang Language code (es, en, eu).
     * @param string $time Append the time at the end.
     * @return string Formatted date string.
     */
    function format_date($str_date, $lang, $time = true){
        $date = strtotime($str_date);
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


    /**
     * Retrieves a text fragment from the database.
     * 
     * @param Page|Entity $model An initialized data model.
     * @param string $id Text identifier.
     * @returns string The text.
     */
    function text($model, $id){
        global $path;
error_log("SELECT text, file FROM text WHERE id = '$id' AND lang = '" . $model->lang . "';");
        $q = mysqli_query($model->db, "SELECT text, file FROM text WHERE id = '$id' AND lang = '" . $model->lang . "';");
        $r = mysqli_fetch_array($q);
        if (strlen($r["file"]) > 0){
            return file_get_contents($path["string"] . $r["file"]);
        }
        else{
            return $r["text"];
        }
    }


    /**
     * This function closes all the opened HTML tags in a given string.
     * 
     * @param string html The string with HTML tags.
     * @return string HTML with closed tags.
     */
    function close_tags($html) {
        $result = [];
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


    /**
     * Text shortener. Given a string, it trims in the proximity of the
     * desired string, up to the next white character. If indicated, it will
     * append a link to the full text.
     * 
     * @param string $text The text to shorten.
     * @param int $length The desired length.
     * @param string $link_text Text for the link. Optional.
     * @param string $link URI of the link.
     * @return string Shortened text.
     */
     function cut_text($text, $length, $link_text = "", $link = ""){
        if (strlen($text) < $length){
            return $text;
        }
        $cut = substr($text, 0, strpos($text, " ", $length));
        $cut = close_tags($cut);
        if (strlen($cut) == 0){
            $cut = $text;
        }
        if (strlen($text) != strlen($cut) && strlen($link) > 0 && strlen($link_text) > 0){
            $cut = $cut . "... <a href='$link'>$link_text</a>";
        }
        return $cut;
    }

?>

