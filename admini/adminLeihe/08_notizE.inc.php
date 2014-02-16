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


//buttons (GET WERT h)
if (isset($_SESSION["User_ID"]) && isset($_GET['we']) && $_GET['we']!="" && ($_SESSION["User_Recht_Admin"]=="1" || $_SESSION["User_Recht_Ausgabeber"]=="1"))
{
$ungeprueData = explode("|", $_GET['we']);
$sql = "UPDATE `05_wk` SET `bemerkungen` = \"".$ungeprueData[0]."\" WHERE `specid_wk` = \"".mysql_real_escape_string(unserialize(base64_decode($ungeprueData[1])))."\" LIMIT 1;"; 
$upDt = mysql_query($sql);
$erfolg=mysql_affected_rows();
echo $erfolg;

if ($erfolg=="1")
{
	?>
	<script>
	$.pnotify({
	pnotify_title: 'Notiz  Warenkorb',
	pnotify_text: 'Die Änderung wurde erfolgreich abgespeichert.',
	});
	$("#contText").slideToggle();
	location.reload();
	</script>
	<?	
}
else
{
	?>
	<script>
	$.pnotify({
	pnotify_title: 'Notiz  Warenkorb',
	pnotify_text: 'Die Änderung wurde nicht abgespeichert.',
	pnotify_type: 'error',
	});
	</script>
	<?	
}


}








?>