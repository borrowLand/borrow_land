<?
session_start();


//System 
/////////////////////////////////////////////
$includeName="../../_00_basic_check.inc.php";
if (file_exists($includeName))
{
require($includeName);
}	
else
{
echo '<br><br><div class="meldung_fehler"><img src="../../BL_BILDER/Meldungen_Warning.png"> <br>CHECK_ALL_LOAD_01</div><br><br>';	
exit();
}

/////////////////////////////////////////////

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


?>

<!DOCTYPE html> 
<html>
<head>
<?
echo eval(welcheEinstellung("SE_headBereich"));
?>
</head>


<body>
<NOSCRIPT>
<br><br><br><br><div class="meldung_fehler"><img src="../../BL_BILDER/Meldungen_Warning.png">Diese Webseite läuft leider nur, wenn Sie <a href="http://de.wikipedia.org/wiki/Javascript" target="_blank">Javascript</a> zulassen. <br>Bitte aktivieren Sie diesen technischen Standard in Ihrem Browser, Danke!</div>
<br><br>
</NOSCRIPT>	
		
<section id="page"> <!-- Defining the #page section with the section tag -->


            <header> <!-- Defining the header section of the page with the appropriate tag -->
            
<?
//#############Anfang Überschrift
?>
<hgroup><h1><a href="../../index.php" title="Startseite"><img src="../../BL_BILDER/start_00.png"></a> <a href="../../index.php" title="Startseite">borrow land</a></h1>
<?
//anfang namensanzeige, nur für benutzerbereich
$nutzerInfos=benutzerDaten($_SESSION["User_ID"]);
//ende namensanzeige, nur für benutzerbereich
$oeffentlich=0;
if ($oeffentlich=="1")
{
?>
<div id="ueberschr_all"><a href="../../">/Leihe</a><a href="../">/Benutzer</a>/Passwort-Änderung</div>
</hgroup>
<?
}
else
{
	if (isset($_SESSION["User_ID"]) && $_SESSION["User_ID"]!="")
	{	
	?>
	<div id="ueberschr_all"><a href="../../">/Leihe</a><a href="../">/<? echo utf8_encode(htmlspecialchars($nutzerInfos[0])); ?></a>/Passwort-Änderung</div>
	</hgroup>
	<?
	}
}
//#############Ende Überschrift	

	//navigation
	/////////////////////////////////////////////
	$includeName="../../_00_basic_nav.inc.php";
	if (file_exists($includeName))
	{
	require($includeName);
	}	
	else
	{
	echo '<br><br><div class="meldung_fehler"><img src="BL_BILDER/Meldungen_Warning.png"> <br>SESS_FU_LOAD_01</div><br><br>';	
	exit();
	}
	/////////////////////////////////////////////
?>
			
            </header>
            <section id="articles"> 

	
	
<?

