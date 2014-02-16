<?

session_start();

//$robert1= base64_encode(serialize("hallo"));
//$robert2= unserialize(base64_decode($robert1));


//weiterleitungen nötig? 
//anfang voraussetzung: registriert, admin oder ausgabeberechtigter
if ((isset($_SESSION["User_ID"]) && $_SESSION["User_Recht_Ausgabeber"]=="1") || (isset($_SESSION["User_ID"]) && $_SESSION["User_Recht_Admin"]=="1") && ($_POST["barcode_input"]!=""))
{
	//objekte modus
	if (preg_match("[^o-]", $_POST["barcode_input"]))
	{
	//Datenbank Verbindung
	/////////////////////////////////////////////
	$includeName="../../../_01_basic_db.inc.php";
	if (file_exists($includeName))
	{
	require($includeName);
	}	
	else
	{
	echo '<br><br><div class="meldung_fehler"><img src="../../../BL_BILDER/Meldungen_Warning.png"> <br>DB_FU_LOAD_01</div><br><br>';	
	exit();
	}

	/////////////////////////////////////////////
	
	
	
	$objekt = explode("-", $_POST["barcode_input"]);
	$sql = "SELECT id FROM `04_obj_objekte` WHERE `specid_obj` = \"".mysql_real_escape_string($objekt[1])."\" LIMIT 1 "; 	
	$obje = mysql_query($sql);
	$anzahlObje = mysql_num_rows($obje); 

		if ($anzahlObje=="1")
		{
		Header("Location: ".$_SESSION["SE_festUrl"]."admini/inventar/objEdit/edit.php?y=".$objekt[1]);
		}
		else
		{
		$fehlerIdentObje=1;
		}	
	}
	
	//warenkorb modus
	if (preg_match("[^w-]", $_POST["barcode_input"])=="1")
	{
	//Datenbank Verbindung
	/////////////////////////////////////////////
	$includeName="../../../_01_basic_db.inc.php";
	if (file_exists($includeName))
	{
	require($includeName);
	}	
	else
	{
	echo '<br><br><div class="meldung_fehler"><img src="../../../BL_BILDER/Meldungen_Warning.png"> <br>DB_FU_LOAD_01</div><br><br>';	
	exit();
	}

	/////////////////////////////////////////////
	
	$wk = explode("-", $_POST["barcode_input"]);
	//$wk[1]= preg_replace("/\r|\n/s", "", $wk[1]);
	$sql = 'SELECT `id` FROM `05_wk` WHERE `specid_wk` = \''.mysql_real_escape_string($wk[1]).'\' LIMIT 1 '; 
	$wks = mysql_query($sql);
	$anzahlWKs = mysql_num_rows($wks); 

		if ($anzahlWKs=="1")
		{
		Header("Location: ".$_SESSION["SE_festUrl"]."admini/adminLeihe/wkEdit?wk=".base64_encode(serialize(mysql_real_escape_string($wk[1]))));	
		}
		else
		{
			//ist der warenkorb schon gelöscht worden?
			$sql = "SELECT geloescht_am,bemerkungen,owner FROM `07_wkHistory` WHERE `specid_wk` = \"".mysql_real_escape_string($wk[1])."\" LIMIT 1 "; 	
			$wksArch = mysql_query($sql);
			$anzahlWKsArc = mysql_num_rows($wksArch);
			$rowArchive = mysql_fetch_row($wksArch);			
			
			if ($anzahlWKsArc=="1")
			{
			//der name des benutzers
			$sql = "SELECT vn_nn FROM `01_Benutzer` WHERE `specid_cyrpt_md5` = \"".$rowArchive[2]."\" LIMIT 1 "; 	
			$nutzername = mysql_query($sql);
			$anzahlNutzername = mysql_num_rows($nutzername);
			
				if ($anzahlNutzername=="1")
				{
				$DatenAnzahlNutzername = mysql_fetch_row($nutzername);
				$nutzernameKlartext=$DatenAnzahlNutzername[0];
				$fehlerIdentWKArch=2; //ausgabe jquery
				$begruendung=$rowArchive[1];
				$zeit=$rowArchive[0];
				}
				else
				{
				$fehlerIdentWKArch=1; //ausgabe jquery
				$begruendung=$rowArchive[1];
				$zeit=$rowArchive[0];
				}
			}
			else
			{
			$fehlerIdentWK=1;
			}
		}
	}
}




