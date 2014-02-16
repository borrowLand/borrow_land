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
$oeffentlich=0;
if ($oeffentlich=="1")
{
?>
<div id="ueberschr_all"><a href="../">/Leihe</a>/Verwaltung</div>
</hgroup>
<?
}
else
{
	if (isset($_SESSION["User_ID"]) && $_SESSION["User_ID"]!="")
	{	
	?>
	<div id="ueberschr_all"><a href="../">/Leihe</a>/Verwaltung</div>
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
	<div id="ajax"></div>
			
	<?
	if (isset($_SESSION["User_ID"]))
	{
	?>

		<?
		if ($_SESSION["User_Recht_Admin"]=="1" || $_SESSION["User_Recht_Bestaet"]=="1" || $_SESSION["User_Recht_Ausgabeber"]=="1" )
		{
		?>
		<article id="articleLogin1"> 
		<h2>Verwaltung</h2>

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
	$meinungen = $tweet->get("statuses/mentions_timeline", null); 
	
	$von1=$meinungen[0]->user->screen_name;
	$datum1=$meinungen[0]->created_at;
	$teile = explode(" ", $datum1);
	
	$von2=$meinungen[1]->user->screen_name;
	$datum2=$meinungen[1]->created_at;
	$teile2 = explode(" ", $datum2);	

		if ($meinungen[0]->text!="")
		{
		echo "<img title='Letzten Meinungen aus dem Internet:' src='".$_SESSION["SE_festUrl"]."BL_BILDER/twitr.png'> Meinungen aus dem Internet: <br>";
		echo "<b>".$meinungen[0]->text."</b> (vom ".$teile[2].". ".$teile[1]." ".$teile[5 ].") <a style='font-size:10px' href='http://www.twitter.com/".$von1."' target='_blank'>Autor</a><br> ";
		}
		if ($meinungen[1]->text!="")
		{
		echo "<b>".$meinungen[1]->text."</b> (vom ".$teile2[2].". ".$teile2[1]." ".$teile2[5 ].") <a style='font-size:10px' href='http://www.twitter.com/".$von2."' target='_blank'>Autor</a><br> ";
		}
	}
?>		

		<div class="articleBody clear">
		<table class='ui-widget-content ui-corner-all' width='100%' id='wk_content_tab' style='padding:10px;margin-top:20px'>
			
			<?
			//<tr><td width="50px"></td><td></td><td width="70px"></td><td width="50px"></td><td></td></tr>
			
			//menüpunkte ausgeber & admin
			if ($_SESSION["User_Recht_Ausgabeber"]=="1" || $_SESSION["User_Recht_Admin"]=="1")
			{
			/*
			<tr><td width="50px"><a href="<? echo $_SESSION["SE_festUrl"]; ?>admini/adminLeihe/rfid" title="RFID-Modus" ><div class="ui-state-default ui-corner-all"><span class="ui-icon ui-icon-signal"></span></div></a></td><td><a href="<? echo $_SESSION["SE_festUrl"]; ?>admini/adminLeihe/rfid" title="RFID-Modus">RFID-Modus</a></td><td width="70px"></td><td width="50px"><a href="<? echo $_SESSION["SE_festUrl"]; ?>admini/adminLeihe/barcode" title="Barcode-Modus"><div class="ui-state-default ui-corner-all"><span class="ui-icon ui-icon-grip-diagonal-se"></span></div></a></td><td><a href="<? echo $_SESSION["SE_festUrl"]; ?>admini/adminLeihe/barcode" title="Barcode-Modus">Barcode-Modus</a></td></tr>
			<tr><td colspan='5'><br></td></tr>
			*/
				if ($_SESSION["SE_RFIDModule"]=="1")
				{
				echo '<a href="adminLeihe/rfid" class="fg-button ui-state-default ui-corner-all" style="margin-bottom: 10px; float: right;">RFID-Modus</a>';
				}
			?>
			
			<a href="adminLeihe/barcode/" class="fg-button ui-state-default ui-corner-all ui-state-hover" style="margin-bottom: 10px; float: right;">Barcode-Modus</a><br><br>
			
			<tr><td width="50px"><a href="<? echo $_SESSION["SE_festUrl"]; ?>admini/adminLeihe" title="Ausleiheverwaltung" ><div class="ui-state-default ui-corner-all"><span class="ui-icon ui-icon-refresh"></span></div></a></td><td><a href="<? echo $_SESSION["SE_festUrl"]; ?>admini/adminLeihe" title="Ausleiheverwaltung">Ausleiheverwaltung</a></td><td width="70px"></td><td width="50px"><a href="<? echo $_SESSION["SE_festUrl"]; ?>admini/stats" title="Status" ><div class="ui-state-default ui-corner-all"><span class="ui-icon ui-icon-help"></span></div></a></td><td><a href="<? echo $_SESSION["SE_festUrl"]; ?>admini/stats" title="Status">Status</a></td></tr>
			<tr><td colspan='5'><br></td></tr>
			<tr><td width="50px"><?
			if ($_SESSION["User_Recht_Bestaet"]=="1")
			{
			?>
			<a href="<? echo $_SESSION["SE_festUrl"]; ?>admini/userAck" title="User-Bestätigung" ><div class="ui-state-default ui-corner-all"><span class="ui-icon ui-icon-plusthick"></span></div></a></td><td><a href="<? echo $_SESSION["SE_festUrl"]; ?>admini/userAck" title="User-Bestätigung">User-Bestätigung</a>
			<?
			}
			?>
			</td><td width="70px"></td><td width="50px">
			<?
			/*
			<a href="#link" title="PLATZHALTER" ><div class="ui-state-default ui-corner-all"><span class="ui-icon ui-icon-help"></span></div></a></td><td><a href="#link" title="Anfragen Heute">PLATZHALTER</a></td></tr>
			<tr><td colspan='5'><br>
			*/
			?>
			</td></tr>
			<?
			}

			//menüpunkte bestätiger
			if ($_SESSION["User_Recht_Bestaet"]=="1" && $_SESSION["User_Recht_Ausgabeber"]=="0" && $_SESSION["User_Recht_Admin"]=="0")
			{
			?>
			<tr><td width="50px"><a href="<? echo $_SESSION["SE_festUrl"]; ?>admini/userAck" title="User-Bestätigung" ><div class="ui-state-default ui-corner-all"><span class="ui-icon ui-icon-plusthick"></span></div></a></td><td><a href="<? echo $_SESSION["SE_festUrl"]; ?>admini/userAck" title="User-Bestätigung">User-Bestätigung</a></td><td width="70px"></td><td width="50px"></td>
			</tr><tr><td colspan='5'><br></td></tr>
			<?
			}			
			
		
			//menüpunkte admin
			if ($_SESSION["User_Recht_Admin"]=="1")
			{
			?>
			<tr><td colspan='5'><br></td></tr>
			<tr><td width="50px"><a href="<? echo $_SESSION["SE_festUrl"]; ?>admini/inventar" title="Inventar" ><div class="ui-state-default ui-corner-all"><span class="ui-icon ui-icon-clipboard"></span></div></a></td><td><a href="<? echo $_SESSION["SE_festUrl"]; ?>admini/inventar" title="Inventar">Inventar</a></td><td width="70px"></td><td width="50px"><a href="<? echo $_SESSION["SE_festUrl"]; ?>admini/protokoll" title="Protokoll"><div class="ui-state-default ui-corner-all"><span class="ui-icon ui-icon-script"></span></div></a></td><td><a href="<? echo $_SESSION["SE_festUrl"]; ?>admini/protokoll" title="Protokoll">Protokoll</a></td></tr>
			<tr><td colspan='5'><br></td></tr>
			<tr><td width="50px"><a href="<? echo $_SESSION["SE_festUrl"]; ?>admini/software" title="Einstellungen" ><div class="ui-state-default ui-corner-all"><span class="ui-icon ui-icon-arrow-4"></span></div></a></td><td><a href="<? echo $_SESSION["SE_festUrl"]; ?>admini/software" title="Inventar">Einstellungen</a></td><td width="70px"></td><td width="50px"><a href="<? echo $_SESSION["SE_festUrl"]; ?>admini/user" title="Benutzerverwaltung"><div class="ui-state-default ui-corner-all"><span class="ui-icon ui-icon-person"></span></div></a></td><td><a href="<? echo $_SESSION["SE_festUrl"]; ?>admini/user" title="Benutzerverwaltung">Benutzerverwaltung</a></td></tr>
			<tr><td colspan='5'><br></td></tr>
			<?
			}
			?>

		</table></div></article>
		<?
		}
		?>	
	

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

echo utf8_encode($_SESSION["SE_EndeIndex"]);
?>

<br><br><br><br><br><br>
</body>
</html>