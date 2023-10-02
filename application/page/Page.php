<?php
/**
 * Page superclass file.
 *
 * Provides a class with all the properties and methods to display the page.
 *
 * @author Iñigo Valentin <i@inigovalentin.com>
 * @license https://www.gnu.org/licenses/gpl-3.0.en.html GNU General Public License V3
 * @package IVV
 */

/**
 * Page superclass.
 *
 * Every visitable page type must inherit from this one.
 *
 * @category Page
 */
abstract class Page{

    /**
     * @var string[] List of CSS files required for the page.
     */
    private $css = [];
    
    /**
     * @var string[] List of js files required for the page.
     */
    private $js = [];
    
    /**
     * @var string Path to the view associated with the page.
     */
    private $view;
    
    /**
     * @var string Title of the page, in the defined language.
     */
    private $title;
    
    /**
     * @var string Site name.
     */
    private $name;
    
    /**
     * @var string Page description, in the defined language.
     */
    private $description;
    
    /**
     * @var string URL to the site favicon.
     */
    private $favicon;
    
    /**
     * @var string URL to the page icon or main image.
     */
    private $icon;
    
    /**
     * @var string Canonical URL.
     */
    private $canonical;
    
    /**
     * @var string Autjhor URL.
     */
    private $author;
    
    /**
     * @var integer HTTP status code.
     */
    private $code = 0;
    
    /**
     * @var string HTTP status message.
     */
    private $message = "";
    
    /**
     * Constructor.
     */
    public function __construct(){
        $this->favicon = URL::IMG["LOGO"] . "logo.svg";
        $this->icon = URL::IMG["LOGO"] . "logo.svg";
        $this->name = get_context()->get_user()->get_display_name();
        $this->author = URL::BASE;
        $this->add_css("ui.css");
    }

    /**
     * Adds a CSS file to the list.
     *
     * @param string $css Css file. Can be the absolute URL, or just the filename.
     */
    protected function add_css($css){
        if (strripos($css, URL::CSS) === false) $file = URL::CSS . $css;
        else $file = $css;
        array_push($this->css, $file);
    }
    
    /**
     * Adds a JS file to the list.
     *
     * @param string $js JS file. Can be the absolute URL, or just the filename.
     */
    protected function add_js($js){
        if (strripos($js, URL::JS) === false) $file = URL::JS . $js;
        else $file = $js;
        array_push($this->js, $file);
    }
    
    /**
     * Retrieves the CSS file URLs for the page.
     *
     * @return string[] CSS files (by absolute URL.)
     */
    public function get_css(){return $this->css;}
    
    /**
     * Retrieves the JS file URLs for the page.
     *
     * @return string[] JS files (by absolute URL.)
     */
    public function get_js(){return $this->js;}
    
    /**
     * Sets the page view.
     *
     * @param string $view View file. Can be the relative path, or just the filename.
     */
    protected function set_view($view){
        if (strripos($view, PATH::VIEW) === false) $file = PATH::VIEW . $view;
        else $file = $view;
        $this->view = $file;
    }
    
    /**
     * Retrieves the page view file.
     *
     * @return string Path to the view file.
     */
    public function get_view(){return $this->view;}
    
    /**
     * Sets the page title.
     *
     * The user name" will always be added at the end.
     *
     * @param string $title Page title.
     */
    protected function set_title($title){
        $this->title = htmlentities($title, ENT_QUOTES);
        if ($title != "") $this->title = $this->title . " - ";
        $this->title = $this->title . get_context()->get_user()->get_display_name();
    }
    
    /**
     * Retrieves the page title.
     *
     * @return string Page title.
     */
    public function get_title(){return $this->title;}
    
    /**
     * Retrieves the site name.
     *
     * @return string Site name.
     */
    public function get_name(){return $this->name;}
    
    /**
     * Sets the page description.
     *
     * The user tagline will always be added at the end.
     *
     * @param string $description Page description text.
     */
    protected function set_description($description){
        $this->description = htmlentities($description, ENT_QUOTES);
        if ($description != "") $this->description = $this->description . " - ";
        $this->description = $this->description . get_context()->get_user()->get_text("TAGLINE");
    }
    
    /**
     * Retrieves the page description
     *
     * @return string Page description.
     */
    public function get_description(){return $this->description;}
    
