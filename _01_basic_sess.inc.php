<?


	//wieviele sessions sollen für die for schleife geladen werden?
	$sql = 'SELECT Desc_Session,InhaltDerEinstellung FROM `00_einstellungenSoftware` WHERE `SessionJaNein` = 1 '; 
	$rs= mysql_query($sql);
	$num_rows = @mysql_num_rows($rs);
	 
	if ($num_rows>0 && count($_SESSION)==NULL)		//Sessions werden nur erzeugt, wenn in der DB mind. 1 Eintrag ist und noch keine Sessions da sind
	{
		while ($row = mysql_fetch_array($rs, MYSQL_NUM))
		{
		$_SESSION[$row[0]] = $row[1];  
		}
	}
?>