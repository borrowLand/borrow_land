<?
session_start();

//System 
/////////////////////////////////////////////
$includeName="../../_00_basic_check.inc.php";
if (file_exists($includeName))
{
require($includeName);
}	
else
{
echo '<br><br><div class="meldung_fehler"><img src="../../BL_BILDER/Meldungen_Warning.png"> <br>CHECK_ALL_LOAD_01</div><br><br>';	
exit();
}

/////////////////////////////////////////////

//Funktionen 
/////////////////////////////////////////////
$includeName="../../_00_basic_func.inc.php";
if (file_exists($includeName))
{
require($includeName);
}	
else
{
echo '<br><br><div class="meldung_fehler"><img src="../../BL_BILDER/Meldungen_Warning.png"> <br>FU_ALL_LOAD_01</div><br><br>';	
exit();
}

/////////////////////////////////////////////


//Datenbank Verbindung
/////////////////////////////////////////////
$includeName="../../_01_basic_db.inc.php";
if (file_exists($includeName))
{
require($includeName);
}	
else
{
echo '<br><br><div class="meldung_fehler"><img src="../../BL_BILDER/Meldungen_Warning.png"> <br>DB_FU_LOAD_01</div><br><br>';	
exit();
}

/////////////////////////////////////////////


//Sessions
/////////////////////////////////////////////
$includeName="../../_01_basic_sess.inc.php";
if (file_exists($includeName))
{
require($includeName);
}	
else
{
echo '<br><br><div class="meldung_fehler"><img src="../../BL_BILDER/Meldungen_Warning.png"> <br>SESS_FU_LOAD_01</div><br><br>';	
exit();
}

/////////////////////////////////////////////


?>

<!DOCTYPE html> 
<html>
<head>
<?
echo eval(welcheEinstellung("SE_headBereich"));
?>
</head>


    <body>
<NOSCRIPT>
<br><br><br><br><div class="meldung_fehler"><img src="../../BL_BILDER/Meldungen_Warning.png">Diese Webseite läuft leider nur, wenn Sie <a href="http://de.wikipedia.org/wiki/Javascript" target="_blank">Javascript</a> zulassen. <br>Bitte aktivieren Sie diesen technischen Standard in Ihrem Browser, Danke!</div>
<br><br>
</NOSCRIPT>	
		
<section id="page"> <!-- Defining the #page section with the section tag -->


<header> <!-- Defining the header section of the page with the appropriate tag -->

<hgroup>

 <?
//#############Anfang Überschrift
?>
<hgroup><h1><a href="../../index.php" title="Startseite"><img src="../../BL_BILDER/start_00.png"></a> <a href="../../index.php" title="Startseite">borrow land</a></h1>
<?
$oeffentlich=1;
if ($oeffentlich=="1")
{
?>
<div id="ueberschr_all"><a href="../../">/Leihe</a><a href="../">/Toolbar</a>/Impressum</div>
</hgroup>
<?
}
else
{
	if (isset($_SESSION["User_ID"]) && $_SESSION["User_ID"]!="")
	{	
	?>
	<div id="ueberschr_all"><a href="../../">/Leihe</a><a href="../">/Toolbar</a>/Impressum</div>
	</hgroup>
	<?
	}
}
//#############Ende Überschrift	


	//navigation
	/////////////////////////////////////////////
	$includeName="../../_00_basic_nav.inc.php";
	if (file_exists($includeName))
	{
	require($includeName);
	}	
	else
	{
	echo '<br><br><div class="meldung_fehler"><img src="BL_BILDER/Meldungen_Warning.png"> <br>SESS_FU_LOAD_01</div><br><br>';	
	exit();
	}
	/////////////////////////////////////////////
?>
            </header>
            <section id="articles"> <!-- A new section with the articles -->


<article id="articleLogin1"> <!-- The new article tag. The id is supplied so it can be scrolled into view. -->
	<h2>Impressum</h2>
	
	<div class="line"></div>
	
	<div class="articleBody clear">
<?
$sql = "SELECT InhaltDerEinstellung FROM `00_einstellungenSoftware` WHERE `Desc_Session` = \"SE_imprint\" LIMIT 1"; 
$datenEinstell = mysql_query($sql);
$row = mysql_fetch_row($datenEinstell);	
echo utf8_encode(nl2br(strip_tags($row[0])));
?>


