<?
//System 
/////////////////////////////////////////////
$includeName="_00_basic_check.inc.php";
if (file_exists($includeName))
{
require($includeName);
}	
else
{
echo '<br><br><div class="meldung_fehler"><img src="BL_BILDER/Meldungen_Warning.png"> <br>CHECK_ALL_LOAD_01</div><br><br>';	
exit();
}

/////////////////////////////////////////////

//Funktionen 
/////////////////////////////////////////////
$includeName="_00_basic_func.inc.php";
if (file_exists($includeName))
{
require($includeName);
}	
else
{
echo '<br><br><div class="meldung_fehler"><img src="BL_BILDER/Meldungen_Warning.png"> <br>FU_ALL_LOAD_01</div><br><br>';	
exit();
}

/////////////////////////////////////////////


//Datenbank Verbindung
/////////////////////////////////////////////
$includeName="_01_basic_db.inc.php";
if (file_exists($includeName))
{
require($includeName);
}	
else
{
echo '<br><br><div class="meldung_fehler"><img src="BL_BILDER/Meldungen_Warning.png"> <br>DB_FU_LOAD_01</div><br><br>';	
exit();
}

/////////////////////////////////////////////


//nur wenn get parameter vorgegeben wurde und der cronjob aktiv ist werden statistiken erhoben
if (welcheEinstellung("SE_cronJob")=="1" && $_GET["djnm_u4lHZ975yz8"]=="sSZmn_n9s")
{
//aktiveObjekte
$sql = "SELECT count(*) FROM `04_obj_objekte` WHERE `ObjOnOff` = 1"; 
$datenAbfrage = mysql_query($sql);
$aktiveObjekte = mysql_fetch_row($datenAbfrage);

//ausgegebeneObjekte
$sql = "SELECT count(*) FROM `06_wkObje` WHERE `abgeholt` IS NOT NULL AND `gebracht` IS NULL"; 
$datenAbfrage = mysql_query($sql);
$ausgegebeneObjekte = mysql_fetch_row($datenAbfrage);

//beendteWKs
$sql = "SELECT count(*) FROM `07_wkHistory`"; 
$datenAbfrage = mysql_query($sql);
$beendteWKs = mysql_fetch_row($datenAbfrage);

//aktiveWKs
$sql = "SELECT count(*) FROM `05_wk`"; 
$datenAbfrage = mysql_query($sql);
$aktiveWKs = mysql_fetch_row($datenAbfrage);

//NutzerGesamt
$sql = "SELECT count(*) FROM `01_Benutzer`"; 
$datenAbfrage = mysql_query($sql);
$NutzerGesamt = mysql_fetch_row($datenAbfrage);

//NutzerAusleihe
$sql = "SELECT count(*) FROM `01_Benutzer` WHERE `rechte_ausleihe` = 1"; 
$datenAbfrage = mysql_query($sql);
$NutzerAusleihe = mysql_fetch_row($datenAbfrage);

//NutzerAusgabe
$sql = "SELECT count(*) FROM `01_Benutzer` WHERE `rechte_ausgabeberechtigt` = 1"; 
$datenAbfrage = mysql_query($sql);
$NutzerAusgabe = mysql_fetch_row($datenAbfrage);

//NutzerDL
$sql = "SELECT count(*) FROM `01_Benutzer` WHERE `rechte_dauerleihe` = 1"; 
$datenAbfrage = mysql_query($sql);
$NutzerDL = mysql_fetch_row($datenAbfrage);

//NutzerBestaetig
$sql = "SELECT count(*) FROM `01_Benutzer` WHERE `rechte_bestaetiger` = 1"; 
$datenAbfrage = mysql_query($sql);
$NutzerBestaetig = mysql_fetch_row($datenAbfrage);

//NutzerAdmin
$sql = "SELECT count(*) FROM `01_Benutzer` WHERE `rechte_admin` = 1"; 
$datenAbfrage = mysql_query($sql);
$NutzerAdmin = mysql_fetch_row($datenAbfrage);

//reservierteObjeGesamt
$sql = "SELECT count(*) FROM `06_wkObje` WHERE `abgeholt` IS NULL AND `gebracht` IS NULL"; 
$datenAbfrage = mysql_query($sql);
$reservierteObjeGesamt = mysql_fetch_row($datenAbfrage);

//reservierteObjeBeendet
$sql = "SELECT count(*) FROM `06_wkObje` WHERE `abgeholt` IS NOT NULL AND `gebracht` IS NOT NULL"; 
$datenAbfrage = mysql_query($sql);
$reservierteObjeBeendet = mysql_fetch_row($datenAbfrage);

//deaktiveObjekte
$sql = "SELECT count(*) FROM `04_obj_objekte` WHERE `ObjOnOff` = 0"; 
$datenAbfrage = mysql_query($sql);
$deaktiveObjekte = mysql_fetch_row($datenAbfrage);

//aktiveHG
$sql = "SELECT count(*) FROM `03_obj_hauptgruppen` WHERE `HGruppenOnOff` = 1"; 
$datenAbfrage = mysql_query($sql);
$aktiveHG = mysql_fetch_row($datenAbfrage);

//deaktiveHG
$sql = "SELECT count(*) FROM `03_obj_hauptgruppen` WHERE `HGruppenOnOff` = 0"; 
$datenAbfrage = mysql_query($sql);
$deaktiveHG = mysql_fetch_row($datenAbfrage);

//media verzeichnis, dateigröße in mb
function fetchDirectorySize($dir, $cvs=TRUE) {
    $size=0;
    flush();
    if ( is_array($dir) ) {
        foreach ( $dir AS $directory ) $size+=fetchDirectorySize($directory);
    } else if ( $directory=@opendir($dir) ){
        $items=array();
        while ( $file=readdir($directory) ) {
            if ( $file!="." && $file!=".." && ($cvs || $file!="CVS" ) ) $items[]=$file;
        }
        closedir($directory);
        foreach ( $items AS $item ) {
            if ( is_dir($transfer=$dir.(substr($dir, -1)!="/" ? "/" : "" ).$item) ) $size+=fetchDirectorySize($transfer);
            else $size+=filesize($transfer);
        }
    }
    return $size;
}  
	
$wertMedia=round(fetchDirectorySize(BL_MEDIA)/1024/1024);

//summe aller wiederbeschaffungswerte

$sql = "SELECT SUM(`Wiederbeschaffungswert`) FROM `04_obj_objekte`"; 
$datenAbfrage = mysql_query($sql);
$WertSummeOb = mysql_fetch_row($datenAbfrage);

$sql2 = "INSERT INTO `08_statistik` (`datum`, `aktiveObjekte`, `ausgegebeneObjekte`, `beendteWKs`, `aktiveWKs`,`NutzerGesamt`, `NutzerAusleihe`, `NutzerAusgabe`, `NutzerDL`, `NutzerBestaetig`, `NutzerAdmin`, `reservierteObjeGesamt`, `reservierteObjeBeendet`, `deaktiveObjekte`, `aktiveHG`, `deaktiveHG`, `dateiGrMediaVerz`, `SummeWiederBesc`) VALUES (NOW(), \"".$aktiveObjekte[0]."\", \"".$ausgegebeneObjekte[0]."\", \"".$beendteWKs[0]."\", \"".$aktiveWKs[0]."\", \"".$NutzerGesamt[0]."\", \"".$NutzerAusleihe[0]."\", \"".$NutzerAusgabe[0]."\", \"".$NutzerDL[0]."\", \"".$NutzerBestaetig[0]."\", \"".$NutzerAdmin[0]."\", \"".$reservierteObjeGesamt[0]."\", \"".$reservierteObjeBeendet[0]."\", \"".$deaktiveObjekte[0]."\", \"".$aktiveHG[0]."\", \"".$deaktiveHG[0]."\", \"".$wertMedia."\", \"".$WertSummeOb[0]."\")"; 
$datenEingabe = mysql_query($sql2);

	if (mysql_affected_rows()=="1")
	{
		//anfang protokoll
		if (welcheEinstellung("SE_ProtokollAnAus")==1)
		{
		protokollEintrag("0","1","Die erweiterte Statistik wurde erfolgreich ausgeführt.");
		}
		//ende protokoll
	}

	//Check User Registrierung, Automatische Lösung von Usern, die sich nicht eingeloggt haben nach x tagen
	/////////////////////////////////////////////
	$includeName="_01_basic_registerDrop.inc.php";
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

	//wk's löschen, wenn komplett abgelaufen nach XX tagen
	/////////////////////////////////////////////
	$includeName="_01_basic_WKDrop.inc.php";
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
	
	
	
	
	
	
	
	
	
	
	
	
	
}













			
?>