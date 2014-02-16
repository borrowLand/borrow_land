<?php
session_start();


// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Inventar.xlsx"');
header('Cache-Control: max-age=0');

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

if ($_SESSION["User_Recht_Admin"]=="1")
{
	/** PHPExcel */
	require_once '../../BL_EXCL/PHPExcel.php';

	// Create new PHPExcel object
	//echo date('H:i:s') . " Create new PHPExcel object\n";
	$objPHPExcel = new PHPExcel();

	// Set properties
	//echo date('H:i:s') . " Set properties\n";
	$objPHPExcel->getProperties()->setCreator("BORROW LAND")
								 ->setLastModifiedBy("BORROW LAND")
								 ->setTitle("Inventarliste BORROW LAND")
								 ->setSubject("Inventarliste BORROW LAND")
								 ->setDescription("Inventarliste BORROW LAND")
								 ->setKeywords("")
								 ->setCategory("");

	//hauptgruppen, überschriften
	$objPHPExcel->getActiveSheet()->setCellValue('A1', 'Hauptgruppen-Übersicht');
	$objPHPExcel->getActiveSheet()->setCellValue('A3', 'Kurzbezeichnung');
	$objPHPExcel->getActiveSheet()->setCellValue('B3', 'Erstellt am');
	$objPHPExcel->getActiveSheet()->setCellValue('C3', 'Erstellt von');
	$objPHPExcel->getActiveSheet()->setCellValue('D3', 'Aktiviert?');
	$objPHPExcel->getActiveSheet()->setCellValue('E3', 'Lange Beschreibung');

	//daten für hauptgruppen
	$sql = 'SELECT * FROM `03_obj_hauptgruppen` ORDER BY `id` ASC'; 
	$hgs = mysql_query($sql);
	$hgs2 = mysql_query($sql);

	$anzahlHGs = mysql_num_rows($hgs); 

	if ($anzahlHGs>0)
	{
	$i=6;
		while ($hgData = mysql_fetch_array($hgs, MYSQL_NUM))
		{
			if ($hgData[6]=="1")
			{
			$anAusHG="ja";
			}
			else
			{
			$anAusHG="nein";
			}
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$i, utf8_encode($hgData[2]));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$i, timeCdZuDatumOhneZeit($hgData[4]));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$i, utf8_encode($hgData[5]));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$i, $anAusHG);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$i, utf8_encode($hgData[3]));
		$i++;				 
		}				 
	}

	//bild objekte unten links
	$objDrawing = new PHPExcel_Worksheet_Drawing();
	$objDrawing->setName('Terms and conditions');
	$objDrawing->setDescription('Terms and conditions');
	$objDrawing->setPath("../../BL_BILDER/bl-text.png");
	$objDrawing->setCoordinates('A'.($i+2));
	$objDrawing->setWorksheet($objPHPExcel->setActiveSheetIndex(0));

	
	//spaltenbreite
	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);								 
	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);								 
	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);								 
	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);								 
	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);								 

	//überschriften-design
	$styleArray = array(
		'font' => array(
			'bold' => true,
		),
		'alignment' => array(
			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
		),
		'borders' => array(
			'top' => array(
				'style' => PHPExcel_Style_Border::BORDER_THIN,
			),
		),
		'fill' => array(
			'type' => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,
			'rotation' => 90,
			'startcolor' => array(
				'argb' => 'FFA0A0A0',
			),
			'endcolor' => array(
				'argb' => 'FFFFFFFF',
			),
		),
	);
	$objPHPExcel->getActiveSheet()->getStyle('A3:E3')->applyFromArray($styleArray);

	// Rename sheet
	//echo date('H:i:s') . " Rename sheet\n";
	$objPHPExcel->getActiveSheet()->setTitle('Hauptgruppen');

	//neues sheet -> objekte
	$objWorksheet1 = $objPHPExcel->createSheet();
	$objWorksheet1->setTitle('Objekte');

	//objekte, überschriften
	$objPHPExcel->setActiveSheetIndex(1)->setCellValue('A1', 'Objekte-Übersicht');
	$objPHPExcel->setActiveSheetIndex(1)->setCellValue('A3', 'Hauptgruppe');
	$objPHPExcel->setActiveSheetIndex(1)->setCellValue('B3', 'Kurzbezeichnung');
	$objPHPExcel->setActiveSheetIndex(1)->setCellValue('C3', 'Erstellt am');
	$objPHPExcel->setActiveSheetIndex(1)->setCellValue('D3', 'Erstellt von');
	$objPHPExcel->setActiveSheetIndex(1)->setCellValue('E3', 'Aktiviert?');
	$objPHPExcel->setActiveSheetIndex(1)->setCellValue('F3', 'Schlagwörter');
	$objPHPExcel->setActiveSheetIndex(1)->setCellValue('G3', 'Miete aktiviert?');
	$objPHPExcel->setActiveSheetIndex(1)->setCellValue('H3', 'Mietpreis 1');
	$objPHPExcel->setActiveSheetIndex(1)->setCellValue('I3', 'Mietpreis 2');
	$objPHPExcel->setActiveSheetIndex(1)->setCellValue('J3', 'Wiederbeschaffungswert');	
	$objPHPExcel->setActiveSheetIndex(1)->setCellValue('K3', 'Bild Startseite');	
	$objPHPExcel->setActiveSheetIndex(1)->setCellValue('L3', 'Lange Beschreibung');	

	$sql = 'SELECT * FROM `03_obj_hauptgruppen` ORDER BY `id` ASC'; 
	$hgs = mysql_query($sql);
	$hgs2 = mysql_query($sql);

	$anzahlHGs = mysql_num_rows($hgs); 

	if ($anzahlHGs>0)
	{
	$i=6;
		while ($hgData = mysql_fetch_array($hgs, MYSQL_NUM))
		{
			$objPHPExcel->setActiveSheetIndex(1)->setCellValue('A'.$i, utf8_encode($hgData[2]));
			//$hgData[1]=hauptgruppenname  jetzt suche in objekten
							
				$sql2 = "SELECT * FROM `04_obj_objekte` WHERE `HGruppe` = \"".$hgData[1]."\""; 
				$ObjAusHGs = mysql_query($sql2);
				$anzahlObjAusHGs = mysql_num_rows($ObjAusHGs); 
				
				if ($anzahlObjAusHGs>0)
				{
					$nummer=1;
					while ($ObjAusHGData = mysql_fetch_array($ObjAusHGs, MYSQL_NUM))
					{					
					
					//aktiviert oder nicht
					if ($ObjAusHGData[7]=="1")
					{
					$anAusObj="ja";
					}
					else
					{
					$anAusObj="nein";
					}
					
					//Mietpreis festgelegt oder nicht?
					if ($ObjAusHGData[11]=="1")
					{
					$mpFestGe="ja";
					}
					else
					{
					$mpFestGe="nein";
					}						

					if ($ObjAusHGData[8]=="")
					{
					$mp1="nicht festgelegt";
					}
					else
					{
					$mp1=$ObjAusHGData[8]."€";
					}						
					
					if ($ObjAusHGData[9]=="")
					{
					$mp2="nicht festgelegt";
					}
					else
					{
					$mp2=$ObjAusHGData[9]."€";
					}						
					
					if ($ObjAusHGData[13]=="")
					{
					$wbw="nicht festgelegt";
					}
					else
					{
					$wbw=$ObjAusHGData[13]."€";
					$alles=$wbw+$alles;
					}						
					
					if ($ObjAusHGData[12]=="")
					{
					$prevStart="nein";
					}
					else
					{
					$prevStart="ja";
					}	

					$objPHPExcel->setActiveSheetIndex(1)->setCellValue('B'.$i, utf8_encode($ObjAusHGData[2]));
					$objPHPExcel->setActiveSheetIndex(1)->setCellValue('C'.$i, timeCdZuDatumOhneZeit($ObjAusHGData[4]));
					$objPHPExcel->setActiveSheetIndex(1)->setCellValue('D'.$i, utf8_encode($ObjAusHGData[5]));					
					$objPHPExcel->setActiveSheetIndex(1)->setCellValue('E'.$i, $anAusObj);					
					$objPHPExcel->setActiveSheetIndex(1)->setCellValue('F'.$i, utf8_encode($ObjAusHGData[14]));										
					$objPHPExcel->setActiveSheetIndex(1)->setCellValue('G'.$i, $mpFestGe);						
					$objPHPExcel->setActiveSheetIndex(1)->setCellValue('H'.$i, $mp1);	
					$objPHPExcel->setActiveSheetIndex(1)->setCellValue('I'.$i, $mp2);	
					$objPHPExcel->setActiveSheetIndex(1)->setCellValue('J'.$i, $wbw);	
					$objPHPExcel->setActiveSheetIndex(1)->setCellValue('K'.$i, $prevStart);	
					$objPHPExcel->setActiveSheetIndex(1)->setCellValue('L'.$i, utf8_encode($ObjAusHGData[3]));
					
					$i++;	
					}
				}
				else
				{
				$objPHPExcel->setActiveSheetIndex(1)->setCellValue('B'.$i, "Es sind keine Objekte zugeordnet worden.");
				}
		$i++;				 
		}				 
	}

	$objPHPExcel->setActiveSheetIndex(1)->setCellValue('B1', 'Gesamtwert: '.$alles.'€');
	$objPHPExcel->setActiveSheetIndex(1)->getStyle('B1')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
	
	//bild objekte unten links
	$objDrawing = new PHPExcel_Worksheet_Drawing();
	$objDrawing->setName('Terms and conditions');
	$objDrawing->setDescription('Terms and conditions');
	$objDrawing->setPath("../../BL_BILDER/bl-text.png");
	$objDrawing->setCoordinates('A'.($i+2));
	$objDrawing->setWorksheet($objPHPExcel->setActiveSheetIndex(1));


	
	//spaltenbreite
	$objPHPExcel->setActiveSheetIndex(1)->getColumnDimension('A')->setAutoSize(true);								 
	$objPHPExcel->setActiveSheetIndex(1)->getColumnDimension('B')->setAutoSize(true);								 
	$objPHPExcel->setActiveSheetIndex(1)->getColumnDimension('C')->setAutoSize(true);								 
	$objPHPExcel->setActiveSheetIndex(1)->getColumnDimension('D')->setAutoSize(true);								 
	$objPHPExcel->setActiveSheetIndex(1)->getColumnDimension('E')->setAutoSize(true);	
	$objPHPExcel->setActiveSheetIndex(1)->getColumnDimension('F')->setAutoSize(true);
	$objPHPExcel->setActiveSheetIndex(1)->getColumnDimension('G')->setAutoSize(true);
	$objPHPExcel->setActiveSheetIndex(1)->getColumnDimension('H')->setAutoSize(true);
	$objPHPExcel->setActiveSheetIndex(1)->getColumnDimension('I')->setAutoSize(true);
	$objPHPExcel->setActiveSheetIndex(1)->getColumnDimension('J')->setAutoSize(true);
	$objPHPExcel->setActiveSheetIndex(1)->getColumnDimension('K')->setAutoSize(true);
	$objPHPExcel->setActiveSheetIndex(1)->getColumnDimension('L')->setAutoSize(true);
	$objPHPExcel->setActiveSheetIndex(1)->getColumnDimension('M')->setAutoSize(true);

	//überschriften-design
	$styleArray = array(
		'font' => array(
			'bold' => true,
		),
		'alignment' => array(
			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
		),
		'borders' => array(
			'top' => array(
				'style' => PHPExcel_Style_Border::BORDER_THIN,
			),
		),
		'fill' => array(
			'type' => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,
			'rotation' => 90,
			'startcolor' => array(
				'argb' => 'FFA0A0A0',
			),
			'endcolor' => array(
				'argb' => 'FFFFFFFF',
			),
		),
	);
	
	$objPHPExcel->setActiveSheetIndex(0)->getTabColor()->setRGB('FF0000');
	$objPHPExcel->setActiveSheetIndex(1)->getTabColor()->setRGB('00FF00');
	$objPHPExcel->setActiveSheetIndex(0)->getStyle('A3:E3')->applyFromArray($styleArray);				
	$objPHPExcel->setActiveSheetIndex(1)->getStyle('A3:M3')->applyFromArray($styleArray);	

	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$objWriter->save('php://output');
}
else
//WENN KEIN LOGIN => FEHLER
{
/** PHPExcel */
require_once '../../BL_EXCL/PHPExcel.php';


// Create new PHPExcel object
//echo date('H:i:s') . " Create new PHPExcel object\n";
$objPHPExcel = new PHPExcel();

// Set properties
//echo date('H:i:s') . " Set properties\n";
$objPHPExcel->getProperties()->setCreator("BORROW LAND")
							 ->setLastModifiedBy("BORROW LAND")
							 ->setTitle("Inventarliste BORROW LAND")
							 ->setSubject("Inventarliste BORROW LAND")
							 ->setDescription("Inventarliste BORROW LAND")
							 ->setKeywords("")
							 ->setCategory("");



// Miscellaneous glyphs, UTF-8
$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('A4', 'Bitte melden Sie sich an für diese Funktion.');
// Rename sheet
//echo date('H:i:s') . " Rename sheet\n";
$objPHPExcel->getActiveSheet()->setTitle('Fehlermeldung');

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
}

	
?>