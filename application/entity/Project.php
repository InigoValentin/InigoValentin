<?php

require_once(PATH::ENTITY . "Entity.php");
require_once(PATH::ENTITY . "License.php");
require_once(PATH::ENTITY . "Project_Type.php");
require_once(PATH::ENTITY . "Project_Image.php");
require_once(PATH::ENTITY . "Project_Url.php");


/**
 * Project.
 *
 * Represents an object from the table 'project'.
 */
class Project extends Entity{

    /**
     * @var int Project identifier.
     */
    private $id;

    /**
     * @var string Permalink for linking the project (relative).
     */
    private $permalink;

    /**
     * @var int Project index for sorting.
     */
    private $index;

    /**
     * @var int Project type identifier.
     */
    private $type_id;
    
    /**
     * @var Project_Type Type of project.
     */
    private $type;

    /**
     * @var string Project title in the selected language.
     */
    private $title;

    /**
     * @var string Project logo filename.
     */
    private $logo;

    /**
     * @var string Project summary in the selected language.
     */
    private $header;

    /**
     * @var String Project description in the selected language.
     */
    private $text;
    
    /**
     * @var int License identifier.
     */
    private $license_id;

    /**
     * @var License Project license.
     */
    private $license;

    /**
     * @var Project_Image[] List of project images.
     */
    private $images = [];

    /**
     * @var Project_Tag[] List of project tags.
     */
    private $tags = [];

    /**
     * @var Project_URL[] List of the project URLs
     */
    private $urls = [];
    
    /**
     * @var bool[] Control flags to check loading status.
     */
    private $load_flags = [
        "type" => false,
        "images" => false,
        "tags" => false,
        "urls" => false
    ];