<br><br><br>
<hr>
<br><br><br>


<h4>Credits:</h4><br>
	
	<?
	//timeline
	//http://tutorialzine.com/2010/01/advanced-event-timeline-with-php-css-jquery/
	?>
	<div title="1.5.1 / 1.8.10 Lizenz: MIT License / GPL Webseite: http://www.jquery.com / http://jqueryui.com/"># jQuery & jQuery UI</div> 
	<div title="1.0.2 Lizenz: GNU Affero GPL Webseite: http://pines.sourceforge.net/pnotify/"># Pines Notify</div>
	<div title="1.2 Lizenz: Open Source MIT License Webseite: http://simplythebest.net/scripts/ajax/ajax_password_strength.html"># Ajax Password Strength Meter Script</div>
	<div title="Webseite: http://ajaxload.info"># ajaxload.info </div>
	<div title="1.6 Lizenz: 'permissive license' Webseite: http://www.fpdf.de "># fpdf</div>
	<div title="1.7.6 Lizenz: GPL v2 license & BSD (3-point) license Webseite: http://www.datatables.net"># DataTables</div>
	<div title="1.3.2 Lizenz: MIT software license Webseite: http://xoxco.com/clickable/jquery-tags-input"># jQuery-Tags </div>
	<div title="1.3 Lizenz: The MIT License Webseite: http://www.itsalif.info/content/ezmark-jquery-checkbox-radiobutton-plugin"># ezmark </div>
	<div title="http://tutorialzine.com/2009/11/hovering-gallery-css3-jquery/"># gallery </div>
	<div title="Webseite: https://github.com/abraham/twitteroauth/"># twitteroauth</div>
	<div title="Webseite: http://translate.google.com/translate_tools"># Google Translate </div>
	<div title="Webseite: http://code.google.com/intl/de-DE/apis/chart"># Google Chart Tools</div>
	<div title="0.2.2. Lizenz: MIT/GPL Webseite: http://james.padolsey.com/demos/imgPreview/full/"># imgPreview jQuery plugin</div>
	<div title="1.7.6. Lizenz: LGPL Webseite: http://phpexcel.codeplex.com/"># PHP EXCEL</div>
	<div title="Webseite: https://www.iconfinder.com/icons/6665/hardware_server_settings_tools_icon#size=128/"># Beispiel-Icon für Hauptgruppe Hardware</div>
	<div title="http://www.luftspiel.de/"># Beispiel-Foto für CPU</div>
	
<br><br><br>
<hr>
<br><br><br>
<h4>Programmierung Erstentwicklung</h4>
<br>
<img style="background-color:#FFFFFF" src='../../BL_BILDER/bl-text.png' align='absmiddle' border='0'><br><br>
<br>
BORROW LAND wurde als open source Software (Lizenz: GPL Version 3) vom Urheber Robert Wagner am 14.02.2014 (Version Version 1.0.1.7) freigegeben.

<br><br><br>
<hr>
<br><br><br>

<h4>Versionsinformation:</h4>
<br>
Version 1.0.1.7<br>
 <a href="http://www.ausleihsoftware.de" target="blank"><u>Projektübersicht</u></a>

<br><br><br><br>
</div>
</article>



            </section>

		
		 <?
		 if ($_SESSION["SE_GooTrans"]=="1")
		 {
					// Start Google Translate -->
   					echo $_SESSION["SE_GooTransScript"];
					// Ende Google Translate -->
		}
		?>		

			
<?
//Footer 
/////////////////////////////////////////////
$includeName="../../_00_basic_footer.php";
if (file_exists($includeName))
{
include_once($includeName);
}	
else
{
echo '<br><br><div class="meldung_fehler"><img src="../../BL_BILDER/Meldungen_Warning.png"> <br>FOOTER_FU_LOAD</div><br><br>';	
exit();
}

/////////////////////////////////////////////			
?>  
	        
       
		</section> <!-- Closing the #page section -->

		 

        
<!-- JavaScript Includes -->
<?
echo nl2br($_SESSION["SE_jQuerUI"]);

echo utf8_encode($_SESSION["SE_EndeIndex"]);
?>
</body>
</html>