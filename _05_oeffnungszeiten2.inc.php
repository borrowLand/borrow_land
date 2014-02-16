<?
session_start();

//Datenbank Verbindung
/////////////////////////////////////////////
$includeName="_01_basic_db.inc.php";
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

//Sessions
/////////////////////////////////////////////
$includeName="_01_basic_sess.inc.php";
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

if (isset($_SESSION["User_ID"]) && $_GET['id2']!="")
{

$datum=$_GET['id2'];
$date = DateTime::createFromFormat('d.m.Y', $datum);
$datum=@$date->format('N'); //1 (für Montag) bis 7 (für Sonntag)

$minutenAufschlag=60/$_SESSION["SE_IntervStunde"]; //z.B. SE_IntervStunde=4 -> 60/4=15 min

switch ($datum) {
    case 1:
        $geschlossOderNichtSess="SE_MoGeschlOderZeite";
		$off11="SE_MoOffen11";
		$off12="SE_MoOffen12";
		$off21="SE_MoOffen21";
		$off22="SE_MoOffen22";
        break;
		
		case 2:
        $geschlossOderNichtSess="SE_DiGeschlOderZeite";
		$off11="SE_DiOffen11";
		$off12="SE_DiOffen12";
		$off21="SE_DiOffen21";
		$off22="SE_DiOffen22";
        break;
		
		case 3:
        $geschlossOderNichtSess="SE_MiGeschlOderZeite";
		$off11="SE_MiOffen11";
		$off12="SE_MiOffen12";
		$off21="SE_MiOffen21";
		$off22="SE_MiOffen22";
        break;
		
		case 4:
        $geschlossOderNichtSess="SE_DoGeschlOderZeite";
		$off11="SE_DoOffen11";
		$off12="SE_DoOffen12";
		$off21="SE_DoOffen21";
		$off22="SE_DoOffen22";
        break;
		
		case 5:
        $geschlossOderNichtSess="SE_FrGeschlOderZeite";
		$off11="SE_FrOffen11";
		$off12="SE_FrOffen12";
		$off21="SE_FrOffen21";
		$off22="SE_FrOffen22";
        break;
		
		case 6:
        $geschlossOderNichtSess="SE_SaGeschlOderZeite";
		$off11="SE_SaOffen11";
		$off12="SE_SaOffen12";
		$off21="SE_SaOffen21";
		$off22="SE_SaOffen22";
        break;
		
		case 7:
        $geschlossOderNichtSess="SE_SoGeschlOderZeite";
		$off11="SE_SoOffen11";
		$off12="SE_SoOffen12";
		$off21="SE_SoOffen21";
		$off22="SE_SoOffen22";
        break;
    
}
//öffnuungszeiten für wochentage

//anfang wochentag
if ($_SESSION[$geschlossOderNichtSess]=="1")
{
echo '<select id="zeitEnde" style="width:143px;">
      <option value="-" selected="selected">Auswahl</option>';

	//erste oeffnungszeit
	if ($_SESSION[$off11]!="-" || $_SESSION[$off12]!="-")
	{
		for ($i=$_SESSION[$off11];$i<$_SESSION[$off12];$i++)
		{
			for ($j=0;$j<$_SESSION["SE_IntervStunde"];$j++)
			{
				$minuten=$j*$minutenAufschlag;
				if ($minuten=="0")
				{
				$minuten="00";
				}
			echo '<option value="'.$i.'.'.$minuten.'">'.$i.'.'.$minuten.' Uhr</option>';
			}
		}
		echo '<option value="'.$i.'.00">'.$i.'.00 Uhr</option>';

	}

	if ($_SESSION[$off21]!="-" || $_SESSION[$off22]!="-")
	{
	//zweite oeffnungszeit
		for ($i=$_SESSION[$off21];$i<$_SESSION[$off22];$i++)
		{
			for ($j=0;$j<$_SESSION["SE_IntervStunde"];$j++)
			{
				$minuten=$j*$minutenAufschlag;
				if ($minuten=="0")
				{
				$minuten="00";
				}
			echo '<option value="'.$i.'.'.$minuten.'">'.$i.'.'.$minuten.' Uhr</option>';
			}
		}
		echo '<option value="'.$i.'.00">'.$i.'.00 Uhr</option>';
	}	
echo '</select>';
	
}
//ende wochentag
}
else
{
		?>
		<script>
		$.pnotify({
		pnotify_title: 'Angabe Enddatum',
		pnotify_text: 'Es fehlt die Angabe des Enddatums.',
		pnotify_type: 'error'
		});
		</script>	
		<?	

}
?>

