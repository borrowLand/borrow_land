<?
function CreatePassword2()
{

	$pool = "qwertzupasdfghkyxcvbnm";
	$pool .= "23456789";
	$pool .= "WERTZUPLKJHGFDSAYXCVBNM";

	srand ((double)microtime()*1000000);

	for($index = 0; $index < 6; $index++)
	{
	$passWord .= substr($pool,(rand()%(strlen ($pool))), 1);
	}
return $passWord;

}

//////////////////////////////////////////////////////////////////////////////////////  

function FUNK_VerSchluesseln($daten)
{
//$verschluesseln=crypt($daten,"CRYPT_MD5");
$verschluesseln=hash('sha256', $daten);

return $verschluesseln;
}
//////////////////////////////////////////////////////////////////////////////////////  


function protokollEintrag($hg,$ug,$dec)
{

$sqlProt = 'INSERT INTO `02_protokoll` (`wann`, `gruppe`, `untergruppe`, `descr`) VALUES (NOW(), \''.$hg.'\', \''.$ug.'\', \''.utf8_decode($dec).'\');'; 
$rsProt= @mysql_query($sqlProt);
}

/*
$algEnt=MCRYPT_BLOWFISH_COMPAT;
$modusEnt=MCRYPT_MODE_CFB;
$ivEnt=mcrypt_create_iv(mcrypt_get_iv_size($algEnt,$modusEnt), MCRYPT_DEV_URANDOM);
$decod=mcrypt_decrypt($algEnt,NEUNEU,base64_decode($datenEnt),$modusEnt,$ivEnt);
*/
		
function zeitCheckDBPruef($dbStart,$dbEnde,$pruefStart,$pruefEnde)
{
/*
//bsp: 1301662800 & 1302026400 sind in db - $DatumBeginn,$DatumEnde kommt vom nutzer
//zeitCheckDBPruef(1301662800,1302026400,$DatumBeginn,$DatumEnde);

										dbStart|-----------------|dbEnde
zeitraum vor beginn des db zeitraums (I.)								zeitraum nach ende des db zeitraums (II.)

$pruefStart < $pruefEnde												$pruefStart < $pruefEnde
$pruefStart < $dbStart													$pruefStart > $dbEnde
$pruefEnde < $dbStart													$pruefEnde > $dbEnde
$pruefStart < $dbEnde													$pruefStart > $dbStart
$pruefStart < $dbEnde													$pruefStart > $dbStart
*/



	//check vor dbStart I.
	if ($pruefStart < $pruefEnde)
	{

		if ($pruefStart < $dbStart)
		{
			if ($pruefEnde <= $dbStart)
			{
				if ($pruefStart < $dbEnde)
				{
					if ($pruefStart < $dbEnde)
					{
					return 1;
					}
				}
			}
		}
	}

	//check nach ende des db zeitraums (II.)
	if ($pruefStart < $pruefEnde)
	{
		if ($pruefStart >= $dbEnde)
		{
			if ($pruefEnde > $dbEnde)
			{
				if ($pruefStart > $dbStart)
				{
					if ($pruefStart > $dbStart)
					{
					return 2;
					}
				}
			}
		}
	}
}
		

		
function klarNameHG($specid_hg)
{
$sql = 'SELECT Kurzbez FROM `03_obj_hauptgruppen` WHERE `specid_hg` = \''.$specid_hg.'\' LIMIT 1 ';
$rs= @mysql_query($sql);
$row = mysql_fetch_row($rs);
return $row[0];
}	
		
function klarNameObj($specid_obj)
{
$sql = 'SELECT Kurzbez FROM `04_obj_objekte` WHERE `specid_obj` = \''.$specid_obj.'\' LIMIT 1 ';
$rs= @mysql_query($sql);
$row = mysql_fetch_row($rs);
return $row[0];
}

function hgNameAusGeraet($geraet)
{
$sql = 'SELECT HGruppe FROM `04_obj_objekte` WHERE `specid_obj` = \''.$geraet.'\' LIMIT 1 ';
$rs= @mysql_query($sql);
$row = mysql_fetch_row($rs);
return $row[0];
}
function hgKurzNameAusHGID($obje)
{
$sql = 'SELECT Kurzbez FROM `03_obj_hauptgruppen` WHERE `specid_hg` = \''.$obje.'\' LIMIT 1 ';
$rs= @mysql_query($sql);
$row = mysql_fetch_row($rs);
return $row[0];
}	
	
