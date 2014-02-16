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



if (isset($_SESSION["User_ID"]) && isset($_GET['x']) && $_GET['x']!="" && ($_SESSION["User_Recht_Admin"]=="1" || $_SESSION["User_Recht_Ausgabeber"]=="1"))
{
$quelle = explode("|", $_GET['x']);

//besitzer?
$sql = "SELECT `owner` FROM `05_wk` WHERE `specid_wk` = \"".mysql_real_escape_string(unserialize(base64_decode($quelle[0])))."\" LIMIT 1 "; 
$WKusr = mysql_query($sql);
$row = mysql_fetch_row($WKusr);			
$nameBesitzer=$row[0];

//alle items wk
$sql = "SELECT count(*) FROM `06_wkObje` WHERE `wkid` = \"".mysql_real_escape_string(unserialize(base64_decode($quelle[0])))."\"";
$DataObjLS4 = mysql_query($sql);
$anzahlItems = mysql_fetch_row($DataObjLS4);



//wk items, die abgeholt und  wiedergekommen sind.
$sql = "SELECT * FROM `06_wkObje` WHERE `abgeholt` IS NOT NULL AND `gebracht` IS NOT NULL AND wkid = \"".mysql_real_escape_string(unserialize(base64_decode($quelle[0])))."\""; 
$DataObjRg = mysql_query($sql);
$anzahl = mysql_num_rows($DataObjRg); 
//nur wenn die anzahl aller wk items mit der anzahl der weder abgeholten/wiedergekommenden entspricht, wird der wk gelöscht.
	
	if ($anzahl==$anzahlItems[0] && $quelle[1]=="mFahd3C*t")
	{
		//warenkorb löschen
		$sql = "DELETE FROM `05_wk` WHERE `specid_wk` = \"".mysql_real_escape_string(unserialize(base64_decode($quelle[0])))."\" LIMIT 1"; 
		$delWK = mysql_query($sql);
		$anzahlDELWK = mysql_affected_rows(); 

		if ($anzahlDELWK=="1")
		{
			//alle items aus dem wk
			$sql = "DELETE FROM `06_wkObje` WHERE `wkid` = \"".mysql_real_escape_string(unserialize(base64_decode($quelle[0])))."\""; 
			$delWK = mysql_query($sql);
			$anzahlDELobje = mysql_affected_rows(); 

			$nameLoescher=benutzerDaten($_SESSION["User_ID"]);
			
				//warenkorb wird in die history aufgenommen
				$sql = 'INSERT INTO `07_wkHistory` (`specid_wk`, `owner`, `geloescht_am`, `bemerkungen`) VALUES (\''.mysql_real_escape_string(unserialize(base64_decode($quelle[0]))).'\', \''.$nameBesitzer.'\', \''.time().'\', \''.utf8_decode("Warenkorb wurde von ".$nameLoescher[0]." gelöscht. Der Warenkorb wurde nach Rückgabe aller Objekte gelöscht.").'\');'; 
				$delProt= mysql_query($sql);
				$delProtAnz = mysql_affected_rows(); 
				//ende history aufnahme.
			
				//wenn protokoll okay und alle items gelöscht wurde, alles okay!
				if ($anzahlDELobje>0 && $delProtAnz=="1")
				{
				?>
				<script>
				$.pnotify({
				pnotify_title: 'Rückgabe & Warenkorb Löschung',
				pnotify_text: 'Alle reservierten Objekte wurden als zurückgegeben markiert. Der Warenkorb wurde erfolgreich gelöscht.'
				});
				$("#articleLogin2").remove();
				</script>
				<article id="articleLogin5"> 
				<h2>Warenkorb Eigenschaften</h2>
					
					<div class="line"></div>
					<div class="articleBody clear" >
					<a href="index.php" class="fg-button ui-state-default ui-corner-all" style="margin-bottom:10px;float:right">Übersicht</a>

					Der Warenkorb wurde erfolgreich gelöscht.
					</div>
				</article>
				<?
				}
				else
				{
				?>
				<script>
				$.pnotify({
				pnotify_title: 'Rückgabe & Warenkorb Löschung',
				pnotify_text: 'Schwerer Fehler bei der Warenkorb Löschung.',
				pnotify_type: 'error',
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
		pnotify_title: 'Rückgabe & Warenkorb Löschung',
		pnotify_text: 'Fehler bei der Warenkorb Löschung.',
		pnotify_type: 'error',
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
	pnotify_title: 'Rückgabe & Warenkorb Löschung',
	pnotify_text: 'Der Warenkorb wurde nicht gelöscht, die Objekte wurden als zurückgegeben markiert.',
	pnotify_type: 'error',
	});
	location.reload();
	</script>
	<?	
	}
	
	
	
	
}
?>