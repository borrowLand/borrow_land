<?
if (welcheEinstellung("SE_VerfallAccountTag")!="0")
{
	//wähle die nutzer registrierungsdatums-daten aus, bei usern, die sich noch nicht selbst eingeloggt haben
	$sql = 'SELECT `userreg_selbst`, `specid_cyrpt_md5`, `vn_nn` FROM `01_Benutzer` WHERE lastlogin=0 '; 
	$rs= mysql_query($sql);
	$num_rows = @mysql_num_rows($rs);		//mysql_num_rows nur bei select

	if ($num_rows>0 )		
	{
		while ($row = mysql_fetch_array($rs, MYSQL_NUM))
		{
		$VerfallUmrechnungVonTageAufSekunden=(welcheEinstellung("SE_VerfallAccountTag") * 86400)+$row[0];
		//echo $VerfallUmrechnungVonTageAufSekunden."XX";
		$aktuellerZeitstempel= new DateTime();
		$aktuelleZeit=$aktuellerZeitstempel->getTimestamp();
		//echo $aktuelleZeit."X".$row[1]."<br><br>";

			if ( $aktuelleZeit >= $VerfallUmrechnungVonTageAufSekunden )
			{
			$ZeitVerfallen=new DateTime;
			$ZeitVerfallen->setTimestamp($VerfallUmrechnungVonTageAufSekunden);
			//echo $ZeitVerfallen->format('d.m.Y G.i.s ')."<br>";  //anzeige aller benutzer, die gelöscht werden sollen
					
					$sql2 = "DELETE FROM `01_Benutzer` WHERE `specid_cyrpt_md5` = '".$row[1]."'"; 
					$rs2= @mysql_query($sql2);

				//anfang protokoll
				if (welcheEinstellung("SE_ProtokollAnAus")==1)
				{
				protokollEintrag("4","2","Benutzer ".utf8_encode($row[2])." wurde automatisch gelöscht. Grund: Ablauf im möglichen Anmeldezeitraum");
				}
				//ende protokoll
			}
		}
	}
}
?>