function timeCdZuDatumOhneZeit($tc)
{
return date("d.m.Y",$tc);
}	

function timeCdZuDatumMitZeit($tc)
{
return date("d.m.Y G:i",$tc);
}

function timeCdZuDatumMitZeitAmerik($tc)
{
return date("Y-m-d G:i",$tc);
}

function google_qr($url,$size ='300',$EC_level='Q',$margin='0') {
$url = urlencode($url);
echo '<img src="http://chart.apis.google.com/chart?chs='.$size.'x'.$size.'&cht=qr&chld='.$EC_level.'|'.$margin.'&chl='.$url.'" alt="QR code" width="'.$size.'" height="'.$size.'"/>';
}
	
function wkCountOhneLeer() 
{
//array_multisort($_SESSION["User_WK"]);
	/*
	for($x=0;$x<count($arrayNeuSort);$x++)
	{
		if ($_SESSION["User_WK"][$x]["name"]!="")
		{
		$anzahlElemente++;
		}
	}
	*/
return count($_SESSION["User_WK"]);
}

function benutzerDaten($userID)
{
$sql = "SELECT vn_nn,tn,m_id,email,adr_strasse_hn,adr_plz,adr_stadt,id FROM `01_Benutzer` WHERE `specid_cyrpt_md5` = \"".mysql_real_escape_string($userID)."\" LIMIT 1 "; 
$benutzerData = mysql_query($sql);
$WKNameDB = mysql_fetch_row($benutzerData);
return ($WKNameDB);
}

function objectDaten($objID)
{
$sql = "SELECT * FROM `04_obj_objekte` WHERE `specid_obj` = \"".mysql_real_escape_string($objID)."\" LIMIT 1 "; 
$objDat = mysql_query($sql);
$objData = mysql_fetch_row($objDat);
return ($objData);
}

function differenzZeit($zeitstempel1,$zeitstempel2,$mod)
{
//$mod=t	für tage
//$mod=s	für stunden
//$mod=m	für minuten

	if($mod=="t")
	{
	$differenz=$zeitstempel2-$zeitstempel1;
	$diff_tage = $differenz / 86400;
	return ($diff_tage);
	}
	
	if($mod=="s")
	{
	$differenz=$zeitstempel2-$zeitstempel1;
	$diff_stunden = $differenz / 3600;
	return ($diff_stunden);
	}
	if($mod=="m")
	{
	$differenz=$zeitstempel2-$zeitstempel1;
	$diff_stunden = $differenz / 60;
	return ($diff_stunden);
	}
	
}

function welcheEinstellung($BeschreibungSesion)
{
$sql = "SELECT InhaltDerEinstellung FROM `00_einstellungenSoftware` WHERE `Desc_Session` = \"".$BeschreibungSesion."\" LIMIT 1"; 
$datenEinstell = mysql_query($sql);
$row = mysql_fetch_row($datenEinstell);
return ($row[0]);
}

function welcheEinstellungLetzteAend($BeschreibungSesion)
{
$sql = "SELECT letzteAenderung FROM `00_einstellungenSoftware` WHERE `Desc_Session` = \"".$BeschreibungSesion."\" LIMIT 1"; 
$datenEinstell = mysql_query($sql);
$row = mysql_fetch_row($datenEinstell);
return ($row[0]);
}


function EinstellungSetzen($BeschreibungSesion,$Wert)
{
$sql = 'UPDATE `00_einstellungenSoftware` SET `InhaltDerEinstellung` = \''.$Wert.'\', `letzteAenderung` = NOW() WHERE `Desc_Session` = \''.$BeschreibungSesion.'\' LIMIT 1;';
$datenSchreib = mysql_query($sql);
$erfolg=mysql_affected_rows();
return ($erfolg);
}

