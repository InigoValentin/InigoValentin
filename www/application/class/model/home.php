<?php

    class Home extends Model{
        public $q_work;
        public $q_project;

        public function __construct(){
        }

        public function prepare(){
            global $path;

            $this->view = $path["view"] . "home.php";
            $s_work =
              "SELECT " .
              "  role, " .
              "  company, " .
              "  city, " .
              "  datediff(now(), start) AS days, " .
              "  summary " .
              "FROM cv_entry " .
              "WHERE " .
              "  category = 1 AND " .
              "  visible = 1 AND " .
              "  end IS NULL " .
              "ORDER BY start " .
              "DESC LIMIT 1;";
            $this->q_work = mysqli_query($this->con, $s_work);

            $s_project =
              "SELECT " .
              "  project.permalink, " .
              "  project_type.title AS type, " .
              "  project.title, " .
              "  project.logo, " .
              "  project.header, " .
              "  project.text " .
              "FROM " .
              "  project, " .
              "  project_type " .
              "WHERE " .
              "  project.type = project_type.id AND " .
              "  project.id = ( " .
              "    SELECT project " .
              "    FROM " .
              "      ( " .
              "        SELECT " .
              "          project, " .
              "          max(dtime) " .
              "        FROM project_version " .
              "        GROUP BY project " .
              "        ORDER BY dtime " .
              "        DESC LIMIT 3 " .
              "      ) lp " .
              "    WHERE lp.project = project.id " .
              "  ) AND " .
              "  visible = 1;";
              $this->q_project = mysqli_query($this->con, $s_work);
        }
    }
