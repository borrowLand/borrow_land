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
//$_GET['o']

define('FPDF_FONTPATH','../../BL_PDF/font/');
require("../../BL_PDF/fpdf.php");

if (isset($_SESSION["User_ID"]))
{
//check, ob die wk wirlich existiert



$pdf=new FPDF('P','pt','A4');
$pdf->AddPage();


$pdf->SetFont('Arial','',12);
$pdf->Text( 20, 22, $_SESSION['SE_Kundenname']); 

$pdf->SetFont('Arial','',10);
$pdf->Text( 20, 33, 'Übersicht Objekte (z.B. für Regalbeschriftung)'); 


$pdf->SetFont('Arial','',9);
		$sql = "SELECT specid_obj,ErstelltAm,Kurzbez FROM `04_obj_objekte` ORDER BY `ErstelltAm` DESC"; 
		$ReservWK = mysql_query($sql);
		$anzahlWK = mysql_num_rows($ReservWK); 
		
		
		$obj=0;
		$obj2=1;	//für den zeilenumbruch, damit nicht bei 5 oder 10 objekten ein unnötiger zeilenumbruch gemacht wird.
		if ($anzahlWK>0)
		{

			while ($WKs = mysql_fetch_array($ReservWK, MYSQL_NUM))
			{
				if ($obj=="0")
				{
				$hoeheObjektY=40;
				}
				else
				{
				$hoeheObjektY=($obj*90)+40;
				}
				
				$pdf->Image("http://chart.apis.google.com/chart?chs=80x80&cht=qr&chld=Q|0&chl=o-".$WKs[0], 30, $hoeheObjektY, 0, 0, 'png');	
				$pdf->Text( 250, $hoeheObjektY+20, "Information zu diesem Objekt:"); 
				$pdf->Text( 250, $hoeheObjektY+40, "o-".$WKs[0]); 
				$pdf->Text( 250, $hoeheObjektY+50, "Erstellt am: ".timeCdZuDatumMitZeit($WKs[1]));
				$pdf->Text( 250, $hoeheObjektY+60, "Name: ".$WKs[2]);
				
				if ($obj % 7 =="0" && $obj!="0" && $obj2<$anzahlWK)
				{
				$pdf->AddPage();
				$obj=0;
				}
				else
				{
				$obj++;
				}
				$obj2++;
			}
				
				

		}


$pdf->SetDisplayMode( 'fullpage' );
$pdf->SetKeywords( 'Ausleihsoftware, Mietsoftware' );
$pdf->SetTitle( 'BORROW LAND PDF Dokument' );
$pdf->SetSubject( 'BORROW LAND PDF Dokument' );
$pdf->SetAuthor( 'http://www.ausleihsoftware.de' );
$pdf->SetCreator('http://www.ausleihsoftware.de'); 
$pdf->Output("borrow-land-objekteuebersicht.pdf", "D");
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
$pdf->SetAuthor( 'BORROW LAND' );
$pdf->SetCreator('BORROW LAND'); 
$pdf->Output("borrow-land-objekteuebersicht.pdf", "I");
}
?>