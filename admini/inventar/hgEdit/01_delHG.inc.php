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



if (isset($_SESSION["User_ID"]) && isset($_GET['d']) && $_GET['d']!="" && $_SESSION["User_Recht_Admin"]=="1")
{

$teile = explode("|", $_GET['d']);

	for ($i=0;$i<count($teile);$i++)
	{
		// unserialize(base64_decode($teile[$i]))		name der hg(en) der gelöst werden soll	
		
		
		//suche nach aktivierten objekten, die möglicherweise ausgeliehen worden sind
		$sql = "SELECT specid_obj FROM `04_obj_objekte` WHERE `HGruppe` = \"".mysql_real_escape_string(unserialize(base64_decode($teile[$i])))."\""; 
		$ObjAusHGs = mysql_query($sql);

		while ($hauptgruppenData = mysql_fetch_array($ObjAusHGs, MYSQL_NUM))
		{
		$sql2 = "SELECT von FROM `06_wkObje` WHERE `geraet` = \"".$hauptgruppenData[0]."\" "; 
		$objImVerleih = mysql_query($sql2);
		$Zeilen = mysql_num_rows($objImVerleih); 
		$leihenProHauptgruppe=$Zeilen+$leihenProHauptgruppe;
		unset($objImVerleih);
		$objekteInHG++;
		}
		$nameHG=utf8_encode(klarNameHG(unserialize(base64_decode($teile[$i]))));

		
		
		if (!isset($leihenProHauptgruppe))
		{
		$leihenProHauptgruppe=0;
		}
		
		if (!isset($objekteInHG))
		{
		$objekteInHG=0;
		}
	
		//echo $objekteInHG."|".$leihenProHauptgruppe."<br>";
		
		if ($leihenProHauptgruppe=="0" && $objekteInHG=="0")
		{
			//löschvorgang okay
		$sql = "DELETE FROM `03_obj_hauptgruppen` WHERE `specid_hg` = \"".mysql_real_escape_string(unserialize(base64_decode($teile[$i])))."\" LIMIT 1"; 
		$loeschOkay = mysql_query($sql);			
		$erfolgOrNot=mysql_affected_rows();
			
			//pdf löschen
			if (is_file('../../../BL_MEDIA/PDF_HG/'.strip_tags(htmlspecialchars($teile[$i])).'.pdf'))
			{
			unlink('../../../BL_MEDIA/PDF_HG/'.strip_tags(htmlspecialchars($teile[$i])).'.pdf');
			}
			
			//profilbild löschen
			if (is_file('../../../BL_MEDIA/PIC_HG/'.strip_tags(htmlspecialchars($teile[$i])).'.jpg'))
			{
			unlink('../../../BL_MEDIA/PIC_HG/'.strip_tags(htmlspecialchars($teile[$i])).'.jpg');
			}	
			
			if ($erfolgOrNot=="1")
			{
				?>
				<script>
				$.pnotify({
				pnotify_title: 'Löschen der Hauptgruppe <? echo $nameHG; ?>',
				pnotify_text: 'Die Hauptgruppe wurde erfolgreich gelöscht.',
				});
				$("input[value='<? echo $teile[$i]; ?>']").closest("tr").remove();
				</script>
				<?
			}
			else
			{
				?>
				<script>
				$.pnotify({
				pnotify_title: 'Löschen der Hauptgruppe <? echo $nameHG; ?>',
				pnotify_text: 'Die Hauptgruppe wurde wegen einem Übertragungsfehler nicht gelöscht.',
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
			pnotify_title: 'Löschen der Hauptgruppe <? echo $nameHG; ?>',
			pnotify_text: 'Die Hauptgruppe wurde nicht gelöscht, da diese noch Objekten zugeordnet ist oder sich Objekte aus der Hauptgruppe im aktiven Verleih befinden.',
			pnotify_type: 'error',
			});
			$("input[value='<? echo $teile[$i]; ?>']").closest("td").animate({ backgroundColor: "#FF0000" }, 1900);
			//css("border","3px solid red")
			</script>
			<?
		}
		
		unset($objekteInHG);
		unset($leihenProHauptgruppe);	
	}
}
?>