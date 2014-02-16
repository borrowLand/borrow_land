<?php
session_start();
/*
CHECK_ALL_LOAD_01	Check konnte nicht eingelesen werden
FU_ALL_LOAD_01		Funktionen konnten nicht eingelesen werden
FOOTER_FU_LOAD		Footer konnte nicht geladen werden
DB_FU_LOAD_01		Die DB Datei konnte nicht geladen werden
SESS_FU_LOAD_01		Die Sessions konnten nicht eingelesen werden

SERV_ERR_01			Standard Wert in der PHP.INI des Servers von display_errors ist auf 1 -> es werden alle Fehler angezeigt.
SERV_ERR_02			Standard Wert get_magic_quotes_gpc ist ein -> auf 0 in der php.ini
SERV_ERR_03			Session wird vom Server an URLS gehängt, Sicherheitsrisiko

ERR_REG_INPUT_01	Im reg Verzeichnis konnte das Include File für die Eingabefelder nicht geladen werden.
ERR_REG_INPUT_02	Im reg Verzeichnis konnte das Include File für die jquery Hilfe nicht geladen werden.

DB_ERR_01			Die DB Verbindung konnte nicht aufgebaut werden
DB_ERR_02			Die DB  konnte nicht geladen werden
*/



//wenn noch keine sessions initiert sind, dann pnotify 
if(isset($_SESSION["SE_GooTrans"]))
{
$startmeldung=0;
}
else
{
$startmeldung=1;
}


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

//Sessions
/////////////////////////////////////////////
$includeName="_01_basic_sess.inc.php";
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
<!DOCTYPE html> 
<html>
<head>
<?
echo eval(welcheEinstellung("SE_headBereich"));
?>
</head>

<body>
    
<NOSCRIPT>
<br><br><br><br><div class="meldung_fehler"><img src="BL_BILDER/Meldungen_Warning.png">Diese Webseite läuft leider nur, wenn Sie <a href="http://de.wikipedia.org/wiki/Javascript" target="_blank">Javascript</a> zulassen. <br>Bitte aktivieren Sie diesen technischen Standard in Ihrem Browser, Danke!</div>
<br><br>
</NOSCRIPT>	
		
<section id="page"> <!-- #page anfang -->

<header>
<?
//#############Anfang Überschrift
?>
<hgroup><h1><a href="index.php" title="Startseite"><img src="BL_BILDER/start_00.png"></a> <a href="index.php" title="Startseite">borrow land</a></h1>
<?
$oeffentlich=0;
if ($oeffentlich=="1")
{
    ?>
    <div id="ueberschr_all">/Leihe</div>
    </hgroup>
    <?
}
else
{
    if (isset($_SESSION["User_ID"]) && $_SESSION["User_ID"]!="")
    {	
    ?>
    <div id="ueberschr_all">/Leihe</div>
    </hgroup>
    <?
    }
}
//#############Ende Überschrift


	//navigation
	/////////////////////////////////////////////
	$includeName="_00_basic_nav.inc.php";
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
	
//Ausleihe-Modul wenn Eingeloggt.
if (isset($_SESSION["User_ID"]))
{
	/////////////////////////////////////////////
	$includeName="_03_startLogin.inc.php";
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
}

//Startseite mit Login & Registrierungslinks wenn nicht eingeloggt
else
{
	
	/////////////////////////////////////////////
	$includeName="_02_startNoLogin.inc.php";
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
}

?>
    </section>

<?
//google translate teil
if ($_SESSION["SE_GooTrans"]=="1")
{
// Start Google Translate -->
echo $_SESSION["SE_GooTransScript"];
// Ende Google Translate -->
}
//ende google translate teil
?>		
			
<?
//Footer 
/////////////////////////////////////////////
$includeName="_00_basic_footer.php";
if (file_exists($includeName))
{
include_once($includeName);
}	
else
{
echo '<br><br><div class="meldung_fehler"><img src="BL_BILDER/Meldungen_Warning.png"> <br>FOOTER_FU_LOAD</div><br><br>';	
exit();
}
/////////////////////////////////////////////			
?>  
 
       
<!-- #page ende -->
        
<!-- JavaScript Includes -->


<?
echo nl2br($_SESSION["SE_jQuerUI"]);

if (($_SESSION["SE_ViewLeihmodHauptg"]=="1" || $_SESSION["SE_ViewLeihmodEinzel"]=="1" || $_SESSION["SE_ViewLeihmodTag"]=="1") && ($_SESSION["User_Dat_RegBestaet"]!="0" && $_SESSION["User_Recht_Ausleihe"]=="1" && isset($_SESSION["User_ID"])))
{
echo '<script type="text/javascript" src="BL_JS/imgpreview.min.0.22.jquery.js"></script>';
}