    /**
     * Retrieves the URL to the favicon.
     *
     * @return string Favicon URL.
     */
    public function get_favicon(){return $this->favicon;}
    
    /**
     * Retrieves the URL to the thumbnail image.
     *
     * @return string Thmbnail icon URL.
     */
    public function get_icon(){return $this->icon;}
    
    /**
     * Sets the page canonical URL.
     *
     * @param string $canonical Canonical URL, absolute or relative.
     */
    protected function set_canonical($canonical){
        if (strripos($canonical, URL::BASE) === false) $file = URL::BASE . $canonical;
        else $file = $canonical;
        $this->canonical = $file;
    }
    
    /**
     * Retrieves the canonical URL to the page.
     *
     * @return string Canonical URL.
     */
    public function get_canonical(){return $this->canonical;}
    
    /**
     * Retrieves the author URL (site main URL).
     *
     * @return string AUthor URL.
     */
    public function get_author(){return $this->author;}
    
    /**
     * Sets the HTTP status code for the page to return.
     *
     * @param int HTTP status code.
     */
    protected function set_code($code){
        if (is_int($code) && $code >= 200 && $code <= 500) $this->code = $code;
    }
    
    /**
     * Retrieves the page HTTP status code.
     *
     * @return int HTTP status code
     */
    public function get_code(){return $this->code;}
    
    /**
     * Sets the HTTP status message for the page to return.
     *
     * @param string HTTP status message.
     */
    protected function set_message($mesage){$this->message = strval($mesage);}
    
    /**
     * Retrieves the page HTTP status message.
     *
     * @return string HTTP status code
     */
    public function get_message(){return $this->message;}
    
    /**
     * Generates the content to be inserted in the HTML <head> section.
     *
     * It must go between the <head> and </head> tags, and anything can go behind it before closing
     * the section. It includes page title, description, css files and metadata.
     *
     * @return string HTML head content.
     */
    public function generate_head(){
        $head = "
          <meta content='text/html; charset=utf-8' http-equiv='content-type'/>
          <meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1'/>
          <title>" . $this->get_title() . "</title>
          <link rel='shortcut icon' href='" . $this->get_favicon() . "'/>
          <!-- CSS files -->";
        foreach ($this->get_css() as $css){
            $head .= "
          <link rel='stylesheet' type='text/css' href='$css'/>";
        }
        $head .= "
          <!-- JS files -->";
        foreach ($this->get_js() as $js){
            $head .= "
          <script type='text/javascript' src='$js'></script>";
        }
        $head .= "
          <!-- Meta tags -->
          <link rel='canonical' href='" . $this->get_canonical() . "'/>
          <link rel='author' href='" . $this->get_author() . "'/>
          <link rel='publisher' href='" . $this->get_author() . "'/>
          <meta name='description' content='" . $this->get_description() . "'/>";
        foreach (get_context()->get_available_langs() as $lang){
            if ($lang != get_context()->get_lang()){
                $url = substr($this->get_canonical(), strlen(URL::BASE));
                if (substr($url, 0, 3) == get_context()->get_lang() . "/")
                    $url = URL::BASE . $lang . "/" . substr($url, 2);
                else $url = URL::BASE . $lang . "/" . $url;
                $head .= "
          <link rel='alternate' hreflang='$lang' href='$url' />";
            }
        }
        $head .= "
          <meta property='og:title' content='" . $this->get_title() . "'/>
          <meta property='og:url' content='" . $this->get_canonical() . "'/>
          <meta property='og:description' content='" . $this->get_description() . "'/>
          <meta property='og:image' content='" . $this->get_icon() . "'/>
          <meta property='og:site_name' content='" . $this->get_name() . "'/>
          <meta property='og:type' content='website'/>
          <meta property='og:locale' content='en'/>
          <meta name='twitter:card' content='summary'/>
          <meta name='twitter:title' content='" . $this->get_title() . "'/>
          <meta name='twitter:description' content='" . $this->get_description() . "'/>
          <meta name='twitter:image' content='" . $this->get_icon() . "'/>
          <meta name='twitter:url' content='" . $this->get_canonical() . "'/>
          <meta name='robots' content='index follow'/>\n";
        return $head;
    }
    
}
