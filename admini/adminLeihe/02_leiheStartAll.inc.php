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



if (isset($_SESSION["User_ID"]) && isset($_GET['ls']) && $_GET['ls']!="" && ($_SESSION["User_Recht_Admin"]=="1" || $_SESSION["User_Recht_Ausgabeber"]=="1"))
{

//nur objekte vom warenkorb, die noch nicht mit zeitstempeln versehen worden sind
$sql = "SELECT * FROM `06_wkObje` WHERE `abgeholt` IS NULL AND `gebracht` IS NULL AND wkid = \"".mysql_real_escape_string(unserialize(base64_decode($_GET['ls'])))."\""; 
$DataObjLS = mysql_query($sql);
$anzahl = mysql_num_rows($DataObjLS); 


	//es gibt keine objekte die draussen herumschwirren, reservierte objekte werden gelöscht, abgegebende auch.
	if ($anzahl>0)
	{
	$jetztLS= new DateTime();
	$dbLSData=$jetztLS->format('U');

	$sql = "UPDATE `06_wkObje` SET `abgeholt` = \"".$dbLSData."\" WHERE `abgeholt` IS NULL AND `gebracht` IS NULL AND wkid = \"".mysql_real_escape_string(unserialize(base64_decode($_GET['ls'])))."\""; 	
	$DataObjLS2 = mysql_query($sql);
	$anzahlUpdates = mysql_affected_rows(); 

		//vergleich werte vorher / erfolg nachher
		if ($anzahl==$anzahlUpdates)
		{
		?>
		<script>
		
		$.pnotify({
		pnotify_title: 'Leihestart-Festlegung',
		pnotify_text: 'Alle reservierten Objekte wurden als verliehen markiert.'
		});
		location.reload();
		</script>
		<?
		}
		else
		{
		?>
		<script>
		$.pnotify({
		pnotify_title: 'Leihestart-Festlegung',
		pnotify_text: 'Die Objekte wurden nicht als verliehen markiert.',
		pnotify_type: 'error'
		});
		</script>
		<?	
		}	
	
	
	
	}

	else
	{
	?>
	<script>
	$.pnotify({
	pnotify_title: 'Leihestart-Festlegung',
	pnotify_text: 'Die Objekte wurden nicht als verliehen markiert.',
	pnotify_type: 'error'
	});
	</script>
	<?	
	}

}
?>