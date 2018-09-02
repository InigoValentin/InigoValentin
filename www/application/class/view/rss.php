<?php
    header('Content-type: application/xml');
    session_start();
    $http_host = $_SERVER["HTTP_HOST"];
    $doc_root = $_SERVER["DOCUMENT_ROOT"] . "/";
    include $doc_root . "functions.php";
    $proto = get_protocol();
    $con = start_db();
    $server = $proto . $http_host;
    $lang = select_language($con);
    $lserver = $server . "/" . $lang;
    $cur_section = "";
    $cur_entry = "";
    ob_clean();
    echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
?>
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
    <channel>
        <title>Iñigo Valentin</title>
        <link><?=$lserver?></link>
        <atom:link href="<?=$lserver?>/rss.xml" rel="self" type="application/rss+xml" />
        <description>TODO 3D art</description>
        <category>TODO cgi</category>
        <image>
            <url><?=$lserver?>/img/logo/cover.png</url>
            <title>Iñigo Valentin</title>
            <link><?=$lserver?></link>
            <width>140</width>
            <height>140</height>
        </image>
        <language><?=$lang?></language>
<?php
            $res_date = mysqli_query($con, "(SELECT DATE_FORMAT(dtime, '%a, %d %b %Y %H:%i:%s +0100') AS cdate FROM project_version) UNION (SELECT DATE_FORMAT(dtime, '%a, %d %b %Y %H:%i:%s +0100') AS cdate FROM post) ORDER BY cdate DESC LIMIT 1;");
            $row_date = mysqli_fetch_array($res_date);
?>
            <pubDate><?=$row_date["cdate"]?></pubDate>
<?php
            $res = mysqli_query($con, "SELECT id, permalink, dtime, DATE_FORMAT(dtime, '%a, %d %b %Y %H:%i:%s +0100') AS cdate, title, text, logo AS image FROM project, project_version WHERE project = project.id  ORDER BY dtime DESC;");
            while ($row = mysqli_fetch_array($res)){
?>
                <item>
                    <title><?=text($con, $row["title"], $lang)?></title>
                    <category><?=text($con, $row["type"], $lang)?></category>
<?php
                    $text = html_entity_decode(text($con, $row["text"], $lang));
?>
                    <description>
                        <![CDATA[
                            <img src='<?=$lserver?>/img/project/x5/<?=$row["image"]?>' height='160' width='160' />
                            <?=$text?>
                        ]]>
                    </description>
                    <link><?=$lserver?>/project/<?=$row["permalink"]?></link>
                    <guid><?=$lserver?>/project/<?=$row["permalink"]?></guid>
                    <pubDate><?=$row["cdate"]?></pubDate>
                </item>
<?php
            }
            mysqli_close($con);
?>
    </channel>
</rss>
