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

if (isset($_SESSION["User_ID"]) && isset($_GET['u']) && $_GET['u']!="" && $_SESSION["User_Recht_Admin"]=="1")
{

$teile = explode("|", $_GET['u']);
	for ($i=0;$i<count($teile);$i++)
	{

	// unserialize(base64_decode($teile[$i]))		name der hg(en) der gelöst werden soll	
		
		//suche nach aktivierten objekten, die möglicherweise ausgeliehen worden sind
		$sql2 = "SELECT erstellt_am FROM `05_wk` WHERE `owner` = \"".mysql_real_escape_string(unserialize(base64_decode($teile[$i])))."\" "; 
		$UsrAktiveWKs = mysql_query($sql2);
		$Zeilen = mysql_num_rows($UsrAktiveWKs); 
		unset($UsrAktiveWKs);
		$name= benutzerDaten(unserialize(base64_decode($teile[$i])));
		
		//admin?
		if ($name[7]=="0" || $name[7]=="1")
		{
			?>
			<script>
			$.pnotify({
			pnotify_title: 'Löschen des Nutzers <? echo htmlspecialchars($name[0]); ?>',
			pnotify_text: 'Hauptadministratoren können nicht gelöscht werden.',
			pnotify_type: 'error',
			});
			$("input[value='<? echo strip_tags($teile[$i]); ?>']").closest("td").animate({ backgroundColor: "#FF0000" }, 1900);

			</script>
			<?
		}
		else
		{
			if ($Zeilen=="0")
			{
			//löschvorgang okay
			$sql = "DELETE FROM `01_Benutzer` WHERE `specid_cyrpt_md5` = \"".mysql_real_escape_string(unserialize(base64_decode($teile[$i])))."\" LIMIT 1"; 
			$loeschOkay = mysql_query($sql);			
			$erfolgOrNot=mysql_affected_rows();
					
				if ($erfolgOrNot=="1")
				{
				
					//anfang protokoll
					$nutzerGerade=benutzerDaten($_SESSION["User_ID"]);
					
					if ($_SESSION["SE_ProtokollAnAus"]==1)
					{
					protokollEintrag("1","0","Der Benutzer ".utf8_encode($name[0])." wurde von ".utf8_encode($nutzerGerade[0])." gelöscht.");
					}
					//ende protokoll
				
					?>
					<script>
					$.pnotify({
					pnotify_title: 'Löschen des Nutzers <? echo utf8_encode(htmlspecialchars($name[0])); ?>',
					pnotify_text: 'Der Benutzer wurde erfolgreich gelöscht.',
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
					pnotify_title: 'Löschen des Nutzers <? echo utf8_encode(htmlspecialchars($name[0])); ?>',
					pnotify_text: 'Der Benutzer wurde wegen einem Übertragungsfehler nicht gelöscht.',
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
				pnotify_title: 'Löschen des Nutzers <? echo utf8_encode(htmlspecialchars($name[0])); ?>',
				pnotify_text: 'Der Benutzer wurde nicht gelöscht, da mind. noch 1 Reservierung vorliegt.',
				pnotify_type: 'error',
				});
				$("input[value='<? echo strip_tags($teile[$i]); ?>']").closest("td").animate({ backgroundColor: "#FF0000" }, 1900);
				</script>
				<?
			}
		}
	}
}
?>