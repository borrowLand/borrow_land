<?
session_start();

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
echo '<br><br><div class="meldung_fehler"><img src="../BL_BILDER/Meldungen_Warning.png"> <br>DB_FU_LOAD_01</div><br><br>';	
exit();
}

/////////////////////////////////////////////

if(isset($_POST['c']) && isset($_POST['d']))
{

$response= $_POST['c'];
$challenge  = trim($_POST['d']);

//
		require_once('recaptchalib.php');
		  $privatekey = welcheEinstellung("SE_reCap_private");
		  $resp = recaptcha_check_answer ($privatekey,
										$_SERVER["REMOTE_ADDR"],
										$challenge,
										$response);
		
		  if (!$resp->is_valid) {
			$msg = "invalid";
			$_SESSION["reg_reCap"]=0;
				
		  } else {
			$msg = "0";
			$_SESSION["reg_reCap"]=1;
		  }
echo $msg;
}

?>
