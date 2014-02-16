<?


//bei fehlern keine meldung sondern log datei wird befüllt
if (ini_get('display_errors')==1 && ini_get('log_errors')==0)
{

ini_set('display_errors', 'off');
ini_set('log_errors', 'on');

//echo '<br><br><div class="meldung_fehler"><img src="BL_BILDER/Meldungen_Warning.png"> <br>SERV_ERR_01</div><br><br>';	
//exit;
}



//php6 kompatibel
if (ini_get('magic_quotes_gpc')==1)
{
echo '<br><br><div class="meldung_fehler"><img src="BL_BILDER/Meldungen_Warning.png"> <br>SERV_ERR_02</div><br><br>';	
exit;
}

//session id soll nicht an urls gehängt werden (sicherheit)
if (ini_get('session.use_trans_sid')!=0)
{
echo '<br><br><div class="meldung_fehler"><img src="BL_BILDER/Meldungen_Warning.png"> <br>SERV_ERR_03</div><br><br>';	
exit;
}


/*
Änderungen in der php.ini um diesen Fehler auszuschalten:

display_errors=off
log_errors=on
session.use_trans_sid=0

oder via Script

ini_set('display_errors', 'off');
ini_set('log_errors', 'on');

*/
 
?>