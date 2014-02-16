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
?>
</head>


<body>
<NOSCRIPT>
<br><br><br><br><div class="meldung_fehler"><img src="../../BL_BILDER/Meldungen_Warning.png">Diese Webseite läuft leider nur, wenn Sie <a href="http://de.wikipedia.org/wiki/Javascript" target="_blank">Javascript</a> zulassen. <br>Bitte aktivieren Sie diesen technischen Standard in Ihrem Browser, Danke!</div>
<br><br>
</NOSCRIPT>	
		
<section id="page"> <!-- Defining the #page section with the section tag -->


            <header> <!-- Defining the header section of the page with the appropriate tag -->
            
            <hgroup>

<?
//#############Anfang Überschrift
?>
<hgroup><h1><a href="../../index.php" title="Startseite"><img src="../../BL_BILDER/start_00.png"></a> <a href="../../index.php" title="Startseite">borrow land</a></h1>
<?
$oeffentlich=0;
if ($oeffentlich=="1")
{
?>
<div id="ueberschr_all"><a href="../../">/Leihe</a><a href="../">/Verwaltung</a>/Protokoll</div>
</hgroup>
<?
}
else
{
	if (isset($_SESSION["User_ID"]) && $_SESSION["User_ID"]!="")
	{	
	?>
	<div id="ueberschr_all"><a href="../../">/Leihe</a><a href="../">/Verwaltung</a>/Protokoll</div>
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
<div id="loadingAj"></div>


            <section id="articles"> 
			
<?
//anfang voraussetzung: registriert, admin oder ausgabeberechtigter
if (isset($_SESSION["User_ID"]) && $_SESSION["User_Recht_Admin"]=="1")
{
?>

<article id="articleLogin2"> 
<h2>Protokoll</h2>
	
<div class="line"></div>
	<div class="articleBody clear" >
	<p>Erhalten Sie einen Überblick über die wichtigsten Ereignisse in borrow land.</p>
		<?
		if (welcheEinstellung(SE_ProtokollAnAus)=="0")
		{
		echo "Die Protokoll Funktion ist deaktiviert. Sie können diese Funktion <a href='../software'><b>hier</b></a> aktivieren.";
		}
		else
		{
		?>
	
		<table cellpadding="0" cellspacing="0" border="0" class="display" id="protoData">	
		<thead>
			<tr>
				<th>Zeitpunkt</th>
				<th>Gruppe</th>
				<th>Untergruppe</th>
				<th>Beschreibung</th>
			</tr>
		</thead>
	
		<tbody>
		<?
		$sql = 'SELECT wann,gruppe,untergruppe,descr FROM `02_protokoll`  '; 
		$protDataAll = mysql_query($sql);

		while ($protData = mysql_fetch_array($protDataAll, MYSQL_NUM))
		{
			if ($protData[1]=="0")
			{
			$gruppe="Allgemein";
				if ($protData[2]=="0")
				{
				$ug="gelöscht";
				}
				if ($protData[2]=="1")
				{
				$ug="hinzugefügt";
				}
				if ($protData[2]=="2")
				{
				$ug="geändert";
				}
			}
			if ($protData[1]=="1")
			{
			$gruppe="Benutzer";
				if ($protData[2]=="0")
				{
				$ug="gelöscht";
				}
				if ($protData[2]=="1")
				{
				$ug="hinzugefügt";
				}
				if ($protData[2]=="2")
				{
				$ug="geändert";
				}
			}
			if ($protData[1]=="2")
			{
			$gruppe="Sicherheit";
				if ($protData[2]=="0")
				{
				$ug="niedrig";
				}
				if ($protData[2]=="1")
				{
				$ug="mittel";
				}
				if ($protData[2]=="3")
				{
				$ug="hoch";
				}
			}		
			if ($protData[1]=="3")
			{
			$gruppe="Paßwort";
			
				if ($protData[2]=="1")
				{
				$ug="Nutzerseitige Änderung nach Login des Nutzers";
				}
				if ($protData[2]=="2")
				{
				$ug="Systemänderung ohne Login des Nutzers";
				}
			}
			if ($protData[1]=="4")
			{
			$gruppe="Automatische Datenlöschung";
			
				if ($protData[2]=="1")
				{
				$ug="Warenkorb";
				}
				
				if ($protData[2]=="2")
				{
				$ug="Benutzer";
				}
			}
			
		if ($protData[1]=="2" && $protData[2]=="3")
		{
		echo "<tr class='gradeX'><td>".$protData[0]."</td><td>".$gruppe."</td><td>".$ug."</td><td>".utf8_encode(strip_tags($protData[3]))."</td></tr>";
		}
		else
		{
		echo "<tr><td>".$protData[0]."</td><td>".$gruppe."</td><td>".$ug."</td><td>".utf8_encode(strip_tags($protData[3]))."</td></tr>";
		}
			
			
		}
		?>
		</tbody>
</table>
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
?>  
<script type="text/javascript" src="../../BL_JS/jquery.dataTables.js"></script>


<?
if (isset($_SESSION["User_ID"]) && $_SESSION["User_Recht_Admin"]=="1")
{
?>
<script>
$(document).ready(function() {
	
	 $('#protoData').dataTable( {
		"bJQueryUI": true,
		"bStateSave": true,
		"sPaginationType": "full_numbers",
	});
} );


$("#loadingAj").hide();
$("#loadingAj").ajaxStart(function(){
   $(this).show();
 });
 $("#loadingAj").ajaxStop(function(){
   $(this).hide();
 });
 $("input:text:visible:first").focus();

</script>

<?
}
?>





<?
echo utf8_encode($_SESSION["SE_EndeIndex"]);
?>

<br><br><br><br><br><br>
</body>
</html>