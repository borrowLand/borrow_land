<?
session_start();


//System 
/////////////////////////////////////////////
$includeName="../../_00_basic_check.inc.php";
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


?>

<!DOCTYPE html> 
<html>
<head>
<?
echo eval(welcheEinstellung("SE_headBereich"));


if (isset($_SESSION["User_ID"]) && $_SESSION["User_Recht_Admin"]=="1" || $_SESSION["User_Recht_Ausgabeber"]=="1")
{
//tacho auslastung
$sql = 'SELECT count(*) FROM `04_obj_objekte` WHERE `ObjOnOff` = 1'; 
$AnfrageObj = mysql_query($sql);
$anzahlObjs = mysql_fetch_row($AnfrageObj);

//anzahl aller aktiven objekte
if ($anzahlObjs[0]>0)
{
$sql = 'SELECT count(*) FROM `06_wkObje` WHERE `abgeholt` IS NOT NULL AND `gebracht` IS NULL'; 
$AnfrageObjWeg = mysql_query($sql);
$anzahlObjWeg = mysql_fetch_row($AnfrageObjWeg);
$prozentAuslastung=round(($anzahlObjWeg[0]/$anzahlObjs[0])*100);
}


//hauptgruppen
$sql = 'SELECT count(*) FROM `03_obj_hauptgruppen` WHERE `HGruppenOnOff` = 1'; 
$Anfrage = mysql_query($sql);
$anzahlHGs = mysql_fetch_row($Anfrage);
if ($anzahlHGs[0]>0)
{
$sql2 = 'SELECT count(*) FROM `03_obj_hauptgruppen` WHERE `HGruppenOnOff` = 0'; 
$Anfrage2 = mysql_query($sql2);
$anzahldeaktHGs = mysql_fetch_row($Anfrage2);

//$anzahlHGs[0]
//$anzahldeaktHGs[0]


}

//objekte
$sql = 'SELECT count(*) FROM `04_obj_objekte` WHERE `ObjOnOff` = 1'; 
$AnfrageObj = mysql_query($sql);
$anzahlObjAKT = mysql_fetch_row($AnfrageObj);
if ($anzahlObjs[0]>0)
{
$sql2 = 'SELECT count(*) FROM `04_obj_objekte` WHERE `ObjOnOff` = 0'; 
$Anfrage2 = mysql_query($sql2);
$anzahlDeaktObjs = mysql_fetch_row($Anfrage2);


$sql3 = 'SELECT count(*) FROM `06_wkObje` '; 
$Anfrage3 = mysql_query($sql3);
$anzahlObjinWks = mysql_fetch_row($Anfrage3);

//$anzahlObjAKT[0]
//$anzahlDeaktObjs[0]
//anzahlObjinWks[0]
}




//warenkörbe
$sql = 'SELECT count(*) FROM `05_wk`'; 
$AnfrageWK = mysql_query($sql);
$anzahlWK = mysql_fetch_row($AnfrageWK);
if ($anzahlObjs[0]>0)
{
$sql2 = 'SELECT count(*) FROM `07_wkHistory`'; 
$AnfrageWK2 = mysql_query($sql2);
$anzahlWKDeakt = mysql_fetch_row($AnfrageWK2);
//$anzahlWK[0]
//$anzahlWKDeakt[0]
}

//protokoll
if ($_SESSION["SE_ProtokollAnAus"]=="1")
{
$sql1 = 'SELECT count(*) FROM `02_protokoll` WHERE `gruppe` = 0'; 
$Anfrage1 = mysql_query($sql1);
$anzahl1 = mysql_fetch_row($Anfrage1);

$sql2 = 'SELECT count(*) FROM `02_protokoll` WHERE `gruppe` = 1'; 
$Anfrage2 = mysql_query($sql2);
$anzahl2 = mysql_fetch_row($Anfrage2);

$sql3 = 'SELECT count(*) FROM `02_protokoll` WHERE `gruppe` = 2'; 
$Anfrage3 = mysql_query($sql3);
$anzahl3 = mysql_fetch_row($Anfrage3);

$sql4 = 'SELECT count(*) FROM `02_protokoll` WHERE `gruppe` = 3'; 
$Anfrage4 = mysql_query($sql4);
$anzahl4 = mysql_fetch_row($Anfrage4);

$sql5 = 'SELECT count(*) FROM `02_protokoll` WHERE `gruppe` = 4'; 
$Anfrage5 = mysql_query($sql5);
$anzahl5 = mysql_fetch_row($Anfrage5);

}

// zeitauswertung: Auslastung, Nutzer; aktiveHG=9
$sql1 = 'SELECT datum,aktiveObjekte, ausgegebeneObjekte,NutzerGesamt,NutzerAusleihe,NutzerAusgabe,NutzerDL,NutzerBestaetig,NutzerAdmin,aktiveHG,deaktiveHG,deaktiveObjekte,aktiveObjekte,aktiveWKs,beendteWKs,reservierteObjeGesamt,reservierteObjeBeendet,SummeWiederBesc,dateiGrMediaVerz FROM `08_statistik` ORDER BY `no` ASC '; 
$AnfrageStat1 = mysql_query($sql1);
$AnfrageStat2 = mysql_query($sql1);
$AnfrageStat3 = mysql_query($sql1);
$AnfrageStat4 = mysql_query($sql1);
$AnfrageStat5 = mysql_query($sql1);
$AnfrageStat6 = mysql_query($sql1);
$AnfrageStat7 = mysql_query($sql1);
$AnfrageStat8 = mysql_query($sql1);




?>	

<script type='text/javascript' src='https://www.google.com/jsapi'></script>
<script type='text/javascript'>
google.load('visualization', '1', {packages:['gauge']});
google.load("visualization", "1", {packages:["corechart"]});



google.setOnLoadCallback(drawChart);
function drawChart() {
	var data = new google.visualization.DataTable();
	data.addColumn('string', 'Label');
	data.addColumn('number', 'Value');
	data.addRows(1);
	data.setValue(0, 0, 'Auslastung');
	data.setValue(0, 1, <? echo $prozentAuslastung; ?>);

	var chart = new google.visualization.Gauge(document.getElementById('chart_div1'));
	var options = {width: 500, height: 250, greenFrom:0, greenTo:75, redFrom: 90, redTo: 100,
	yellowFrom:75, yellowTo: 90, minorTicks: 5};
	chart.draw(data, options);
}
</script>


<script type="text/javascript">
google.setOnLoadCallback(drawChart);
function drawChart() {
	var data = new google.visualization.DataTable();
	data.addColumn('string', 'Zuordnung');
	data.addColumn('number', 'aktiviert');
	data.addColumn('number', 'deaktiviert');
	data.addRows(2);
	data.setValue(0, 0, 'Hauptgruppen');
	data.setValue(0, 1, <? echo $anzahlHGs[0]; ?>);
	data.setValue(0, 2, <? echo $anzahldeaktHGs[0]; ?>);
	data.setValue(1, 0, 'Objekte');
	data.setValue(1, 1, <? echo $anzahlObjAKT[0]; ?>);
	data.setValue(1, 2, <? echo $anzahlDeaktObjs[0]; ?>);


	var chart = new google.visualization.ColumnChart(document.getElementById('chart_div2'));
	chart.draw(data, {width: 600, height: 350, title: 'Verfügbarkeit',
					  hAxis: {title: '', titleTextStyle: {color: 'red'}}
					 });
}
</script>

<script type="text/javascript">
google.setOnLoadCallback(drawChart);
function drawChart() {
	var data = new google.visualization.DataTable();
	data.addColumn('string', 'Warenkörbe');
	data.addColumn('number', 'Anzahl');
	data.addRows(3);
	data.setValue(0, 0, 'aktive');
	data.setValue(0, 1, <? echo $anzahlWK[0]; ?>);
	data.setValue(1, 0, 'beendet');
	data.setValue(1, 1, <? echo $anzahlWKDeakt[0]; ?>);
	data.setValue(2, 0, 'Objekte in Warenkörben');
    data.setValue(2, 1, <? echo $anzahlObjinWks[0]; ?>);


	var chart = new google.visualization.ColumnChart(document.getElementById('chart_div3'));
	chart.draw(data, {width: 600, height: 350, title: 'Warenkörbe',
					  hAxis: {title: '', titleTextStyle: {color: 'red'}}
					 });
}
</script>

<script type="text/javascript">
  google.setOnLoadCallback(drawChart);
  function drawChart() {
	var data = new google.visualization.DataTable();
	data.addColumn('string', 'A');
	data.addColumn('number', 'B');
	data.addRows(5);
	data.setValue(0, 0, 'Allgemein');
	data.setValue(0, 1, <? echo $anzahl1[0]; ?>);
	data.setValue(1, 0, 'Benutzer');
	data.setValue(1, 1, <? echo $anzahl2[0]; ?>);
	data.setValue(2, 0, 'Sicherheit');
	data.setValue(2, 1, <? echo $anzahl3[0]; ?>);
	data.setValue(3, 0, 'Passwort');
	data.setValue(3, 1, <? echo $anzahl4[0]; ?>);
	data.setValue(4, 0, 'automat. Datenlöschung');
	data.setValue(4, 1, <? echo $anzahl5[0]; ?>);

	var chart = new google.visualization.PieChart(document.getElementById('chart_div4'));
	chart.draw(data, {width: 600, height: 350, title: 'Protokollmeldungen'});
  }
</script>


<script type="text/javascript">
  google.setOnLoadCallback(drawVisualization);
function drawVisualization() {
  // Create and populate the data table.
  var data = new google.visualization.DataTable();
  data.addColumn('string', 'x');
  data.addColumn('number', 'Auslastung');
 
<?
	while ($DatenStat1 = mysql_fetch_array($AnfrageStat1, MYSQL_NUM))
	{
	$teileDatumZeit1 = explode(" ", $DatenStat1[0]);
	?>
data.addRow(["<? echo $teileDatumZeit1[0]; ?>", <? echo round(($DatenStat1[2]/$DatenStat1[1])*100); ?>]);
	<?
	}
?>
	var chart = new google.visualization.LineChart(document.getElementById('chart_div5'));
	chart.draw(data, {curveType: "function", width: 600, height: 350, title: 'Auslastung'} );
	
	

}
</script>

<script type="text/javascript">
  google.setOnLoadCallback(drawVisualization2);
function drawVisualization2() {
  // Create and populate the data table.
  var data = new google.visualization.DataTable();
  data.addColumn('string', 'x');
  data.addColumn('number', 'Gesamt');
  data.addColumn('number', 'Ausleiheberechtigt');
  data.addColumn('number', 'Ausgabeberechtigt');
  data.addColumn('number', 'Dauerleihe-Nutzer');
  data.addColumn('number', 'Bestätiger');
  data.addColumn('number', 'Admin');
<?
	while ($DatenStat2 = mysql_fetch_array($AnfrageStat2, MYSQL_NUM))
	{
	$teileDatumZeit2 = explode(" ", $DatenStat2[0]);
	?>
data.addRow(["<? echo $teileDatumZeit2[0]; ?>",<? echo $DatenStat2[3]; ?>,<? echo $DatenStat2[4]; ?>,<? echo $DatenStat2[5]; ?>,<? echo $DatenStat2[6]; ?>,<? echo $DatenStat2[7]; ?>,<? echo $DatenStat2[8]; ?> ]);
	<?
	}
?>

	var chart = new google.visualization.LineChart(document.getElementById('chart_div6'));
	chart.draw(data, {curveType: "function", width: 600, height: 350, title: 'Benutzerentwicklung'} );
}
</script>

<script type="text/javascript">
google.setOnLoadCallback(drawVisualization3);
function drawVisualization3() {
// Create and populate the data table.
var data = new google.visualization.DataTable();
data.addColumn('string', 'x');
data.addColumn('number', 'aktive HG');
data.addColumn('number', 'deaktive HG');
data.addColumn('number', 'Gesamt');


<?
	while ($DatenStat3 = mysql_fetch_array($AnfrageStat3, MYSQL_NUM))
	{
	$teileDatumZeit3 = explode(" ", $DatenStat3[0]);
	?>
data.addRow(["<? echo $teileDatumZeit3[0]; ?>",<? echo $DatenStat3[9]; ?>,<? echo $DatenStat3[10]; ?>,<? echo $DatenStat3[10]+$DatenStat3[9]; ?>]);
	<?
	}
?>

	var chart = new google.visualization.LineChart(document.getElementById('chart_div7'));
	chart.draw(data, {curveType: "function", width: 600, height: 350, title: 'Hauptgruppen'} );
}
</script>

<script type="text/javascript">
google.setOnLoadCallback(drawVisualization4);
function drawVisualization4() {
// Create and populate the data table.
var data = new google.visualization.DataTable();
data.addColumn('string', 'x');
data.addColumn('number', 'aktive Objekte');
data.addColumn('number', 'deaktive Objekte');
data.addColumn('number', 'Gesamt');

<?
	while ($DatenStat4 = mysql_fetch_array($AnfrageStat4, MYSQL_NUM))
	{
	$teileDatumZeit4 = explode(" ", $DatenStat4[0]);
	?>
data.addRow(["<? echo $teileDatumZeit4[0]; ?>",<? echo $DatenStat4[12]; ?>,<? echo $DatenStat4[11]; ?>,<? echo $DatenStat4[12]+$DatenStat4[11]; ?>]);
	<?
	}
?>

	var chart = new google.visualization.LineChart(document.getElementById('chart_div8'));
	chart.draw(data, {curveType: "function", width: 600, height: 350, title: 'Objekte'} );
}
</script>

<script type="text/javascript">
google.setOnLoadCallback(drawVisualization5);
function drawVisualization5() {
// Create and populate the data table.
var data = new google.visualization.DataTable();
data.addColumn('string', 'x');
data.addColumn('number', 'aktive WKe');
data.addColumn('number', 'beendete WKe');

<?
	while ($DatenStat5 = mysql_fetch_array($AnfrageStat5, MYSQL_NUM))
	{
	$teileDatumZeit5 = explode(" ", $DatenStat5[0]);
	?>
data.addRow(["<? echo $teileDatumZeit5[0]; ?>",<? echo $DatenStat5[13]; ?>,<? echo $DatenStat5[14]; ?>]);
	<?
	}
?>

	var chart = new google.visualization.LineChart(document.getElementById('chart_div9'));
	chart.draw(data, {curveType: "function", width: 600, height: 350, title: 'Warenkörbe (WK)'} );
}
</script>


<script type="text/javascript">
  google.setOnLoadCallback(drawVisualization6);
function drawVisualization6() {
  // Create and populate the data table.
  var data = new google.visualization.DataTable();
  data.addColumn('string', 'x');
  data.addColumn('number', 'Gesamt');
  data.addColumn('number', 'ausgegebene Obj.');
  data.addColumn('number', 'reservierte Obj.');
  data.addColumn('number', 'beendete Obj.');
<?
	while ($DatenStat6 = mysql_fetch_array($AnfrageStat6, MYSQL_NUM))
	{
	$teileDatumZeit6 = explode(" ", $DatenStat6[0]);
	?>
data.addRow(["<? echo $teileDatumZeit6[0]; ?>",<? echo $DatenStat6[2]+$DatenStat6[15]+$DatenStat6[16]; ?>,<? echo $DatenStat6[2]; ?>,<? echo $DatenStat6[15]; ?>,<? echo $DatenStat6[16]; ?> ]);
	<?
	}
?>

	var chart = new google.visualization.LineChart(document.getElementById('chart_div10'));
	chart.draw(data, {curveType: "function", width: 600, height: 350, title: 'Objekte in Reservierung'} );
}
</script>


<script type="text/javascript">
  google.setOnLoadCallback(drawVisualization);
function drawVisualization() {
  // Create and populate the data table.
  var data = new google.visualization.DataTable();
  data.addColumn('string', 'x');
  data.addColumn('number', 'Werte-Entwicklung');
 
<?
	while ($DatenStat7 = mysql_fetch_array($AnfrageStat7, MYSQL_NUM))
	{
	$teileDatumZeit7 = explode(" ", $DatenStat7[0]);
	?>
data.addRow(["<? echo $teileDatumZeit7[0]; ?>", <? echo $DatenStat7[17]; ?>]);
	<?
	}
?>
	var chart = new google.visualization.LineChart(document.getElementById('chart_div11'));
	chart.draw(data, {curveType: "function", width: 600, height: 350, title: 'Werte-Entwicklung'} );
	
	

}
</script>

<script type="text/javascript">
  google.setOnLoadCallback(drawVisualization);
function drawVisualization() {
  // Create and populate the data table.
  var data = new google.visualization.DataTable();
  data.addColumn('string', 'x');
  data.addColumn('number', 'Speicherplatz (MB)');
 
<?
	while ($DatenStat8 = mysql_fetch_array($AnfrageStat8, MYSQL_NUM))
	{
	$teileDatumZeit8 = explode(" ", $DatenStat8[0]);
	?>
data.addRow(["<? echo $teileDatumZeit8[0]; ?>", <? echo $DatenStat8[18]; ?>]);
	<?
	}
?>
	var chart = new google.visualization.LineChart(document.getElementById('chart_div12'));
	chart.draw(data, {curveType: "function", width: 600, height: 350, title: 'Speicherplatz (MB)'} );
	
	

}
</script>

<?
}
?>



