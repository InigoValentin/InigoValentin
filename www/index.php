<?php
	session_start();
	$host = $_SERVER['HTTP_HOST'];
	include("functions.php");
	$proto = getProtocol();
	$server = "$proto$host";
	//$con = startdb();

	//Language
	//$lang = selectLanguage();
	//include("lang/lang_" . $lang . ".php");

	//$cur_section = $lng['section_home'];
?>


<html>
	<head>
		<meta content='text/html; charset=utf-8' http-equiv='content-type'/>
		<meta charset='utf-8'/>
		<meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=2, minimum-scale=1'>
		<title>I&ntilde;igo Valentin</title>
		<link rel='shortcut icon' href='<?=$server?>/img/logo/favicon.ico'>
		<!-- CSS files -->
		<style>
<?php
			include("css/ui.css");
			include("css/index.css");
?>
		</style>
		<!-- CSS for mobile version -->
		<style media="(max-width : 990px)">
<?php
			//include("css/m/ui.css");
			//include("css/m/index.css");
?>
		</style>

	</head>
	<body>
		<!-- TODO Toolbar -->
		<div id='content'>
			<div class='content_table'>
				<div class='content_row'>
					<div class='content_cell' id='content_cell_0'> 
						<div class='section' id='section_profile'>
							<h2 class='section_title'>I&nacute;igo Valentin</h2>
							<div class='section_content'>
								<img alt='I&nacute;igo Valentin' id='profile' src='<?=$server?>/img/profile/0.jpg'/>
								<br/>
								<div id='social'>
									<a title='Github' href='https://github.com/Seavenois' target='_blank'>
										<img alt='Github' src='<?=$server?>/img/social/github.gif'/>
									</a>
									<a title='LinkedIn' href='https://www.linkedin.com/in/ivalentin/' target='_blank'>
										<img alt='LinkedIn' src='<?=$server?>/img/social/linkedin.gif'/>
									</a>
									<a title='Google+' href='https://plus.google.com/+I%C3%B1igoValentin' target='_blank'>
										<img alt='Google+' src='<?=$server?>/img/social/googleplus.gif'/>
									</a>
									<a title='Facebook' href='https://facebook.com/seavenois' target='_blank'>
										<img alt='Facebook' src='<?=$server?>/img/social/facebook.gif'/>
									</a>
								</div> <!-- #social  -->
							</div> <!-- .section_content -->
						</div> <!-- #section_profile -->
					</div> <!-- #content_cell_0 -->
					<div class='content_cell' id='content_cell_1'>
						<div class='section' id='section_bio'>
							<h2 class='section_title'>TR Bio</h2>
								<div class='section_content'>
									<p>TR Bio_content</p>
								</div> <!-- .section_content -->
						</div> <!-- #section_bio -->
						<br/>
						<div class='section' id='section_navigation'>
							<h2 class='section_title'>TR Nav</h2>
							<div class='section_content'>
								<div class='nav_item' id='nav_cv'>
									<h2>TR CV</h2>
								</div> <!-- #nav_cv-->
								<div class='nav_item' id='nav_projects'>
									<h2>TR Projects</h2>
								</div> <!-- #nav_projects-->
								<div class='nav_item' id='nav_snippets'> 
									<h2>TR Code snippets<h2>
								</div> <!-- #nav_snippets -->
								<div class='nav_item' id='nav_cgi'>
									<h2>TR CGI</h2>
								</div> <!-- #nav_cgi -->
							</div> <!-- .section_content -->
						</div> <!-- #section_navigation -->
					</div> <!-- #content_cell_1 -->
				</div> <!-- .content_row -->
			</div>  <!-- .content_table -->
		</div> <!-- .content -->
		<!-- TODO Footer -->
	</body>
</html>