//System 
/////////////////////////////////////////////
$includeName="../../../_00_basic_check.inc.php";
if (file_exists($includeName))
{
require($includeName);
}	
else
{
echo '<br><br><div class="meldung_fehler"><img src="../../../BL_BILDER/Meldungen_Warning.png"> <br>CHECK_ALL_LOAD_01</div><br><br>';	
exit();
}

/////////////////////////////////////////////

//Funktionen 
/////////////////////////////////////////////
$includeName="../../../_00_basic_func.inc.php";
if (file_exists($includeName))
{
require($includeName);
}	
else
{
echo '<br><br><div class="meldung_fehler"><img src="../../../BL_BILDER/Meldungen_Warning.png"> <br>FU_ALL_LOAD_01</div><br><br>';	
exit();
}

/////////////////////////////////////////////


//Datenbank Verbindung
/////////////////////////////////////////////
$includeName="../../../_01_basic_db.inc.php";
if (file_exists($includeName))
{
require($includeName);
}	
else
{
echo '<br><br><div class="meldung_fehler"><img src="../../../BL_BILDER/Meldungen_Warning.png"> <br>DB_FU_LOAD_01</div><br><br>';	
exit();
}

/////////////////////////////////////////////


//Sessions
/////////////////////////////////////////////
$includeName="../../../_01_basic_sess.inc.php";
if (file_exists($includeName))
{
require($includeName);
}	
else
{
echo '<br><br><div class="meldung_fehler"><img src="../../../BL_BILDER/Meldungen_Warning.png"> <br>SESS_FU_LOAD_01</div><br><br>';	
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
<br><br><br><br><div class="meldung_fehler"><img src="../../../BL_BILDER/Meldungen_Warning.png">Diese Webseite läuft leider nur, wenn Sie <a href="http://de.wikipedia.org/wiki/Javascript" target="_blank">Javascript</a> zulassen. <br>Bitte aktivieren Sie diesen technischen Standard in Ihrem Browser, Danke!</div>
<br><br>
</NOSCRIPT>	
		
<section id="page"> 


            <header> 
            
<?
//#############Anfang Überschrift
?>
<hgroup><h1><a href="../../../index.php" title="Startseite"><img src="../../../BL_BILDER/start_00.png"></a> <a href="../../../index.php" title="Startseite">borrow land</a></h1>
<?
$oeffentlich=0;
if ($oeffentlich=="1")
{
?>
<div id="ueberschr_all"><a href="../../../">/Leihe</a><a href="../../">/Verwaltung</a><a href="../">/Ausleiheverwaltung</a>/Barcode-Modus</div>
</hgroup>
<?
}
else
{
	if (isset($_SESSION["User_ID"]) && $_SESSION["User_ID"]!="")
	{	
	?>
<div id="ueberschr_all"><a href="../../../">/Leihe</a><a href="../../">/Verwaltung</a><a href="../">/Ausleiheverwaltung</a>/Barcode-Modus</div>
	</hgroup>
	<?
	}
}
//#############Ende Überschrift	

	//navigation
	/////////////////////////////////////////////
	$includeName="../../../_00_basic_nav.inc.php";
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


            <section id="articles"> 
			
<?
//anfang voraussetzung: registriert, admin oder ausgabeberechtigter
if ((isset($_SESSION["User_ID"]) && $_SESSION["User_Recht_Ausgabeber"]=="1") || (isset($_SESSION["User_ID"]) && $_SESSION["User_Recht_Admin"]=="1"))
{
?>

<article id="articleLogin2"> 
<h2>Barcode-Modus</h2>
	
<div class="line"></div>
	<div class="articleBody clear" >
	<p>Scannen Sie einen beliebigen Barcode ein, es werden Ihnen alle verfügbaren Informationen angezeigt.</p><br><br>
		<div style="margin-left:251px" class="articleBody clear">
		<h4>BARCODE</h4>
		<form id="BenForgForm" autocomplete="off" method="post" action="index.php">
		<input name="barcode_input" class="login_inputtext" type="text"><br><br>
		<input aria-disabled="false" class="ui-button ui-widget ui-state-default ui-corner-all ui-state-hover" value="Überprüfen" type="submit">
		</form>
		</div>
	</div>

</article>


<?	

	
}//ende voraussetzung registriert
else
{
	//nicht eingeloggt
	/////////////////////////////////////////////
	$includeName="../../../_02_NoLoginAllPages.inc.php";
	if (file_exists($includeName))
	{
	require($includeName);
	}	
	else
	{
	echo '<br><br><div class="meldung_fehler"><img src="../../../BL_BILDER/Meldungen_Warning.png"> <br>DB_FU_LOAD_01</div><br><br>';	
	exit();
	}
	/////////////////////////////////////////////
}
?>
			


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
$includeName="../../../_00_basic_footer.php";
if (file_exists($includeName))
{
include_once($includeName);
}	
else
{
echo '<br><br><div class="meldung_fehler"><img src="../../../BL_BILDER/Meldungen_Warning.png"> <br>FOOTER_FU_LOAD</div><br><br>';	
exit();
}

/////////////////////////////////////////////			
?>  
	        
 
		 

        
<!-- JavaScript Includes -->
<?
echo nl2br($_SESSION["SE_jQuerUI"]);

if ($fehlerIdentObje=="1")
{
	?>
	<script>
	$.pnotify({
	pnotify_title: 'Objekt-Suche',
	pnotify_text: 'Leider konnte dieses Objekt nicht gefunden werden.',
	pnotify_type: 'error'
	});
	</script>
	<?
}

if ($fehlerIdentWK=="1")
{
	?>
	<script>
	$.pnotify({
	pnotify_title: 'Warenkorb-Suche',
	pnotify_text: 'Leider konnte dieser Warenkorb nicht gefunden werden.',
	pnotify_type: 'error'
	});
	</script>
	<?
}

if ($fehlerIdentWKArch=="1")
{
	?>
	<script>
	$.pnotify({
	pnotify_title: 'Warenkorb-Suche',
	pnotify_text: 'Der Warenkorb wurde am <? echo timeCdZuDatumMitZeit($zeit); ?> gelöscht. Als Löschungsgrund wurde angegeben: <? echo utf8_encode($begruendung); ?> Der Mieter ist nicht mehr aktiv.',
	});
	</script>
	<?
}

if ($fehlerIdentWKArch=="2")
{
	?>
	<script>
	$.pnotify({
	pnotify_title: 'Warenkorb-Suche',
	pnotify_text: 'Der Warenkorb wurde am <? echo timeCdZuDatumMitZeit($zeit); ?> gelöscht. Als Löschungsgrund wurde angegeben: <? echo utf8_encode($begruendung); ?> Mieter: (<? echo $nutzernameKlartext; ?>)',
	});
	</script>
	<?
}


?>

<script>
$("#loadingAj").hide();
$("#loadingAj").ajaxStart(function(){
   $(this).show();
 });
 $("#loadingAj").ajaxStop(function(){
   $(this).hide();
 });
 $("input:text:visible:first").focus();

</script>







<?
echo utf8_encode($_SESSION["SE_EndeIndex"]);
?>

<br><br><br><br><br><br>
</body>
</html>