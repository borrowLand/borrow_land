<?
session_start();

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



if (isset($_SESSION["User_ID"]) && isset($_GET['la']) && $_GET['la']!="" && ($_SESSION["User_Recht_Admin"]=="1" || $_SESSION["User_Recht_Ausgabeber"]=="1"))
{


//anzahl items im warenkorb, wenn zurückgegeben mit gesamt übereinstimmt=>warenkorb wird gelöscht.

$sql = "SELECT count(*) FROM `06_wkObje` WHERE `wkid` = \"".mysql_real_escape_string(unserialize(base64_decode($_GET['la'])))."\"";
$DataObjLS4 = mysql_query($sql);
$anzahlItems = mysql_fetch_row($DataObjLS4);



//nur objekte vom warenkorb, die noch nicht mit zeitstempeln bei gebracht versehen worden sind, aber bei abgeholt einen haben.
$sql = "SELECT * FROM `06_wkObje` WHERE `abgeholt` IS NOT NULL AND `gebracht` IS NULL AND wkid = \"".mysql_real_escape_string(unserialize(base64_decode($_GET['la'])))."\""; 
$DataObjRg = mysql_query($sql);
$anzahl = mysql_num_rows($DataObjRg); 

	if ($anzahl>0)
	{
	$jetztLS= new DateTime();
	$dbLSData=$jetztLS->format('U');

	$sql = "UPDATE `06_wkObje` SET `gebracht` = \"".$dbLSData."\" WHERE `abgeholt` IS NOT NULL AND `gebracht` IS NULL AND wkid = \"".mysql_real_escape_string(unserialize(base64_decode($_GET['la'])))."\""; 	
	$DataObjLS2 = mysql_query($sql);
	$anzahlUpdates = mysql_affected_rows(); 

	
	//wenn jetzt alle werte im warenkorb so gesetzt sind, dass nur noch zurückgegebene objekte exixistieren, kann auch eine wk löschung gemacht werden...
	$sql = "SELECT * FROM `06_wkObje` WHERE `abgeholt` IS NOT NULL AND `gebracht` IS NOT NULL AND wkid = \"".mysql_real_escape_string(unserialize(base64_decode($_GET['la'])))."\""; 
	$DataObjRg2 = mysql_query($sql);
	$anzahlNachUpdate = mysql_num_rows($DataObjRg2); 
	
	
	
	
	
	
		//vergleich werte vorher / erfolg nachher; warenkorb kann weg
		if ($anzahlItems[0]==$anzahlUpdates || $anzahlNachUpdate==$anzahlItems[0])
		{
		
		?>
		
		<style>
		a.ui-dialog-titlebar-close{
		display: none;
		}
		</style>
		
		<div id="wkDelFrage" title="Löschen Warenkorbs." >
		<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Alle Elemente in diesem Warenkorb wurden zurückgegeben. Der Warenkorb kann nun gelöscht werden.<br><br><b>Möchten Sie den Warenkorb unwiderruflich löschen? (Empfohlen: Ja)</b></p>
		</div>
		
		<script>

		$("#wkDelFrage").dialog({ autoOpen: false });

		$("#wkDelFrage").dialog({
					resizable: false,
					height:340,
					modal: true,
					buttons: {
						"Ja": function() {
						$("#ajaWKCon").load("04_delWKAuto.php?x="+"<? echo $_GET['la'];?>|mFahd3C*t");
						$( this ).dialog( "close" );
						},
						"Abbrechen": function() {
						$.pnotify({
						pnotify_title: 'Rückgabe-Festlegung',
						pnotify_text: 'Alle reservierten Objekte wurden als zurückgegeben markiert.'
						});						
						location.reload();
						$( this ).dialog( "close" );
						}
					}
				});
		$("#wkDelFrage" ).dialog('open');
		

		
		
		
		
		
		</script>
		<?
		}
		//wk kann nich weg
		else
		{
		?>
		<script>
		$.pnotify({
		pnotify_title: 'Rückgabe-Festlegung',
		pnotify_text: 'Alle reservierten Objekte wurden als zurückgegeben markiert.'
		});
		location.reload();
		</script>
		<?
		
		}
		
		
		
		
		

	
	
	
	}
	else
	{
	?>
	<script>
	$.pnotify({
	pnotify_title: 'Rückgabe-Festlegung',
	pnotify_text: 'Die Objekte wurden nicht als zurückgegeben markiert.',
	pnotify_type: 'error'
	});
	</script>
	<?	
	}

}
?>