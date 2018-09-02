<?php

    require_once("../application/config/config.php");
    require_once("../application/config/auth.php");
    require_once($path["helper"] . "db.php");
    require_once($path["helper"] . "text.php");
    require_once($path["helper"] . "net.php");
    require_once($path["model"] . "model.php");
    foreach (glob($path["model"] . "*.php") as $modelname){
        require_once($modelname);
    }

    $model = null;

    class Controller {

        public function __construct(){}

        public function handle_request($params){

            global $path;
            global $model;

            // Get language (first param)
            // TODO GET
            //$lang = $params[0];
            $lang = 'en';

            // Connect to the database
            $con = start_db();

            if ($params == null || count($params) == 0){
                // This should not be possible due to language redirects
                // TODO: remove home
                $model = new Home();
            }
            elseif (count($params) == 1){
                // Home screen
                $model = new Home();
            }
            else{
                // TODO: Other sections
                $model = new Home();
            }


            // Load the view
            $model->lang = $lang;
            $model->con = $con;
            $model->prepare();
            //require_once($model->view);
            error_log("INCLUDING " . $model->view);
            include $model->view;
        }
    }
?>
