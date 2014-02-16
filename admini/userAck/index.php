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
<div id="ueberschr_all"><a href="../../">/Leihe</a><a href="../">/Verwaltung</a>/Benutzer bestätigen</div>
</hgroup>
<?
}
else
{
	if (isset($_SESSION["User_ID"]) && $_SESSION["User_ID"]!="")
	{	
	?>
	<div id="ueberschr_all"><a href="../../">/Leihe</a><a href="../">/Verwaltung</a>/Benutzer bestätigen</div>
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
<div id="output"></div>

            <section id="articles"> 
			
<?
//anfang voraussetzung: registriert, admin oder ausgabeberechtigter
if (isset($_SESSION["User_ID"]) && $_SESSION["User_Recht_Admin"]=="1" || $_SESSION["User_Recht_Bestaet"]=="1")
{
?>

<article id="articleLogin2"> 
<h2>Benutzer bestätigen</h2>
	
<div class="line"></div>
	<div class="articleBody clear" >

		<table cellpadding="0" cellspacing="0" border="0" class="display" id="userData">	
		<thead>
			<tr>
				<th>Name</th>
				<th>Profil</th>
				<th>Registrierung</th>
				<?
				if (welcheEinstellung(SE_AccessContrYN)=="1")
				{
				echo "<th>".welcheEinstellung(SE_AccessContrName)."</th>";
				}
				?>
				<th>Bestätigen</th>
				
			</tr>
		</thead>
	
		<tbody>
		<?
		$sql = 'SELECT vn_nn,tn,m_id,email,adr_strasse_hn,adr_plz,adr_stadt,ProfOnOff,userreg_selbst,lastlogin,specid_cyrpt_md5,rechte_admin,userreg_bestaet FROM `01_Benutzer` WHERE `userreg_bestaet` = 0 ORDER BY `userreg_selbst` ASC '; 
		$usRDataSqlAll = mysql_query($sql);

		while ($usRDataSql = mysql_fetch_array($usRDataSqlAll, MYSQL_NUM))
		{
			
			if (welcheEinstellung(SE_AdressModuleYesNo)=="1")
			{
			$titleUeberName="Adresse: ".$usRDataSql[4]." ".$usRDataSql[5]." ".$usRDataSql[6]." Telefonnumer: ".$usRDataSql[1];
			}
			else
			{
			$titleUeberName="Telefonnumer: ".$usRDataSql[1];
			}
		
			if (welcheEinstellung(SE_AccessContrYN)=="1")
			{
				if ($usRDataSql[12]=="0")
				{
				$DatumBestae="-";
				}
				echo "<tr";
				if ($usRDataSql[11]=="1")
				{
				echo " class='gradeA'";
				}
				echo "><td title='".utf8_encode(htmlspecialchars($titleUeberName))."'>".utf8_encode(htmlspecialchars($usRDataSql[0]))." <a href='mailto:".utf8_encode(htmlspecialchars($usRDataSql[3]))."'><span style='float:right' class='ui-icon ui-icon-mail-closed' title='E-Mail senden'></span></a> </td><td>";
				if ($usRDataSql[7]=="1")
				{
				echo 'an';
				}
				else
				{
				echo 'aus';
				}
				echo "</td><td>".utf8_encode(htmlspecialchars(timeCdZuDatumMitZeit($usRDataSql[8])))."</td><td>".utf8_encode(htmlspecialchars($usRDataSql[2]))."</td><td>";
				echo "<input type=\"checkbox\" name=\"check4\" value=\"".base64_encode(serialize($usRDataSql[10]))."\"></td>";
			}
			else
			{
				if ($usRDataSql[12]=="0")
				{
				$DatumBestae="-";
				}
				echo "<tr";
				if ($usRDataSql[11]=="1")
				{
				echo " class='gradeA'";
				}
				echo "><td title='".utf8_encode(htmlspecialchars($titleUeberName))."'>".utf8_encode(htmlspecialchars($usRDataSql[0]))." <a href='mailto:".utf8_encode(htmlspecialchars($usRDataSql[3]))."'><span style='float:right' class='ui-icon ui-icon-mail-closed' title='E-Mail senden'></span></a> </td><td>";
				if ($usRDataSql[7]=="1")
				{
				echo 'an';
				}
				else
				{
				echo 'aus';
				}
				echo "</td><td>".utf8_encode(htmlspecialchars(timeCdZuDatumMitZeit($usRDataSql[8])))."</td><td>";
				echo "<input type=\"checkbox\" name=\"check4\" value=\"".base64_encode(serialize($usRDataSql[10]))."\"></td>";
				}
		
		}
		?>
		</tbody>
</table>

<input aria-disabled="false" id="bestSel" class="ui-button ui-widget ui-state-default ui-corner-all ui-state-hover" style="float:right;margin-top:20px" value="Markierte Nutzer bestätigen" type="submit"> 

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
if ($_SESSION["User_Recht_Admin"]=="1" || $_SESSION["User_Recht_Bestaet"]=="1")
{
?>
<script>


	daten = new Array();
	var daten2;
	
    $("#bestSel").click(function () {
	$("input:checked").each(function(index) {
	daten = daten.concat($(this).val());
	});
	var daten2 = daten.join("|");
	$("#output").load("01_AckUsr.inc.php?b="+daten2);
	daten = new Array();
	var daten2;
    });
	
	
$(document).ready(function() {
	

	$('#userData').dataTable( {
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