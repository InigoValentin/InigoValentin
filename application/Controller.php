<?php

    require_once(__DIR__ . "/config/config.php");
    require_once($path["helper"] . "db.php");
    require_once($path["helper"] . "text.php");
    require_once($path["helper"] . "net.php");
    foreach (glob($path["page"] . "*.php") as $pagename){
        require_once($pagename);
    }


    /**
     * Application controller.
     *
     * Handles every request, creating the required models and selecting the
     * view.
     */
    class Controller {

        /**
         * Constructor.
         *
         * Handles every request, creating the required models and selecting the
         * view.
         */
        public function __construct($params){

            global $path;
            global $root;
            $page;

            $db = start_db();

            // Parse parameters, get lang and build the route.
            $pars = [];
            foreach($params as $p){
                if (strlen($p) > 0){
                    array_push($pars, $p);
                }
            }
            $route = [];
            if (sizeof($pars) > 0 && preg_match("/^[a-zA-Z]{2}$/", $pars[0])){
                $lang = $pars[0];
                array_splice($pars, 0, 1);
            }
            else{
                $lang = select_language($db);
                // TODO: Redirect to url with lang?
            }
            foreach($pars as $p){
                array_push($route, $p);
            }

            // Select the model to load.
            if (sizeof($route) == 0){
                $page = new Home_Page($db, $lang);
            }
            else{
                if (strtoupper($route[0]) == "HELP"){
                    $page = new Help_Page($db, $lang);
                }
                if (strtoupper($route[0]) == "PROFILE"){
                    $page = new Profile_Page($db, $lang);
                }
                elseif (strtoupper($route[0]) == "PROJECT"){
                    if (sizeof($route) > 1){
                        // Project page
                        $page = new Project_Page($db, $lang, $route[1]);
                    }
                    else{
                        // Project list page
                        $page = new Projects_Page($db, $lang);
                    }
                }
            }

            // Load the view, or set an error code.
            if (isset($page)){
                require_once($page->view);
            }
            else{
                http_response_code(404);
            }
        }
    }
?>
