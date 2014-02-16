<?

session_start();

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
<div id="ueberschr_all"><a href="../../../">/Leihe</a><a href="../../">/Verwaltung</a><a href="../">/Inventar</a>/Hauptgruppe bearbeiten - Übersicht</div>
</hgroup>
<?
}
else
{
	if (isset($_SESSION["User_ID"]) && $_SESSION["User_ID"]!="")
	{	
	?>
<div id="ueberschr_all"><a href="../../../">/Leihe</a><a href="../../">/Verwaltung</a><a href="../">/Inventar</a>/Hauptgruppe bearbeiten - Übersicht</div>
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
	echo '<br><br><div class="meldung_fehler"><img src="../../../BL_BILDER/Meldungen_Warning.png"> <br>SESS_FU_LOAD_01</div><br><br>';	
	exit();
	}
	/////////////////////////////////////////////
?>
			
            </header>
<div id="loadingAj"></div>
<div id="output"></div>
            <section id="articles"> 
			
<?
//anfang voraussetzung: registriert, admin oder ausgabeberechtigter
if (isset($_SESSION["User_ID"]) && $_SESSION["User_Recht_Admin"]=="1")
{
?>

<article id="articleLogin2"> 
<h2>Hauptgruppen Bearbeitung</h2>
	
<div class="line"></div>
	<div class="articleBody clear" >
	<p>Bitte wählen Sie eine Hauptgruppe aus, welches bearbeitet werden soll.</p><br><br>
<table cellpadding="0" cellspacing="0" border="0" class="display" id="hg_overview">	
	<thead>
		<tr>
		
			<th>Kurzbezeichnung</th>
			<? //<th>Interne Bezeichnung</th> ?>
			<th>Status</th>
			<th>Reservierungen</th>
			<th>Anzahl Objekte</th>
			<th>Bearbeiten</th>
			<th>Löschen</th>
		</tr>
	</thead>
	
	<tbody>
	<?
	$sql = 'SELECT specid_hg,Kurzbez,HGruppenOnOff FROM `03_obj_hauptgruppen` ORDER BY `ErstelltAm` DESC'; 
	$hauptgruppen = mysql_query($sql);

	while ($hauptgruppenData = mysql_fetch_array($hauptgruppen, MYSQL_NUM))
	{
		
		//suche nach aktivierten objekten, die möglicherweise ausgeliehen worden sind
		$sql3 = "SELECT specid_obj FROM `04_obj_objekte` WHERE `HGruppe` = \"".mysql_real_escape_string($hauptgruppenData[0])."\""; 
		$ObjAusHGs = mysql_query($sql3);

		while ($hgObjAktivLeihe = mysql_fetch_array($ObjAusHGs, MYSQL_NUM))
		{
		$sql4 = "SELECT * FROM `06_wkObje` WHERE `geraet` = \"".$hgObjAktivLeihe[0]."\" "; 
		$objImVerleih = mysql_query($sql4);
		$Zeilen = mysql_num_rows($objImVerleih); 
		$leihenProHauptgruppe=$Zeilen+$leihenProHauptgruppe;
		unset($objImVerleih);
		$objekteInHG++;
		}

		if (!isset($leihenProHauptgruppe))
		{
		$leihenProHauptgruppe=0;
		}
		
		if (!isset($objekteInHG))
		{
		$objekteInHG=0;
		}
		
		if ($hauptgruppenData[2]=="1")
		{
		$status="aktiv";
		echo "<tr><td title=\"".$hauptgruppenData[0]."\">".utf8_encode($hauptgruppenData[1])."</td><td>".$status."</td><td>".$leihenProHauptgruppe."</td><td>".$objekteInHG."</td><td><a href=\"editHG.php?g=".base64_encode(serialize($hauptgruppenData[0]))."\" title=\"bearbeiten\" ><div class=\"ui-state-default ui-corner-all\"><span class=\"ui-icon ui-icon-wrench\"></span></div></a></td><td><input type=\"checkbox\" name=\"check\" value=\"".base64_encode(serialize($hauptgruppenData[0]))."\"></td></tr>";

		}
		else
		{
		$status="deaktiviert";
		echo "<tr class='gradeU'><td title=\"".$hauptgruppenData[0]."\">".utf8_encode($hauptgruppenData[1])."</td><td>".$status."</td><td>".$leihenProHauptgruppe."</td><td>".$objekteInHG."</td><td><a href=\"editHG.php?g=".base64_encode(serialize($hauptgruppenData[0]))."\" title=\"bearbeiten\" ><div class=\"ui-state-default ui-corner-all\"><span class=\"ui-icon ui-icon-wrench\"></span></div></a></td><td><input type=\"checkbox\" name=\"check\" value=\"".base64_encode(serialize($hauptgruppenData[0]))."\"></td></tr>";

		}
		unset($objekteInHG);
		unset($leihenProHauptgruppe);
	}
	?>
	</tbody>
</table>

<input aria-disabled="false" id="delSel" class="ui-button ui-widget ui-state-default ui-corner-all ui-state-hover" style="float:right;margin-top:20px" value="Markierte Objekte löschen" type="submit"> 
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
?>  
<script type="text/javascript" src="../../../BL_JS/jquery.dataTables.js"></script>
<?
//anfang voraussetzung: registriert, admin oder ausgabeberechtigter
if (isset($_SESSION["User_ID"]) && $_SESSION["User_Recht_Admin"]=="1")
{
?>
<script>

	daten = new Array();
	var daten2;
	
    $("#delSel").click(function () {
	$("input:checked").each(function(index) {
	daten = daten.concat($(this).val());
	});
	var daten2 = daten.join("|");
	$("#output").load("01_delHG.inc.php?d="+daten2);
	daten = new Array();
	var daten2;
    });

$(document).ready(function() {
	
	 $('#hg_overview').dataTable( {
		"bJQueryUI": true,
		"bStateSave": true,
		"sPaginationType": "full_numbers"
	});
} );

$("#loadingAj").hide();
$("#loadingAj").ajaxStart(function(){
   $(this).show();
 });
 $("#loadingAj").ajaxStop(function(){
   $(this).hide();
 });
</script>

<?
}
?>





<?
echo utf8_encode($_SESSION["SE_EndeIndex"]);
?>

<br><br><br><br><br><br>
</body>
</html>