<?

session_start();
/////////////////////////////////////////////

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


define('FPDF_FONTPATH','../../BL_PDF/font/');
require("../../BL_PDF/fpdf.php");



if (isset($_SESSION["User_ID"]))
{
$warenkorb=unserialize(base64_decode($_GET['o']));

		//wenn kein admin, dann nur zugriff auf eigene mietverträge
		if ($_SESSION["User_Recht_Ausgabeber"]=="1" || $_SESSION["User_Recht_Admin"]=="1")
		{
		$sql = "SELECT erstellt_am,specid_wk,bemerkungen,owner,fuer_dritte  FROM `05_wk` WHERE `specid_wk` = \"".mysql_real_escape_string($warenkorb)."\" LIMIT 1 "; 
		}
		else
		{
		$sql = "SELECT erstellt_am,specid_wk,bemerkungen,owner,fuer_dritte  FROM `05_wk` WHERE `owner` = \"".$_SESSION["User_ID"]."\" AND `specid_wk` = \"".mysql_real_escape_string($warenkorb)."\" LIMIT 1 "; 
		}

		$ReservWK = mysql_query($sql);
		$WKDaten = mysql_fetch_row($ReservWK);
		$anzahlWK = mysql_num_rows($ReservWK); 
		
		if ($anzahlWK=="1")
		{
		$pdf=new FPDF('P','pt','A4');
		$pdf->AddPage();

		$pdf->SetFont('Arial','',9);
		$pdf->AliasNbPages('{GesamtanzahlSeiten}');
		
		$pdf->SetFont('Arial','',12);
		$pdf->Text( 20, 22, $_SESSION['SE_Kundenname']. " (Verleiher)"); 
		$pdf->SetFont('Arial','',10);
		
		$pdf->Text( 20, 33, 'Ausleihe: w-'.$WKDaten[1]." (Eingang: ".timeCdZuDatumMitZeit($WKDaten[0]).")"); 

	
		$pdf->Image("http://chart.apis.google.com/chart?chs=130x130&cht=qr&chld=Q|0&chl=w-".$WKDaten[1], 470, 0, 0, 0, 'png');	
		
		$nutzerDaten=benutzerDaten($WKDaten[3]);
		
		$pdf->Text( 20, 51, "Vertragspartner (Ausleihender genannt):"); 
		
		//falls auf namen dritter kommen nur ____ damit vor ort daten manuell eingefügt werden können	
		if ($WKDaten[4]=="1")
		{
		
		$pdf->Line(20, 65, 450, 65);
		//$pdf->Text( 20, 65, "_________________________________________________"); 
		
		$pdf->Text( 20, 80, "Telefonnummmer:"); 
		$pdf->Line(110, 80, 450, 80);
		
		$pdf->Text( 20, 95, "E-Mail:"); 
		$pdf->Line(110, 95, 450, 95);
		
		$pdf->Text( 20, 110, "Adresse: "); 
		$pdf->Line(110, 110, 450, 110);
		
		$pdf->Text( 20, 125, "PLZ/Ort: "); 
		$pdf->Line(110, 125, 450, 125);
		}
		else
		{
		$pdf->Text( 20, 61, $nutzerDaten[0]); 
		$pdf->Text( 20, 71, "Telefonnummmer: ".$nutzerDaten[1]); 
		$pdf->Text( 20, 81, "E-Mail: ".$nutzerDaten[3]); 
			//prüf-id wird angezeigt, wenn gesetzt
			if ($_SESSION["SE_AccessContrYN"]=="1")
			{
			$pdf->Text( 20, 91, $_SESSION["SE_AccessContrName"].": ".$nutzerDaten[2]); 
			}		
			
			//adressmodul anzeigen, wenn gesetzt.
			if ($_SESSION["SE_AdressModuleYesNo"]=="1")
			{
			$pdf->Text( 20, 101, "Adresse: ".$nutzerDaten[4]); 
			$pdf->Text( 20, 111, $nutzerDaten[5]." ".$nutzerDaten[6]); 
			}		
		}
		
		

		$pdf->ln(105);

		$pdf->Cell(0,20,'Übersicht der Mietobjekte',1,1,C);
		
		//Überschriften
		//breite insgesamt: 538p
		$spalte0breite=15;
		$spalte1breite=320;
		$spalte2breite=154;
		
		$pdf->Cell($spalte0breite,15,'N°',1,0);
		$pdf->Cell($spalte1breite,15,'Bezeichnung:',1,0);

		if ($_SESSION['SE_versandMod']=="1")
		{
		$pdf->Cell($spalte2breite,15,'Ausleihezeit:',1,0);
		$pdf->Cell(0,15,'Versand',1,1);		
		}
		else
		{
		$pdf->Cell(0,15,'Ausleihezeit:',1,1);
		}

		//$pdf->Cell(0,15,'Bezeichnung: aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa',1,1);

		$sql = "SELECT id,geraet,von,bis,abgeholt,gebracht,versandObj FROM `06_wkObje` WHERE `wkid` = \"".$WKDaten[1]."\" ORDER BY `geraet` DESC"; 
		$objekteWK = mysql_query($sql);
		$anzahlWKobj = mysql_num_rows($objekteWK); 

				
			if ($anzahlWKobj>0)
			{
				$objektnummer=1;
				while ($WKobjDaten = mysql_fetch_array($objekteWK, MYSQL_NUM))
				{
					$pdf->SetFont('Arial','',6);
					$pdf->Cell($spalte0breite,15,$objektnummer,1,0);
				
					if ($_SESSION["SE_ViewLeihmodHauptg"]=="1")
					{
						if ($WKobjDaten[4]!=NULL && $WKobjDaten[5]==NULL)
						{
						$pdf->SetFont('Arial','',9);
						$pdf->Cell($spalte1breite,15,hgKurzNameAusHGID(hgNameAusGeraet($WKobjDaten[1]))."*",1,0);
						$legendeStern=1;
						}
						else
						{
						$pdf->SetFont('Arial','',9);
						$pdf->Cell($spalte1breite,15,hgKurzNameAusHGID(hgNameAusGeraet($WKobjDaten[1])),1,0);
						}
	
					}
					else
					{
						if ($WKobjDaten[4]!=NULL && $WKobjDaten[5]==NULL)
						{
						$pdf->SetFont('Arial','',9);
						$pdf->Cell($spalte1breite,15,klarNameObj($WKobjDaten[1])."*",1,0);
						$legendeStern=1;
						}
						else
						{
						$pdf->SetFont('Arial','',9);
						$pdf->Cell($spalte1breite,15,klarNameObj($WKobjDaten[1]),1,0);
						}					
					
					}
			
				$pdf->SetFont('Arial','',9);
				$pdf->Cell($spalte2breite,15,timeCdZuDatumMitZeit($WKobjDaten[2])." - ".timeCdZuDatumMitZeit($WKobjDaten[3]),"L",0);
				
				if ($_SESSION['SE_versandMod']=="1")
				{
					if ($WKobjDaten[6]=="1")
					{
					$pdf->Cell(0,15,"ja",1,1);
					$versandElementeAnzahl++;
					}
					else
					{
					$pdf->Cell(0,15,"nein",1,1);
					}
				}
				else
				{
				$pdf->Cell(0,15,"","R",1);
				}
				
				
				$pdf->SetFont('Arial','',7);
				
				//objektid
				$pdf->Cell(0,10,"Objektnummer: ".$WKobjDaten[1],1,1);
				//erste zeile eines eintrages zuende
				
				//monitäres modul aktiv, darstellung von mietpreisen & wiederbeschaffungswert
				if ($_SESSION["SE_MoneyModule"]=="1")
				{
				$pdf->SetFont('Arial','',8);
				$wbWert=objectDaten($WKobjDaten[1]);

				//wenn zeitberechnung eingeschaltet worden ist und weniger als 24 stunden vergangen sind, dann erfolgt die berechnung, die für die kleinste zeitabrechnung vorgesehen ist (SE_MindLeihZeit)
				if ((differenzZeit($WKobjDaten[2],$WKobjDaten[3],"s")<=24 && $wbWert[11]=="1") || (differenzZeit($WKobjDaten[2],$WKobjDaten[3],"s")<=24 && $wbWert[11]=="2"))
				{
				//abrechnungszeit aus 
				$minuten=(60/$_SESSION["SE_IntervStunde"]);
				$preisProMinute=$wbWert[8]/$minuten;
				
				$mintenAusleihen=differenzZeit($WKobjDaten[2],$WKobjDaten[3],"m");
				$preisProUserMinuten=(($mintenAusleihen*$preisProMinute));
				
				
				if (round($mintenAusleihen)<61)
				{
				$kosten=$preisProUserMinuten."€ (".round($mintenAusleihen,2)." Minuten x ".round($preisProMinute,2)."€/Minute)";
				}
				else
				{
				$kosten=$preisProUserMinuten."€ (".round(($mintenAusleihen/60),2)." Stunde/n x ".round($preisProMinute*60,2)."€/Stunde)";
				}
				
				
				
				$gesamtkosten=$gesamtkosten+$preisProUserMinuten;
				}
				
				//wenn zeitberechnung eingeschaltet worden ist und mehr  als 24 stunden vergangen sind, dann erfolgt tage berechnung
				if ((differenzZeit($WKobjDaten[2],$WKobjDaten[3],"t")>=1 && $wbWert[11]=="1") || (differenzZeit($WKobjDaten[2],$WKobjDaten[3],"t")>=1 && $wbWert[11]=="2"))
				{
				$kosten=round((differenzZeit($WKobjDaten[2],$WKobjDaten[3],"t")*$wbWert[9]),2)."€ (".round(differenzZeit($WKobjDaten[2],$WKobjDaten[3],"t"),2)." Tag/e x ".$wbWert[9]."€/Tag)";
				$gesamtkosten=$gesamtkosten+(differenzZeit($WKobjDaten[2],$WKobjDaten[3],"t")*$wbWert[9]);
				}
					
				if ($wbWert[11]=="0")
				{
				$kosten="Es fehlen genauere Angaben zum Mietpreis dieses Objektes.";
				}
				if ($wbWert[11]=="3")
				{
				$kosten="Es erfolgt eine individuelle Berechnung.";
				}

					$pdf->SetFont('Arial','',7);
					
					if ($_SESSION["SE_MoneyModule_Mietp"]=="1")
					{
					$pdf->Cell(0,10,"Wiederbeschaffungswert: ".$wbWert[13]."€. Mietpreis für dieses Gerät: ".$kosten,1,1);
					$gesamtWiederBeschaff=$gesamtWiederBeschaff+$wbWert[13];
					}
					else
					{
					$pdf->Cell(0,10,"Wiederbeschaffungswert: ".$wbWert[13]."€",0,1);
					$gesamtWiederBeschaff=$gesamtWiederBeschaff+$wbWert[13];
					}
			
				}
				
				$objektnummer++;
				}
				
				$pdf->ln(15);
				$pdf->SetFont('Arial','',7);
				
				if ($WKDaten[2]!="")
				{
				$pdf->Cell(0,10,'Bemerkungen: '.$WKDaten[2],0,1);
				}
				
				if ($_SESSION["SE_MoneyModule"]=="1")
				{
					if ($_SESSION["SE_MoneyModule_Mietp"]=="1")
					{
					$pdf->Cell(0,10,'Mietkosten: '.round($gesamtkosten,2)." €. Summe Wiederbeschaffungswert: ".$gesamtWiederBeschaff. " €",0,1);
					}
					else
					{
					$pdf->Cell(0,10,"Summe Wiederbeschaffungswert: ".$gesamtWiederBeschaff. " €",0,1);
					}
				}
				
				if ($versandElementeAnzahl>=1 && $_SESSION['SE_versandMod']=="1")
				{
				$pdf->Cell(0,10,'Versandkosten: '.($versandElementeAnzahl)*$_SESSION['SE_versandPreisAll'].'€; '.$_SESSION['SE_versandPreisAll'].'€/Objekt. Nähere Informationen zum Versand: '.$_SESSION['SE_versandURL'],0,1);
				}	
				
				$pdf->ln(5);
				
				//gesamtbetrag
				$ges2=($versandElementeAnzahl*$_SESSION['SE_versandPreisAll']) + round($gesamtkosten,2);
				$pdf->Cell(0,12,'Gesamtkosten der Leihe: '.$ges2.'€',0,1);
				
				$pdf->ln(25);
				$pdf->SetFont('Arial','',10);
				//übernahme
				$pdf->Cell(0,15,'Ausleihe: Hiermit übernehme ich ('.$nutzerDaten[0].') die o.g. vollständigen und fehlerfreien Mietobjekte.',0,1);			
				$pdf->ln(15);
				$pdf->SetFont('Arial','',7);
				$pdf->Cell(0,15,'Ort, Datum, Unterschrift: _________________________________________________________________________________________________________ (Ausleihender)',0,1);							
				$pdf->ln(15);				
				$pdf->Cell(0,15,'Ort, Datum, Unterschrift: _________________________________________________________________________________________________________ (Verleiher)',0,1);							
				$pdf->ln(35);				
				
				//rücknahme
				$pdf->SetFont('Arial','',10);
				$pdf->Cell(0,15,'Rücknahme: Die o.g. Mietobjekte wurden [__] vollständig & fehlerfrei / [__] unvollständig / [__] nicht fehlerfrei angenommen.',0,1);			
				$pdf->ln(15);				
				$pdf->SetFont('Arial','',7);
				$pdf->Cell(0,15,'Ort, Datum, Unterschrift: _________________________________________________________________________________________________________ (Ausleihender)',0,1);							
				$pdf->ln(15);				
				$pdf->Cell(0,15,'Ort, Datum, Unterschrift: _________________________________________________________________________________________________________ (Verleiher)',0,1);				
 				$pdf->ln(35);				

				$pdf->SetFont('Arial','',7);
				$pdf->Cell(0,15,'Dieses Dokument enthält {GesamtanzahlSeiten} Seite/n und wurde am '.timeCdZuDatumMitZeit(time()).' von BORROW LAND (http://www.ausleihsoftware.de) erzeugt.',0,1);				
			
				if ($legendeStern=="1")
				{
				$pdf->Cell(0,15,'* = Dieses Objekt ist zum Erstellungszeit dieses Vertrages bereits verliehen.',0,1);				
				}
 
			}
			else
			{
			$pdf->Cell(0,15,'Fehler: In dem Warenkorb befinden sich keine Objekte.',1,1);

			}
		
		}
		else
		{
		$pdf=new FPDF('P','mm','A4');
		$pdf->AddPage();
		$pdf->SetFont('Helvetica','B',12);
		$pdf->Cell(40,10,'Es ist ein Fehler aufgetreten.');
		
		}

$pdf->SetDisplayMode( 'fullpage' );
$pdf->SetKeywords( 'Ausleihsoftware, Mietsoftware' );
$pdf->SetTitle( 'BORROW LAND PDF Dokument' );
$pdf->SetSubject( 'BORROW LAND PDF Dokument' );
$pdf->SetAuthor( 'http://www.ausleihsoftware.de' );
$pdf->SetCreator('http://www.ausleihsoftware.de'); 
$pdf->Output("borrow-land-ausleihe.pdf", "D");
}
else
{
$pdf=new FPDF('P','mm','A4');
$pdf->AddPage();
$pdf->SetFont('Helvetica','B',16);
$pdf->Cell(40,10,'Bitte melden Sie sich an.');
$pdf->SetDisplayMode( 'fullpage' );
$pdf->SetKeywords( 'Ausleihsoftware, Mietsoftware' );
$pdf->SetTitle( 'BORROW LAND PDF Dokument' );
$pdf->SetSubject( 'BORROW LAND PDF Dokument' );
$pdf->SetAuthor( 'http://www.ausleihsoftware.de' );
$pdf->SetCreator('http://www.ausleihsoftware.de'); 
$pdf->Output("borrow-land-ausleihe.pdf", "I");
}
?>