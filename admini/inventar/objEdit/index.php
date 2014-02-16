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
		
<section id="page"> <!-- Defining the #page section with the section tag -->


            <header> <!-- Defining the header section of the page with the appropriate tag -->
            
<?
//#############Anfang Überschrift
?>
<hgroup><h1><a href="../../../index.php" title="Startseite"><img src="../../../BL_BILDER/start_00.png"></a> <a href="../../../index.php" title="Startseite">borrow land</a></h1>
<?
$oeffentlich=0;
if ($oeffentlich=="1")
{
?>
<div id="ueberschr_all"><a href="../../../">/Leihe</a><a href="../../">/Verwaltung</a><a href="../">/Inventar</a>/Objekt bearbeiten - Übersicht</div>
</hgroup>
<?
}
else
{
	if (isset($_SESSION["User_ID"]) && $_SESSION["User_ID"]!="")
	{	
	?>
<div id="ueberschr_all"><a href="../../../">/Leihe</a><a href="../../">/Verwaltung</a><a href="../">/Inventar</a>/Objekt bearbeiten - Übersicht</div>
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
<h2>Objekte Bearbeitung</h2>
	
<div class="line"></div>
	<div class="articleBody clear" >
	<p>Bitte wählen Sie ein Objekt aus, welches bearbeitet werden soll.</p><br><br>
	
<table cellpadding="0" cellspacing="0" border="0" class="display" id="obj_overview">	
	<thead>
		<tr>
		
			<th>Kurzbezeichnung</th>
			<? //<th>Interne Bezeichnung</th> ?>
			<th>Hauptgruppe</th>
			<th>Status</th>
			<th>Reservierungen</th>
			<th>Bearbeiten</th>
			<th>Löschen</th>
		</tr>
	</thead>
	
	<tbody>
	<?
	$sql = 'SELECT specid_obj,Kurzbez,HGruppe,ObjOnOff,interneBez FROM `04_obj_objekte` ORDER BY `ErstelltAm` DESC'; 
	$objekte = mysql_query($sql);

	while ($objekteData = mysql_fetch_array($objekte, MYSQL_NUM))
	{
	
		$sql2 = "SELECT von FROM `06_wkObje` WHERE `geraet` = \"".$objekteData[0]."\" "; 
		$objImVerleih = mysql_query($sql2);
		$Zeilen = mysql_num_rows($objImVerleih); 
	
		if ($objekteData[3]=="1")
		{
		$status="aktiv";
		echo "<tr><td title=\"".$objekteData[0]."\">".utf8_encode($objekteData[1])."</td><td>".utf8_encode(hgKurzNameAusHGID($objekteData[2]))."</td><td>".$status."</td><td>".$Zeilen."</td><td><a href=\"edit.php?z=".base64_encode(serialize($objekteData[0]))."\" title=\"bearbeiten\" ><div class=\"ui-state-default ui-corner-all\"><span class=\"ui-icon ui-icon-wrench\"></span></div></a></td><td><input type=\"checkbox\" name=\"check4\" value=\"".base64_encode(serialize($objekteData[0]))."\"></td></tr>";

		}
		else
		{
		$status="deaktiviert";
		echo "<tr class='gradeU'><td title=\"".$objekteData[0]."\">".utf8_encode($objekteData[1])."</td><td>".utf8_encode(hgKurzNameAusHGID($objekteData[2]))."</td><td>".$status."</td><td>".$Zeilen."</td><td><a href=\"edit.php?z=".base64_encode(serialize($objekteData[0]))."\" title=\"bearbeiten\" ><div class=\"ui-state-default ui-corner-all\"><span class=\"ui-icon ui-icon-wrench\"></span></div></a></td><td><input type=\"checkbox\" name=\"check4\" value=\"".base64_encode(serialize($objekteData[0]))."\"></td></tr>";
		}
		
		
		unset($Zeilen);
	}
	?>
	</tbody>
</table>
<br>
graue Zeilen=Objekt deaktiviert
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


<script>
	daten = new Array();
	var daten2;
	
    $("#delSel").click(function () {
	$("input:checked").each(function(index) {
	daten = daten.concat($(this).val());
	});
	var daten2 = daten.join("|");
	$("#output").load("01_delObj.inc.php?e="+daten2);
	daten = new Array();
	var daten2;
    });

$(document).ready(function() {
	
	 $('#obj_overview').dataTable( {
		"bJQueryUI": true,
		"sPaginationType": "full_numbers",
		"bStateSave": true
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
echo utf8_encode($_SESSION["SE_EndeIndex"]);
?>

<br><br><br><br><br><br>
</body>
</html>