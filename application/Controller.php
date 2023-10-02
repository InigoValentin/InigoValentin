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

require_once(__DIR__ . "/helper/DB_Helper.php");
require_once(__DIR__ . "/helper/TEXT_Helper.php");
require_once(__DIR__ . "/helper/NET_Helper.php");
require_once(__DIR__ . "/helper/HTML_Helper.php");
require_once(__DIR__ . "/util/Log.php");
require_once(__DIR__ . "/util/Path.php");
require_once(__DIR__ . "/util/URL.php");
require_once(__DIR__ . "/Context.php");

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
    
    /**
     * @var string URL command (first parameter, excluding optional language).
     */
     private $command = "";
    
     /**
      * @var int HTTP status.
      */
    private $status = 201;

    /**
     * @var string HTTP message.
     */
    private $message = "OK";
    

    /**
     * Retrieves the application context.
     * 
     * @return Context The context.
     */
    public function get_context(){return $this->context;}
    
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
        
        // Check if the first parameter is a language code.
        if (sizeof($this->params) > 0 && $this->context->get_user()->is_valid_language($this->params[0])){
            $this->context->set_lang($this->params[0]);
            $this->params = array_slice($this->params, 1);
        }
        elseif(isSet($_COOKIE['lang']) && $this->context->get_user()->is_valid_language($_COOKIE['lang'])){
            $this->context->set_lang($_COOKIE['lang']);
        }
        else{
            $lang = "";
            // Set a default
            if (sizeof($this->context->get_user()->get_langs()) > 0)
                $lang = $this->context->get_user()->get_langs()[0]->get_code();
            // Get a list of avaiable languages from client browser.
            foreach (explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']) as $accepted) {
                $code = substr($accepted, 0, 2);
                if ($this->context->get_user()->is_valid_language($code)){
                    $lang = $code;
                    break;
                }
            }
            if ($lang != "") $this->context->set_lang($lang);
        }
        
        // Obtain the command and process it
        if (sizeof($this->params) > 0) $this->command = strtoupper($this->params[0]);
        Log::debug("Controller command set: '" . $this->command . "'");
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
            case "PROJECT": // Projects
            case "PROJECTS": // Projects
                if (sizeof($this->params) > 1){
                    require_once(PATH::PAGE . "Project_Page.php");
                    $page = new Project_Page($this->params[1]);
                }
                else{
                    require_once(PATH::PAGE . "Projects_Page.php");
                    $page = new Projects_Page();
                }
                break;
            case "PROFILE": // Profile
                require_once(PATH::PAGE . "Profile_Page.php");
                $page = new Profile_Page();
                break;
            case "HELP": // Help static page
                require_once(PATH::PAGE . "Help_Page.php");
                $page = new Help_Page();
                break;
            case "SITEMAP.XML": // Sitemap file
                require_once(PATH::PAGE . "Sitemap_Page.php");
                $page = new Sitemap_Page();
                break;
            case "ROBOTS.TXT": // robots.txt file
                require_once(PATH::PAGE . "Robots_Page.php");
                $page = new Robots_Page();
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

}
?>
