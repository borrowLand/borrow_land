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


//warenkorb löschen nur möglich, wenn in wkEdit.php keine objekte existieren die noch zurückgegeben werden müssen
if (isset($_SESSION["User_ID"]) && isset($_GET['wi']) && $_GET['wi']!="" && ($_SESSION["User_Recht_Admin"]=="1" || $_SESSION["User_Recht_Ausgabeber"]=="1"))
{

$quelle = explode("|", $_GET['wi']);

$sql = "SELECT * FROM `06_wkObje` WHERE `abgeholt` IS NOT NULL AND `gebracht` IS NULL AND wkid = \"".mysql_real_escape_string(unserialize(base64_decode($quelle[0])))."\""; 
$DataAbgObj = mysql_query($sql);
$anzahl = mysql_num_rows($DataAbgObj); 


	//es gibt keine objekte die draussen herumschwirren, reservierte objekte werden gelöscht, abgegebende auch.
	if ($anzahl=="0")
	{
		$sql = "SELECT `owner` FROM `05_wk` WHERE `specid_wk` = \"".mysql_real_escape_string(unserialize(base64_decode($quelle[0])))."\" LIMIT 1 "; 
		$WKusr = mysql_query($sql);
		$row = mysql_fetch_row($WKusr);			
		$nameBesitzer=$row[0];	
		
		
		$sql = "DELETE FROM `05_wk` WHERE `specid_wk` = \"".mysql_real_escape_string(unserialize(base64_decode($quelle[0])))."\" LIMIT 1"; 
		$delWK = mysql_query($sql);
		$anzahlDELWK = mysql_affected_rows(); 

		if ($anzahlDELWK=="1")
		{
			$sql = "DELETE FROM `06_wkObje` WHERE `wkid` = \"".mysql_real_escape_string(unserialize(base64_decode($quelle[0])))."\""; 
			$delWK = mysql_query($sql);
			$anzahlDELobje = mysql_affected_rows(); 

			if ($anzahlDELobje>0)
			{
			$jetzt= new DateTime();
			$dbDelData=$jetzt->format('U');
			
			
			$nameLoescher=benutzerDaten($_SESSION["User_ID"]);
			
			//für E-Mail
			$DatenBesitzer=benutzerDaten($nameBesitzer);
			
			
				if ($quelle[1]!="")
				{
				$bemerkungAdmin=mysql_real_escape_string($quelle[1]);
				}
				
				
				//warenkorb wird in die history aufgenommen
				$sql = 'INSERT INTO `07_wkHistory` (`specid_wk`, `owner`, `geloescht_am`, `bemerkungen`) VALUES (\''.mysql_real_escape_string(unserialize(base64_decode($quelle[0]))).'\', \''.$nameBesitzer.'\', \''.$dbDelData.'\', \''.utf8_decode("Warenkorb wurde von ".$nameLoescher[0]." gelöscht.".$bemerkungAdmin).'\');'; 
				$delProt= mysql_query($sql);
				$delProtAnz = mysql_affected_rows(); 
				//ende history aufnahme.
				
				
				//alles okay, loeschung & protokollierung
				if ($delProtAnz>0)
				{
					?>
					<script>
					$.pnotify({
					pnotify_title: 'Warenkorb-Löschung',
					pnotify_text: 'Der Warenkorb wurde erfolgreich gelöscht.',
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
					if ($quelle[2]=="true" || $quelle[2]=="checked")
					{
					//mail versenden
					$empfaenger=$DatenBesitzer[3];						
					$betreff="Löschung Reservierung ".$_SESSION["SE_Kundenname"];
					$nachricht="Sehr geehrter Kunde,\r\n\r\nIhre Reservierung:\r\n\r\n\r\nw-".unserialize(base64_decode($quelle[0]))."\r\n\r\n\r\nmusste leider zurückgenommen werden.\r\n\r\nAls Grund wurde angegeben:\r\n\r\n".$bemerkungAdmin."\r\n\r\n\r\n\r\nIhr Ausleihteam.\r\n\r\n\r\n\r\n\r\n--\r\n\r\nErstellt mit http://www.borrow-land.de";
					$header="From: \"Ausleihe ".$_SESSION["SE_Kundenname"]. "\" <".$_SESSION["SE_adminEMail"].">";				
					mail(htmlentities($empfaenger, ENT_QUOTES),utf8_decode($betreff),utf8_decode($nachricht),$header);
					}
				}
				else
				{
				?>
				<script>
				$.pnotify({
				pnotify_title: 'Fehler Warenkorb-Löschung',
				pnotify_text: 'Der Warenkorb wurde nicht erfolgreich gelöscht.',
				pnotify_type: 'error',
				});
				</script>
				<?
				}
				
				
				
				
				
				
				
			}
		}
	}



}
?>