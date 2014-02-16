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



if (isset($_SESSION["User_ID"]) && $_SESSION["User_Recht_Admin"]=="1" && isset($_GET['e']) && $_GET['e']!="")
{

$teile = explode("|", $_GET['e']);
	for ($i=0;$i<count($teile);$i++)
	{

	// unserialize(base64_decode($teile[$i]))		name der hg(en) der gelöst werden soll	
		
		//suche nach aktivierten objekten, die möglicherweise ausgeliehen worden sind
		$sql2 = "SELECT von FROM `06_wkObje` WHERE `geraet` = \"".mysql_real_escape_string(unserialize(base64_decode($teile[$i])))."\" "; 
		$objImVerleih = mysql_query($sql2);
		$Zeilen = mysql_num_rows($objImVerleih); 
		unset($objImVerleih);
		
		$nameObj=utf8_encode(klarNameObj(unserialize(base64_decode($teile[$i]))));

		if ($Zeilen=="0")
		{
		//löschvorgang okay
		$sql = "DELETE FROM `04_obj_objekte` WHERE `specid_obj` = \"".mysql_real_escape_string(unserialize(base64_decode($teile[$i])))."\" LIMIT 1"; 
		$loeschOkay = mysql_query($sql);			
		$erfolgOrNot=mysql_affected_rows();

			//pdf löschen
			if (is_file('../../../BL_MEDIA/PDF_OBJ/'.strip_tags(htmlspecialchars($teile[$i])).'.pdf'))
			{
			unlink('../../../BL_MEDIA/PDF_OBJ/'.strip_tags(htmlspecialchars($teile[$i])).'.pdf');
			}

			//profilbild löschen
			if (is_file('../../../BL_MEDIA/PIC_OBJ/'.strip_tags(htmlspecialchars($teile[$i])).'.jpg'))
			{
			unlink('../../../BL_MEDIA/PIC_OBJ/'.strip_tags(htmlspecialchars($teile[$i])).'.jpg');
			}			
			
			
			if ($erfolgOrNot=="1")
			{
				?>
				<script>
				$.pnotify({
				pnotify_title: 'Löschen des Objektes <? echo $nameObj; ?>',
				pnotify_text: 'Das Objekt wurde erfolgreich gelöscht.',
				});
				$("input[value='<? echo strip_tags($teile[$i]); ?>']").closest("tr").remove();
				</script>
				<?
			}
			else
			{
				?>
				<script>
				$.pnotify({
				pnotify_title: 'Löschen des Objektes <? echo $nameObj ?>',
				pnotify_text: 'Das Objekt wurde wegen einem Übertragungsfehler nicht gelöscht.',
				pnotify_type: 'error',
				});
				</script>
				<?
			}

		}
		else
		{
		//hauptgruppe ist noch objekt zugeordnet oder in leihe
		?>
			<script>
			$.pnotify({
			pnotify_title: 'Löschen des Objektes <? echo $nameObj ?>',
			pnotify_text: 'Das Objekt wurde nicht gelöscht, da mind. 1 Reservierung vorliegt.',
			pnotify_type: 'error',
			});
			$("input[value='<? echo strip_tags($teile[$i]); ?>']").closest("td").animate({ backgroundColor: "#FF0000" }, 1900);
			//css("border","3px solid red")
			</script>
			<?
		}

	}
}
?>