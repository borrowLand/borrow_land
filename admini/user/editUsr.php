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


<header> 
 <?
//#############Anfang Überschrift
?>
<hgroup><h1><a href="../../index.php" title="Startseite"><img src="../../BL_BILDER/start_00.png"></a> <a href="../../index.php" title="Startseite">borrow land</a></h1>
<?
$oeffentlich=0;
if ($oeffentlich=="1")
{
?>
<div id="ueberschr_all"><a href="../../">/Leihe</a><a href="../">/Verwaltung</a>/Benutzerverwaltung -  Bearbeitung</div>
</hgroup>
<?
}
else
{
	if (isset($_SESSION["User_ID"]) && $_SESSION["User_ID"]!="")
	{	
	?>
	<div id="ueberschr_all"><a href="../../">/Leihe</a><a href="../">/Verwaltung</a>/Benutzerverwaltung - Bearbeitung</div>
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
	echo '<br><br><div class="meldung_fehler"><img src="../../BL_BILDER/Meldungen_Warning.png"> <br>SESS_FU_LOAD_01</div><br><br>';	
	exit();
	}
	/////////////////////////////////////////////
?>
			
            </header>


            <section id="articles"> 

<?
	if ($_POST['usr_name']!="" && $_POST['usr_name']!="" && isset($_SESSION["User_ID"]) && $_SESSION["User_Recht_Admin"]=="1" && $_POST['dkh_a']!="")
	{
		//profil
		if ($_POST['usr_ProfOnOff']=="on")
		{
		$profOnOff=1;
		}
		else
		{
		$profOnOff=0;
		}		
		
		
		if ($_POST['usr_Recht1']=="on")
		{
		$Recht1=1;
		}
		else
		{
		$Recht1=0;
		}		
		
		if ($_POST['usr_RechtAusgabe2']=="on")
		{
		$Recht2=1;
		}
		else
		{
		$Recht2=0;
		}	
			
		if ($_POST['usr_RechtBestaet3']=="on")
		{
		$Recht3=1;
		}
		else
		{
		$Recht3=0;
		}	
					
		if ($_POST['usr_dauerl4']=="on")
		{
		$Recht4=1;
		}
		else
		{
		$Recht4=0;
		}		
		
		if ($_POST['usr_admin5']=="on" && isset($_POST['usr_admin5']) && $_POST['usr_admin5']!="")
		{
		$Recht5=1;
		}
		if ($_POST['usr_admin5']!="on" && isset($_POST['usr_admin5']) && $_POST['usr_admin5']!="")
		{
		$Recht5=0;
		}		

		$sql = "UPDATE `01_Benutzer` SET `vn_nn` = \"".mysql_real_escape_string(utf8_decode($_POST['usr_name']))."\", `tn` = \"".mysql_real_escape_string(utf8_decode($_POST['usr_tn']))."\", `m_id` = \"".mysql_real_escape_string(utf8_decode($_POST['usr_ident']))."\", `email` = \"".mysql_real_escape_string(utf8_decode($_POST['usr_email']))."\", `adr_strasse_hn` = \"".mysql_real_escape_string(utf8_decode($_POST['usr_addr1']))."\", `adr_plz` = \"".mysql_real_escape_string(utf8_decode($_POST['usr_addr2']))."\", `adr_stadt` = \"".mysql_real_escape_string(utf8_decode($_POST['usr_addr3']))."\", `ProfOnOff` = \"".$profOnOff."\", `rechte_ausleihe` = \"".$Recht1."\", `rechte_ausgabeberechtigt` = \"".$Recht2."\", `rechte_bestaetiger` = \"".$Recht3."\", `rechte_dauerleihe` = \"".$Recht4."\", `rechte_admin` = \"".$Recht5."\" WHERE `specid_cyrpt_md5` = \"".mysql_real_escape_string(unserialize(base64_decode($_POST['dkh_a'])))."\" LIMIT 1;"; 
		
		$EingabeUsRData = mysql_query($sql);
		$angabeErfolg = mysql_affected_rows(); 		
		

	}
?>

<?
//anfang voraussetzung: registriert, admin oder ausgabeberechtigter
if (isset($_SESSION["User_ID"]) && $_SESSION["User_Recht_Admin"]=="1")
{

	if (isset($_GET['u']) || isset($_POST['dkh_a']))
	{
	
		if (isset($_GET['u']))
		{
		$usrCode=unserialize(base64_decode($_GET['u']));
		}
		if (isset($_POST['dkh_a']))
		{
		$usrCode=unserialize(base64_decode($_POST['dkh_a']));
		}
	
	
	
	$sql = "SELECT * FROM `01_Benutzer` WHERE `specid_cyrpt_md5` = \"".mysql_real_escape_string($usrCode)."\" LIMIT 1 "; 
	$UsrDataAbfrage = mysql_query($sql);
	$USRdataSql = mysql_fetch_row($UsrDataAbfrage);
		
?>

	<article id="articleLogin2"> 
	<h2>Benutzerverwaltung - Bearbeitung</h2>
		
	<div class="line"></div>
	<div class="articleBody clear" >
	<a href="index.php" class="fg-button ui-state-default ui-corner-all" style="margin-bottom:10px;float:right">Übersicht</a>

	
	<div style="margin-left:251px" class="articleBody clear">
	<form id="newHG" autocomplete="off" method="post" action="editUsr.php">
	<input name="dkh_a" type="hidden" value="<? echo base64_encode(serialize($usrCode)); ?>" />

	<h4>Name</h4>
	<input name="usr_name" maxlength="100" class="login_inputtext" value="<? echo utf8_encode(htmlspecialchars($USRdataSql[3])); ?>" type="text">
	<br><br>
	
	<h4>Telefonnummer</h4>
	<input name="usr_tn" maxlength="20" class="login_inputtext" value="<? echo utf8_encode(htmlspecialchars($USRdataSql[4])); ?>" type="text">
	<br><br>
	
	<?
	if ($_SESSION["SE_AccessContrYN"]=="1")
	{
	?>
	<h4><? echo $_SESSION["SE_AccessContrName"]; ?></h4>
	<input name="usr_ident" maxlength="50" class="login_inputtext" value="<? echo utf8_encode(htmlspecialchars($USRdataSql[5])); ?>" type="text">
	<br><br>
	<?
	}
	?>
	
	<h4>E-Mail Adresse</h4>
	<input name="usr_email" maxlength="60" class="login_inputtext" value="<? echo utf8_encode(htmlspecialchars($USRdataSql[6])); ?>" type="text">
	<br><br>	
	
	<?
	if ($_SESSION["SE_AdressModuleYesNo"]=="1")
	{
	?>
	<h4>Adresse</h4>
	<input name="usr_addr1" maxlength="100" class="login_inputtext" value="<? echo utf8_encode(htmlspecialchars($USRdataSql[8])); ?>" type="text">
	<br><br>
	
	<h4>Postleitzahl</h4>
	<input name="usr_addr2" maxlength="5" class="login_inputtext" value="<? echo utf8_encode(htmlspecialchars($USRdataSql[9])); ?>" type="text">
	<br><br>	
	
	<h4>Stadt</h4>
	<input name="usr_addr3" maxlength="100" class="login_inputtext" value="<? echo utf8_encode(htmlspecialchars($USRdataSql[10])); ?>" type="text">
	<br><br>	
	<?
	}
	?>	
	
	<h4>Profil aktiv</h4>
	<p class="iphone-ui" id="iphoneP">
	<input type="checkbox" name="usr_ProfOnOff" <?
	if ($USRdataSql[11]=="1")
	{
	echo 'checked="checked"';
	}
	?>/></p>
	<br><br>	
	<hr>

	<br><br>
	
	<h4>Recht 1: Benutzer darf Objekte ausleihen</h4>
	<p class="iphone-ui" id="iphoneP">
	<input type="checkbox" name="usr_Recht1" <?
	if ($USRdataSql[15]=="1")
	{
	echo 'checked="checked"';
	}
	?>/></p>
	<br>	
	
	<h4>Recht 2: Benutzer darf Objekte ausgeben</h4>
	<p class="iphone-ui" id="iphoneP">
	<input type="checkbox" name="usr_RechtAusgabe2" <?
	if ($USRdataSql[16]=="1")
	{
	echo 'checked="checked"';
	}
	?>/></p>
	<br>
	
	<h4>Recht 3: Benutzer darf anderen Nutzern das Recht 1 (Ausleihe) <br>vergeben.</h4>
	<p class="iphone-ui" id="iphoneP">
	<input type="checkbox" name="usr_RechtBestaet3" <?
	if ($USRdataSql[17]=="1")
	{
	echo 'checked="checked"';
	}
	?>/></p>
	<br>
	
	<h4>Recht 4: Dauerleihe Nutzer- es gelten andere Begrenzungen<br> in der Ausleihe.</h4>
	<p class="iphone-ui" id="iphoneP">
	<input type="checkbox" name="usr_dauerl4" <?
	if ($USRdataSql[18]=="1")
	{
	echo 'checked="checked"';
	}
	?>/></p>
	<br>	
	
	<h4>Recht 5: Administrator.</h4>
	<?
	if ($USRdataSql[0]=="0" || $USRdataSql[0]=="1")
	{
	echo "Hinweis: Dieser Wert ist nicht änderbar, da Sie Hauptadministrator sind.";
	
		if ($USRdataSql[19]=="1")
		{
		echo '<input name="usr_admin5" type="hidden" value="on" />';
		}
		else
		{
		echo '<input name="usr_admin5" type="hidden" value="" />';
		}

	}
	else
	{
	?>
	<p class="iphone-ui" id="iphoneP"><input type="checkbox" name="usr_admin5" <?
		
		if ($USRdataSql[19]=="1")
		{
		echo 'checked="checked"/></p>';
		}
		else
		{
		echo "/></p>";
		}
	}
	
	?>
	<br><br>
	<h4>Ausleihe von Objekten</h4>
<br>Voraussetzungen: <br>
	<?
	if ($USRdataSql[13]=="0")
	{
	echo "<span class='ui-icon ui-icon-circle-close' title='NOK'></span> Der Benutzer wurde bisher nicht bestätigt. (<a href='../userAck'><b>bestätigen</b></a>)<br>";
	$leiheNOK=1;
	}
	else
	{
	echo "<span class='ui-icon ui-icon-circle-check' title='OK'></span> Der Benutzer wurde bestätigt.<br>";
	}

	if ($USRdataSql[15]=="0")
	{
	echo "<span class='ui-icon ui-icon-circle-close' title='NOK'></span> Das Recht der Ausleihe ist nicht gesetzt worden.<br>";
	$leiheNOK=1;
	}
	else
	{
	echo "<span class='ui-icon ui-icon-circle-check' title='OK'></span> Das Recht der Ausleihe ist gesetzt worden.<br>";
	}
	
	if ($USRdataSql[11]=="0")
	{
	echo "<span class='ui-icon ui-icon-circle-close' title='NOK'></span> Das Profil des Nutzers ist deaktiviert.<br>";
	$leiheNOK=1;
	}		
	else
	{
	echo "<span class='ui-icon ui-icon-circle-check' title='OK'></span> Das Profil des Nutzers ist aktiviert.<br>";
	}
	
	
	if ($leiheNOK!="1")
	{
	echo "<br><span class='ui-icon ui-icon-circle-arrow-e' title='OK'></span> Der Benutzer kann derzeit Objekte ausleihen.<br>";
	}
	else
	{
	echo "<br><span class='ui-icon ui-icon-circle-arrow-e' title='OK'></span> Eine Leihe dieses Benutzers ist derzeit nicht möglich.<br>";
	}
	
	?>

	
	<br><br><br><br><br>
		
		<input aria-disabled="false" class="ui-button ui-widget ui-state-default ui-corner-all" value="Benutzerdaten ändern" type="submit">
		</form>
	<br><br><br><br>
		
		</div>		
			
		</div>
		</article>


	<?	

	}
	else
	{
		?>
		<article id="articleLogin2"> 
		<form id="form">
		<h2>Benutzer Bearbeitung</h2>
			
		<div class="line"></div>
			<div class="articleBody clear" >
			Leider ist ein Übertragungsfehler aufgetreten.<br><br><a href="<? echo $_SESSION["SE_festUrl"]."admini/user"; ?>"><b>Übersicht Benutzer</b></a><br><br>
		</div>
		</article>
		<?			
	}
}//ende voraussetzung registriert
else
{
	//nicht eingeloggt
	/////////////////////////////////////////////
	$includeName="../../_02_NoLoginAllPages.inc.php";
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
	        
 
		 

        
<!-- JavaScript Includes -->
<?
echo nl2br($_SESSION["SE_jQuerUI"]);
?>  
<script type="text/javascript" src="../../BL_JS/jquery.numeric.js"></script>
<script type="text/javascript" src="../../BL_JS/jquery.ezmark.min.js"></script>

<script>
	$('#iphoneP input').ezMark({checkboxCls:'ez-checkbox-iphone', checkedCls: 'ez-checked-iphone'});
<?

	if (isset($angabeErfolg) && isset($EingabeUsRData))
{

	if ($angabeErfolg=="1")
	{
	?>
	$.pnotify({
	pnotify_title: 'Änderung der Benutzerdaten',
	pnotify_text: 'Die Benutzerdaten wurden erfolgreich geändert.',
	});
	<?
	}
	
	else
	{
	?>
	$.pnotify({
	pnotify_title: 'Änderung der Benutzerdaten',
	pnotify_text: 'Die Benutzerdaten wurden nicht erfolgreich geändert.',
	pnotify_type: 'error',
	});
	<?
	}
}
?>


</script>

<?
echo utf8_encode($_SESSION["SE_EndeIndex"]);
?>

<br><br><br><br><br><br>
</body>
</html>