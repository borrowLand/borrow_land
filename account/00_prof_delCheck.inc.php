<?
session_start();



//Datenbank Verbindung
/////////////////////////////////////////////
$includeName="../_01_basic_db.inc.php";
if (file_exists($includeName))
{
require($includeName);
}	
else
{
echo '<br><br><div class="meldung_fehler"><img src="../BL_BILDER/Meldungen_Warning.png"> <br>DB_FU_LOAD_01</div><br><br>';	
exit();
}

/////////////////////////////////////////////


//Funktionen 
/////////////////////////////////////////////
$includeName="../_00_basic_func.inc.php";
if (file_exists($includeName))
{
require($includeName);
}	
else
{
echo '<br><br><div class="meldung_fehler"><img src="../BL_BILDER/Meldungen_Warning.png"> <br>FU_ALL_LOAD_01</div><br><br>';	
exit();
}

/////////////////////////////////////////////

//Sessions
/////////////////////////////////////////////
$includeName="../_01_basic_sess.inc.php";
if (file_exists($includeName))
{
require($includeName);
}	
else
{
echo '<br><br><div class="meldung_fehler"><img src="../BL_BILDER/Meldungen_Warning.png"> <br>SESS_FU_LOAD_01</div><br><br>';	
exit();
}

/////////////////////////////////////////////



	if (isset($_SESSION["User_ID"]))
	{

		//hat der benuter die super-id 1?! dann kann der benutzer nicht gelsöcht werden
		$sql = "SELECT id,vn_nn FROM 01_Benutzer WHERE specid_cyrpt_md5 = \"".$_SESSION["User_ID"]."\" LIMIT 1"; 
		$NummerData = mysql_query($sql);
		$welcheID = mysql_fetch_row($NummerData);

		//superid ist nicht oder 1, löschen ist okay
		if ($welcheID[0]!="1" && $welcheID[0]!="0")
		{
			$sql = "SELECT count(*) as anzahl FROM `05_wk` WHERE `owner` = \"".$_SESSION["User_ID"]."\" LIMIT 1"; 
			$abfrageWKs = mysql_query($sql);
			$DatenAbfrage = mysql_fetch_row($abfrageWKs);

			//es sind keine warenkörbe aktiv, profil kann gelöscht werden
			if ($DatenAbfrage[0]=="0")
			{
			$sql = "DELETE FROM `01_Benutzer` WHERE `specid_cyrpt_md5` = \"".$_SESSION["User_ID"]."\" LIMIT 1"; 
			$UserDEL = mysql_query($sql);
		
				if (mysql_affected_rows()=="1")
				{
					//anfang protokoll
					if ($_SESSION["SE_ProtokollAnAus"]==1)
					{
					protokollEintrag("1","0","Der Benutzer ".$welcheID[1]." wurde gelöscht. Grund: Benutzer-Datenlöschung.");
					}
					//ende protokoll
					?>
					<script>
					$.pnotify({
					pnotify_title: 'Profil löschen',
					pnotify_text: 'Ihr Profil wurde erfolgreich gelöscht.',
					});
					$("#articleLogin1").remove();
					$("#articleLogin2").remove();
					$("#RechtsOben").remove();
					</script>
						
					<article id="articleLogin99"> 
					<h2>Löschung des Profils</h2>
					<div class="line"></div>
					<div class="articleBody clear">Ihr Profil wurde erfolgreich gelöscht. <br>Vielen Dank für die Nutzung von borrow land!<br><br>
					<a href='../'>Beenden</a></div>
					</article>
					<?
					
					//Session Daten löschen 
					/////////////////////////////////////////////
					$includeName="../_04_logoutSess.inc.php";
					if (file_exists($includeName))
					{
					require($includeName);
					}	
					else
					{
					echo '<br><br><div class="meldung_fehler"><img src="BL_BILDER/Meldungen_Warning.png"> <br>CHECK_ALL_LOAD_01</div><br><br>';	
					exit();
					}

					/////////////////////////////////////////////
					session_destroy();
				}
				else
				{
					?>
					<script>
					$.pnotify({
					pnotify_title: 'Profil löschen',
					pnotify_text: 'Ihr Profil wurde leider nicht erfolgreich gelöscht. Bei Fragen wenden Sie sich bitte an <? echo $_SESSION["SE_adminEMail"]; ?>',
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
			pnotify_title: 'Profil löschen',
			pnotify_type: 'error',
			pnotify_text: 'Ihr Profil konnte nicht gelöscht werden, da Sie derzeit noch Warenkörbe reserviert haben. Bitte löschen Sie diese vorher <a href="basketControl"><b>hier</b></a>.'
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
		pnotify_title: 'Profil löschen',
		pnotify_text: 'Als Administrator kann Ihr Konto nicht gelöscht werden.',
		pnotify_type: 'error'
		});
		</script>
		<?
		}
}


?>
