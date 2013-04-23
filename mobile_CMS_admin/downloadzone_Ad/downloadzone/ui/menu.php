 <table width="100%" height="100%">
	<tr><td colspan="3" class="bkgnd_lightgrey" height="20"><div id="main_feature_hdr">Content Management Admin Panel </div></td></tr>
	 <tr>
		<td width="180" class="bkgnd_lightgrey" valign="top">
		<br><font color="#0033CC"><strong>DownloadZone</strong></font><br><br>
			<strong>Logs</strong><br><br>
			  	<li><a href="?main=1">Greetings Log</a></li><br><br>
			  	<li><a href="?main=2">Animations Log</a></li><br><br>
			  	<li><a href="?main=3">Animated Greetings Log</a></li><br><br>
			 	<li><a href="?main=4">Games Log</a></li><br><br>
			 	<li><a href="?main=5">Theme Log</a></li><br><br>
			  	<li><a href="?main=6">Tone Log</a></li><br><br>
			  	<li><a href="?main=7">Wallpaper Log</a></li><br><br>
			 <strong>Upload</strong><br><br>
			  	<li><a href="?main=8">Games</a></li><br><br>
			  	<li><a href="?main=9">Wallpaper</a></li><br><br>
			  	<li><a href="?main=10">Greetings</a></li><br><br>
				<li><a href="?main=11">Animated Greetings</a></li><br><br>
				<li><a href="?main=14">Animation</a></li><br><br>
				<li><a href="?main=12">Theme</a></li><br><br>
				<li><a href="?main=13">Tone</a></li><br><br>
			 <font color="#0033CC"><strong>3G</strong></font><br><br>
				<li><a href="?main=15">Full Track</a></li><br><br>
				<li><a href="?main=16">Vedio</a></li><br><br>
		</td>
		<td width="20">&nbsp;</td>
		<td valign="top">
			<?php 
				switch ($_REQUEST["main"]) {
				case 0:
				   echo "Please select a link option";
				   break;
				case 1:
				   include_once("search.php");//log no 1 is greetings
				   break;
				case 2:
				   include_once("search.php");//log no 2 is animations
				   break;
				case 3:
				   include_once("search.php");//log no 3 is animated greetings
				   break;
				case 4:
				   include_once("search.php");//log no 4 is games
				   break;
				case 5:
				   include_once("search.php");//log no 5 is theme
				   break;
				case 6:
				   include_once("search.php");//log no 6 is tone
				   break;
				case 7:
				   include_once("search.php");//log no 7 is wallpaper
				   break;
				case 8:
				   include_once("gameupload.php");
				   break;
				case 9:
				   include_once("wallpaper.php");
				   break; 
				case 10:
				   include_once("greeting.php");
				   break; 
				case 11:
				   include_once("anigreetings.php");
				   break;
				 case 12:
				   include_once("theme.php");
				   break;
				  case 13:
				   include_once("tone.php");
				   break; 
				  case 14:
				   include_once("animation.php");
				   break;  
				  case 15:
				   include_once("fulltrack.php");
				   break;    
				}
			?>
		</td>
	 </tr>
 </table>
