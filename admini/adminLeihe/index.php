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
<div id="ueberschr_all"><a href="../../">/Leihe</a><a href="../">/Verwaltung</a>/Ausleiheverwaltung</div>
</hgroup>
<?
}
else
{
	if (isset($_SESSION["User_ID"]) && $_SESSION["User_ID"]!="")
	{	
	?>
	<div id="ueberschr_all"><a href="../../">/Leihe</a><a href="../">/Verwaltung</a>/Ausleiheverwaltung</div>
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
	<div id="loadingAj"></div>
	<div id="ajax"></div>
			<section id="articles">
	<?
	if (isset($_SESSION["User_ID"]) && ($_SESSION["User_Recht_Admin"]=="1" || $_SESSION["User_Recht_Ausgabeber"]=="1"))
	{
	?>
	<article id="articleLogin1"> 
	<h2>Ausleiheverwaltung</h2>

	<div class="line"></div>

	<div class="articleBody clear">
		<div id="tabsAusleiheAdmin">
			<ul>
			<li><a href="#WK">Kunden</a></li>
			<li><a href="#Live">Verleih</a></li>
			<li><a href="#reqTod">Heute</a></li>
			<li><a href="#exitObj">Objekte im Verleih</a></li>
			<li><a href="#Obj" id="obj_load">Objekte</a></li>
			<li><a href="#HG" id="hg_load">Hauptgruppen</a></li>
			</ul>

			<div id="Live">
			<br>
			<input class="ui-state-disabled" onmouseover="tooltip2.pnotify_display();" onmousemove="tooltip2.css({'top': event.clientY+12, 'left': event.clientX+12});" onmouseout="tooltip2.pnotify_remove();" style="float:left;" value="Hinweis" type="button" /><br><br>

				<table cellpadding="0" cellspacing="0" border="0" class="display" id="WK_Verleih">	
					<thead>
						<tr>
							<th>Erstellt am</th>
							<th>Bearbeiter</th>
							<th>Anzahl</th>
							<th>Mietvertrag</th>
							<?
							if ($_SESSION["SE_versandMod"]=="1")
							{
							echo "<th>Versand</th>";							
							}
							?>

							<th>Bearbeiten</th>
						</tr>
					</thead>
					
					<tbody>
					<?
					$sql = 'SELECT erstellt_am,owner,specid_wk,bemerkungen FROM `05_wk` WHERE `fuer_dritte` =1 ORDER BY `erstellt_am` DESC'; 
					$WKobjekte = mysql_query($sql);

					while ($objekteWKData = mysql_fetch_array($WKobjekte, MYSQL_NUM))
					{

					$userWK=benutzerDaten($objekteWKData[1]);
					
						$sql2 = "SELECT von FROM `06_wkObje` WHERE `wkid` = \"".$objekteWKData[2]."\" "; 
						$objImVerleih = mysql_query($sql2);
						$Zeilen = mysql_num_rows($objImVerleih); 
						
						if ($_SESSION["SE_versandMod"]=="1")
						{
						$sql3 = "SELECT von FROM `06_wkObje` WHERE `wkid` = \"".$objekteWKData[2]."\" AND `versandObj` = 1"; 
						$objImVerleih3 = mysql_query($sql3);
						$Zeilen2 = mysql_num_rows($objImVerleih3);					

							if($Zeilen2==0)
							{
							$versandInfo="-";
							}
							else
							{
							$versandInfo=$Zeilen2;
							}
							echo "<tr><td title=\"".$objekteWKData[3]."\">".timeCdZuDatumMitZeitAmerik($objekteWKData[0])."</td><td>".utf8_encode($userWK[0])."</td><td>".$Zeilen."</td><td><a href=\"".$_SESSION["SE_festUrl"]."account/basketControl/01_pdf_mv.inc.php?o=".base64_encode(serialize($objekteWKData[2]))."\"><img src=\"../../BL_BILDER/pdf.png\"></a></td><td>".$versandInfo."</td><td><a href='wkEdit.php?wk=".base64_encode(serialize($objekteWKData[2]))."' title='bearbeiten' ><div class='ui-state-default ui-corner-all'><span class='ui-icon ui-icon-wrench'></span></div></a></td></tr>\n";
							unset($versandInfo);
						}
						else
						{
						echo "<tr><td title=\"".$objekteWKData[3]."\">".timeCdZuDatumMitZeitAmerik($objekteWKData[0])."</td><td>".utf8_encode($userWK[0])."</td><td>".$Zeilen."</td><td><a href=\"".$_SESSION["SE_festUrl"]."account/basketControl/01_pdf_mv.inc.php?o=".base64_encode(serialize($objekteWKData[2]))."\"><img src=\"../../BL_BILDER/pdf.png\"></a></td><td><a href='wkEdit.php?wk=".base64_encode(serialize($objekteWKData[2]))."' title='bearbeiten' ><div class='ui-state-default ui-corner-all'><span class='ui-icon ui-icon-wrench'></span></div></a></td></tr>\n";
						}
	
					}
					?>
					</tbody>
				</table>
			</div>			
			
			<div id="Obj">
			</div>
			
			<div id="HG">
			</div>	
			
			<div id="WK" class="clear">
			<br>
			<input class="ui-state-disabled" onmouseover="tooltip.pnotify_display();" onmousemove="tooltip.css({'top': event.clientY+12, 'left': event.clientX+12});" onmouseout="tooltip.pnotify_remove();" style="float:left;" value="Hinweis" type="button" /><br><br>

				<table cellpadding="0" cellspacing="0" border="0" class="display" id="WK_AdmOv">	
					<thead>
						<tr>
							<th>Erstellt am</th>
							<th>Von</th>
							<th>Anzahl</th>
							<th>Mietvertrag</th>
							<?
							if ($_SESSION["SE_versandMod"]=="1")
							{
							echo "<th>Versand</th>";							
							}
							?>

							<th>Bearbeiten</th>
						</tr>
					</thead>
					
					<tbody>
					<?
					$sql = 'SELECT erstellt_am,owner,specid_wk,bemerkungen FROM `05_wk` WHERE `fuer_dritte` =0 ORDER BY `erstellt_am` DESC'; 
					$WKobjekte = mysql_query($sql);

					while ($objekteWKData = mysql_fetch_array($WKobjekte, MYSQL_NUM))
					{

					$userWK=benutzerDaten($objekteWKData[1]);
					
						$sql2 = "SELECT von FROM `06_wkObje` WHERE `wkid` = \"".$objekteWKData[2]."\" "; 
						$objImVerleih = mysql_query($sql2);
						$Zeilen = mysql_num_rows($objImVerleih); 
						
						if ($_SESSION["SE_versandMod"]=="1")
						{
						$sql3 = "SELECT von FROM `06_wkObje` WHERE `wkid` = \"".$objekteWKData[2]."\" AND `versandObj` = 1"; 
						$objImVerleih3 = mysql_query($sql3);
						$Zeilen2 = mysql_num_rows($objImVerleih3);					

							if($Zeilen2==0)
							{
							$versandInfo="-";
							}
							else
							{
							$versandInfo=$Zeilen2;
							}
							echo "<tr><td title=\"".$objekteWKData[3]."\">".timeCdZuDatumMitZeitAmerik($objekteWKData[0])."</td><td>".utf8_encode($userWK[0])."</td><td>".$Zeilen."</td><td><a href=\"".$_SESSION["SE_festUrl"]."account/basketControl/01_pdf_mv.inc.php?o=".base64_encode(serialize($objekteWKData[2]))."\"><img src=\"../../BL_BILDER/pdf.png\"></a></td><td>".$versandInfo."</td><td><a href='wkEdit.php?wk=".base64_encode(serialize($objekteWKData[2]))."' title='bearbeiten' ><div class='ui-state-default ui-corner-all'><span class='ui-icon ui-icon-wrench'></span></div></a></td></tr>\n";
							unset($versandInfo);
						}
						else
						{
						echo "<tr><td title=\"".$objekteWKData[3]."\">".timeCdZuDatumMitZeitAmerik($objekteWKData[0])."</td><td>".utf8_encode($userWK[0])."</td><td>".$Zeilen."</td><td><a href=\"".$_SESSION["SE_festUrl"]."account/basketControl/01_pdf_mv.inc.php?o=".base64_encode(serialize($objekteWKData[2]))."\"><img src=\"../../BL_BILDER/pdf.png\"></a></td><td><a href='wkEdit.php?wk=".base64_encode(serialize($objekteWKData[2]))."' title='bearbeiten' ><div class='ui-state-default ui-corner-all'><span class='ui-icon ui-icon-wrench'></span></div></a></td></tr>\n";
						}
	
					}
					?>
					</tbody>
				</table>				
				
			</div>
		
			<div id="reqTod" class="clear">
			<br>
			<input class="ui-state-disabled" onmouseover="tooltip3.pnotify_display();" onmousemove="tooltip3.css({'top': event.clientY+12, 'left': event.clientX+12});" onmouseout="tooltip3.pnotify_remove();" style="float:left;" value="Hinweis" type="button" /><br><br>
			
				<table cellpadding="0" cellspacing="0" border="0" class="display" id="reqTodOv">	
					<thead>
						<tr>
							<th>Erstellt am</th>
							<th>Von</th>
							<th>Anzahl Objekte</th>
							<th>Mietvertrag</th>
							<th>Bearbeiten</th>
						</tr>
					</thead>
					
					<tbody>
					<?
					$sql = 'SELECT erstellt_am,owner,specid_wk,bemerkungen FROM `05_wk` ORDER BY `erstellt_am` DESC'; 
					$WKobjekte = mysql_query($sql);

					while ($objekteWKData = mysql_fetch_array($WKobjekte, MYSQL_NUM))
					{

						$sql = "SELECT von FROM `06_wkObje` WHERE `wkid` = \"".$objekteWKData[2]."\" AND `abgeholt` IS NULL AND `gebracht` IS NULL"; 
						$ObjekteimWK = mysql_query($sql);

						while ($objAusWKidAbfr = mysql_fetch_array($ObjekteimWK, MYSQL_NUM))
						{
							if (date("d.m.Y")==date("d.m.Y",$objAusWKidAbfr[0]) && $warenkorbDargestellt!="1")
							{
							$userWK=benutzerDaten($objekteWKData[1]);
							$sql2 = "SELECT von FROM `06_wkObje` WHERE `wkid` = \"".$objekteWKData[2]."\" "; 
							$objImVerleih = mysql_query($sql2);
							$Zeilen = mysql_num_rows($objImVerleih); 
							
							echo "<tr><td title=\"".$objekteWKData[3]."\">".timeCdZuDatumMitZeitAmerik($objekteWKData[0])."</td><td>".utf8_encode($userWK[0])."</td><td>".$Zeilen."</td><td><a href=\"".$_SESSION["SE_festUrl"]."account/basketControl/01_pdf_mv.inc.php?o=".base64_encode(serialize($objekteWKData[2]))."\"><img src=\"../../BL_BILDER/pdf.png\"></a></td><td><a href='wkEdit.php?wk=".base64_encode(serialize($objekteWKData[2]))."' title='bearbeiten' ><div class='ui-state-default ui-corner-all'><span class='ui-icon ui-icon-wrench'></span></div></a></td></tr>\n";
							$warenkorbDargestellt=1;
							}
						}
						unset($warenkorbDargestellt);
						
					}
					?>
					</tbody>
				</table>
			</div>		

			<div id="exitObj" class="clear">
			<br>
			<input class="ui-state-disabled" onmouseover="tooltip4.pnotify_display();" onmousemove="tooltip4.css({'top': event.clientY+12, 'left': event.clientX+12});" onmouseout="tooltip4.pnotify_remove();" style="float:left;" value="Hinweis" type="button" /><br><br>
			
				<table cellpadding="0" cellspacing="0" border="0" class="display" id="exitObjTab">	
					<thead>
						<tr>
							<th>Objektname</th>
							<th>Mietvertrag</th>
							<th>Bearbeiten</th>
						</tr>
					</thead>
					
					<tbody>
					<?
					$sql = 'SELECT geraet,wkid FROM `06_wkObje` WHERE `abgeholt` IS NOT NULL AND `gebracht` IS NULL'; 
					$WKobjekteEx = mysql_query($sql);

					while ($objekteWKExt = mysql_fetch_array($WKobjekteEx, MYSQL_NUM))
					{
					echo "<tr><td>".utf8_encode(klarNameObj($objekteWKExt[0]))."</td><td><a href=\"".$_SESSION["SE_festUrl"]."account/basketControl/01_pdf_mv.inc.php?o=".base64_encode(serialize($objekteWKExt[1]))."\"><img src=\"../../BL_BILDER/pdf.png\"></a></td><td><a href='wkEdit.php?wk=".base64_encode(serialize($objekteWKExt[1]))."' title='bearbeiten' ><div class='ui-state-default ui-corner-all'><span class='ui-icon ui-icon-wrench'></span></div></a></td></tr>";
					}

					?>
					</tbody>
				</table>
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
</section>	        
<!-- JavaScript Includes -->
<?
echo nl2br($_SESSION["SE_jQuerUI"]);
?>
<script type="text/javascript" src="../../BL_JS/jquery.dataTables.js"></script>

<script>
<?
if (isset($_SESSION["User_ID"]) && ($_SESSION["User_Recht_Admin"]=="1" || $_SESSION["User_Recht_Ausgabeber"]=="1"))
{
?>
	$( "#tabsAusleiheAdmin" ).tabs();

	$("#obj_load").click(function(event) {
		$("#tabsAusleiheAdmin ul").slideUp();
		$('#Obj').html("Die Daten werden geladen. <br>Je nach Menge der eingegebenden Objekte kann dieser Vorgang einige Zeit in Anspruch nehmen.");
		$.ajax({
		type: "POST",
		url: "11_viewObject.inc.php",
		dataType: "html",
		success: function(data) {
		$('#Obj').html(data);
		}
		});
	});
	
	$("#hg_load").click(function(event) {
		$("#tabsAusleiheAdmin ul").slideUp();
		$('#HG').html("Die Daten werden geladen. <br>Je nach Menge der eingegebenden Hauptgruppen kann dieser Vorgang einige Zeit in Anspruch nehmen.");
		$.ajax({
		type: "POST",
		url: "12_viewHG.inc.php",
		dataType: "html",
		success: function(data) {
		$('#HG').html(data);
		}
		});
	});
	
 $('#WK_AdmOv').dataTable( {
	"bJQueryUI": true,
	"sPaginationType": "full_numbers"
});
 
 $('#WK_Verleih').dataTable( {
	"bJQueryUI": true,
	"sPaginationType": "full_numbers"
});

 $('#reqTodOv').dataTable( {
	"bJQueryUI": true,
	"sPaginationType": "full_numbers"
});	

 $('#exitObjTab').dataTable( {
	"bJQueryUI": true,
	"sPaginationType": "full_numbers"
});		
	


	<?

	if ($_SESSION["SE_InfoFaellObj"]=="1" && $_SESSION["User_ID"]!="")
	{
	//nachschauen, ob geräte noch nicht zurück gebracht worden sind, die als verliehen makriert worden sind

	//abfrage nach geräten, die angeholt worden sind, aber noch nicht zurückgebracht worden sind
	$sql = 'SELECT wkid,geraet,bis FROM `06_wkObje` WHERE `abgeholt` IS NOT NULL AND `gebracht` IS NULL '; 
	$DataObjNotBack = mysql_query($sql);
		while ($DatenObjDraussen = mysql_fetch_array($DataObjNotBack, MYSQL_NUM))
		{
			if (time()>$DatenObjDraussen[2])
			{
			$zeitspanne=time()-$DatenObjDraussen[2];
			$zeitspanne1=round($zeitspanne/3600); //stunden
			
			if ($zeitspanne1>24)
			{
			$zeitspanne2=round($zeitspanne1/24)." Tag/en";
			}
			else
			{
			$zeitspanne2=$zeitspanne1." Stunden";
			}
			
			?>
			$.pnotify({
			pnotify_title: 'Fälligkeit von Mietobjekten',
			pnotify_text: 'Das Objekt <? echo klarNameObj($DatenObjDraussen[1]); ?> wurde seit <? echo $zeitspanne2; ?> nicht zurückgegeben. <br><a href="wkEdit.php?wk=<? echo base64_encode(serialize($DatenObjDraussen[0])); ?>"><b>Jetzt bearbeiten</b></a>',
			pnotify_type: 'error'
			});
			<?
			}
		}
	}
?>

tooltip = $.pnotify({
	pnotify_title: "Hinweis",
	pnotify_text: "Diese Ansicht beinhaltet alle Anfragen von registrierten Kunden. Es werden keine Warenkörbe angezeigt, die vor Ort erzeugt worden sind.",
	pnotify_hide: false,
	pnotify_closer: false,
	pnotify_history: false,
	pnotify_animate_speed: 100,
	pnotify_opacity: 1,
	pnotify_notice_icon: "ui-icon ui-icon-comment",
	// Setting stack to false causes Pines Notify to ignore this notice when positioning.
	pnotify_stack: false,
	pnotify_after_init: function(pnotify){
		// Remove the notice if the user mouses over it.
		pnotify.mouseout(function(){
			pnotify.pnotify_remove();
		});
	},
	pnotify_before_open: function(pnotify){
		// This prevents the notice from displaying when it's created.
		pnotify.pnotify({
			pnotify_before_open: null
		});
		return false;
	}
});

tooltip2 = $.pnotify({
	pnotify_title: "Hinweis",
	pnotify_text: "In dieser Ansicht erhalten Sie einen Überblick von Anfragen, die vor Ort entstanden sind. Warenkörbe, die von registrierten Kunden erzeugt worden sind, werden nicht angezeigt.",
	pnotify_hide: false,
	pnotify_closer: false,
	pnotify_history: false,
	pnotify_animate_speed: 100,
	pnotify_opacity: 1,
	pnotify_notice_icon: "ui-icon ui-icon-comment",
	// Setting stack to false causes Pines Notify to ignore this notice when positioning.
	pnotify_stack: false,
	pnotify_after_init: function(pnotify){
		// Remove the notice if the user mouses over it.
		pnotify.mouseout(function(){
			pnotify.pnotify_remove();
		});
	},
	pnotify_before_open: function(pnotify){
		// This prevents the notice from displaying when it's created.
		pnotify.pnotify({
			pnotify_before_open: null
		});
		return false;
	}
});

tooltip3 = $.pnotify({
	pnotify_title: "Hinweis",
	pnotify_text: "Für Vorbereitungen bei komplexen Ausleihen erhalten Sie hier eine Ausleihe-Übersicht zum heutigen Tag. Es werden alle Warenkörbe angezeigt, die mindestens ein Objekt mit dem heutigen Startdatum haben.",
	pnotify_hide: false,
	pnotify_closer: false,
	pnotify_history: false,
	pnotify_animate_speed: 100,
	pnotify_opacity: 1,
	pnotify_notice_icon: "ui-icon ui-icon-comment",
	// Setting stack to false causes Pines Notify to ignore this notice when positioning.
	pnotify_stack: false,
	pnotify_after_init: function(pnotify){
		// Remove the notice if the user mouses over it.
		pnotify.mouseout(function(){
			pnotify.pnotify_remove();
		});
	},
	pnotify_before_open: function(pnotify){
		// This prevents the notice from displaying when it's created.
		pnotify.pnotify({
			pnotify_before_open: null
		});
		return false;
	}
});

tooltip4 = $.pnotify({
	pnotify_title: "Hinweis",
	pnotify_text: "Sie möchten wissen welche Objekte aus den Warenkörbe sich jetzt bei Kunden befinden? Hier erhalten Sie eine Übersicht.",
	pnotify_hide: false,
	pnotify_closer: false,
	pnotify_history: false,
	pnotify_animate_speed: 100,
	pnotify_opacity: 1,
	pnotify_notice_icon: "ui-icon ui-icon-comment",
	// Setting stack to false causes Pines Notify to ignore this notice when positioning.
	pnotify_stack: false,
	pnotify_after_init: function(pnotify){
		// Remove the notice if the user mouses over it.
		pnotify.mouseout(function(){
			pnotify.pnotify_remove();
		});
	},
	pnotify_before_open: function(pnotify){
		// This prevents the notice from displaying when it's created.
		pnotify.pnotify({
			pnotify_before_open: null
		});
		return false;
	}
});

tooltip5 = $.pnotify({
	pnotify_title: "Hinweis",
	pnotify_text: "In diesem Bereich erhalten Sie eine Übersicht zu allen Objekten und den dazugehörigen Leihe-Anfragen.",
	pnotify_hide: false,
	pnotify_closer: false,
	pnotify_history: false,
	pnotify_animate_speed: 100,
	pnotify_opacity: 1,
	pnotify_notice_icon: "ui-icon ui-icon-comment",
	// Setting stack to false causes Pines Notify to ignore this notice when positioning.
	pnotify_stack: false,
	pnotify_after_init: function(pnotify){
		// Remove the notice if the user mouses over it.
		pnotify.mouseout(function(){
			pnotify.pnotify_remove();
		});
	},
	pnotify_before_open: function(pnotify){
		// This prevents the notice from displaying when it's created.
		pnotify.pnotify({
			pnotify_before_open: null
		});
		return false;
	}
});

tooltip6 = $.pnotify({
	pnotify_title: "Hinweis",
	pnotify_text: "Konzentriert auf Hauptgruppen erhalten Sie hier eine Übersicht zur Auslastung in der kommenden Zeit.",
	pnotify_hide: false,
	pnotify_closer: false,
	pnotify_history: false,
	pnotify_animate_speed: 100,
	pnotify_opacity: 1,
	pnotify_notice_icon: "ui-icon ui-icon-comment",
	// Setting stack to false causes Pines Notify to ignore this notice when positioning.
	pnotify_stack: false,
	pnotify_after_init: function(pnotify){
		// Remove the notice if the user mouses over it.
		pnotify.mouseout(function(){
			pnotify.pnotify_remove();
		});
	},
	pnotify_before_open: function(pnotify){
		// This prevents the notice from displaying when it's created.
		pnotify.pnotify({
			pnotify_before_open: null
		});
		return false;
	}
});



$("#loadingAj").hide();
$("#loadingAj").ajaxStart(function(){
   $(this).show();
 });
 $("#loadingAj").ajaxStop(function(){
   $(this).hide();
 });
 <?
 }
 ?>
</script>

<?
echo utf8_encode($_SESSION["SE_EndeIndex"]);
?>

<br><br><br><br><br><br>
</body>
</html>