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

if (isset($_SESSION["User_ID"]) && isset($_GET['b']) && $_GET['b']!="" && $_SESSION["User_Recht_Admin"]=="1")
{

$teile = explode("|", $_GET['b']);
	for ($i=0;$i<count($teile);$i++)
	{

	// unserialize(base64_decode($teile[$i]))		name der hg(en) der gelöst werden soll	
		

	$name= benutzerDaten(unserialize(base64_decode($teile[$i])));

	//edit okay
	

	$jetzt= new DateTime();
	$jetztPur=$jetzt->format('U');

	$sql = "UPDATE `01_Benutzer` SET `userreg_bestaet` = \"".$jetztPur."\" WHERE `specid_cyrpt_md5` = \"".mysql_real_escape_string(unserialize(base64_decode($teile[$i])))."\" LIMIT 1;"; 					
	$loeschOkay = mysql_query($sql);			
	$erfolgOrNot=mysql_affected_rows();
			
		if ($erfolgOrNot=="1")
		{
							
			//anfang protokoll
			$nutzerGerade=benutzerDaten($_SESSION["User_ID"]);
			
			if ($_SESSION["SE_ProtokollAnAus"]==1)
			{
			protokollEintrag("1","2","Der Benutzer ".$name[0]." wurde von ".$nutzerGerade[0]." bestätigt.");
			}
			//ende protokoll
			
			
			?>
			<script>
			$.pnotify({
			pnotify_title: 'Bestätigung Nutzer',
			pnotify_text: 'Der Nutzer <? echo htmlspecialchars($name[0]); ?> wurde erfolgreich bestätigt.',
			});
			$("input[value='<? echo strip_tags($teile[$i]); ?>']").closest("td").replaceWith("<td bgcolor=\"green\"><font color=\"white\">Bestätigt</font></td>");
			</script>
			<?
		}
		else
		{
			?>
			<script>
			$.pnotify({
			pnotify_title: 'Bestätigung Nutzer',
			pnotify_text: 'Der Nutzer <? echo htmlspecialchars($name[0]); ?> wurde nicht erfolgreich bestätigt.',
			pnotify_type: 'error',
			});
			</script>
			<?
		}


		
	}
}
?>