</head>


<body>
<NOSCRIPT>
<br><br><br><br><div class="meldung_fehler"><img src="../../BL_BILDER/Meldungen_Warning.png">Diese Webseite läuft leider nur, wenn Sie <a href="http://de.wikipedia.org/wiki/Javascript" target="_blank">Javascript</a> zulassen. <br>Bitte aktivieren Sie diesen technischen Standard in Ihrem Browser, Danke!</div>
<br><br>
</NOSCRIPT>	
		
<section id="page"> 


            <header> 
<?
//#############Anfang Überschrift
?>
<hgroup><h1><a href="../../index.php" title="Startseite"><img src="../../BL_BILDER/start_00.png"></a> <a href="../../index.php" title="Startseite">borrow land</a></h1>
<?
$oeffentlich=0;
if ($oeffentlich=="1")
{
?>
<div id="ueberschr_all"><a href="../../">/Leihe</a><a href="../">/Verwaltung</a>/Status</div>
</hgroup>
<?
}
else
{
	if (isset($_SESSION["User_ID"]) && $_SESSION["User_ID"]!="")
	{	
	?>
	<div id="ueberschr_all"><a href="../../">/Leihe</a><a href="../">/Verwaltung</a>/Status</div>
	</hgroup>
	<?
	}
}
//#############Ende Überschrift	

	//navigation
	/////////////////////////////////////////////
	$includeName="../../_00_basic_nav.inc.php";
	if (file_exists($includeName))
	{
	require($includeName);
	}	
	else
	{
	echo '<br><br><div class="meldung_fehler"><img src="BL_BILDER/Meldungen_Warning.png"> <br>SESS_FU_LOAD_01</div><br><br>';	
	exit();
	}
	/////////////////////////////////////////////
