<div id='dialog'>
    <div id='dialog_background'>
    </div>
    <div class='section'>
        <h3 id='dialog_title' class='section_title'></h3>
        <div class='entry'>
            <p id='dialog_text'></p>
            <div id='dialog_button_a_container'>
                <input type='button' id='dialog_accept' value='Aceptar'/>
            </div>
            <div id='dialog_button_yn_container'>
                <input type='button' id='dialog_yes' value='Yes'/>
                <input type='button' id='dialog_no' value='No'/>
            </div>
        </div> <!-- .entry -->
    </div> <!-- .section -->
</div>
<div id='header'>
    <table>
        <tr>
            <td>
                <img src='<?=$server?>/img/misc/logo.png'/>
                <span style='font-weight:normal;font-style:italic;font-size:90%;'><?=$_SESSION['name']?></span>
            </td>
            <td>
                <a href='<?=$server?>/' class='pointer header_section'>Inicio</a>
            </td>
            <td class='pointer header_section' onClick='showHeader("blog", this);'>
                <span class='pointer'>Blog</span>
            </td>
            <td class='pointer header_section' onClick='showHeader("projects", this);'>
                <span class='pointer'>Projects</span>
            </td>
            <td class='pointer header_section' onClick='showHeader("stats", this);'>
                <span class='pointer'>Stats</span>
            </td>
            <td class='pointer header_section' onClick='showHeader("settings", this);'>
                <span class='pointer'>Settings</span>
            </td>
        </tr>
    </table>
</div>
<div class='secondary_header' id='header_blog'>
    <table>
        <tr>
            <td>
                <a href='<?=$server?>/blog/add/'>New post</a>
            </td>
            <td>
                <a href='<?=$server?>/blog/'>Manage posts</a>
            </td>
        </tr>
    </table>
</div>
<div class='secondary_header' id='header_projects'>
    <table>
        <tr>
            <td>
                <a href='<?=$server?>/projects/add/'>New project</a>
            </td>
            <td>
                <a href='<?=$server?>/projects/'>Manage projects</a>
            </td>
        </tr>
    </table>
</div>
<div class='secondary_header' id='header_stats'>
    <table>
        <tr>
            <td>
                <a href='<?=$server?>/stats/'>View stats</a>
            </td>
        </tr>
    </table>
</div>
<div class='secondary_header' id='header_settings'>
    <table>
        <tr>
            <td>
                <a href='<?=$server?>/settings/'>Page settings</a>
            </td>
            <td>
                <a href='<?=$server?>/settings/profile.php'>Profile settings</a>
            </td>
        </tr>
    </table>
</div>
