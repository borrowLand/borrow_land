<?
session_start();


//System 
/////////////////////////////////////////////
$includeName="../_00_basic_check.inc.php";
if (file_exists($includeName))
{
require($includeName);
}	
else
{
echo '<br><br><div class="meldung_fehler"><img src="../BL_BILDER/Meldungen_Warning.png"> <br>CHECK_ALL_LOAD_01</div><br><br>';	
exit();
}

/////////////////////////////////////////////

//Funktionen 
/////////////////////////////////////////////
$includeName="../_00_basic_func.inc.php";
if (file_exists($includeName))
{
require($includeName);
}	
else
{
echo '<br><br><div class="meldung_fehler"><img src="../BL_BILDER/Meldungen_Warning.png"> <br>FU_ALL_LOAD_01</div><br><br>';	
exit();
}

/////////////////////////////////////////////


//Datenbank Verbindung
/////////////////////////////////////////////
$includeName="../_01_basic_db.inc.php";
if (file_exists($includeName))
{
require($includeName);
}	
else
{
echo '<br><br><div class="meldung_fehler"><img src="../BL_BILDER/Meldungen_Warning.png"> <br>DB_FU_LOAD_01</div><br><br>';	
exit();
}

/////////////////////////////////////////////


//Sessions
/////////////////////////////////////////////
$includeName="../_01_basic_sess.inc.php";
if (file_exists($includeName))
{
require($includeName);
}	
else
{
echo '<br><br><div class="meldung_fehler"><img src="../BL_BILDER/Meldungen_Warning.png"> <br>SESS_FU_LOAD_01</div><br><br>';	
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
<br><br><br><br><div class="meldung_fehler"><img src="../BL_BILDER/Meldungen_Warning.png">Diese Webseite läuft leider nur, wenn Sie <a href="http://de.wikipedia.org/wiki/Javascript" target="_blank">Javascript</a> zulassen. <br>Bitte aktivieren Sie diesen technischen Standard in Ihrem Browser, Danke!</div>
<br><br>
</NOSCRIPT>	
		
<section id="page"> 
<header> 
            
<?
//#############Anfang Überschrift
?>
<hgroup><h1><a href="../index.php" title="Startseite"><img src="../BL_BILDER/start_00.png"></a> <a href="../index.php" title="Startseite">borrow land</a></h1>
<?
//anfang namensanzeige, nur für benutzerbereich
$nutzerInfos=benutzerDaten($_SESSION["User_ID"]);
//ende namensanzeige, nur für benutzerbereich

$oeffentlich=0;
if ($oeffentlich=="1")
{
?>
<div id="ueberschr_all"><a href="../">/Leihe</a>/Benutzer</div>
</hgroup>
<?
}
else
{
	if (isset($_SESSION["User_ID"]) && $_SESSION["User_ID"]!="")
	{	
	?>
	<div id="ueberschr_all"><a href="../">/Leihe</a>/<? echo utf8_encode(htmlspecialchars($nutzerInfos[0])); ?></div>
	</hgroup>
	<?
	}
}
//#############Ende Überschrift
			
			

	//navigation
	/////////////////////////////////////////////
	$includeName="../_00_basic_nav.inc.php";
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
	<div id="loadingAj"></div>
	<div id="ajax"></div>
			
	<?
	if (isset($_SESSION["User_ID"]))
	{
	?>
	<article id="articleLogin2"> 
	<h2>Übersicht und Einstellungen in Ihrem Profil</h2>

	<div class="line"></div>
	<?
	
	if (welcheEinstellung("SE_twitterModuleActi")=="1" && welcheEinstellung("SE_twitterName")!="")
	{
	$consumerKey    = welcheEinstellung("SE_auth_consumerKey");
	$consumerSecret = welcheEinstellung("SE_consumerSecret");
	$oAuthToken     = welcheEinstellung("SE_oAuthToken");
	$oAuthSecret    = welcheEinstellung("SE_oAuthSecret");

	require_once('../BL_TWITR/twitteroauth.php');

	$tweet = new TwitterOAuth($consumerKey, $consumerSecret, $oAuthToken, $oAuthSecret);
	$response = $tweet->get("statuses/user_timeline", null); 
	$datum=$response[0]->created_at;
	$teile = explode(" ", $datum);
		if ($response[0]->text!="")
		{
		echo "<img title='Letzte aktuelle Nachricht der Ausleihe:' src='".$_SESSION["SE_festUrl"]."BL_BILDER/twitr.png'> Letzte aktuelle Nachricht der Ausleihe: <br><b> ".$response[0]->text." </b>(vom ".$teile[2].". ".$teile[1]." ".$teile[5 ].") <a style='font-size:10px' href='http://www.twitter.com/".welcheEinstellung("SE_twitterName")."' target='_blank'>Alle Nachrichten und Profil</a>";
		}
	}

?>
	<div class="articleBody clear">

	<div id="dialog-confirm" class="ui-helper-hidden" title="Löschen des Profils.">
	<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Es wird im nächsten Schritt geprüft, ob von Ihnen noch Geräte ausgeliehen worden sind. <br><br>Falls dies nicht der Fall ist, wird Ihr Profil ohne weitere Rückfrage gelöscht. <b>Sind Sie sich sicher?</b></p>
	</div>

	<table class='ui-widget-content ui-corner-all' width='100%' id='wk_content_tab' style='padding:10px;margin-top:20px'>
	<tr><td colspan='5'><br></td></tr>
	<tr><td width="50px"><a href="<? echo $_SESSION["SE_festUrl"]; ?>" title="Leihe starten" ><div class="ui-state-default ui-corner-all"><span class="ui-icon ui-icon-home"></span></div></a></td><td><a href="<? echo $_SESSION["SE_festUrl"]; ?>" title="Leihe starten" >Leihe starten</a></td><td width="70px"></td><td width="50px"><a href="<? echo $_SESSION["SE_festUrl"]; ?>account/basketControl" title="Reservierungen" ><div class="ui-state-default ui-corner-all"><span class="ui-icon ui-icon-pin-s"></span></div></a></td><td><a href="<? echo $_SESSION["SE_festUrl"]; ?>account/basketControl" title="Reservierungen" >Reservierungen</a></td></tr>
	<tr><td colspan='5'><br></td></tr>
	<tr><td width="50px"><a href="<? echo $_SESSION["SE_festUrl"]; ?>account/pwChg" title="Passwort ändern" ><div class="ui-state-default ui-corner-all"><span class="ui-icon ui-icon-key"></span></div></a></td><td><a href="<? echo $_SESSION["SE_festUrl"]; ?>account/pwChg" title="Passwort ändern" >Passwort ändern</a></td><td width="70px"></td><td width="50px"><a href="#link" title="Profil löschen" ><div class="ui-state-default ui-corner-all"><span class="ui-icon ui-icon-circle-close"></span></div></a></td><td><a href="#link" title="Profil löschen" >Profil löschen</a></td></tr>
	
	
	<tr><td colspan='5'><br></td></tr>
	</table>
	
	</div>

	</article>	
	<?
	}
	else
	{
	//nicht eingeloggt
	/////////////////////////////////////////////
	$includeName="../_02_NoLoginAllPages.inc.php";
	if (file_exists($includeName))
	{
	require($includeName);
	}	
	else
	{
	echo '<br><br><div class="meldung_fehler"><img src="../BL_BILDER/Meldungen_Warning.png"> <br>DB_FU_LOAD_01</div><br><br>';	
	exit();
	}
	/////////////////////////////////////////////
	}
	?>
			
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
$includeName="../_00_basic_footer.php";
if (file_exists($includeName))
{
include_once($includeName);
}	
else
{
echo '<br><br><div class="meldung_fehler"><img src="../BL_BILDER/Meldungen_Warning.png"> <br>FOOTER_FU_LOAD</div><br><br>';	
exit();
}

/////////////////////////////////////////////			
?>  
</section>	        
<!-- JavaScript Includes -->
<?
echo nl2br($_SESSION["SE_jQuerUI"]);
?>

<script>
$("#dialog-confirm").dialog({ autoOpen: false })

$( "#dialog-confirm" ).dialog({
			resizable: false,
			height:310,
			modal: true,
			buttons: {
				"Ja": function() {
				$("#ajax").load("00_prof_delCheck.inc.php");
				$( this ).dialog( "close" );
				},
				"Abbrechen": function() {
					$( this ).dialog( "close" );
				}
			}
		});

$("a[title='Profil löschen']").click(function(event) {
$("#dialog-confirm" ).dialog('open');
});		

$("#loadingAj").hide();
$("#loadingAj").ajaxStart(function(){
   $(this).show();
 });
 $("#loadingAj").ajaxStop(function(){
   $(this).hide();
 });	
</script>



<?
echo utf8_encode($_SESSION["SE_EndeIndex"]);
?>

<br><br><br><br><br><br>
</body>
</html>