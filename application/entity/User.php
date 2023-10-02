<?php

require_once(PATH::ENTITY . "Entity.php");
require_once(PATH::ENTITY . "Lang.php");
require_once(PATH::ENTITY . "Social.php");

/**
 * User.
 *
 * Represents an object from the table 'user'.
 */
class User extends Entity{

    /**
     * @var int User identifier.
     */
    private $id;

    /**
     * @var string User's display name.
     */
    private $display_name;


    /**
     * @var string User's image path.
     */
    private $image;

    /**
     * @var Lang[] List of the user languages.
     */
    private $langs = [];

    /**
     * @var Email[] List of the user emails.
     */
    private $email = [];

    /**
     * @var Social[] List of the user social links.
     */
    private $social = [];

    /**
     * @var string[] List uf user-defined texts.
     */
    private $texts = [];

    /**
     * @var bool[] Control flags to check loading status.
     */
    private $load_flags = [
        "email" => false,
        "social" => false,
        "lang" => false
    ];

    /**
     * Constructor.
     *
     * Searches the database and retrieves the information about the user, populating it. The
     * user to be loaded must be defined in the configuration file.
     */
    public function __construct(){
        $this->id = parse_ini_file(__DIR__ . "/../config/config.ini", true)["user"]["id"];
        $statement = get_context()->get_db()->prepare(
          "SELECT id, name, image FROM user WHERE id = :id"
        );
        $statement->bindValue(':id', $this->id, PDO::PARAM_INT);
        $statement->execute();
        $r_user = $statement->fetch(PDO::FETCH_ASSOC);
        if ($r_user !== false){
            $this->id = $r_user["id"];
            $this->display_name = $r_user["name"];
            $this->image = $r_user["image"];
        }
        else Log::error("User with id '$this->id' doesn't exist");
    }

    /**
     * Retrieves the user identifier
     *
     * @return int User ID.
     */
    public function get_id(){return $this->id;}

    /**
     * Retrieves the user's display name.
     *
     * @return string The user's display name.
     */
    public function get_display_name(){return $this->display_name;}

    /**
     * Retrieves a user defined text text.
     *
     * @param string $key Text key.
     * @return string The defined text, or an empty string if it doesn't exist.
     */
    public function get_text($key){
        if (isset($this->texts[$key])) return $this->texts[$key];
        $statement = get_context()->get_db()->prepare(
          "SELECT text FROM user_text WHERE user = :user AND upper(name) = upper(:key)"
        );
        $statement->bindValue(':user', $this->id, PDO::PARAM_INT);
        $statement->bindValue(':key', $key, PDO::PARAM_STR);
        $statement->execute();
        $r = $statement->fetch(PDO::FETCH_ASSOC);
        if ($r == false) return "";
        $this->texts[$key] = Text::get($r["text"], false);
        return $this->texts[$key];
    }

    /**
     * Retrieves the user's profile image file path.
     *
     * @return string The user's profile image.
     */
    public function get_image(){return $this->image;}

    /**
     * Retrieves the user's list of emails.
     *
     * @return string[] The user's list of emails.
     */
    public function get_emails(){
        if ($this->load_flags["email"] === false) $this->load_email();
        return $this->email;
    }

    /**
     * Retrieves the user's first visible email address.
     *
     * @return string The user's first visible email, null if there are none.
     */
    public function get_first_email(){
        if ($this->load_flags["email"] === false) $this->load_email();
        if (sizeof($this->email) == 0) return null;
        else return $this->email[0];
    }

    /**
     * Retrieves the user's list of supported languages.
     *
     * @return string[] The user's list of languages, sorted by priority.
     */
    public function get_langs(){
        if ($this->load_flags["lang"] === false) $this->load_lang();
        return $this->langs;
    }

    /**
     * Retrieves the user's list of social links.
     *
     * @return Social[] The user's list of social links.
     */
    public function get_social(){
        if ($this->load_flags["social"] === false) $this->load_social();
        return $this->social;
    }
    
    /**
     * Checks if a language is supported by the user.
     * 
     * @param sting $code Two letter language code to check, case insensitive.
     * @return True if the language is supported by the user, false otherwise.
     */
    public function is_valid_language($code){
        if ($this->load_flags["lang"] === false) $this->load_lang();
        foreach ($this->langs as $lang){
            if (strtolower($lang->get_code()) == strtolower($code))
                return true;
        }
        return false;
    }

    /**
     * Loads the user emails.
     *
     * Not exposed, must be called before accessing the user email list.
     */
    private function load_email(){
        if ($this->load_flags["email"] === false){
            $statement = get_context()->get_db()->prepare(
              "SELECT email FROM user_email WHERE user = :id AND visible = 1"
            );
            $statement->bindValue(':id', $this->id, PDO::PARAM_INT);
            $statement->execute();
            while ($r_email = $statement->fetch(PDO::FETCH_ASSOC))
                array_push($this->email, $r_email["email"]);
            $this->load_flags["email"] = true;
        }
    }

    /**
     * Loads the user supported languages.
     *
     * Not exposed, must be called before accessing the user languages.
     */
    private function load_lang(){
        if ($this->load_flags["lang"] === false){
            $statement = get_context()->get_db()->prepare(
              "SELECT lang FROM user_lang WHERE user = :id ORDER BY priority"
            );
            $statement->bindValue(':id', $this->id, PDO::PARAM_INT);
            $statement->execute();
            while ($r_lang = $statement->fetch(PDO::FETCH_ASSOC))
                array_push($this->langs, new Lang($r_lang["lang"]));
            $this->load_flags["lang"] = true;
        }
    }

    /**
     * Loads the user social links.
     *
     * Not exposed, must be called before accessing the user links.
     */
    private function load_social(){
        if ($this->load_flags["social"] === false){
            $statement = get_context()->get_db()->prepare(
              "SELECT id FROM user_social WHERE user = :id ORDER BY priority"
            );
            $statement->bindValue(':id', $this->id, PDO::PARAM_INT);
            $statement->execute();
            while ($r_social = $statement->fetch(PDO::FETCH_ASSOC))
                array_push($this->social, new Social($r_social["id"]));
            $this->load_flags["social"] = true;
        }
    }
}
