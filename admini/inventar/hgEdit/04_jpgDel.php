<?
session_start();

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



if (isset($_SESSION["User_ID"]) && $_SESSION["User_Recht_Admin"]=="1" && isset($_GET['jI']) && $_GET['jI']!="")
{

	if (is_file('../../../BL_MEDIA/PIC_HG/'.strip_tags(htmlspecialchars($_GET['jI'])).'.jpg'))
	{
		if (unlink('../../../BL_MEDIA/PIC_HG/'.strip_tags(htmlspecialchars($_GET['jI'])).'.jpg')==TRUE)
		{
		?>
		<script>
		$.pnotify({
		pnotify_title: 'Löschen des Profilbildes',
		pnotify_text: 'Das Bild wurde erfolgreich gelöscht.',
		});
		$('#picPrev').after('Kein Bild vorhanden ');
		$('#PICDel').remove();
		$('#picPrev').remove();
		</script>
		<?	
		}
		else
		{
		?>
		<script>
		$.pnotify({
		pnotify_title: 'Löschen des Profilbildes',
		pnotify_text: 'Das Bild konnte leider nicht gelöscht werden.',
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
		pnotify_title: 'Löschen des Profilbildes',
		pnotify_text: 'Das Bild konnte leider nicht gelöscht werden.',
		pnotify_type: 'error',
		});
		</script>
		<?	
		}

}
?>