if (isset($_SESSION["User_ID"]) && isset($_POST["field_pw1"]) && isset($_POST["field_pw2"]) && isset($_POST["field_pw3"]) && $_POST["field_pw1"]!="" && $_POST["field_pw2"]!="" && $_POST["field_pw3"]!="" && $_SESSION["pwChg_ctrl1"]=== $_POST["dmh83vhW4"])
{
unset($fehlerPwChg);


	if ($_POST["field_pw2"]!=$_POST["field_pw3"])
	{
	$fehlerPwChg[]="Das neue Passwort wurde in beiden Eingabefeldern zweimal unterschiedlich eingegeben.";
	}
	
	if (strlen($_POST["field_pw2"])<6)
	{
	$fehlerPwChg[]="Das neue Passwort (1. Eingabefeld) enthielt nicht mind. 6 Zeichen.";
	}

	if (strlen($_POST["field_pw3"])<6)
	{
	$fehlerPwChg[]="Das neue Passwort (2. Eingabefeld) enthielt nicht mind. 6 Zeichen.";
	}
	
	if (strlen($_POST["field_pw3"])>49)
	{
	$fehlerPwChg[]="Das Passwort hat mehr als 50 Zeichen.";
	}
	
	if (ctype_alnum($_POST["field_pw3"]) != TRUE || ctype_alnum($_POST["field_pw2"]) != TRUE)
	{
	$fehlerPwChg[]="Das Passwort darf nur Zahlen und Buchstaben enthalten.";
	}

	if ($_POST["field_pw2"]==$_POST["field_pw3"] && $_POST["field_pw1"]==$_POST["field_pw3"] && $_POST["field_pw1"]==$_POST["field_pw2"])
	{
	$fehlerPwChg[]="Das neue Passwort entspricht dem alten Passwort.";
	}

	if (!isset($fehlerPwChg))
	{

		$sql = "SELECT pw_hash,email FROM `01_Benutzer` WHERE `specid_cyrpt_md5` = '".$_SESSION["User_ID"]."' LIMIT 1";
		$rsd = mysql_query($sql);
		$msg = @mysql_num_rows($rsd); //1 die mail adresse gibt es => okay
		
		
		if($msg=="1") //der angemeldete benutzer hat das passwort $DatabaseUserPW[0]
		{
		
		//hinterlegtes pw datenbank 
		$DatabaseUserPW= mysql_fetch_row($rsd); 
		
		//vormaliges userseitiges pw 
		$userOldPW=FUNK_VerSchluesseln(trim($_POST["field_pw1"]));
		
			if ($DatabaseUserPW[0] === $userOldPW) //nur wenn db pw und user gecryptes pw übereinstimmt, kann pw geändert werden.
			{
				$sql = 'UPDATE `01_Benutzer` SET `pw_hash` = \''.FUNK_VerSchluesseln($_POST["field_pw2"]).'\' WHERE `specid_cyrpt_md5` = \''.$_SESSION["User_ID"].'\' LIMIT 1;';
				$updaPW = mysql_query($sql); 
				$geaendertPWUserChg=mysql_affected_rows();
				
					if ($geaendertPWUserChg=="1")
					{
					$successPWUserChg=1;
					//anfang protokoll
					if ($_SESSION["SE_ProtokollAnAus"]==1)
					{
					protokollEintrag("3","1","Der Benutzer ".$DatabaseUserPW[1]." hat sein Passwort selbst geändert.");
					}
					//ende protokoll
					}	
					
					else //db fehler
					{
					$fehlerPwChg[]="Das neue Passwort konnte nicht gespeichert werden.";
					}
			
			}

			else //altes pw stimmt nicht überein -> fehler
			{
			$fehlerPwChg[]="Leider stimmt ihr jetziges Passwort nicht.";
			}
		}
	}
}
?>
	
	<?
	if (isset($_SESSION["User_ID"]))
	{
	//eingeloggt
	/////////////////////////////////////////////
	$includeName="01_loggedInPWChg.inc.php";
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
	}
	else
	{
	//nicht eingeloggt
	/////////////////////////////////////////////
	$includeName="../../_02_NoLoginAllPages.inc.php";
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
	
	}
	?>
			


            </section>

			
			
			
			
			
		
		 <?
		 if ($_SESSION["SE_GooTrans"]=="1")
		 {
					// Start Google Translate -->
   					echo $_SESSION["SE_GooTransScript"];
					// Ende Google Translate -->
		}
		?>		

			
<?
//Footer 
/////////////////////////////////////////////
$includeName="../../_00_basic_footer.php";
if (file_exists($includeName))
{
include_once($includeName);
}	
else
{
echo '<br><br><div class="meldung_fehler"><img src="../../BL_BILDER/Meldungen_Warning.png"> <br>FOOTER_FU_LOAD</div><br><br>';	
exit();
}

/////////////////////////////////////////////			
?>  
	        
 
		 

        
<!-- JavaScript Includes -->
<?
echo nl2br($_SESSION["SE_jQuerUI"]);
?>  
<script type="text/javascript" src="../../BL_JS/jquery.pstrength-min.1.2.js"></script>
<script type="text/javascript">
$(function() {
$('.password').pstrength();
});

$(".password").change( function() {
  
  if($('#field_pw2').val() == $('#field_pw3').val() && $('#field_pw2').val().length>=6 && $('#field_pw3').val().length>=6){
  ('#sendPWChg').hide();
  }
  
  
});

<?

if (count($fehlerPwChg)>0 )
{
	for ($i = 0; $i < count($fehlerPwChg); $i++)
	{
	echo "
	$.pnotify({
	pnotify_title: 'Fehler Passwort-Änderung',
	pnotify_text: '".$fehlerPwChg[$i]."',
	pnotify_type: 'error'
	});
	";
	}
}

if ($successPWUserChg =="1")
{

	echo "
	$.pnotify({
	pnotify_title: 'Änderung Passwort',
	pnotify_text: 'Ihr Passwort wurde erfolgreich geändert.',
	});
	$('#contentPWChg').hide();
	";
	
}
?>

</script>





<?
echo utf8_encode($_SESSION["SE_EndeIndex"]);
?>

<br><br><br><br><br><br>
</body>
</html>