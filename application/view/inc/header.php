<?php global $static?>
<header>
    <div id='logo'>
        inigoValentin
    </div>
    <nav>
        <a href='<?=$base_url?>/'>
            <img src='<?=$static["layout"]?>icon/home.svg'/>
            <?=text($page, "SECTION_HOME")?>
        </a>
        <a href='<?=$base_url?>/profile/'/>
            <img src='<?=$static["layout"]?>icon/profile.svg'/>
            <?=text($page, "SECTION_ME")?>
        </a>
        <a href='<?=$base_url?>/project/'>
            <img src='<?=$static["layout"]?>icon/project.svg'/>
            <?=text($page, "SECTION_PROJECTS")?>
        </a>
    </nav>
</header>
