<?

session_start();


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
//$_GET['o']

if (isset($_SESSION["User_ID"]))
{
	//echo unserialize(base64_decode($_GET['w']));

	//sind objekte des wk in der aktiven leihe? falls ja, wird der wk definitiv nicht gelöscht.
	$sql3 = "SELECT id FROM `06_wkObje` WHERE `wkid` = \"".mysql_real_escape_string(unserialize(base64_decode($_GET['w'])))."\" AND `abgeholt` IS NOT NULL";
	$objekteInLeihe = mysql_query($sql3);
	$anzahlobjekteInLeihe = mysql_num_rows($objekteInLeihe);
	
	if ($anzahlobjekteInLeihe=="0")
	{
		$sql = "DELETE FROM `05_wk` WHERE `owner` = \"".$_SESSION["User_ID"]."\" AND `specid_wk` = \"".mysql_real_escape_string(unserialize(base64_decode($_GET['w'])))."\" AND `fuer_dritte` =0 LIMIT 1"; 
		$delWK = mysql_query($sql);
		$anzahlDELWK = mysql_affected_rows(); 

		if ($anzahlDELWK=="1")
		{
			$sql = "DELETE FROM `06_wkObje` WHERE `wkid` = \"".mysql_real_escape_string(unserialize(base64_decode($_GET['w'])))."\""; 
			$delWK = mysql_query($sql);
			$anzahlDELobje = mysql_affected_rows(); 

			if ($anzahlDELobje>0)
			{
			$jetzt= new DateTime();
			$dbDelData=$jetzt->format('U');
			
			//warenkorb wird in die history aufgenommen
			$sql = 'INSERT INTO `07_wkHistory` (`specid_wk`, `owner`, `geloescht_am`, `bemerkungen`) VALUES (\''.mysql_real_escape_string(unserialize(base64_decode($_GET['w']))).'\', \''.$_SESSION["User_ID"].'\', \''.$dbDelData.'\', \''.utf8_decode("Warenkorb wurde vom Kunden selbst gelöscht.").'\');'; 
			$delProt= mysql_query($sql);
			$delProtAnz = mysql_affected_rows(); 
			//ende history aufnahme.
			
				if ($delProtAnz>0)
				{
					$sql = "SELECT specid_wk FROM `05_wk` WHERE `owner` = \"".$_SESSION["User_ID"]."\""; 
					$ReservWK = mysql_query($sql);
					$anzahlWK = mysql_num_rows($ReservWK); 

					//löschung und protokolleintrag erfolgreich.
					if ($anzahlWK>0)
					{
						if ($anzahlWK=="1")
						{
						echo "Von Ihnen liegt uns derzeit eine Reservierung vor.";
						}
						else
						{
						echo "Von Ihnen liegen uns derzeit ".$anzahlWK." Reservierungen vor.";
						}

				
					?>
					<script>
					$.pnotify({
					pnotify_title: 'Warenkorb-Löschung',
					pnotify_text: 'Der gewählte Warenkorb wurde erfolgreich gelöscht.',
					});
					$("#<? echo "s_".htmlspecialchars($_GET['w']); ?>").slideToggle().remove();
					$("tr[id^=w_<? echo htmlspecialchars($_GET['w']); ?>]").remove();
					</script>
					<?
					}
					//wenn keine warenkörbe mehr, dann alles weg.
					else
					{
					echo "Es liegen keine Reservierungen mehr vor.";
					?>
					<script>
					$.pnotify({
					pnotify_title: 'Warenkorb-Löschung',
					pnotify_text: 'Der gewählte Warenkorb wurde erfolgreich gelöscht.',
					});
					$("#<? echo "s_".htmlspecialchars($_GET['w']); ?>").remove();
					$("tr[id^=w_<? echo htmlspecialchars($_GET['w']); ?>]").remove();
					$("#wk_overview").remove();
					$("#pdfOutput").remove();
					$("#wkPDF").remove();
					</script>
					<?
					
					}
				}
			}
		}
		else
		{
		?>
		<br><br><br>
		<script>
		$.pnotify({
		pnotify_title: 'Warenkorb-Löschung',
		pnotify_text: 'Der gewählte Warenkorb wurde nicht erfolgreich gelöscht.',
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
	pnotify_title: 'Warenkorb-Löschung',
	pnotify_text: 'Der gewählte Warenkorb wurde nicht erfolgreich gelöscht, Objekte des Warenkorbs befinden sich in der Leihe.',
	pnotify_type: 'error'
	});
	</script>
	<?
	}		
	
		
		
		
}
else
{

}
?>