function objekteDieZurVerfuegungStehen($ZeitStempelStart,$ZeitStempelEnde)
{
//echo $ZeitStempelStart."XX".$ZeitStempelEnde;

//beginn auswahl (nur aktivierte) hauptgruppen
$sql = 'SELECT specid_hg FROM `03_obj_hauptgruppen` WHERE `HGruppenOnOff` = 1'; 
$hg = mysql_query($sql);
$anzahlHGaktiv = mysql_num_rows($hg); 

	//sind aktivierte hauptgruppen verfügbar?
	if ($anzahlHGaktiv>0)
	{
		while ($hgData = mysql_fetch_array($hg, MYSQL_NUM))
		{
		$sql = 'SELECT specid_obj FROM `04_obj_objekte` WHERE `HGruppe` = \''.$hgData[0].'\' AND `ObjOnOff` =1'; 
		$objekte = mysql_query($sql);
		$anzahlObjAktiv = mysql_num_rows($objekte);
		$summeObjektePur=$anzahlObjAktiv+$summeObjektePur;
		

			if ($anzahlObjAktiv>0)
			{
				while ($objekteData = mysql_fetch_array($objekte, MYSQL_NUM))
				{
					//schaffung der aktuellen datenbasis, ohne warenkorb und zeitvergleiche
					//ausgabe hauptgruppe: objekt
					//echo $hgData[0].": ".$objekteData[0]."<br>";
					$alleObjekte[$hgData[0]][]=$objekteData[0];
					
					/* warenkorb:
					im warenkorb gibt es nur die drei möglichkeiten:
					1. objekt ist im wk, aber zeitraum stört nicht => drin
					2. objekt ist im wk, zeitraum stört => draussen
					3. objekt ist nicht im wk => drin 
					*/

					//1. check: warenkorb
					if (count($_SESSION["User_WK"])>0)
					{
						for ($i=0;$i<count($_SESSION["User_WK"]);$i++)
						{
							//objektname in der datenbank ist identisch mit einem warenkorb objekt
							if ($objekteData[0]==$_SESSION["User_WK"][$i]["name"])
							{
								//ist dieses objekt im warenkorb so angegeben, dass es ausserhalb der useranfrage liegt?
								if (zeitCheckDBPruef($_SESSION["User_WK"][$i]["zeitStart"],$_SESSION["User_WK"][$i]["zeitEnde"],$ZeitStempelStart,$ZeitStempelEnde)==1 || zeitCheckDBPruef($_SESSION["User_WK"][$i]["zeitStart"],$_SESSION["User_WK"][$i]["zeitEnde"],$ZeitStempelStart,$ZeitStempelEnde)==2)
								{
								//geraet nicht im warenkorb, allgemein verfügbar
								}
								else
								{
								//das objekt im wk kollidiert mit festgelegter zeitanfrage, darf nicht mehr angeboten werden
								$blacklist[]=$objekteData[0];
								}
							}
							else
							{
							//geraet nicht im warenkorb, allgemein verfügbar
							}
						}
					}
					
					//2. datenbank check
					$sql2 = 'SELECT geraet,von,bis FROM `06_wkObje` WHERE `geraet` = \''.$objekteData[0].'\' '; 
					$objekteWK = mysql_query($sql2);
					$anzahlWKOb = mysql_num_rows($objekteWK);

					if ($anzahlWKOb>0)
					{
						while ($objektWKAktiv = mysql_fetch_array($objekteWK, MYSQL_NUM))
						{
							if ($objektWKAktiv[0]==$objekteData[0])
							{
								//ist dieses objekt im warenkorb so angegeben, dass es ausserhalb der useranfrage liegt?
								if (zeitCheckDBPruef($objektWKAktiv[1],$objektWKAktiv[2],$ZeitStempelStart,$ZeitStempelEnde)==1 || zeitCheckDBPruef($objektWKAktiv[1],$objektWKAktiv[2],$ZeitStempelStart,$ZeitStempelEnde)==2)
								{
								// alles okay, objekt steht nicht im widerspruch zur anfrage
								}
								else
								{
								$blacklist[]=$objekteData[0];
								}
							}
							else
							{
							// alles okay, objekt steht nicht im widerspruch zur anfrage							
							}
						}
					}					
				}
			}
		}
		
		//beide blacklisten auf doppelte einträge checken.
		$bl2 = array_unique($blacklist);
	
		unset($_SESSION["aktuelleObjekte"]);
	
		//bedingungen zum weitermachen: es müssen mehr objekte allgemein da sein, als die blacklist aufführt - und es muss mind. 1 element in den hauptgruppen existieren
		if ($summeObjektePur > count($bl2) && $summeObjektePur>0)
		{
			foreach ($alleObjekte as $x => $val) 
			{
				foreach ($alleObjekte[$x] as $y => $val2) 
				{
				//ausspucken der hauptgruppe mit objekt			
				//echo $x.": ".$val2."<br>";
					if(in_array($val2,$bl2))
					{
					//der wert kommt in der blacklist vor, keine darstellung.
					}
					else
					{
					//ausgabe funktion nur von objekten, die in keiner blacklist waren.
					$_SESSION["aktuelleObjekte"][$x][]=$val2;
					}
				}
			}
			
		}
		else
		{
			//abbruchmeldung: aktive hauptgruppen vorhanden, aber mit keinen aktiven objekten.
			?>
			<script>
			$.pnotify({
			pnotify_title: 'Ausleihobjekte',
			pnotify_text: 'Derzeit ist keine Ausleihe von Objekten möglich. Grund: Es sind derzeit nicht genügend Objekte verfügbar oder zugeordnet.',
			pnotify_type: 'error'
			});
			</script>
			<?		
		}
	}
	else
	{
		//abbruchmeldung, keine aktiven hauptgruppen
		?>
		<script>
		$.pnotify({
		pnotify_title: 'Ausleihobjekte',
		pnotify_text: 'Derzeit ist keine Ausleihe von Objekten möglich. Grund: Es existieren keine Hauptgruppen.',
		pnotify_type: 'error'
		});
		</script>
		<?
	}
}

