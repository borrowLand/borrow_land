<?

session_start();
if(isset($_POST['a']))
{
$email = trim($_POST['a']);

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
//Datenbank Verbindung
/////////////////////////////////////////////
$includeName="../_01_basic_db.inc.php";
if (file_exists($includeName))
{
require($includeName);
}	

else
{
//echo '<br><br><div class="meldung_fehler"><img src="../BL_BILDER/Meldungen_Warning.png"> <br>DB_FU_LOAD_01</div><br><br>';	
exit();
}

/////////////////////////////////////////////

if(eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email))
{
	$sql = "SELECT id FROM `01_Benutzer` WHERE `email` = '".mysql_real_escape_string(htmlentities($email, ENT_QUOTES))."'";
	$rsd = mysql_query($sql);
	$msg = mysql_num_rows($rsd); //0 die mail adresse gibts nicht=> okay
	
							//anfang protokoll
							if ($_SESSION["SE_ProtokollAnAus"]==1 && $msg!=0)
							{
							protokollEintrag("2","1","Die Mail Adresse ".mysql_real_escape_string(htmlentities($email, ENT_QUOTES))." wurde versucht bei der Registrierung (vor Übersendung der Daten an den Server) anzugeben, obwohl ein Nutzer mit dieser Adresse schon vergeben ist.  IP:".getenv('REMOTE_ADDR'));
							}
							//ende protokoll

}
else
{
$msg = "invalid";
}
echo $msg;

}

?>
