<?php
/**
 * Controller file.
 *
 * Provides a class to handle all posible request.
 * 
 * @author Iñigo Valentin <i@inigovalentin.com>
 * @license https://www.gnu.org/licenses/gpl-3.0.en.html GNU General Public License V3
 * @package IVV
 */

require_once(__DIR__ . "/Context.php");
require_once(__DIR__ . "/helper/DB_Helper.php");
require_once(__DIR__ . "/helper/TEXT_Helper.php");
require_once(__DIR__ . "/helper/NET_Helper.php");
require_once(__DIR__ . "/helper/HTML_Helper.php");
require_once(__DIR__ . "/util/Log.php");
require_once(__DIR__ . "/util/Path.php");
require_once(__DIR__ . "/util/URL.php");
//require_once(__DIR__ . "/helper/net.php");
//require_once(__DIR__ . "/Application.php");
//require_once(__DIR__ . "/util/Log.php");


/**
 * Application controller.
 *
 * Handles every request, creating the required models and selecting the
 * view.
 *
 * @category Controller
 */
class Controller extends Context{

    /**
     * @var string[] GET parameters received by the controller.
     */
    private $params = [];

    /**
     * @var Context Publicly available context.
     */
    private $context;
    
    private $command = "";
    
    private $status = 201;
    private $message = "OK";
    

    /**
     * Retrieves the application context.
     * 
     * @return Context The context.
     */
    public function get_context(){
        return $this->context;
    }
    
    /**
     * Controller constructor.
     *
     * Initializes a database connection and sets up the public context.
     */
    public function __construct(){
        $this->context = new Context();
        session_start();
        $configuration = parse_ini_file(__DIR__ . "/config/config.ini", true);
        $this->db = DB::start($configuration["database"]);
        $this->context->set_db($this->db);
        Log::debug("Controller created succesfully");
    }
    
    private function execute_action($action){
        require_once(PATH::ACTION . $action . ".php");
        action();
        return;
    }
    
    /**
     * Handles the request parameters.
     *
     * Receives the request params and gets itself ready. Authenticates the user (if needed)
     * and validates the URL.
     *
     * @param string[] $params GET parameters of the request.
     */
    public function prepare($params){

        // Parse parameters.
        foreach($params as $p){
            if (strlen($p) > 0){
                Log::debug("Controller parameter: $p");
                array_push($this->params, $p);
            }
        }
        
        // Obtain the command and process it
        if (sizeof($this->params) > 0){
            $this->command = strtoupper($this->params[0]);
        }
        Log::debug("Controller command set: '" . $this->command . "'");
        switch ($this->command){
            case "": // Main page
                break;
            case "API": // An API call
                return; // End preparation here, the API controller will deal with everything.
                break;
            case "ACTION": // Execute an action
                //$auth_required = true;
                break;
            case "PLAYER": // A player page
                if (sizeof($this->params) > 1){
                    $player_id = $this->params[1];
                }
                else{
                    $this->status = 400;
                    $this->message = "Bad request";
                    return;
                }
                break;
            case "LOGIN": // The login page
                break;
            case "REGISTER": // Registration page
                break;
            case "SEARCH": // Search results
                break;
            case "DUNGEON": // Dungeon static pages
                break;
            case "BUILDING": // Building static pages
                break;
            case "FUSION": // Fusion static pages
                break;
            case "HELP": // Help static page
                break;
            case "ERROR": // Error page
                break;
            default: // Unknown page
                
        }
    }
    
