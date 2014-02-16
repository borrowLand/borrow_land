<?

if (welcheEinstellung("SE_VerfallWkTag")!="0")
{
$VerfallUmrechnungVonTageAufSekunden=(welcheEinstellung("SE_VerfallWkTag") * 86400);

	//alle warenkörbe aufrufen
	$sql = 'SELECT specid_wk,owner FROM `05_wk`'; 
	$rs= mysql_query($sql);
	$num_rows = @mysql_num_rows($rs);

	if ($num_rows>0 )		
	{
		while ($row = mysql_fetch_array($rs, MYSQL_NUM))
		{
		//jeder wk wird im leihtable nachgesehen
		//echo $row[0]."<br>";
		$sql2 = "SELECT von,bis,abgeholt,gebracht,wkid FROM `06_wkObje` WHERE `wkid` = \"".$row[0]."\" "; 
		$rs2= mysql_query($sql2);
		$num_rows2 = @mysql_num_rows($rs2);
		
			//wenn wk mehr als eine leihe beinhaltet => nachsehen
			if ($num_rows2>0 )		
			{
							
				while ($row2 = mysql_fetch_array($rs2, MYSQL_NUM))
				{
				$aktuellerZeitstempel= new DateTime();
				$aktuelleZeit=$aktuellerZeitstempel->getTimestamp();
				$zeitVgl=$VerfallUmrechnungVonTageAufSekunden+$row2[1];
				
				
					//objekt wurde nur angefragt, keine fertige ausleihe
					if ($row2[2]=="" && $row2[3]=="" && $aktuelleZeit>=$zeitVgl)
					{
					//echo $row2[4]."<br>";
					$droppix++;
					}
					
					//objekt wurde angefragt, leihe ist fertig
					if ($row2[2]!="" && $row2[3]!="" && $aktuelleZeit>=$zeitVgl)
					{
					//echo $row2[4]."<br>";
					$droppix++;
					}
				$WKN=$row2[4];
				}
				
				//wk löschen wenn anzahl suchdurchlauf mit anzahl elemente wk übereinstimmt
				if ($droppix==$num_rows2)
				{
				//echo $WKN."<br>";
				//archiv verschiebung
				
				//warenkorb wird in die history aufgenommen
				$sql = 'INSERT INTO `07_wkHistory` (`specid_wk`, `owner`, `geloescht_am`, `bemerkungen`) VALUES (\''.$WKN.'\', \''.$row[1].'\', \''.time().'\', \''.utf8_decode("Warenkorb wurde automatisch gelöscht, da alle Objekte die Vorhaltehaltezeit überschritten haben.").'\');'; 
				$delProt= mysql_query($sql);
				$delProtAnz = mysql_affected_rows(); 
				//ende history aufnahme.
					
					//erfolgreich kopiert, jetzt wird gelöscht
					if ($delProtAnz=="1")
					{
					$sql = "DELETE FROM `05_wk` WHERE `specid_wk` = \"".$WKN."\""; 
					$delWK = mysql_query($sql);
					$anzahlDELobje = mysql_affected_rows(); 
					
					$sql2 = "DELETE FROM `06_wkObje` WHERE `wkid` = \"".$WKN."\""; 
					$delWK2 = mysql_query($sql2);
					$anzahlDELobjeEinz = mysql_affected_rows();					

						//es war alles okay, protokoll eintrag
						if ($anzahlDELobje=="1" && $anzahlDELobjeEinz>=1)
						{
							//anfang protokoll
							if (welcheEinstellung("SE_ProtokollAnAus")==1)
							{
							protokollEintrag("4","1","Der Warenkorb w-".$WKN." wurde automatisch gelöscht. Grund: Ablauf Vorhaltezeit von ".welcheEinstellung("SE_VerfallWkTag")." Tagen.");
							}
							//ende protokoll
						}
					}
				}
				unset($droppix);
			}
		}
	}
}


?>