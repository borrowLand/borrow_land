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


if (isset($_SESSION["User_ID"]) && isset($_GET['lsE']) && $_GET['lsE']!="" && ($_SESSION["User_Recht_Admin"]=="1" || $_SESSION["User_Recht_Ausgabeber"]=="1"))
{
$quelle = explode("_", $_GET['lsE']);

//ist das objekt im warenkorb wirklich noch nicht mit ausleihestart daten versehen?
$sql = "SELECT abgeholt FROM `06_wkObje` WHERE  id = \"".mysql_real_escape_string($quelle[1]-376592)."\""; 
$DataObjLSE = mysql_query($sql);
$LSEinzelData = mysql_fetch_row($DataObjLSE);

	//okay, der wert wurde noch nicht gesetzt
	if ($LSEinzelData[0]=="")
	{
	$sql = "UPDATE `06_wkObje` SET `abgeholt` = \"".time()."\" WHERE `id` = \"".mysql_real_escape_string($quelle[1]-376592)."\" LIMIT 1"; 
	$SetAuslStEi = mysql_query($sql);
	$okayOderNicht = mysql_affected_rows();

	//okay, das hat geklappt!
	if($okayOderNicht=="1")
	{
		?>
		<script>
		$.pnotify({
		pnotify_title: 'Ausleihe Start Objekt',
		pnotify_text: 'Das Objekt wurde als ausgeliehen markiert.',
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
		pnotify_title: 'Ausleihe Start Objekt',
		pnotify_text: 'Das Objekt wurde nicht als ausgeliehen markiert.',
		pnotify_type: 'error',
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
		pnotify_title: 'Ausleihe Start Objekt',
		pnotify_text: 'Das Objekt wurde nicht als ausgeliehen markiert.',
		pnotify_type: 'error',
		});
		</script>
		<?	
	}

}
?>