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
$pdf->Text( 20, 33, 'Übersicht Reservierungen:'); 


$pdf->SetFont('Arial','',9);
		$sql = "SELECT specid_wk,erstellt_am FROM `05_wk` WHERE `owner` = \"".$_SESSION["User_ID"]."\" ORDER BY `erstellt_am` DESC"; 
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
				$hoeheObjektY=50;
				}
				else
				{
				$hoeheObjektY=($obj*140)+50;
				}
				
				$sql2 = "SELECT id FROM `06_wkObje` WHERE `wkid` = \"".$WKs[0]."\""; 
				$ReservWKobj = mysql_query($sql2);
				$anzahlWKobj = mysql_num_rows($ReservWKobj); 

				$sql3 = "SELECT * FROM `06_wkObje` WHERE `wkid` = \"".$WKs[0]."\" AND `abgeholt` IS NOT NULL";
				$objektSchonWeg = mysql_query($sql3);
				$anzahlSchonWeg = mysql_num_rows($objektSchonWeg);
				
				$pdf->Image("http://chart.apis.google.com/chart?chs=130x130&cht=qr&chld=Q|0&chl=w-".$WKs[0], 30, $hoeheObjektY, 0, 0, 'png');	
				$pdf->Text( 250, $hoeheObjektY+40, "Information zu diesem Warenkorb:"); 
				$pdf->Text( 250, $hoeheObjektY+60, "w-".$WKs[0]); 
				$pdf->Text( 250, $hoeheObjektY+70, "Erstellt am: ".timeCdZuDatumMitZeit($WKs[1]));
				$pdf->Text( 250, $hoeheObjektY+80, "Anzahl der Objekte: ".$anzahlWKobj);
				$pdf->Text( 250, $hoeheObjektY+90, "Bereits verliehen: ".$anzahlSchonWeg. " Objekt/e");
				
				if ($obj % 4 =="0" && $obj!="0" && $obj2<$anzahlWK)
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
$pdf->Output("borrow-land-leihuebersicht.pdf", "D");
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
$pdf->Output("borrow-land-leihuebersicht.pdf", "I");
}
?>