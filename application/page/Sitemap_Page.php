<?php

require_once(PATH::PAGE . 'Page.php');

/**
 * Sitemap.xml file page model.
 */
class Sitemap_Page extends Page{

    /**
     * Sitemap contents
     */
    private $text = '';

    /**
     * Constructor.
     *
     * Retrieves the data and populates the text.
     */
    public function __construct(){
        parent::__construct();
        $this->set_view('sitemap.php');
        // TODO: Don't use static date.
        $lastmod = "2023-09-14";
        $this->text .= "<?xml version='1.0' encoding='UTF-8'?>
<urlset xmlns='http://www.sitemaps.org/schemas/sitemap/0.9'>
    <url>
        <loc>" . URL::BASE . "</loc>
        <lastmod>" . $lastmod ."</lastmod>
        <changefreq>monthly</changefreq>
        <priority>1.0</priority>
    </url>
    <url>
        <loc>" . URL::BASE . "profile/</loc>
        <lastmod>" . $lastmod ."</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.9</priority>
    </url>
    <url>
        <loc>" . URL::BASE . "projects/</loc>
        <lastmod>" . $lastmod ."</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.8</priority>
    </url>";
        $statement = get_context()->get_db()->prepare(
          'SELECT permalink FROM project WHERE user = :user AND visible = 1 ORDER BY idx'
        );
        $statement->bindValue(':user', get_context()->get_user()->get_id(), PDO::PARAM_INT);
        $statement->execute();
        $priority = 0.7;
        $priority_dec = 0.3 / $statement->rowcount();
        while ($r = $statement->fetch(PDO::FETCH_ASSOC)){
            $this->text .= "
    <url>
        <loc>" . URL::BASE . "projects/" . $r["permalink"]. "</loc>
        <lastmod>" . $lastmod ."</lastmod>
        <changefreq>monthly</changefreq>
        <priority>" . $priority . "</priority>
    </url>";
            $priority -= $priority_dec;
        }
        $this->text .= "
</urlset>";

    }

    /**
     * Retrieves the text for the sitemap XML file.
     *
     * @return string The text for the XML.
     */
    public function get_text(){return $this->text;}

}