function resizeImage ($filepath_old, $filepath_new, $image_dimension, $scale_mode = 0)
{
  if (!(file_exists($filepath_old)) ) return false;

  $image_attributes = getimagesize($filepath_old);
  $image_width_old = $image_attributes[0];
  $image_height_old = $image_attributes[1];
  $image_filetype = $image_attributes[2];

  if ($image_width_old <= 0 || $image_height_old <= 0) return false;
  $image_aspectratio = $image_width_old / $image_height_old;

  if ($scale_mode == 0) {
   $scale_mode = ($image_aspectratio > 1 ? -1 : -2);
  } elseif ($scale_mode == 1) {
   $scale_mode = ($image_aspectratio > 1 ? -2 : -1);
  }

  if ($scale_mode == -1) {
   $image_width_new = $image_dimension;
   $image_height_new = round($image_dimension / $image_aspectratio);
  } elseif ($scale_mode == -2) {
   $image_height_new = $image_dimension;
   $image_width_new = round($image_dimension * $image_aspectratio);
  } else {
   return false;
  }

  switch ($image_filetype) {
   case 1:
    $image_old = imagecreatefromgif($filepath_old);
    $image_new = imagecreate($image_width_new, $image_height_new);
    imagecopyresampled($image_new, $image_old, 0, 0, 0, 0, $image_width_new, $image_height_new, $image_width_old, $image_height_old);
    imagegif($image_new, $filepath_new);
    break;
 
   case 2:
    $image_old = imagecreatefromjpeg($filepath_old);
    $image_new = imagecreatetruecolor($image_width_new, $image_height_new);
    imagecopyresampled($image_new, $image_old, 0, 0, 0, 0, $image_width_new, $image_height_new, $image_width_old, $image_height_old);
    imagejpeg($image_new, $filepath_new);
    break;

   case 3:
    $image_old = imagecreatefrompng($filepath_old);
    $image_colordepth = imagecolorstotal($image_old);

    if ($image_colordepth == 0 || $image_colordepth > 255) {
     $image_new = imagecreatetruecolor($image_width_new, $image_height_new);
    } else {
     $image_new = imagecreate($image_width_new, $image_height_new);
    }

    imagealphablending($image_new, false);
    imagecopyresampled($image_new, $image_old, 0, 0, 0, 0, $image_width_new, $image_height_new, $image_width_old, $image_height_old);
    imagesavealpha($image_new, true);
    imagepng($image_new, $filepath_new);
    break;

   default:
    return false;
  }

  imagedestroy($image_old);
  imagedestroy($image_new);
  return true;
 } 


?>