if (welcheEinstellung("SE_cronJob")=="0")
{
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

if ($_SESSION["User_Dat_RegBestaet"]!="0" && $_SESSION["User_Recht_Ausleihe"]=="1")
{
?>
<script>
<?


	
	//wieviele tage kann ein user buchen?
	if ($_SESSION["User_Recht_Dauerleih"]=="1")
	{
	$ausleihtageVoraus=$_SESSION["SE_DauerleiheMaxStar"];
	}
	else
	{
	$ausleihtageVoraus=$_SESSION["SE_normaloMaxStartTa"];
	}

	//berechnung der nächsten deaktivierten wochentage
	//grundlage: $ausleihtageVoraus
			
$datumJetzt=date("U", mktime(12, 0, 0, date("n"), date("j"), date("Y")));

	//anfang berechnung und anzeige der zu deaktivierenden tage
	for ($i=1;$i<($ausleihtageVoraus+10);$i++)
		{
		
		$wochentag=getdate($datumJetzt);

			//wenn wochentag zu, dann wird dies im kalender markiert
			if ($_SESSION["SE_MoGeschlOderZeite"]=="0" && $wochentag[wday]=="1")
			{
			$GeschlossMariert[].=$datumJetzt;
			}

			if ($_SESSION["SE_DiGeschlOderZeite"]=="0" && $wochentag[wday]=="2")
			{
			$GeschlossMariert[].=$datumJetzt;
			}

			if ($_SESSION["SE_MiGeschlOderZeite"]=="0" && $wochentag[wday]=="3")
			{
			$GeschlossMariert[].=$datumJetzt;
			}

			if ($_SESSION["SE_DoGeschlOderZeite"]=="0" && $wochentag[wday]=="4")
			{
			$GeschlossMariert[].=$datumJetzt;
			}

			if ($_SESSION["SE_FrGeschlOderZeite"]=="0" && $wochentag[wday]=="5")
			{
			$GeschlossMariert[].=$datumJetzt;
			}

			if ($_SESSION["SE_SaGeschlOderZeite"]=="0" && $wochentag[wday]=="6")
			{
			$GeschlossMariert[].=$datumJetzt;
			}

			if ($_SESSION["SE_SoGeschlOderZeite"]=="0" && $wochentag[wday]=="0")
			{
			$GeschlossMariert[].=$datumJetzt;
			}
		
		//$jetzt->add(new DateInterval('P1D'));
		$datumJetzt=$datumJetzt+86400;
		}

		if (count($GeschlossMariert)>0)
		{
		echo 'var bookedDays = [';
			for ($i=0;$i<count($GeschlossMariert);$i++)
			{
				$date = DateTime::createFromFormat('U', $GeschlossMariert[$i]);
				echo '"'.$date->format('Y-n-j').'"';
				if (($i+1)==count($GeschlossMariert))
				{
				}
				else
				{
				echo ",";
				}
			}
		echo '];';

		}
else
{
echo "var bookedDays = [];";
}
?>
function isAvailable(date){
var dateAsString = date.getFullYear().toString() + "-" + (date.getMonth()+1).toString() + "-" + date.getDate();
var result = $.inArray( dateAsString, bookedDays ) ==-1 ? [true] : [false];
return result
}

$.datepicker.regional['de'] = {
	closeText: 'Fertig',
	prevText: '< vor',
	nextText: 'zurück >',
	currentText: 'Heute',
	monthNames: ['Januar','Februar','März','April','Mai','Juni','Juli','August','September','Oktober','November','Dezember'],
	monthNamesShort: ['Jan','Feb','Mär','Apr','Mai','Jun','Jul','Aug','Sep','Okt','Nov','Dez'],
	dayNames: ['Sonntag','Montag','Dientag','Mittwoch','Donnerstag','Freitag','Sonnabend'],
	dayNamesShort: ['Son','Mon','Die','Mit','Don','Fre','Sam'],
	dayNamesMin: ['So','Mo','Di','Mi','Do','Fr','Sa'],
	dateFormat: 'dd.mm.yy',
	firstDay: 1,
	isRTL: false,
	showMonthAfterYear: false,
	yearSuffix: ''
};

$.datepicker.setDefaults($.datepicker.regional['de']);

$(function() {
	var dates = $( "#ZeitObjAbholen" ).datepicker({
		showButtonPanel: true,
		changeMonth: true,
		minDate: 0,
		maxDate: +<?echo $ausleihtageVoraus; ?>,
		numberOfMonths: 2,
		onClose: function(dateText, inst) { contentloader($('#ZeitObjAbholen').val()) },
		beforeShowDay: isAvailable

	});
});

$(function() {
	var dates = $("#datumsObjAbgabe" ).datepicker({
		showButtonPanel: true,
		changeMonth: true,
		minDate: 0,
		maxDate: +<?echo $ausleihtageVoraus; ?>,
		numberOfMonths: 2,
		onClose: function(dateText, inst) { contentloader2($('#datumsObjAbgabe').val())},
		beforeShowDay: isAvailable
	});
});

function contentloader(datumOr) {
$('#zeitStart').val("-");
$("#cku7Vap").load("_05_oeffnungszeiten.inc.php?id="+datumOr+"");
objCheck();
}

function contentloader2(datumOr) {
$('#zeitEnde').val("-");				
$("#vls7Hr").load("_05_oeffnungszeiten2.inc.php?id2="+datumOr+"");
objCheck();
}

$('#cku7Vap').change(function() {
objCheck();
});

$('#vls7Hr').change(function() {
objCheck();
});

		
function objCheck()
{
$("#loadingAj").load("_06_objekteSuche-0.inc.php?oz1="+$('#ZeitObjAbholen').val()+"&oz2="+$('#zeitStart').val()+"&oz3="+$('#datumsObjAbgabe').val()+"&oz4="+$('#zeitEnde').val());
};
</script>
<?
}
//darstellung der tabs nur wenn der user leihe-berechtigt und sih eingeloggt hat
if (($_SESSION["SE_ViewLeihmodHauptg"]=="1" || $_SESSION["SE_ViewLeihmodEinzel"]=="1" || $_SESSION["SE_ViewLeihmodTag"]=="1") && ($_SESSION["User_Dat_RegBestaet"]!="0" && $_SESSION["User_Recht_Ausleihe"]=="1" && isset($_SESSION["User_ID"])))
{	
?>
<script>
$(function() {
$( "#tabs" ).tabs();
});
</script>
<?
}
//ende tabs
?>
<script>

<?
if($startmeldung=="1")
{
?>
$("#article3").delay(2000).slideToggle("slow");
<?
}
  
?>


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