    /**
     * Constructor.
     *
     * Searches the database and retrieves the information about the
     * project, populating it and it's items.
     *
     * @param string $id Identifier or permalink of the project.
     */
    public function __construct($id){
        Log::debug("Loading project with ID: " . $id);
        $statement = get_context()->get_db()->prepare("
          SELECT
            id,
            permalink,
            idx,
            type,
            title,
            logo,
            header,
            text,
            license
          FROM project
          WHERE
            id = :id OR
            permalink = :permalink
          LIMIT 1
        ");
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->bindValue(':permalink', $id, PDO::PARAM_STR);
        $statement->execute();
        $r_project = $statement->fetch(PDO::FETCH_ASSOC);
        if ($r_project !== false){
            $this->id = $r_project["id"];
            $this->permalink = $r_project["permalink"];
            $this->idx = $r_project["idx"];
            $this->title = Text::get($r_project["title"]);
            $this->logo = $r_project["logo"];
            $this->header = Text::get($r_project["header"]);
            $this->text = Text::get($r_project["text"]);
            $this->type_id = $r_project["type"];
            $this->license_id = $r_project["license"];
            $this->mark_as_loaded(true);
        }
        else{
            Log::debug("Project with id '$id' doesn't exist");
        }
    }

    /**
     * Retrieves the project identifier
     *
     * @return int Project ID.
     */
    public function get_id(){
        return $this->id;
    }

    /**
     * Retrieves the project permalink
     *
     * @return string Project permalink
     */
    public function get_permalink(){
        return $this->permalink;
    }

    /**
     * Retrieves the project index for sorting purpuses.
     *
     * @return int Project index
     */
    public function get_index(){
        return $this->index;
    }

    /**
     * Loads the project type information.
     * 
     * Not exposed, must be called before accessing the project type.
     */
    private function load_type(){
        if ($this->get_flag("type") === false){
            $this->type = new Project_Type($this->type_id);
            $this->set_flag("type", true);
        }
    }
    
    /**
     * Retrieves the project type.
     *
     * @return Project_Type The project type.
     */
    public function get_type(){
        if ($this->get_flag("type") === false){
            $this->load_type();
        }
        return $this->type;
    }

    /**
     * Retrieves the project title.
     *
     * @return string Title.
     */
    public function get_title(){
        return $this->title;
    }

    /**
     * Retrieves the project logo.
     *
     * @return string The logo filename.
     */
    public function get_logo(){
        return $this->logo;
    }

    /**
     * Retrieves a short project description.
     *
     * @return string Project header.
     */
    public function get_header(){
        return $this->header;
    }

    /**
     * Retrieves the project description.
     *
     * @return string Project description text.
     */
    public function get_text(){
        return $this->text;
    }
    
    /**
     * Loads the project license information.
     *
     * Not exposed, must be called before accessing the project license.
     */
    private function load_license(){
        if ($this->get_flag("license") === false){
            $this->type = new License($this->licenses_id);
            $this->set_flag("license", true);
        }
    }

    /**
     * Retrieves the project license.
     *
     * @return License Project license.
     */
    public function get_license(){
        if ($this->get_flag("license") === false){
            $this->load_license();
        }
        return $this->license;
    }
    
    /**
     * Loads the project images.
     *
     * Not exposed, must be called before accessing the project images.
     */
    private function load_images(){
        if ($this->get_flag("images") === false){
            $statement = get_context()->get_db()->prepare("
              SELECT id 
              FROM project_image
              WHERE project = :id
              ORDER BY idx
            ");
            $statement->bindValue(':id', $this->id, PDO::PARAM_INT);
            $statement->execute();
            while ($r_image = $statement->fetch(PDO::FETCH_ASSOC)){
                array_push($this->images, new Project_Image($r_image["id"]));
            }
            $this->set_flag("images", true);
        }
    }

    /**
     * Retrieves the projcet images
     *
     * @return Project_Image[] List of the project images.
     */
    public function get_images(){
        if ($this->get_flag("images") === false){
            $this->load_images();
        }
        return $this->images;
    }
    
    /**
     * Loads the project tags.
     *
     * Not exposed, must be called before accessing the project tags.
     */
    private function load_tags(){
        if ($this->get_flag("tags") === false){
            $statement = get_context()->get_db()->prepare("
              SELECT id
              FROM project_tag
              WHERE project = :id
            ");
            $statement->bindValue(':id', $this->id, PDO::PARAM_INT);
            $statement->execute();
            while ($r_tag = $statement->fetch(PDO::FETCH_ASSOC)){
                array_push($this->tags, Text::get($r_tag["id"]));
            }
            $this->set_flag("tags", true);
        }
    }

    /**
     * Retrieves the project tags.
     *
     * @return Project_Tag[] Project tags. 
     */
    public function get_tags(){
        if ($this->get_flag("tags") === false){
            $this->load_tags();
        }
        return $this->tags;
    }
    
    /**
     * Loads the project URLs.
     *
     * Not exposed, must be called before accessing the project URLs.
     */
    private function load_urls(){
        if ($this->get_flag("urls") === false){
            $statement = get_context()->get_db()->prepare("
              SELECT id
              FROM project_url
              WHERE project = :id
            ");
            $statement->bindValue(':id', $this->id, PDO::PARAM_INT);
            $statement->execute();
            while ($r_url = $statement->fetch(PDO::FETCH_ASSOC)){
                array_push($this->urls, new Project_Url($r_url["id"]));
            }
            $this->set_flag("urls", true);
        }
    }

    /**
     * Retrieves the project URLs
     *
     * @return Project_URL[] List of the project URLs. 
     */
    public function get_urls(){
        if ($this->get_flag("urls") === false){
            $this->load_urls();
        }
        return $this->urls;
    }

    /**
     * Retrieves a state flag
     *
     * @return boolean Flag value, false if it doesn't exist. 
     */
    private function get_flag($flag){
        $value = false;
        if (array_key_exists($flag , $this->load_flags)){
            $value = $this->load_flags[$flag];
        }
        return $value;
    }

    /**
     * Sets a load status flag.
     * 
     * If, once set, all flags are set to true, mark_as_complete(true)
     * will be automatically called.
     * 
     * @param string $flag Flag name.
     * @param boolean $value Flag name.
     */
    private function set_flag($flag, $value){
        $key_found = false;
        $keys = array_keys($this->load_flags);
        foreach($keys as $key){
            if ($key === $flag){
                $key_found = true;
                break;
            }
        }
        if ($key_found == false){
            Log::warn("Trying to set non-existing flag '$flag' in project");
            return false;
        }
        else{
            if ($value !== true && $value !== false){
                Log::warn("Trying to set project flag '$flag' to an invalid value: " . $value);
                return false;
            }
            else{
                $this->load_flags[$flag] = $value;
                
                // Once set, loop all keys to check if they are all true
                $all_loaded = true;
                foreach($this->load_flags as $value){
                    if ($value !== true){
                        $all_loaded = false;
                        break;
                    }
                }
                $this->mark_as_complete($all_loaded);
                return true;
            }
        }
    }
}