?>
			
            </header>

            <section id="articles"> 
		
		
<?
//anfang voraussetzung registriert
if (isset($_SESSION["User_ID"]) && $_SESSION["User_Recht_Admin"]=="1" || $_SESSION["User_Recht_Ausgabeber"]=="1")
{
?>
<article id="articleLogin2"> 
<h2>Status</h2>
	
<div class="line"></div>
	<div class="articleBody clear" align="center">
	<br><br>
	
<div id='chart_div1'></div><br>
Auslastung: Das prozentuale Verhältnis  <br>
zwischen allen aktiven Objekten und den  <br>
Objekten, die gerade ausgegeben worden sind.

<br><br><br>
<hr>
<br><br><br>

<div id='chart_div2'></div><br>
Aktivierte und Deaktivierte Hauptgruppen / Objekte


<br><br><br>
<hr>
<br><br><br>


<div id='chart_div3'></div><br>
Aktive Warenkörbe, Beendete Warenkörbe,<br> 
Anzahl Objekte in den aktiven Warenkröben


<br><br><br>
<hr>
<br><br><br>


<div id='chart_div4'></div><br>
Anteil der Meldebereiche im Protokoll

<?
if (welcheEinstellung("SE_cronJob")=="1")
{
?>
	<br><br><br>
	<hr>
	<br><br><br>
	Ab diesem Bereich finden Sie alle zeitlichen Auswertungen.
	<br><br><br>
	<hr>
	<br><br><br>

	<div id='chart_div5'></div><br>
	Auslastung der Ausleihe in %<br>
	(Quotient ausgegebene Objekte/aktive Objekte)

	<br><br><br>
	<hr>
	<br><br><br>

	<div id='chart_div7'></div><br>
	Entwicklung der Hauptgruppen
		
	<br><br><br>
	<hr>
	<br><br><br>
	
	<div id='chart_div8'></div><br>
	Entwicklung der Objekte
		
	<br><br><br>
	<hr>
	<br><br><br>
	
	<div id='chart_div9'></div><br>
	Entwicklung der Warenkörbe
		
	<br><br><br>
	<hr>
	<br><br><br>	
	
	<div id='chart_div10'></div><br>
	Objekte in Reservierung
		
	<br><br><br>
	<hr>
	<br><br><br>

	<div id='chart_div6'></div><br>
	Benutzerentwicklung
		
		
	<br><br><br>
	<hr>
	<br><br><br>

	<div id='chart_div11'></div><br>
	Werte-Entwicklung<br>
	Summe aller Wiederbeschaffungswerte

	<br><br><br>
	<hr>
	<br><br><br>		
			
	<div id='chart_div12'></div><br>
	Speicherplatz Media Dateien (Bilder & PDF) in MB<br>
		
				
	
	
	
	
	
	
	
<?
}
?>	
	
	</div>

</article>
<?
}//ende voraussetzung registriert
else
{
	//nicht eingeloggt
	/////////////////////////////////////////////
	$includeName="../../_02_NoLoginAllPages.inc.php";
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
}
?>
			


            </section>

		 <?
		 if ($_SESSION["SE_GooTrans"]=="1")
		 {
					// Start Google Translate -->
   					echo $_SESSION["SE_GooTransScript"];
					// Ende Google Translate -->
		}
		?>		

			
<?
//Footer 
/////////////////////////////////////////////
$includeName="../../_00_basic_footer.php";
if (file_exists($includeName))
{
include_once($includeName);
}	
else
{
echo '<br><br><div class="meldung_fehler"><img src="../../BL_BILDER/Meldungen_Warning.png"> <br>FOOTER_FU_LOAD</div><br><br>';	
exit();
}

/////////////////////////////////////////////			
?>  
	        
 
		 

        
<!-- JavaScript Includes -->
<?
echo nl2br($_SESSION["SE_jQuerUI"]);
echo utf8_encode($_SESSION["SE_EndeIndex"]);
?>

<br><br><br><br><br><br>
</body>
</html>