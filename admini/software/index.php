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
		
<section id="page"> 


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
<div id="ueberschr_all"><a href="../../">/Leihe</a><a href="../">/Verwaltung</a>/Einstellungen Software</div>
</hgroup>
<?
}
else
{
	if (isset($_SESSION["User_ID"]) && $_SESSION["User_ID"]!="")
	{	
	?>
	<div id="ueberschr_all"><a href="../../">/Leihe</a><a href="../">/Verwaltung</a>/Einstellungen Software</div>
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
	<div id="loadingAj"></div>
	<div id="output"></div>
			
	<?
	if (isset($_SESSION["User_ID"]) && $_SESSION["User_Recht_Admin"]=="1")
	{
	?>


	
<article id="articleLogin1"> 
<h2>Einstellungen Software</h2>
<br><span class="ui-icon ui-icon-alert" title="ui-icon-alert"></span>Bitte beachten Sie, dass erst nach Löschen der Browserdaten (Cookie) die Einstellungen sichtbar sind. 

<div class="line"></div>
<div class="articleBody clear">

<div id="tabsAdmin">
<ul>
	<li><a href="#Module">Module</a></li>
	<li><a href="#RegisStart">Registrierungseinstellungen</a></li>
	<li><a href="#Lend">Ausleiheinstellungen</a></li>
	<li><a href="#oz">Öffnungszeiten</a></li>
	<li><a href="#iKo">Impressum/Kontakt</a></li>
	<li><a href="#Transl">Übersetzen</a></li>
	<li><a href="#DL">Automatische Datenlöschung</a></li>
	<li><a href="#Prot">Protokoll</a></li>
	<li><a href="#AdStat">Erweiterte Statistik</a></li>
	<li><a href="#twitr">twitter</a></li>	
</ul>

	<div id="Module">

		<div style="margin-left:110px; margin-right:110px;" class="articleBody clear">

			<h4 title="Letzte Änderung: <? echo welcheEinstellungLetzteAend(SE_AdressModuleYesNo); ?>">Adress-Modul</h4>
			<p class="iphone-ui" id="iphoneP">
			Dieses Modul verlangt bei der Registrierung die Eingabe einer Adresse mit Stadt und Postleitszahl. 
			In Mietverträgen wird diese Adresse dann automatisch integriert.
			<br><input type="checkbox" name="Mod_Adress" id="Mod_Adress" <?
			if (welcheEinstellung("SE_AdressModuleYesNo")=="1")
			{
			echo 'checked="checked"';
			}
			?>/></p>

		<hr>

			<br><h4 title="Letzte Änderung: <? echo welcheEinstellungLetzteAend(SE_MoneyModule); ?>">monetäres Modul</h4>
			<p class="iphone-ui" id="iphoneP">
			Alle monetären Funktionen wie die Anzeige des Wiederbeschaffungswert in den Mietverträgen oder Paypal wird aktiviert.
			<br><input type="checkbox" name="Mod_Money" id="Mod_Money" <?
			if (welcheEinstellung("SE_MoneyModule")=="1")
			{
			echo 'checked="checked"';
			}
			?>/></p>	
			
			<?
			if (welcheEinstellung("SE_MoneyModule")=="1")
			{
			echo '<div id="monModMP">';
			}
			else
			{
			echo '<div id="monModMP" class="ui-helper-hidden">';
			}
			?>
			<br><h4 title="Letzte Änderung: <? echo welcheEinstellungLetzteAend(SE_MoneyModule_Mietp); ?>">monetäres Modul - Mietpreise</h4>
			<p class="iphone-ui" id="iphoneP">
			Die Mietpreise erscheinen auf den Mietverträgen.
			<br><input type="checkbox" name="Mod_Money2" id="Mod_Money2" <?
			if (welcheEinstellung("SE_MoneyModule_Mietp")=="1")
			{
			echo 'checked="checked"';
			}
			?>/></p>	
			</div>
			
		<hr>

			<br><h4 title="Letzte Änderung: <? echo welcheEinstellungLetzteAend(SE_AccessContrYN); ?>">Modul Zugangsprüfung</h4>
			<p class="iphone-ui" id="iphoneP">
			Die Prüfung eines Zugangs wird eingeschaltet. 
			<br><input type="checkbox" name="Mod_access" id="Mod_access" <?
			if (welcheEinstellung("SE_AccessContrYN")=="1")
			{
			echo 'checked="checked"';
			}
			?>/></p>	

			<?
			if (welcheEinstellung("SE_AccessContrYN")=="1")
			{
			echo '<div id="zugangsnumm">';
			}
			else
			{
			echo '<div id="zugangsnumm" class="ui-helper-hidden">';
			}
			?>
			<br><h4 title="Letzte Änderung: <? echo welcheEinstellungLetzteAend(SE_AccessContrName); ?>">Modul Zugangsprüfung - Bezeichnung</h4>
			<p class="iphone-ui" id="iphoneP">
			Wie soll die Zugangsprüfung bezeichnet werden (z.B. Mitarbeiternummer, Matrikelnummer). 
			<br><input type="input" name="Mod_access2" id="Mod_access2" class="input_auswahl2" maxlength="40" <?
			echo 'value=\''.strip_tags(utf8_encode(welcheEinstellung("SE_AccessContrName"))).'\'';
			?> />
			<a href="#link" id="txt_bezChec" class="fg-button ui-state-default ui-corner-all" style="margin-bottom: 10px; float: right;">Ändern</a>
			<br><br><br></p>	
			</div>
			
		<hr>
			
			<br><br><h4 title="Letzte Änderung: <? echo welcheEinstellungLetzteAend(SE_vortextJaNein); ?>">Modul Vortext</h4>
			<p class="iphone-ui" id="iphoneP">
			Bei der Registrierung wird ein Vortext eingelendet. 
			<br><input type="checkbox" name="Mod_Vortext" id="Mod_Vortext" <?
			if (welcheEinstellung("SE_vortextJaNein")=="1")
			{
			echo 'checked="checked"';
			}
			?>/></p>	
			
			<?
			if (welcheEinstellung("SE_vortextJaNein")=="1")
			{
			echo '<div id="textCont">';
			}
			else
			{
			echo '<div id="textCont" class="ui-helper-hidden">';
			}
			?>		
			<br><h4 title="Letzte Änderung: <? echo welcheEinstellungLetzteAend(SE_vortextInhalt); ?>">Modul Vortext - Inhalt</h4>
			<p class="iphone-ui" id="iphoneP">
			Bitte geben Sie hier den Text ein, der vor der Registrierung angezeigt werden soll. 
			<br>
			<textarea name="Mod_VortextCont" id="Mod_VortextCont" class="input_long2" wrap="hard"><?
			$sql = "SELECT InhaltDerEinstellung FROM `00_einstellungenSoftware` WHERE `Desc_Session` = \"SE_vortextInhalt\" LIMIT 1"; 
			$datenEinstell = mysql_query($sql);
			$row = mysql_fetch_row($datenEinstell);	
			echo utf8_encode(strip_tags($row[0]));
			//echo strip_tags(utf8_encode(welcheEinstellung("SE_vortextInhalt")));
			?></textarea>
			<a href="#link" id="txt_vortxt" class="fg-button ui-state-default ui-corner-all" style="margin-bottom: 10px; float: right;">Ändern</a>
			</p></div><br><br><br>

			
		<hr>
			
			<br><br><h4 title="Letzte Änderung: <? echo welcheEinstellungLetzteAend(SE_RFIDModule); ?>">RFID-Modul</h4>
			<p class="iphone-ui" id="iphoneP">
			Benutzen Sie dieses Modul um die RFID Funktionalität anzuzeigen und zu nutzen.
			<br><input type="checkbox" name="Mod_RFID" id="Mod_RFID" <?
			if (welcheEinstellung("SE_RFIDModule")=="1")
			{
			echo 'checked="checked"';
			}
			?>/></p>			
			
			<hr>


			<br><br><h4 title="Letzte Änderung: <? echo welcheEinstellungLetzteAend(SE_versandMod); ?>">Versand-Modul</h4>
			<p class="iphone-ui" id="iphoneP">
			Versandoption: Sollen Ihre Objekte versendet werden können?
			<br><input type="checkbox" name="Mod_Versand" id="Mod_Versand" <?
			if (welcheEinstellung("SE_versandMod")=="1")
			{
			echo 'checked="checked"';
			}
			?>/></p>	

			<?
			if (welcheEinstellung("SE_versandMod")=="1")
			{
			echo '<div id="versandeinstell">';
			}
			else
			{
			echo '<div id="versandeinstell" class="ui-helper-hidden">';
			}
			?>
			
			<br><h4 title="Letzte Änderung: <? echo welcheEinstellungLetzteAend(SE_versandURL); ?>">Versand - Info URL</h4>
			<p class="iphone-ui" id="iphoneP">
			Auf welcher Internetseite können die Nutzer weitere Informationen zum Versand erhalten? 
			<br><input type="input" name="Mod_VersandURL" id="Mod_VersandURL" class="input_auswahl2" maxlength="40" <?
			echo 'value=\''.strip_tags(utf8_encode(welcheEinstellung("SE_versandURL"))).'\'';
			?> />
			<a href="#link" id="txt_VersandUrl" class="fg-button ui-state-default ui-corner-all" style="margin-bottom: 10px; float: right;">Ändern</a>
			<br><br><br></p>

			<br><h4 title="Letzte Änderung: <? echo welcheEinstellungLetzteAend(SE_versandPreisAll); ?>">Versand - Kosten</h4>
			<p class="iphone-ui" id="iphoneP">
			Geben Sie die Kosten an, die pro Objekt beim Versand entstehen.
			<br><input type="input" name="Mod_VersandPrice" id="Mod_VersandPrice" class="input_auswahl2" maxlength="40" <?
			echo 'value=\''.strip_tags(utf8_encode(welcheEinstellung("SE_versandPreisAll"))).'\'';
			?> />
			<a href="#link" id="txt_VersandPreis" class="fg-button ui-state-default ui-corner-all" style="margin-bottom: 10px; float: right;">Ändern</a>
			<br><br><br></p>



			
			</div>


			
			<br><br><br><br><br><br><br>
		</div>
	</div>
	
	<div id="RegisStart">
		<div style="margin-left:110px; margin-right:110px;" class="articleBody clear">
			
			<h4 title="Letzte Änderung: <? echo welcheEinstellungLetzteAend(SE_GleichLeiheMoegli); ?>">Nach der Registrierung kann der Benutzer gleich reservieren.</h4>
			<p class="iphone-ui" id="iphoneP">
			Der Nutzer kann gleich nach der Registrierung Objekte ausleihen ("ON"-Einstellung).			
			<br><input type="checkbox" name="Mod_LeiheAftReg" id="Mod_LeiheAftReg" <?
			if (welcheEinstellung("SE_GleichLeiheMoegli")=="1")
			{
			echo 'checked="checked"';
			}
			?>/></p>

		<hr>			
			
			<br><h4 title="Letzte Änderung: <? echo welcheEinstellungLetzteAend(SE_AdressModuleYesNo); ?>">Profilaktivierung</h4>
			<p class="iphone-ui" id="iphoneP">
			Das Benutzerprofil soll nach einer Registrierung aktiviert werden ("ON"-Einstellung).
			<br><input type="checkbox" name="Mod_ProfAftReg" id="Mod_ProfAftReg" <?
			if (welcheEinstellung("SE_ProfilOnOff")=="1")
			{
			echo 'checked="checked"';
			}
			?>/></p>

		<hr>			
			
			<br><h4 title="Letzte Änderung: <? echo welcheEinstellungLetzteAend(SE_reCap_private); ?>">reCaptcha Daten - privater Schlüssel</h4>
			<p class="iphone-ui" id="iphoneP">
			Der private Schlüssel wird benötigt, um den SPAM Schutz zu gewährleisten. 
			<br><input type="input" name="Mod_reCap1" id="Mod_reCap1" class="input_auswahl2" maxlength="60" <?
			echo 'value=\''.strip_tags(utf8_encode(welcheEinstellung("SE_reCap_private"))).'\'';
			?> />
			<a href="#link" id="txt_reCap1" class="fg-button ui-state-default ui-corner-all" style="margin-bottom: 10px; float: right;">Ändern</a>
			<br><br><br></p>
			
		
			<br><h4 title="Letzte Änderung: <? echo welcheEinstellungLetzteAend(SE_reCap_public); ?>">reCaptcha Daten - öffentlicher Schlüssel</h4>
			<p class="iphone-ui" id="iphoneP">
			Der öffentliche Schlüssel wird benötigt, um den SPAM Schutz zu gewährleisten. 
			<br><input type="input" name="Mod_reCap2" id="Mod_reCap2" class="input_auswahl2" maxlength="60" <?
			echo 'value=\''.strip_tags(utf8_encode(welcheEinstellung("SE_reCap_public"))).'\'';
			?> />
			<a href="#link" id="txt_reCap2" class="fg-button ui-state-default ui-corner-all" style="margin-bottom: 10px; float: right;">Ändern</a>
			<br><br><br></p>			
			
		<hr>			
			
			<br><h4 title="Letzte Änderung: <? echo welcheEinstellungLetzteAend(SE_TextRegBestaetigu); ?>">E-Mail Text nach Registrierung</h4>
			<p class="iphone-ui" id="iphoneP">
			Bitte geben Sie hier den Text ein, der nach der Registrierung dem neuen Benutzer zugeschickt werden soll. Hinweis: Die Einlogg-Daten werden automatisch angehängt.
			<br>
			<textarea name="Mod_MailNachReg" id="Mod_MailNachReg" class="input_long2" wrap="hard"><?
			echo strip_tags(utf8_encode(welcheEinstellung("SE_TextRegBestaetigu")));
			?></textarea>
			<a href="#link" id="txt_MailNachReg" class="fg-button ui-state-default ui-corner-all" style="margin-bottom: 10px; float: right;">Ändern</a>
			</p>
			


						

			<br><br><br><br><br><br><br>	
		</div>	
	</div>
	
	
	


	<div id="Lend">
	
		<div style="margin-left:110px; margin-right:110px;" class="articleBody clear">
			<h4 title="Letzte Änderung: <? echo welcheEinstellungLetzteAend(SE_ViewLeihmodHauptg); ?>">Aktivierung Leihmodul Hauptgruppen</h4>
			<p class="iphone-ui" id="iphoneP">
			Der Benutzer kann nach Auswahl des Zeitraumes anhand der Hauptgruppen-Auswahl sein Wunsch-Objekt ausleihen.
			<br><input type="checkbox" name="Mod_lendMod1" id="Mod_lendMod1" <?
			if (welcheEinstellung("SE_ViewLeihmodHauptg")=="1")
			{
			echo 'checked="checked"';
			}
			?>/></p>

			
	
			<br><h4 title="Letzte Änderung: <? echo welcheEinstellungLetzteAend(SE_ViewLeihmodEinzel); ?>">Aktivierung Leihmodul Einzelgeräte</h4>
			<p class="iphone-ui" id="iphoneP">
			Der Benutzer kann nach Auswahl des Zeitraumes anhand der Einzelgeräte-Auswahl sein Wunsch-Objekt ausleihen.
			<br><input type="checkbox" name="Mod_lendMod2" id="Mod_lendMod2" <?
			if (welcheEinstellung("SE_ViewLeihmodEinzel")=="1")
			{
			echo 'checked="checked"';
			}
			?>/></p>

			
	
			<br><h4 title="Letzte Änderung: <? echo welcheEinstellungLetzteAend(SE_ViewLeihmodTag); ?>">Aktivierung Leihmodul tags</h4>
			<p class="iphone-ui" id="iphoneP">
			Der Benutzer kann nach Auswahl des Zeitraumes anhand von tags (Schlagwörtern) sein Wunsch-Objekt ausleihen.
			<br><input type="checkbox" name="Mod_lendMod3" id="Mod_lendMod3" <?
			if (welcheEinstellung("SE_ViewLeihmodTag")=="1")
			{
			echo 'checked="checked"';
			}
			?>/></p>

			
			<?
			if (welcheEinstellung("SE_ViewLeihmodTag")=="1")
			{
			echo '<div id="ModtagsDiv">';
			}
			else
			{
			echo '<div id="ModtagsDiv" class="ui-helper-hidden">';
			}
			?>
			<br><h4 title="Letzte Änderung: <? echo welcheEinstellungLetzteAend(SE_tagAnzahl); ?>">Anzahl maximaler tags </h4>
			Anzahl der Schlagwörter, die maximal angezeigt werden sollen. (0=alle)
			<br><input type="input" name="Mod_MaxTagsA" id="Mod_MaxTagsA" class="input_auswahl2" maxlength="4" <?
			echo 'value=\''.strip_tags(utf8_encode(welcheEinstellung("SE_tagAnzahl"))).'\'';
			?> />
			<a href="#link" id="txt_Maxtags" class="fg-button ui-state-default ui-corner-all" style="margin-bottom: 10px; float: right;">Ändern</a>
			<br><br><br><br>
			</div>
			

		<hr>
			
			<br><h4 title="Letzte Änderung: <? echo welcheEinstellungLetzteAend(SE_normaloMaxStartTa); ?>">Maximaler Leihbeginn - Standardbenutzer</h4>
			Anzahl Tage, die im Voraus von einem Standardnutzer reserviert werden können.
			<br><input type="input" name="Mod_FutStdUsr" id="Mod_FutStdUsr" class="input_auswahl2" maxlength="4" <?
			echo 'value=\''.strip_tags(utf8_encode(welcheEinstellung("SE_normaloMaxStartTa"))).'\'';
			?> />
			<a href="#link" id="txt_FutStdUsr" class="fg-button ui-state-default ui-corner-all" style="margin-bottom: 10px; float: right;">Ändern</a>
			<br><br><br><br>
			
			<h4 title="Letzte Änderung: <? echo welcheEinstellungLetzteAend(SE_DauerleiheMaxStar); ?>">Maximaler Leihbeginn - Dauerleihebenutzer</h4>
			Anzahl Tage, die im Voraus von einem Dauerleihe-Nutzer reserviert werden können.
			<br><input type="input" name="Mod_FutAdvUsr" id="Mod_FutAdvUsr" class="input_auswahl2" maxlength="4" <?
			echo 'value=\''.strip_tags(utf8_encode(welcheEinstellung("SE_DauerleiheMaxStar"))).'\'';
			?> />
			<a href="#link" id="txt_FutAdvUsr" class="fg-button ui-state-default ui-corner-all" style="margin-bottom: 10px; float: right;">Ändern</a>
			<br><br><br><br>			
			
		<hr>	
			
			<br><h4 title="Letzte Änderung: <? echo welcheEinstellungLetzteAend(SE_normaloMaxDauerTa); ?>">Maximale Leihdauer - Standardbenutzer</h4>
			Anzahl der Zeitspanne in Tagen, die von einem Standard-Nutzer für ein Objekt zur Verfügung stehen.
			<br><input type="input" name="Mod_MaxDaysStdUsr" id="Mod_MaxDaysStdUsr" class="input_auswahl2" maxlength="4" <?
			echo 'value=\''.strip_tags(utf8_encode(welcheEinstellung("SE_normaloMaxDauerTa"))).'\'';
			?> />
			<a href="#link" id="txt_MaxDaysStdUsr" class="fg-button ui-state-default ui-corner-all" style="margin-bottom: 10px; float: right;">Ändern</a>
			<br><br><br><br>
			
			<h4 title="Letzte Änderung: <? echo welcheEinstellungLetzteAend(SE_DauerleiheMaxDaue); ?>">Maximale Leihdauer - Dauerleihebenutzer</h4>
			Anzahl der Zeitspanne in Tagen, die von einem Dauerleihe-Nutzer für ein Objekt zur Verfügung stehen.
			<br><input type="input" name="Mod_MaxDaysAdvUsr" id="Mod_MaxDaysAdvUsr" class="input_auswahl2" maxlength="4" <?
			echo 'value=\''.strip_tags(utf8_encode(welcheEinstellung("SE_DauerleiheMaxDaue"))).'\'';
			?> />
			<a href="#link" id="txt_MaxDaysAdvUsr" class="fg-button ui-state-default ui-corner-all" style="margin-bottom: 10px; float: right;">Ändern</a>
			<br><br><br><br>				
			
		<hr>	
			
			<br><h4 title="Letzte Änderung: <? echo welcheEinstellungLetzteAend(SE_AnzahlElemWKMax); ?>">Maximale Ausleihobjekte in einem Warenkorb </h4>
			Anzahl der Leihobjekte, die ein Benutzer mit einem Ausleihvorgang in den Warenkorb legen kann.
			<br><input type="input" name="Mod_ElemWK" id="Mod_ElemWK" class="input_auswahl2" maxlength="4" <?
			echo 'value=\''.strip_tags(utf8_encode(welcheEinstellung("SE_AnzahlElemWKMax"))).'\'';
			?> />
			<a href="#link" id="txt_ElemWK" class="fg-button ui-state-default ui-corner-all" style="margin-bottom: 10px; float: right;">Ändern</a>
			<br><br><br><br>		
			
		<hr>
			
			<br><h4 title="Letzte Änderung: <? echo welcheEinstellungLetzteAend(SE_InfoFaellObj); ?>">Benachrichtigung bei Fälligkeit</h4>
			<p class="iphone-ui" id="iphoneP">
			Aktivieren Sie diese Option, wenn Sie Hinweise in der Ausleiheverwaltung erhalten wollen, wenn Objekte nicht rechtzeitig abgegeben worden sind.
			<br><input type="checkbox" name="Mod_messFae" id="Mod_messFae" <?
			if (welcheEinstellung("SE_InfoFaellObj")=="1")
			{
			echo 'checked="checked"';
			}
			?>/></p>			
			
			
		<hr>	
			
			<br><h4 title="Letzte Änderung: <? echo welcheEinstellungLetzteAend(SE_TimeFreigabeLeihe); ?>">Ausgabe vor Reservierungszeit </h4>
			Zeitdauer, die angibt wieviele Stunden vor Beginn einer Leihe das Mietobjekt ausgegeben werden kann.
			<br><input type="input" name="Mod_ZeiRes" id="Mod_ZeiRes" class="input_auswahl2" maxlength="4" <?
			echo 'value=\''.strip_tags(utf8_encode(welcheEinstellung("SE_TimeFreigabeLeihe"))).'\'';
			?> />
			<a href="#link" id="txt_ZeiRes" class="fg-button ui-state-default ui-corner-all" style="margin-bottom: 10px; float: right;">Ändern</a>
			<br><br><br><br>		
			
			
			
	
		</div>
	</div>
	<div id="oz" class="clear">
	
	
<table width="100%" border="1">
  <tr>
    <td><h4>Wochentag</h4></td>
    <td align="center" valign="middle"><h4>Geöffnet?</h4></td>
    <td align="center" valign="middle"><h4>Zeitraum1<br><br><br><br></h4></td>
    <td align="center" valign="middle"><h4>Zeitraum2</h4><br> Hinweis: Bei "0-0 Uhr" wird<br> kein 2. Zeitraum berücksichtigt. </td>
  </tr>
  <tr>
    <td>
	Montag
	</td>
    
	<td align="center" valign="middle">
     <p class="iphone-ui" id="iphoneP"><input type="checkbox" name="geschl_mo24" id="geschl_mo24" <?
			if (welcheEinstellung("SE_MoGeschlOderZeite")=="1")
			{
			echo 'checked="checked"';
			}
			?> title="Letzte Änderung: <? echo welcheEinstellungLetzteAend(SE_MoGeschlOderZeite); ?>"/></p>
    </td>
    
	<td align="center" valign="middle">
	<br>
	<input type="text" id="valMo1" style="border:0; color:#000000; font-weight:bold;width:100px" />
	<br><br>
	<div id="sRgMo1" style="width:300px" ></div>
	<br>
	</td>
	
    <td align="center" valign="middle">
	<br>
	<input type="text" id="valMo2" style="border:0; color:#000000; font-weight:bold;width:100px" />
	<br><br>
	<div id="sRgMo2" style="width:300px" ></div>
	<br>
	</td>
  </tr>
  <tr>
    <td>
	Dienstag
	</td>
	
    <td align="center" valign="middle">
	<p class="iphone-ui" id="iphoneP"><input type="checkbox" name="geschl_di24" id="geschl_di24" <?
			if (welcheEinstellung("SE_DiGeschlOderZeite")=="1")
			{
			echo 'checked="checked"';
			}
			?> title="Letzte Änderung: <? echo welcheEinstellungLetzteAend(SE_DiGeschlOderZeite); ?>"/></p>
	</td>
	
    <td align="center" valign="middle">
	<br>
	<input type="text" id="valDi1" style="border:0; color:#000000; font-weight:bold;width:100px" />
	<br><br>
	<div id="sRgDi1" style="width:300px" ></div>
	<br>
	</td>
	
    <td align="center" valign="middle">
	<br>
	<input type="text" id="valDi2" style="border:0; color:#000000; font-weight:bold;width:100px" />
	<br><br>
	<div id="sRgDi2" style="width:300px" ></div>
	<br>
	</td>
  </tr>
  <tr>
    <td>Mittwoch</td>
    <td align="center" valign="middle">
	<p class="iphone-ui" id="iphoneP"><input type="checkbox" name="geschl_mi24" id="geschl_mi24" <?
			if (welcheEinstellung("SE_MiGeschlOderZeite")=="1")
			{
			echo 'checked="checked"';
			}
			?> title="Letzte Änderung: <? echo welcheEinstellungLetzteAend(SE_MiGeschlOderZeite); ?>"/></p></td>
    <td align="center" valign="middle">
	<br>
	<input type="text" id="valMi1" style="border:0; color:#000000; font-weight:bold;width:100px" />
	<br><br>
	<div id="sRgMi1" style="width:300px" ></div>
	<br>
	</td>
    <td align="center" valign="middle">
	<br>
	<input type="text" id="valMi2" style="border:0; color:#000000; font-weight:bold;width:100px" />
	<br><br>
	<div id="sRgMi2" style="width:300px" ></div>
	<br>
	</td>
  </tr>
  <tr>
    <td>Donnerstag</td>
    <td align="center" valign="middle">
	<p class="iphone-ui" id="iphoneP"><input type="checkbox" name="geschl_do24" id="geschl_do24" <?
			if (welcheEinstellung("SE_DoGeschlOderZeite")=="1")
			{
			echo 'checked="checked"';
			}
			?> title="Letzte Änderung: <? echo welcheEinstellungLetzteAend(SE_DoGeschlOderZeite); ?>"/></p></td>
    <td align="center" valign="middle">
	<br>
	<input type="text" id="valDo1" style="border:0; color:#000000; font-weight:bold;width:100px" />
	<br><br>
	<div id="sRgDo1" style="width:300px" ></div>
	<br>
	</td>
    <td align="center" valign="middle">
	<br>
	<input type="text" id="valDo2" style="border:0; color:#000000; font-weight:bold;width:100px" />
	<br><br>
	<div id="sRgDo2" style="width:300px" ></div>
	<br>
	</td>
  </tr>
  <tr>
    <td>Freitag</td>
    <td align="center" valign="middle">
	<p class="iphone-ui" id="iphoneP"><input type="checkbox" name="geschl_fr24" id="geschl_fr24" <?
			if (welcheEinstellung("SE_FrGeschlOderZeite")=="1")
			{
			echo 'checked="checked"';
			}
			?> title="Letzte Änderung: <? echo welcheEinstellungLetzteAend(SE_FrGeschlOderZeite); ?>"/></p></td>
    <td align="center" valign="middle">
	<br>
	<input type="text" id="valFr1" style="border:0; color:#000000; font-weight:bold;width:100px" />
	<br><br>
	<div id="sRgFr1" style="width:300px" ></div>
	<br>
	</td>
    <td align="center" valign="middle">
	<br>
	<input type="text" id="valFr2" style="border:0; color:#000000; font-weight:bold;width:100px" />
	<br><br>
	<div id="sRgFr2" style="width:300px" ></div>
	<br>
	</td>
  </tr>
  <tr>
    <td>Sonnabend</td>
    <td align="center" valign="middle">
	<p class="iphone-ui" id="iphoneP"><input type="checkbox" name="geschl_sa24" id="geschl_sa24" <?
			if (welcheEinstellung("SE_SaGeschlOderZeite")=="1")
			{
			echo 'checked="checked"';
			}
			?> title="Letzte Änderung: <? echo welcheEinstellungLetzteAend(SE_SaGeschlOderZeite); ?>"/></p></td>
    <td align="center" valign="middle">
	<br>
	<input type="text" id="valSa1" style="border:0; color:#000000; font-weight:bold;width:100px" />
	<br><br>
	<div id="sRgSa1" style="width:300px" ></div>
	<br>
	</td>
    <td align="center" valign="middle">
	<br>
	<input type="text" id="valSa2" style="border:0; color:#000000; font-weight:bold;width:100px" />
	<br><br>
	<div id="sRgSa2" style="width:300px" ></div>
	<br>
	</td>
  </tr>
  <tr>
    <td>Sonntag</td>
    <td align="center" valign="middle">
	<p class="iphone-ui" id="iphoneP"><input type="checkbox" name="geschl_so24" id="geschl_so24" <?
			if (welcheEinstellung("SE_SoGeschlOderZeite")=="1")
			{
			echo 'checked="checked"';
			}
			?> title="Letzte Änderung: <? echo welcheEinstellungLetzteAend(SE_SoGeschlOderZeite); ?>"/></p></td>
    <td align="center" valign="middle">
	<br>
	<input type="text" id="valSo1" style="border:0; color:#000000; font-weight:bold;width:100px" />
	<br><br>
	<div id="sRgSo1" style="width:300px" ></div>
	<br>
	</td>
	
    <td align="center" valign="middle">	<br>
	<input type="text" id="valSo2" style="border:0; color:#000000; font-weight:bold;width:100px" />
	<br><br>
	<div id="sRgSo2" style="width:300px" ></div>
	<br>
	</td>
  </tr>
 
<tr>
<td colspan="4" align="center" valign="middle">
<br>
<a href="#link" id="clockChg" class="fg-button ui-state-default ui-corner-all" style="margin-bottom: 10px; float: right;">Ändern der Uhrzeiten</a>
</td>
</tr>
</table>


<table width="100%" border="0">
<tr>
<td colspan="4" border="0" align="center" valign="middle">
<br>Hier können Sie eine Stunde in weitere Ausleihschritte unterteilen.<br>Dadurch kann diese Einstellung auch als kleinste mögliche Leihzeit verstanden werden.<br><br>
Beispiele:<br> 60min=stundenweise Schritte<br> 30min=zu jeder halben Stunde wird eine Leihzeit angeboten.<br><br>Bei ungeraden Angaben wird aufgegrundet.<br><br><br>
<input type="text" id="minSteps" style="border:0; color:#000000; font-weight:bold;width:100px" />
<br><br>
<div id="visminSteps" style="width:300px" ></div>
<br><br>
<a href="#link" id="minMinChg" class="fg-button ui-state-default ui-corner-all" style="margin-bottom: 10px; float: right;">Ändern</a>

</td>
</tr>

</table>

<br><br>
<hr>
<br><br>

		<div style="margin-left:110px; margin-right:110px;" class="articleBody clear">

			<br><h4 title="Letzte Änderung: <? echo welcheEinstellungLetzteAend(SE_infoOeff_MO); ?>">Bemerkungsfeld für Öffnungszeiten am Montag</h4>
			Diese Bemerkung wird bei der Anzeige der Öffnungszeiten angezeigt.
			<br><input type="input" name="Mod_OeffnNote_MO" id="Mod_OeffnNote_MO" class="input_auswahl2" maxlength="245" <?
			echo 'value=\''.strip_tags(utf8_encode(welcheEinstellung("SE_infoOeff_MO"))).'\'';
			?> />
			<a href="#link" id="txt_OeffnNote_MO" class="fg-button ui-state-default ui-corner-all" style="margin-bottom: 10px; float: right;">Ändern</a>
			<br><br><br><br>	
	
			<br><h4 title="Letzte Änderung: <? echo welcheEinstellungLetzteAend(SE_infoOeff_DI); ?>">Bemerkungsfeld für Öffnungszeiten am Dienstag</h4>
			Diese Bemerkung wird bei der Anzeige der Öffnungszeiten angezeigt.
			<br><input type="input" name="Mod_OeffnNote_DI" id="Mod_OeffnNote_DI" class="input_auswahl2" maxlength="245" <?
			echo 'value=\''.strip_tags(utf8_encode(welcheEinstellung("SE_infoOeff_DI"))).'\'';
			?> />
			<a href="#link" id="txt_OeffnNote_DI" class="fg-button ui-state-default ui-corner-all" style="margin-bottom: 10px; float: right;">Ändern</a>
			<br><br><br><br>	

			<br><h4 title="Letzte Änderung: <? echo welcheEinstellungLetzteAend(SE_infoOeff_MI); ?>">Bemerkungsfeld für Öffnungszeiten am Mittwoch</h4>
			Diese Bemerkung wird bei der Anzeige der Öffnungszeiten angezeigt.
			<br><input type="input" name="Mod_OeffnNote_MI" id="Mod_OeffnNote_MI" class="input_auswahl2" maxlength="245" <?
			echo 'value=\''.strip_tags(utf8_encode(welcheEinstellung("SE_infoOeff_MI"))).'\'';
			?> />
			<a href="#link" id="txt_OeffnNote_MI" class="fg-button ui-state-default ui-corner-all" style="margin-bottom: 10px; float: right;">Ändern</a>
			<br><br><br><br>	

			<br><h4 title="Letzte Änderung: <? echo welcheEinstellungLetzteAend(SE_infoOeff_DO); ?>">Bemerkungsfeld für Öffnungszeiten am Donnerstag</h4>
			Diese Bemerkung wird bei der Anzeige der Öffnungszeiten angezeigt.
			<br><input type="input" name="Mod_OeffnNote_DO" id="Mod_OeffnNote_DO" class="input_auswahl2" maxlength="245" <?
			echo 'value=\''.strip_tags(utf8_encode(welcheEinstellung("SE_infoOeff_DO"))).'\'';
			?> />
			<a href="#link" id="txt_OeffnNote_DO" class="fg-button ui-state-default ui-corner-all" style="margin-bottom: 10px; float: right;">Ändern</a>
			<br><br><br><br>	

			<br><h4 title="Letzte Änderung: <? echo welcheEinstellungLetzteAend(SE_infoOeff_FR); ?>">Bemerkungsfeld für Öffnungszeiten am Freitag</h4>
			Diese Bemerkung wird bei der Anzeige der Öffnungszeiten angezeigt.
			<br><input type="input" name="Mod_OeffnNote_FR" id="Mod_OeffnNote_FR" class="input_auswahl2" maxlength="245" <?
			echo 'value=\''.strip_tags(utf8_encode(welcheEinstellung("SE_infoOeff_FR"))).'\'';
			?> />
			<a href="#link" id="txt_OeffnNote_FR" class="fg-button ui-state-default ui-corner-all" style="margin-bottom: 10px; float: right;">Ändern</a>
			<br><br><br><br>	

			<br><h4 title="Letzte Änderung: <? echo welcheEinstellungLetzteAend(SE_infoOeff_SA); ?>">Bemerkungsfeld für Öffnungszeiten am Sonnabend</h4>
			Diese Bemerkung wird bei der Anzeige der Öffnungszeiten angezeigt.
			<br><input type="input" name="Mod_OeffnNote_SA" id="Mod_OeffnNote_SA" class="input_auswahl2" maxlength="245" <?
			echo 'value=\''.strip_tags(utf8_encode(welcheEinstellung("SE_infoOeff_SA"))).'\'';
			?> />
			<a href="#link" id="txt_OeffnNote_SA" class="fg-button ui-state-default ui-corner-all" style="margin-bottom: 10px; float: right;">Ändern</a>
			<br><br><br><br>	

			<br><h4 title="Letzte Änderung: <? echo welcheEinstellungLetzteAend(SE_infoOeff_SO); ?>">Bemerkungsfeld für Öffnungszeiten am Sonntag</h4>
			Diese Bemerkung wird bei der Anzeige der Öffnungszeiten angezeigt.
			<br><input type="input" name="Mod_OeffnNote_SO" id="Mod_OeffnNote_SO" class="input_auswahl2" maxlength="245" <?
			echo 'value=\''.strip_tags(utf8_encode(welcheEinstellung("SE_infoOeff_SO"))).'\'';
			?> />
			<a href="#link" id="txt_OeffnNote_SO" class="fg-button ui-state-default ui-corner-all" style="margin-bottom: 10px; float: right;">Ändern</a>
			<br><br><br><br>				
	
	
	
	
	
</div>	

	</div>
	<div id="iKo">
	
		<div style="margin-left:110px; margin-right:110px;" class="articleBody clear">
			
			<br><h4 title="Letzte Änderung: <? echo welcheEinstellungLetzteAend(SE_Kundenname); ?>">Organisationsname (z.B. Firma)</h4>
			Der Name erscheint bei dem E-Mail Absender und bei allen Verträgen. 
			<br><input type="input" name="Mod_regOrga" id="Mod_regOrga" class="input_auswahl2" maxlength="40" <?
			echo 'value=\''.strip_tags(utf8_encode(welcheEinstellung("SE_Kundenname"))).'\'';
			?> />
			<a href="#link" id="txt_regOrgaNam" class="fg-button ui-state-default ui-corner-all" style="margin-bottom: 10px; float: right;">Ändern</a>
			<br><br><br><br>
			
		<hr>

			<br><h4 title="Letzte Änderung: <? echo welcheEinstellungLetzteAend(SE_adminEMail); ?>">E-Mail Adresse</h4>
			Diese Adresse wird als E-Mail Absender genutzt und im Zusammenhang mit borrow land genutzt. 
			<br><input type="input" name="Mod_regMail" id="Mod_regMail" class="input_auswahl2" maxlength="40" <?
			echo 'value=\''.strip_tags(utf8_encode(welcheEinstellung("SE_adminEMail"))).'\'';
			?> />
			<a href="#link" id="txt_regMail" class="fg-button ui-state-default ui-corner-all" style="margin-bottom: 10px; float: right;">Ändern</a>
			<br><br><br><br>

		<hr>			
			
			<br><h4 title="Letzte Änderung: <? echo welcheEinstellungLetzteAend(SE_imprint); ?>">Impressumstext</h4>
			Bitte geben Sie hier den Text ein, der auf der Seite bei Impressum erscheinen soll.
			<br>
			<textarea name="Mod_imprint" id="Mod_imprint" class="input_long2" wrap="hard"><?
			$sql = "SELECT InhaltDerEinstellung FROM `00_einstellungenSoftware` WHERE `Desc_Session` = \"SE_imprint\" LIMIT 1"; 
			$datenEinstell = mysql_query($sql);
			$row = mysql_fetch_row($datenEinstell);	
			echo utf8_encode(strip_tags($row[0]));
			
			
			
			//echo strip_tags(utf8_encode(welcheEinstellung("SE_imprint")));
			?></textarea>
			<a href="#link" id="txt_imprint" class="fg-button ui-state-default ui-corner-all" style="margin-bottom: 10px; float: right;">Ändern</a>





			
			<br><br><br><br><br><br><br>	
		</div>	
	
	
	</div>
	
	<div id="Transl">
		<div style="margin-left:110px; margin-right:110px;" class="articleBody clear">
			<br><h4 title="Letzte Änderung: <? echo welcheEinstellungLetzteAend(SE_GooTrans); ?>">Übersetzung durch Google</h4>
			<p class="iphone-ui" id="iphoneP">
			Auf jeder Webseite wird die Übersetzung angeboten, bei ausländischen Browsern/Besuchern wird automatisch ein Banner zur Übersetzung eingeblendet. 
			<br><input type="checkbox" name="Mod_UebersGoo" id="Mod_UebersGoo" <?
			if (welcheEinstellung("SE_GooTrans")=="1")
			{
			echo 'checked="checked"';
			}
			?>/></p>	

			<?
			if (welcheEinstellung("SE_GooTrans")=="1")
			{
			echo '<div id="gTr">';
			}
			else
			{
			echo '<div id="gTr" class="ui-helper-hidden">';
			}
			?>		
			<br><h4 title="Letzte Änderung: <? echo welcheEinstellungLetzteAend(SE_GooTransScript); ?>">Übersetzungscode von Google:</h4>
			<p class="iphone-ui" id="iphoneP">
			<textarea name="Mod_UebersGoo2" id="Mod_UebersGoo2" class="input_long2" wrap="hard"><?
			//strip_tags raus, da explizit script dargestellt wird
			echo (utf8_encode(welcheEinstellung("SE_GooTransScript")));
			?></textarea>
			<a href="#link" id="txt_gooTrCod" class="fg-button ui-state-default ui-corner-all" style="margin-bottom: 10px; float: right;">Ändern</a>
			</p></div>
			
			<br><br><br><br><br><br><br>
		</div>
	</div>
	

	<div id="DL">
			<div style="margin-left:110px; margin-right:110px;" class="articleBody clear">
				<br><h4 title="Letzte Änderung: <? echo welcheEinstellungLetzteAend(SE_VerfallAccountTag); ?>">Nicht aktive registrierte Benutzer</h4>
				Falls ein Nutzer nach der Registrierung sich nicht anmeldet, können Sie hier festlegen, nach wievielen Tagen der Zugang automatisch gelöscht werden soll.
				<br>Geben Sie 0 ein, wenn keine Nutzer automatisch gelöscht werden soll (nicht empfohlen).<br><br>
				<br><input type="input" name="Mod_AutoUserDel" id="Mod_AutoUserDel" class="input_auswahl2" maxlength="4" <?
				echo 'value=\''.strip_tags(utf8_encode(welcheEinstellung("SE_VerfallAccountTag"))).'\'';
				?> />
				<a href="#link" id="txt_AutoUserDel" class="fg-button ui-state-default ui-corner-all" style="margin-bottom: 10px; float: right;">Ändern</a>
				<br><br><br><br>	
			
		
		<hr>			
				<br><h4 title="Letzte Änderung: <? echo welcheEinstellungLetzteAend(SE_VerfallWkTag); ?>">Verfallende Warenkörbe</h4>
				Nachfolgend können Sie angeben, wieviele Tage bei allen Objekten eines Warenkorbes mindestens vergangen sein müssen, damit dieser automatisch gelöscht wird. 
				<br>Geben Sie 0 ein, wenn keine Warenkörbe automatisch gelöscht werden sollen (nicht empfohlen).<br><br>
				<br><input type="input" name="Mod_AutoWKDel" id="Mod_AutoWKDel" class="input_auswahl2" maxlength="4" <?
				echo 'value=\''.strip_tags(utf8_encode(welcheEinstellung("SE_VerfallWkTag"))).'\'';
				?> />
				<a href="#link" id="txt_AutoWKDel" class="fg-button ui-state-default ui-corner-all" style="margin-bottom: 10px; float: right;">Ändern</a>
				<br><br><br><br>	
			</div>					

	</div>
	
	
	
	
	<div id="Prot">
		<div style="margin-left:110px; margin-right:110px;" class="articleBody clear">
	
			<br><h4 title="Letzte Änderung: <? echo welcheEinstellungLetzteAend(SE_ProtokollAnAus); ?>">Aktivierung Protokoll</h4>
			<p class="iphone-ui" id="iphoneP">
			Es werden wichtige Ereignisse (z.B. Registrierung neuer Nutzer, Sicherheitshinweise, Paßwortänderungen) protokolliert.<br>
			<br><input type="checkbox" name="Mod_ProtOnOff" id="Mod_ProtOnOff" <?
			if (welcheEinstellung("SE_ProtokollAnAus")=="1")
			{
			echo 'checked="checked"';
			}
			?>/></p>

		</div>	
	</div>

	<div id="twitr">
		<div style="margin-left:110px; margin-right:110px;" class="articleBody clear">

			<br><h4 title="Letzte Änderung: <? echo welcheEinstellungLetzteAend(SE_twitterModuleActi); ?>">twitter Funktionalität</h4>
			<p class="iphone-ui" id="iphoneP">
			Aktivieren Sie mit dieser Funktion das twitter Modul. Bei neuen Nutzern, neuen Objekten, neuen Hauptgruppen oder Änderungen
			der Öffnungszeiten wird automatisch ein tweet gesendet. Sie benötigen ein bereits angelegtes twitter Profil und eine <a href="https://dev.twitter.com/apps" target="_blank"><b>twitter app</b></a>.
			<br><input type="checkbox" name="Mod_twitr" id="Mod_twitr" <?
			if (welcheEinstellung("SE_twitterModuleActi")=="1")
			{
			echo 'checked="checked"';
			}
			?>/></p>
			

		
			<?
			if (welcheEinstellung("SE_twitterModuleActi")=="1")
			{
			echo '<div id="twitr_acc">';
			}
			else
			{
			echo '<div id="twitr_acc" class="ui-helper-hidden">';
			}
			?>	
				<br><h4 title="Letzte Änderung: <? echo welcheEinstellungLetzteAend(SE_auth_consumerKey); ?>">Benutzerschlüssel</h4>
				<p class="iphone-ui" id="iphoneP">
				Bitte übertragen Sie diesen Wert nach der twitter - Anwendungseinrichtung.
				<br><input type="input" name="Mod_twitrAu1" id="Mod_twitrAu1" class="input_auswahl2" maxlength="60" <?
				echo 'value=\''.strip_tags(utf8_encode(welcheEinstellung("SE_auth_consumerKey"))).'\'';
				?> />
				<a href="#link" id="txt_twitr_1" class="fg-button ui-state-default ui-corner-all" style="margin-bottom: 10px; float: right;">Ändern</a>
				<br><br><br></p>
				
			
				<br><h4 title="Letzte Änderung: <? echo welcheEinstellungLetzteAend(SE_consumerSecret); ?>">Benutzerkennwort</h4>
				<p class="iphone-ui" id="iphoneP">
				Bitte übertragen Sie diesen Wert nach der twitter - Anwendungseinrichtung.
				<br><input type="input" name="Mod_twitrAu2" id="Mod_twitrAu2" class="input_auswahl2" maxlength="60" <?
				echo 'value=\''.strip_tags(utf8_encode(welcheEinstellung("SE_consumerSecret"))).'\'';
				?> />
				<a href="#link" id="txt_twitr_2" class="fg-button ui-state-default ui-corner-all" style="margin-bottom: 10px; float: right;">Ändern</a>
				<br><br><br></p>			
				
				<br><h4 title="Letzte Änderung: <? echo welcheEinstellungLetzteAend(SE_oAuthToken); ?>">Access Token (oauth_token)</h4>
				<p class="iphone-ui" id="iphoneP">
				Bitte übertragen Sie diesen Wert nach der twitter - Anwendungseinrichtung.
				<br><input type="input" name="Mod_twitrAu3" id="Mod_twitrAu3" class="input_auswahl2" maxlength="60" <?
				echo 'value=\''.strip_tags(utf8_encode(welcheEinstellung("SE_oAuthToken"))).'\'';
				?> />
				<a href="#link" id="txt_twitr_3" class="fg-button ui-state-default ui-corner-all" style="margin-bottom: 10px; float: right;">Ändern</a>
				<br><br><br></p>
				
			
				<br><h4 title="Letzte Änderung: <? echo welcheEinstellungLetzteAend(SE_oAuthSecret); ?>">Access Token Secret (oauth_token_secret)</h4>
				<p class="iphone-ui" id="iphoneP">
				Bitte übertragen Sie diesen Wert nach der twitter - Anwendungseinrichtung.
				<br><input type="input" name="Mod_twitrAu4" id="Mod_twitrAu4" class="input_auswahl2" maxlength="60" <?
				echo 'value=\''.strip_tags(utf8_encode(welcheEinstellung("SE_oAuthSecret"))).'\'';
				?> />
				<a href="#link" id="txt_twitr_4" class="fg-button ui-state-default ui-corner-all" style="margin-bottom: 10px; float: right;">Ändern</a>
				<br><br><br></p>			

				
			
			
				<br><h4>Speicherung der o.g. Daten zulassen</h4>
				Bestätigen Sie die oberen Daten um twitter zum lesen und schreiben zu verwenden.
				<br><a href="#link" id="test_twitr" class="fg-button ui-state-default ui-corner-all" style="margin-bottom: 10px; float: right;">Übernehmen</a>
				<div id="twitrtestArea"></div>
			</div>
		</div>	
	</div>
	
	
	<div id="AdStat">
		<div style="margin-left:110px; margin-right:110px;" class="articleBody clear">
	
			<br><h4 title="Letzte Änderung: <? echo welcheEinstellungLetzteAend(SE_cronJob); ?>">Erweiterte Statistik</h4>
			<p class="iphone-ui" id="iphoneP">
			Wenn Sie diese Funktion einschalten, müssen Sie einen <a href="http://de.wikipedia.org/wiki/Cron" target="_blank"><b>Cron Job</b></a> einrichten.<br>
			<br><input type="checkbox" name="Mod_AdStatOnOff" id="Mod_AdStatOnOff" <?
			if (welcheEinstellung("SE_cronJob")=="1")
			{
			echo 'checked="checked"';
			}
			?>/>
			<br><br>Die Datei zu dem Aufruf (Empfehlung: täglich, 1 Uhr Morgens) lautet:<br>
			<b><? echo $_SESSION["SE_festUrl"]; ?>_99_cron_kd7653hg.php?djnm_u4lHZ975yz8=sSZmn_n9s</b></p>

		</div>	
	</div>	
	

	
	
</div>
</div>

	</article>	
	<?
	}
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
</section>	        
<!-- JavaScript Includes -->
<?
echo nl2br($_SESSION["SE_jQuerUI"]);
?>
<script type="text/javascript" src="../../BL_JS/jquery.ezmark.min.js"></script>
<script type="text/javascript" src="../../BL_JS/jquery.numeric.js"></script>


<?
if (isset($_SESSION["User_ID"]) && $_SESSION["User_Recht_Admin"]=="1")
{
	?>
	<script>

$(function() {

		$( "#sRgMo1" ).slider({
			range: true,
			min: 0,
			max: 24,
			values: [ <? echo welcheEinstellung(SE_MoOffen11); ?> , <? echo welcheEinstellung(SE_MoOffen12); ?> ],
			slide: function( event, ui ) {
				$( "#valMo1" ).val(ui.values[ 0 ] + "-"+ ui.values[ 1 ] +" Uhr");
			}
		});
		$( "#valMo1" ).val( $( "#sRgMo1" ).slider( "values", 0 ) +"-"+
			$( "#sRgMo1" ).slider( "values", 1 )+" Uhr" );


		$( "#sRgMo2" ).slider({
			range: true,
			min: 0,
			max: 24,
			values: [ <? if (welcheEinstellung(SE_MoOffen21)=="-")
			{
			echo "0";
			}
			else
			{
			echo welcheEinstellung(SE_MoOffen21);
			}; ?>, <? if (welcheEinstellung(SE_MoOffen22)=="-")
			{
			echo "0";
			}
			else
			{
			echo welcheEinstellung(SE_MoOffen22);
			}; ?> ],
			slide: function( event, ui ) {
				$( "#valMo2" ).val(ui.values[ 0 ] + "-"+ ui.values[ 1 ] +" Uhr");
			}
		});
		$( "#valMo2" ).val( $( "#sRgMo2" ).slider( "values", 0 ) +"-"+
			$( "#sRgMo2" ).slider( "values", 1 )+" Uhr" );


		$( "#sRgDi1" ).slider({
			range: true,
			min: 0,
			max: 24,
			values: [ <? echo welcheEinstellung(SE_DiOffen11); ?> , <? echo welcheEinstellung(SE_DiOffen12); ?> ],
			slide: function( event, ui ) {
				$( "#valDi1" ).val(ui.values[ 0 ] + "-"+ ui.values[ 1 ] +" Uhr");
			}
		});
		$( "#valDi1" ).val( $( "#sRgDi1" ).slider( "values", 0 ) +"-"+
			$( "#sRgDi1" ).slider( "values", 1 )+" Uhr" );


		$( "#sRgDi2" ).slider({
			range: true,
			min: 0,
			max: 24,
			values: [ <? if (welcheEinstellung(SE_DiOffen21)=="-")
			{
			echo "0";
			}
			else
			{
			echo welcheEinstellung(SE_DiOffen21);
			}; ?>, <? if (welcheEinstellung(SE_DiOffen22)=="-")
			{
			echo "0";
			}
			else
			{
			echo welcheEinstellung(SE_DiOffen22);
			}; ?> ],
			slide: function( event, ui ) {
				$( "#valDi2" ).val(ui.values[ 0 ] + "-"+ ui.values[ 1 ] +" Uhr");
			}
		});
		$( "#valDi2" ).val( $( "#sRgDi2" ).slider( "values", 0 ) +"-"+
			$( "#sRgDi2" ).slider( "values", 1 )+" Uhr" );


		$( "#sRgMi1" ).slider({
			range: true,
			min: 0,
			max: 24,
			values: [ <? echo welcheEinstellung(SE_MiOffen11); ?> , <? echo welcheEinstellung(SE_MiOffen12); ?> ],
			slide: function( event, ui ) {
				$( "#valMi1" ).val(ui.values[ 0 ] + "-"+ ui.values[ 1 ] +" Uhr");
			}
		});
		$( "#valMi1" ).val( $( "#sRgMi1" ).slider( "values", 0 ) +"-"+
			$( "#sRgMi1" ).slider( "values", 1 )+" Uhr" );


		$( "#sRgMi2" ).slider({
			range: true,
			min: 0,
			max: 24,
			values: [ <? if (welcheEinstellung(SE_MiOffen21)=="-")
			{
			echo "0";
			}
			else
			{
			echo welcheEinstellung(SE_MiOffen21);
			}; ?>, <? if (welcheEinstellung(SE_MiOffen22)=="-")
			{
			echo "0";
			}
			else
			{
			echo welcheEinstellung(SE_MiOffen22);
			}; ?> ],
			slide: function( event, ui ) {
				$( "#valMi2" ).val(ui.values[ 0 ] + "-"+ ui.values[ 1 ] +" Uhr");
			}
		});
		$( "#valMi2" ).val( $( "#sRgMi2" ).slider( "values", 0 ) +"-"+
			$( "#sRgMi2" ).slider( "values", 1 )+" Uhr" );
			

		$( "#sRgDo1" ).slider({
			range: true,
			min: 0,
			max: 24,
			values: [ <? echo welcheEinstellung(SE_DoOffen11); ?> , <? echo welcheEinstellung(SE_DoOffen12); ?> ],
			slide: function( event, ui ) {
				$( "#valDo1" ).val(ui.values[ 0 ] + "-"+ ui.values[ 1 ] +" Uhr");
			}
		});
		$( "#valDo1" ).val( $( "#sRgDo1" ).slider( "values", 0 ) +"-"+
			$( "#sRgDo1" ).slider( "values", 1 )+" Uhr" );


		$( "#sRgDo2" ).slider({
			range: true,
			min: 0,
			max: 24,
			values: [ <? if (welcheEinstellung(SE_DoOffen21)=="-")
			{
			echo "0";
			}
			else
			{
			echo welcheEinstellung(SE_DoOffen21);
			}; ?>, <? if (welcheEinstellung(SE_DoOffen22)=="-")
			{
			echo "0";
			}
			else
			{
			echo welcheEinstellung(SE_DoOffen22);
			}; ?> ],
			slide: function( event, ui ) {
				$( "#valDo2" ).val(ui.values[ 0 ] + "-"+ ui.values[ 1 ] +" Uhr");
			}
		});
		$( "#valDo2" ).val( $( "#sRgDo2" ).slider( "values", 0 ) +"-"+
			$( "#sRgDo2" ).slider( "values", 1 )+" Uhr" );
			
			
		$( "#sRgFr1" ).slider({
			range: true,
			min: 0,
			max: 24,
			values: [ <? echo welcheEinstellung(SE_FrOffen11); ?> , <? echo welcheEinstellung(SE_FrOffen12); ?> ],
			slide: function( event, ui ) {
				$( "#valFr1" ).val(ui.values[ 0 ] + "-"+ ui.values[ 1 ] +" Uhr");
			}
		});
		$( "#valFr1" ).val( $( "#sRgFr1" ).slider( "values", 0 ) +"-"+
			$( "#sRgFr1" ).slider( "values", 1 )+" Uhr" );


		$( "#sRgFr2" ).slider({
			range: true,
			min: 0,
			max: 24,
			values: [ <? if (welcheEinstellung(SE_FrOffen21)=="-")
			{
			echo "0";
			}
			else
			{
			echo welcheEinstellung(SE_FrOffen21);
			}; ?>, <? if (welcheEinstellung(SE_FrOffen22)=="-")
			{
			echo "0";
			}
			else
			{
			echo welcheEinstellung(SE_FrOffen22);
			}; ?> ],
			slide: function( event, ui ) {
				$( "#valFr2" ).val(ui.values[ 0 ] + "-"+ ui.values[ 1 ] +" Uhr");
			}
		});
		$( "#valFr2" ).val( $( "#sRgFr2" ).slider( "values", 0 ) +"-"+
			$( "#sRgFr2" ).slider( "values", 1 )+" Uhr" );
			
			
		$( "#sRgSa1" ).slider({
			range: true,
			min: 0,
			max: 24,
			values: [ <? echo welcheEinstellung(SE_SaOffen11); ?> , <? echo welcheEinstellung(SE_SaOffen12); ?> ],
			slide: function( event, ui ) {
				$( "#valSa1" ).val(ui.values[ 0 ] + "-"+ ui.values[ 1 ] +" Uhr");
			}
		});
		$( "#valSa1" ).val( $( "#sRgSa1" ).slider( "values", 0 ) +"-"+
			$( "#sRgSa1" ).slider( "values", 1 )+" Uhr" );


		$( "#sRgSa2" ).slider({
			range: true,
			min: 0,
			max: 24,
			values: [ <? if (welcheEinstellung(SE_SaOffen21)=="-")
			{
			echo "0";
			}
			else
			{
			echo welcheEinstellung(SE_SaOffen21);
			}; ?>, <? if (welcheEinstellung(SE_SaOffen22)=="-")
			{
			echo "0";
			}
			else
			{
			echo welcheEinstellung(SE_SaOffen22);
			}; ?> ],
			slide: function( event, ui ) {
				$( "#valSa2" ).val(ui.values[ 0 ] + "-"+ ui.values[ 1 ] +" Uhr");
			}
		});
		$( "#valSa2" ).val( $( "#sRgSa2" ).slider( "values", 0 ) +"-"+
			$( "#sRgSa2" ).slider( "values", 1 )+" Uhr" );
						
		
			
		$( "#sRgSo1" ).slider({
			range: true,
			min: 0,
			max: 24,
			values: [ <? echo welcheEinstellung(SE_SoOffen11); ?> , <? echo welcheEinstellung(SE_SoOffen12); ?> ],
			slide: function( event, ui ) {
				$( "#valSo1" ).val(ui.values[ 0 ] + "-"+ ui.values[ 1 ] +" Uhr");
			}
		});
		$( "#valSo1" ).val( $( "#sRgSo1" ).slider( "values", 0 ) +"-"+
			$( "#sRgSo1" ).slider( "values", 1 )+" Uhr" );


		$( "#sRgSo2" ).slider({
			range: true,
			min: 0,
			max: 24,
			values: [ <? if (welcheEinstellung(SE_SoOffen21)=="-")
			{
			echo "0";
			}
			else
			{
			echo welcheEinstellung(SE_SoOffen21);
			}; ?>, <? if (welcheEinstellung(SE_SoOffen22)=="-")
			{
			echo "0";
			}
			else
			{
			echo welcheEinstellung(SE_SoOffen22);
			}; ?> ],
			slide: function( event, ui ) {
				$( "#valSo2" ).val(ui.values[ 0 ] + "-"+ ui.values[ 1 ] +" Uhr");
			}
		});
		$( "#valSo2" ).val( $( "#sRgSo2" ).slider( "values", 0 ) +"-"+
			$( "#sRgSo2" ).slider( "values", 1 )+" Uhr" );
						
//minuten			
	$(function() {
		$( "#visminSteps" ).slider({
			value:<? echo 60/(welcheEinstellung(SE_IntervStunde)); ?>,
			min: 5,
			max: 60,
			step: 5,
			slide: function( event, ui ) {
				$( "#minSteps" ).val(ui.value + " Minuten");
			}
		});
		$( "#minSteps" ).val( $( "#visminSteps" ).slider( "value" ) + " Minuten");
	});





			
<?
if (welcheEinstellung("SE_MoGeschlOderZeite")=="0")
{
?>
$("#geschl_mo24").closest("td").next().addClass("ui-state-disabled").next().addClass("ui-state-disabled");
$("#sRgMo1, #sRgMo2").slider({ disabled: true });
$("#sRgMo1, #sRgMo2").slider({ enabled: false });

<?
}
?>	

<?
if (welcheEinstellung("SE_DiGeschlOderZeite")=="0")
{
?>
$("#geschl_di24").closest("td").next().addClass("ui-state-disabled").next().addClass("ui-state-disabled");
$("#sRgDi1, #sRgDi2").slider({ disabled: true });
$("#sRgDi1, #sRgDi2").slider({ enabled: false });

<?
}
?>	

<?
if (welcheEinstellung("SE_MiGeschlOderZeite")=="0")
{
?>
$("#geschl_mi24").closest("td").next().addClass("ui-state-disabled").next().addClass("ui-state-disabled");
$("#sRgMi1, #sRgMi2").slider({ disabled: true });
$("#sRgMi1, #sRgMi2").slider({ enabled: false });

<?
}
?>	

<?
if (welcheEinstellung("SE_DoGeschlOderZeite")=="0")
{
?>
$("#geschl_do24").closest("td").next().addClass("ui-state-disabled").next().addClass("ui-state-disabled");
$("#sRgDo1, #sRgDo2").slider({ disabled: true });
$("#sRgDo1, #sRgDo2").slider({ enabled: false });

<?
}
?>	

<?
if (welcheEinstellung("SE_FrGeschlOderZeite")=="0")
{
?>
$("#geschl_fr24").closest("td").next().addClass("ui-state-disabled").next().addClass("ui-state-disabled");
$("#sRgFr1, #sRgFr2").slider({ disabled: true });
$("#sRgFr1, #sRgFr2").slider({ enabled: false });

<?
}
?>	

<?
if (welcheEinstellung("SE_SaGeschlOderZeite")=="0")
{
?>
$("#geschl_sa24").closest("td").next().addClass("ui-state-disabled").next().addClass("ui-state-disabled");
$("#sRgSa1, #sRgSa2").slider({ disabled: true });
$("#sRgSa1, #sRgSa2").slider({ enabled: false });

<?
}
?>	


<?
if (welcheEinstellung("SE_SoGeschlOderZeite")=="0")
{
?>
$("#geschl_so24").closest("td").next().addClass("ui-state-disabled").next().addClass("ui-state-disabled");
$("#sRgSo1, #sRgSo2").slider({ disabled: true });
$("#sRgSo1, #sRgSo2").slider({ enabled: false });
<?
}
?>	


	$('#iphoneP input').ezMark({checkboxCls:'ez-checkbox-iphone', checkedCls: 'ez-checked-iphone'});
	
	$("#Mod_FutAdvUsr").numeric();
	$("#Mod_FutStdUsr").numeric();
	$("#Mod_MaxDaysStdUsr").numeric();
	$("#Mod_MaxDaysAdvUsr").numeric();
	$("#Mod_ElemWK").numeric();
	$("#Mod_MaxTagsA").numeric();

	//tabs
	$( "#tabsAdmin" ).tabs();

	//klick für zugangsnummer
    $("#Mod_access").click(function () {
      $("#zugangsnumm").slideToggle("slow");
    });
	
	//klick für textRegistrierung
    $("#Mod_Vortext").click(function () {
      $("#textCont").slideToggle("slow");
    });	
	
	//klick für twitter
    $("#Mod_twitr").click(function () {
      $("#twitr_acc").slideToggle("slow");
    });	
	
	//klick für monModul-Mietpreise
    $("#Mod_Money").click(function () {
      $("#monModMP").slideToggle("slow");
    });	
	
	//klick für übersetzung
    $("#Mod_UebersGoo").click(function () {
      $("#gTr").slideToggle("slow");
    });	

	//klick für versand
    $("#Mod_Versand").click(function () {
      $("#versandeinstell").slideToggle("slow");
    });	

	//klick für tag module
    $("#Mod_lendMod3").click(function () {
      $("#ModtagsDiv").slideToggle("slow");
    });	

	//checkboxen
    $("input:checkbox").click(function () {
	$("#output").load("01_att.inc.php?h="+$(this).attr("name"));
    });	
	
	$("#txt_bezChec").click(function(event) {
	$("#output").load("01_att.inc.php?t="+$(this).val("id")+"|"+encodeURI($("#Mod_access2").val()));
	});	

	$("#txt_vortxt").click(function(event) {
		$.ajax({
		type: "POST",
		url: "01_att.inc.php",
		data: "t="+$(this).attr("id")+"|"+encodeURI($("#Mod_VortextCont").val()),
		success: function(data) {
		$('#output').html(data);
		}
		});
	});
	
	$("#txt_MailNachReg").click(function(event) {
		$.ajax({
		type: "POST",
		url: "01_att.inc.php",
		data: "t="+$(this).attr("id")+"|"+encodeURI($("#Mod_MailNachReg").val()),
		success: function(data) {
		$('#output').html(data);
		}
		});
	});
		
	$("#txt_imprint").click(function(event) {
		$.ajax({
		type: "POST",
		url: "01_att.inc.php",
		data: "t="+$(this).attr("id")+"|"+encodeURI($("#Mod_imprint").val()),
		success: function(data) {
		$('#output').html(data);
		}
		});
	});
			
	$("#txt_gooTrCod").click(function(event) {
		$.ajax({
		type: "POST",
		url: "01_att.inc.php",
		data: "t="+$(this).attr("id")+"|"+encodeURI($("#Mod_UebersGoo2").val()),
		success: function(data) {
		$('#output').html(data);
		}
		});
	});	

	$("#txt_regOrgaNam").click(function(event) {
	$("#output").load("01_att.inc.php?t="+$(this).attr("id")+"|"+encodeURI($("#Mod_regOrga").val()));
	});	

	$("#txt_OeffnNote_MO").click(function(event) {
	$("#output").load("01_att.inc.php?t="+$(this).attr("id")+"|"+encodeURI($("#Mod_OeffnNote_MO").val()));
	});		
	
	$("#txt_OeffnNote_DI").click(function(event) {
	$("#output").load("01_att.inc.php?t="+$(this).attr("id")+"|"+encodeURI($("#Mod_OeffnNote_DI").val()));
	});		
	
	$("#txt_OeffnNote_MI").click(function(event) {
	$("#output").load("01_att.inc.php?t="+$(this).attr("id")+"|"+encodeURI($("#Mod_OeffnNote_MI").val()));
	});		
	
	$("#txt_OeffnNote_DO").click(function(event) {
	$("#output").load("01_att.inc.php?t="+$(this).attr("id")+"|"+encodeURI($("#Mod_OeffnNote_DO").val()));
	});		
	
	$("#txt_OeffnNote_FR").click(function(event) {
	$("#output").load("01_att.inc.php?t="+$(this).attr("id")+"|"+encodeURI($("#Mod_OeffnNote_FR").val()));
	});		
	
	
	$("#txt_OeffnNote_SA").click(function(event) {
	$("#output").load("01_att.inc.php?t="+$(this).attr("id")+"|"+encodeURI($("#Mod_OeffnNote_SA").val()));
	});		
	
	$("#txt_OeffnNote_SO").click(function(event) {
	$("#output").load("01_att.inc.php?t="+$(this).attr("id")+"|"+encodeURI($("#Mod_OeffnNote_SO").val()));
	});		
	
	$("#txt_regMail").click(function(event) {
	$("#output").load("01_att.inc.php?t="+$(this).attr("id")+"|"+encodeURI($("#Mod_regMail").val()));
	});	
	
	$("#txt_reCap1").click(function(event) {
	$("#output").load("01_att.inc.php?t="+$(this).attr("id")+"|"+encodeURI($("#Mod_reCap1").val()));
	});	
	
	$("#txt_reCap2").click(function(event) {
	$("#output").load("01_att.inc.php?t="+$(this).attr("id")+"|"+encodeURI($("#Mod_reCap2").val()));
	});
	
	$("#txt_FutStdUsr").click(function(event) {
	$("#output").load("01_att.inc.php?t="+$(this).attr("id")+"|"+encodeURI($("#Mod_FutStdUsr").val()));
	});	
	
	$("#txt_FutAdvUsr").click(function(event) {
	$("#output").load("01_att.inc.php?t="+$(this).attr("id")+"|"+encodeURI($("#Mod_FutAdvUsr").val()));
	});		
	
	$("#txt_MaxDaysStdUsr").click(function(event) {
	$("#output").load("01_att.inc.php?t="+$(this).attr("id")+"|"+encodeURI($("#Mod_MaxDaysStdUsr").val()));
	});	
	
	$("#txt_MaxDaysAdvUsr").click(function(event) {
	$("#output").load("01_att.inc.php?t="+$(this).attr("id")+"|"+encodeURI($("#Mod_MaxDaysAdvUsr").val()));
	});	
	
	$("#txt_ElemWK").click(function(event) {
	$("#output").load("01_att.inc.php?t="+$(this).attr("id")+"|"+encodeURI($("#Mod_ElemWK").val()));
	});	

	$("#minMinChg").click(function(event) {
	$("#output").load("01_att.inc.php?t="+$(this).attr("id")+"|"+encodeURI($("#minSteps").val()));
	});	
	
	$("#txt_AutoUserDel").click(function(event) {
	$("#output").load("01_att.inc.php?t="+$(this).attr("id")+"|"+encodeURI($("#Mod_AutoUserDel").val()));
	});	

	$("#txt_AutoWKDel").click(function(event) {
	$("#output").load("01_att.inc.php?t="+$(this).attr("id")+"|"+encodeURI($("#Mod_AutoWKDel").val()));
	});		
	
	$("#txt_ZeiRes").click(function(event) {
	$("#output").load("01_att.inc.php?t="+$(this).attr("id")+"|"+encodeURI($("#Mod_ZeiRes").val()));
	});	

	$("#txt_twitr_1").click(function(event) {
	$("#output").load("01_att.inc.php?t="+$(this).attr("id")+"|"+encodeURI($("#Mod_twitrAu1").val()));
	});	

	$("#txt_twitr_2").click(function(event) {
	$("#output").load("01_att.inc.php?t="+$(this).attr("id")+"|"+encodeURI($("#Mod_twitrAu2").val()));
	});	

	$("#txt_twitr_3").click(function(event) {
	$("#output").load("01_att.inc.php?t="+$(this).attr("id")+"|"+encodeURI($("#Mod_twitrAu3").val()));
	});	

	$("#txt_twitr_4").click(function(event) {
	$("#output").load("01_att.inc.php?t="+$(this).attr("id")+"|"+encodeURI($("#Mod_twitrAu4").val()));
	});	
	
	$("#txt_Maxtags").click(function(event) {
	$("#output").load("01_att.inc.php?t="+$(this).attr("id")+"|"+encodeURI($("#Mod_MaxTagsA").val()));
	});	

	
	

	$("#test_twitr").click(function(event) {
	$("#twitrtestArea").load("02_twtr.inc.php?u=fjm_zQw");
	});	
	 
	$("#clockChg").click(function(event) {
	
	var Mo1=$("#valMo1").val().split(" ");
	var Mo2=$("#valMo2").val().split(" ");
	
	var Di1=$("#valDi1").val().split(" ");
	var Di2=$("#valDi2").val().split(" ");
	
	var Mi1=$("#valMi1").val().split(" ");
	var Mi2=$("#valMi2").val().split(" ");
	
	var Do1=$("#valDo1").val().split(" ");
	var Do2=$("#valDo2").val().split(" ");
	
	var Fr1=$("#valFr1").val().split(" ");
	var Fr2=$("#valFr2").val().split(" ");
	
	var Sa1=$("#valSa1").val().split(" ");
	var Sa2=$("#valSa2").val().split(" ");
	
	var So1=$("#valSo1").val().split(" ");
	var So2=$("#valSo2").val().split(" ");

	$("#output").load("01_att.inc.php?u="+Mo1[0]+"|"+Mo2[0]+"|"+Di1[0]+"|"+Di2[0]+"|"+Mi1[0]+"|"+Mi2[0]+"|"+Do1[0]+"|"+Do2[0]+"|"+Fr1[0]+"|"+Fr2[0]+"|"+Sa1[0]+"|"+Sa2[0]+"|"+So1[0]+"|"+So2[0]);
	});	

	$("#txt_VersandUrl").click(function(event) {
	$("#output").load("01_att.inc.php?t="+$(this).attr("id")+"|"+encodeURI($("#Mod_VersandURL").val()));
	});	

	$("#txt_VersandPreis").click(function(event) {
	$("#output").load("01_att.inc.php?t="+$(this).attr("id")+"|"+encodeURI($("#Mod_VersandPrice").val()));
	});



	
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
</script>
<?
echo utf8_encode($_SESSION["SE_EndeIndex"]);
?>

<br><br><br><br><br><br>
</body>
</html>