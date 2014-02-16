<?
session_start();

	if (isset($_SESSION["User_ID"]))
	{
	
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

//sinn dieser datei: warenkorb -> datenbank
//var_dump($_SESSION["User_WK"]);


	if (count($_SESSION["User_WK"])>0)
	{
		//festlegung eineindeutige id für warenkörbe
		$unique_wkid=sha1(uniqid(microtime(),1));
		
		//check ob id schon verwendet wurde, falls ja abbruch und aufforderung nochmal zu reserviren => neue erzeugung id
		$sql = 'SELECT * FROM `05_wk` WHERE `specid_wk` = \''.$unique_wkid.'\'  '; 
		$rs1=mysql_query($sql);
		$num_rows = mysql_num_rows($rs1); 
		//alles tutti, id ist noch nicht vergeben, theoretisch könnte warenkorb angelegt werden, 
		//aber erst kommt noch der check in der datenbank über alle items.
		if ($num_rows!=1)
		{
			//check ob items schon sich die userdaten mit der db beissen,
			//vielleicht hat ein anderer kunde in der zwischenzeit ein 
			//gerät schon bestellt
			foreach ($_SESSION["User_WK"] as $key => $value)
			{
				$sql = 'SELECT geraet,von,bis FROM `06_wkObje` WHERE `geraet` = \''.$value[name].'\' '; 
				$rs = mysql_query($sql);

				if (mysql_num_rows($rs)>0)
				{
					while ($row = mysql_fetch_array($rs)) 
					{
						if (zeitCheckDBPruef($row[1],$row[2],$value[zeitStart],$value[zeitEnde])==1 || zeitCheckDBPruef($row[1],$row[2],$value[zeitStart],$value[zeitEnde])==2)
						{
						}
						else
						{
						$blacklistReserviert[]=$key;
						}
					}
				}
			}
			if (!isset($blacklistReserviert))
			{
				//kein objekt läuft gefahr doppelt reserierviert zu werden,
				//warenkorb kann mit items erzeugt werden-
				$jetztWKBuild= new DateTime();
				$zeitFuerDBBuild=$jetztWKBuild->format('U');

				if ($_SESSION["User_Recht_Ausgabeber"]=="1" && $_GET['fremd']=="1")
				{
				$fremdleihe="1";
				}
				else
				{
				$fremdleihe="0";
				}
				
				$sql = 'INSERT INTO `05_wk` (`specid_wk`, `owner`, `erstellt_am`, `bemerkungen`, `fuer_dritte`) VALUES (\''.$unique_wkid.'\', \''.$_SESSION["User_ID"].'\', \''.$zeitFuerDBBuild.'\', \'angelegt mit '.count($_SESSION["User_WK"]).' Element/en\', \''.$fremdleihe.'\');'; 
				$rs2=mysql_query($sql);

				if (mysql_affected_rows()=="1")
				{
					foreach ($_SESSION["User_WK"] as $key => $value)
					{
					//echo "<br>---".$value[name]."<br>";

					//versand bei jedem objekt
					if ($value[versand]=="1")
					{
					$versandOption=1;
					}
					else
					{
					$versandOption=0;
					}
						if ($value[name]!="")
						{
							$sql = 'INSERT INTO `06_wkObje` (`wkid`, `geraet`, `von`, `bis`, `versandObj`) VALUES (\''.$unique_wkid.'\', \''.$value[name].'\', \''.$value[zeitStart].'\', \''.$value[zeitEnde].'\', \''.$versandOption.'\');'; 
							$rs3=mysql_query($sql);
							//$r++;
							if (mysql_affected_rows()!="1")
							{
							$fehlerWKDataTrans=1;
							}
						}
						else
						{
						//$s++;
						}
					}
				}
				else
				{
				$fehlerWKDataTrans=1;
				}

			}
			else
			{
			//fehler, anzeige der nicht mehr resierungsfähigen geräte
			?>
			<script>
			$.pnotify({
			pnotify_title: 'Überprüfung Warenkorb',
			pnotify_text: 'Durch andere Nutzer sind die rot markierten Objekte mittlerweile nicht mehr verfügbar.',
			pnotify_type: 'error',
			});
			$("#fehlermeldungenWK").html("Bitte entfernen Sie alle rot markierten Objekte aus dem Warenkorb um fortzufahren.");
			</script>
			<?
			//var_dump($_SESSION["User_WK"]);
			
				for ($i=0;$i<count($_SESSION["User_WK"]);$i++)
				{
					for ($s=0;$s<count($blacklistReserviert);$s++)
					{
						if ($i==$blacklistReserviert[$s])
						{
						?>
						<script>
						$("#tab_<? echo $i+569823; ?>").css({color: '#ff0000'});
						$("#letsTakeALook").show();
						</script>
						<?
						}
					}
				}
			}
		}
		else
		{
		$fehlerWKDataTrans=1;
		}

		if ($fehlerWKDataTrans=="1")
		{
		?>
		<script>
		$.pnotify({
		pnotify_title: 'Übertragungsfehler',
		pnotify_text: 'Bitte klicken Sie nochmal auf reservieren, Danke!',
		pnotify_type: 'error',
		});
		$("#letsTakeALook").show();
		</script>
		<?
		}
		else
		{
			if (!isset($blacklistReserviert))
			{
				$_SESSION["User_WK"]=array();
				?>
				<script>
				$("#wk").remove();
				$("#letsTakeALook").remove();
				$("#wk_content_tab").remove();
				$("#hinweisWeiter").remove();
				$("#fehlermeldungenWK").html("Ihre Reservierung wurde erfolgreich durchgeführt.<br><br>Ihre Reservierungsnummer: <b>w-<? echo $unique_wkid; ?></b> <br><a href='<? echo $_SESSION["SE_festUrl"]."account/basketControl/01_pdf_mv.inc.php?o=".base64_encode(serialize($unique_wkid)); ?>'>Mietvertrag <img src='../../BL_BILDER/pdf.png'></a><br><br><br>Sie können in <a href='../basketControl/'><b>diesem Bereich</b></a> Ihre Reservierungen verwalten.<br> (Z.B. eine Gesamtübersicht oder Mietverträge ausdrucken, Reservierungen zurücknehmen usw.)<figure><a href='../../'><img src='../../BL_BILDER/res_okay.png' width='200' height='95' /></a></figure>");
				</script>
				<?
			}
		}
	}
	else
	{
		if (!isset($_SESSION["User_ID"]))
		{
			//Session Daten löschen 
			/////////////////////////////////////////////
			$includeName="../../_04_logoutSess.inc.php";
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
		exit;
		}

	}
}

	
	//unerlaubter zugriff1
	if ($_SESSION["User_Recht_Ausgabeber"]!="1" && $_GET['fremd']=="1" && !isset($_SESSION["User_ID"]))
	{
		//anfang protokoll
		if ($_SESSION["SE_ProtokollAnAus"]==1)
		{
		protokollEintrag("2","3","Eine nicht ausleiheberechtigte und nicht angemeldete Person versuchte einen Warenkorb für Dritte auszuleihen.  IP:".getenv('REMOTE_ADDR'));
		}
		//ende protokoll
	}
	else
	{
		//unerlaubter zugriff2
		if ($_SESSION["User_Recht_Ausgabeber"]!="1" && $_GET['fremd']=="1")
		{
			//anfang protokoll
			if ($_SESSION["SE_ProtokollAnAus"]==1)
			{
			protokollEintrag("2","2","Eine nicht ausleiheberechtigte Person versuchte einen Warenkorb für Dritte auszuleihen.  IP:".getenv('REMOTE_ADDR'));
			}
			//ende protokoll
		}
	
	}
	
	
	
	
	
	
	
	
	

?>

