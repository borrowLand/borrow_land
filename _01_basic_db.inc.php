<?

$conn=@mysql_connect("<DEIN SERVER MIT ODER OHNE PORT>","<DEIN BENUTZERNAME>","<DEIN PASSWORT>") or die('<br><br><div class="meldung_fehler"><img src="BL_BILDER/Meldungen_Warning.png"> <br>DB_ERR_01</div><br><br>');
@mysql_select_db("<DER DATENBANKNAME>",$conn) or die('<br><br><div class="meldung_fehler"><img src="BL_BILDER/Meldungen_Warning.png"> <br>DB_ERR_02</div><br><br>'); 

?>