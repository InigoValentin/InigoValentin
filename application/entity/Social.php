<?php

require_once(PATH::ENTITY . "Entity.php");

/**
 * Social.
 *
 * Represents a social link.
 */
class Social extends Entity{

    /**
     * @var int User profile URL.
     */
    private $url;

    /**
     * @var string Social site name.
     */
    private $site_name;

    /**
     * @var string Path to the site logo.
     */
    private $logo;

    /**
     * @var string Link text.
     */
    private $text;

    /**
     * Constructor.
     *
     * Searches the database and retrieves the information about the social link, populating it.
     */
    public function __construct($id){
        $user_id = parse_ini_file(__DIR__ . "/../config/config.ini", true)["user"]["id"];
        $statement = get_context()->get_db()->prepare("
          SELECT site_name, url, logo, text
          FROM social, user_social
          WHERE social.id = user_social.social AND user = :user AND user_social.id = :id
        ");
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->bindValue(':user', $user_id, PDO::PARAM_INT);
        $statement->execute();
        $r_social = $statement->fetch(PDO::FETCH_ASSOC);
        if ($r_social !== false){
            $this->url = $r_social["url"];
            $this->site_name = $r_social["site_name"];
            $this->logo = $r_social["logo"];
            $this->text = Text::get($r_social["text"]);
        }
        else Log::error("Social link with id '$id' doesn't exist for user '$user_id'");
    }

    /**
     * Retrieves the link URL.
     *
     * @return string link URL.
     */
    public function get_url(){return $this->url;}

    /**
     * Retrieves the social site name.
     *
     * @return string The social site name.
     */
    public function get_site_name(){return $this->site_name;}

    /**
     * Retrieves the site logo.
     *
     * @return string The site logo file path.
     */
    public function get_logo(){return $this->logo;}

    /**
     * Retrieves the social link text.
     *
     * @return string The social link text.
     */
    public function get_text(){return $this->text;}

}