    /**
     * Executes the required action.
     *
     * Must be called after {@see Controller::prepare()}.
     * @return void|number
     */
    public function action(){
        
        Log::debug("Executing action");
        
        // If there was an error in preparation, it's time to throw it.
        if ($this->status >= 400 && $this->status < 500){
            Log::debug("Executing action error code: " . $this->status);
            require_once(PATH::PAGE . "Error_Page.php");
            $page = new Error_Page($this->status, $this->message);
            require_once($page->get_view());
            http_response_code($this->status);
            return $this->status;
        }
        
        // Process the command
        $page = null;
        switch ($this->command){
            case "": // Main page
                require_once(PATH::PAGE . "Home_Page.php");
                $page = new Home_Page();
                break;
            case "ACTION": // Execute an action
                // If no action specified
                if (sizeof($this->params) < 2){
                    require_once(PATH::PAGE . "Error_Page.php");
                    $page = new Error_Page(400, "No action specified.");
                    require_once($page->get_view());
                    http_response_code(400);
                    return 400;
                }
                
                // Process action
                $action = strtoupper($this->params[1]);
                switch ($action){
                    // Special cases where the output must be printed:
                    case "OPTIMIZE_LIST":
                        require_once(PATH::ACTION . "Optimize_List_Action.php");
                        $action = new Optimize_List_Action();
                        break;
                    default:
                        require_once(PATH::PAGE . "Error_Page.php");
                        $page = new Error_Page(404, "Action not found");
                        require_once($page->get_view());
                        http_response_code(404);
                        return;
                }
                $action->execute();
                if (strlen($action->get_output()) > 0){
                    echo($action->get_output());
                }
                http_response_code($action->get_code());
                return $action->get_code();
                break;
            case "PLAYER": // A player page
                if ($this->context->get_player() == null || $this->context->get_player()->get_id() == null){
                    require_once(PATH::PAGE . "Error_Page.php");
                    $page = new Error_Page(404, "Player not found");
                    require_once($page->get_view());
                    http_response_code(404);
                    return;
                }
                if (
                  $this->context->get_player()->is_public() == false &&
                  (
                      $this->context->get_user() == null ||
                    $this->context->get_player()->get_user() != $this->context->get_user()->get_id()
                  )
                ){
                    require_once(PATH::PAGE . "Error_Page.php");
                    $page = new Error_Page(401, "Player profile set to private");
                    require_once($page->get_view());
                    http_response_code(401);
                }
                $subcommand = "";
                if (sizeof($this->params) > 2){
                    $subcommand = strtoupper($this->params[2]);
                }
                $page = null;
                switch ($subcommand){
                    case "": // Player profile
                        require_once(PATH::PAGE . "Player_Page.php");
                        $page = new Player_Page($this->context->get_player()->get_id());
                        break;
                    
                    case "TEAMS":
                        require_once(PATH::PAGE . "Teams_Page.php");
                        $page = new Teams_Page();
                        break;
                }
                break;
            
            case "BUILDINGS": // Building static pages
                if (sizeof($this->params) > 1){
                    require_once(PATH::PAGE . "Building_Page.php");
                    $page = new Building_Page($this->params[1]);
                }
                else{
                    require_once(PATH::PAGE . "Buildings_Page.php");
                    $page = new Buildings_Page();
                }
                break;
                break;
            /*case "FUSION": // Fusion static pages
                require_once(PATH::PAGE . "Fusion_Page.php");
                $page = new Fusion_Page();
                break;*/
            case "HELP": // Help static page
                require_once(PATH::PAGE . "Help_Page.php");
                $page = new Help_Page();
                break;
        }
        
        // If page is not set, it's a not found.
        if ($page == null){
            require_once(PATH::PAGE . "Error_Page.php");
            $page = new Error_Page(404, "Page not found");
        }
        
        // Once the page is loaded, chack if it can be seen
        // TODO verify
        if ($page->get_code() >= 400 && $page->get_code() < 600){
            require_once(PATH::PAGE . "Error_Page.php");
            $page = new Error_Page($page->get_code(), $page->get_message());
            http_response_code($page->get_code());
        }
        
        
        // Load the view, or set an error code.
        Log::debug("Loading view: " . $page->get_view());
        require_once($page->get_view());
        http_response_code($page->get_code());
    }

        /**
         * Constructor.
         *
         * Handles every request, creating the required models and selecting the
         * view.
         */
        /*public function __construct($params){

            global $path;
            global $base_url;
            global $static;
            global $static_url;
            global $base_dir;
            $page;
            
            header("Content-Type: text/html; charset=utf8");
            
            // Read configuration
            // TODO: Read the other params and do something with them.
            $configuration = parse_ini_file(__DIR__ . "/config/config.ini", true);
            $db = DB::start($configuration["database"]);

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
                // Override global to include language in URL
                $base_url = get_protocol() . $_SERVER["HTTP_HOST"] . "/" . $lang;
            }
            else{
                $lang = select_language($db);
            }
            foreach($pars as $p){
                array_push($route, $p);
            }

            // Select the model to load.
            if (sizeof($route) == 0){
                require_once($path["page"] . "Home_Page.php");
                $page = new Home_Page($db, $lang);
            }
            else{
                if (strtoupper($route[0]) == "HELP"){
                    require_once($path["page"] . "Help_Page.php");
                    $page = new Help_Page($db, $lang);
                }
                if (strtoupper($route[0]) == "PROFILE"){
                    require_once($path["page"] . "Profile_Page.php");
                    $page = new Profile_Page($db, $lang);
                }
                elseif (strtoupper($route[0]) == "PROJECT"){
                    if (sizeof($route) > 1){
                        // Project page
                        require_once($path["page"] . "Project_Page.php");
                        $page = new Project_Page($db, $lang, $route[1]);
                    }
                    else{
                        // Project list page
                        require_once($path["page"] . "Projects_Page.php");
                        $page = new Projects_Page($db, $lang);
                    }
                }
            }

            // Load the view, or set an error code.
            if (!isset($page)){
                http_response_code(404);
                require_once($path["page"] . "Error_Page.php");
                $page = new Error_Page($db, $lang);
            }
            require_once($page->view);
        }*/
    }
?>
