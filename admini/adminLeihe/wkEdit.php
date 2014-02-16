<?
session_start();
	if (isset($_SESSION["User_ID"]))
	{

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
<div id="ueberschr_all"><a href="../../">/Leihe</a><a href="../">/Verwaltung</a><a href="index.php">/Ausleiheverwaltung</a>/Warenkorb Eigenschaften</div>
</hgroup>
<?
}
else
{
	if (isset($_SESSION["User_ID"]) && $_SESSION["User_ID"]!="")
	{	
	?>
<div id="ueberschr_all"><a href="../../">/Leihe</a><a href="../">/Verwaltung</a><a href="index.php">/Ausleiheverwaltung</a>/Warenkorb Eigenschaften</div>
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
<div id="ajaWKCon"></div>
	
<section id="articles"> 
			
<?
//anfang voraussetzung registriert
if (isset($_SESSION["User_ID"]) && ($_SESSION["User_Recht_Admin"]=="1" || $_SESSION["User_Recht_Ausgabeber"]=="1"))
{
?>
<article id="articleLogin2"> 
<h2>Warenkorb Eigenschaften</h2>
	
<div class="line"></div>
<div class="articleBody clear" >

<a href="rfid" class="fg-button ui-state-default ui-corner-all" style="margin-bottom:10px;float:right">RFID-Modus</a>
<a href="barcode" class="fg-button ui-state-default ui-corner-all" style="margin-bottom:10px;float:right">Barcode-Modus</a>
<a href="index.php" class="fg-button ui-state-default ui-corner-all" style="margin-bottom:10px;float:right">Übersicht</a>

	
<?
$sql = "SELECT bemerkungen,owner,erstellt_am,fuer_dritte  FROM `05_wk` WHERE `specid_wk` = \"".mysql_real_escape_string(unserialize(base64_decode($_GET['wk'])))."\" LIMIT 1 ";
$AnzahWK = mysql_query($sql);
$anzahlWK = mysql_num_rows($AnzahWK); 
$bemerkungen = mysql_fetch_row($AnzahWK);
$nuterInfos=benutzerDaten($bemerkungen[1]);

 
if ($anzahlWK=="1")
{
?>
<br><br>

<table width="100%">
    <tr>
        <td width="50%"><span class="ui-icon ui-icon-person" title="<?
		if ($bemerkungen[3]=="1")
		{
		echo "Bearbeiter";
		}
		else
		{
		echo "Benutzer";
		}
		?>" style="float:left;margin-right:2em;"></span><? echo utf8_encode($nuterInfos[0]); ?> </td>
        <td width="50%"><span class="ui-icon ui-icon-mail-closed" title="E-Mail" style="float:left;margin-right:2em;"></span><a href="mailto:<? echo utf8_encode($nuterInfos[3]); ?>"><h4>E-Mail</h4></a></td>
        
    </tr>
    
    <tr>
        <td width="50%"><span class="ui-icon ui-icon-arrowreturnthick-1-e" title="Telefon" style="float:left;margin-right:2em;"></span><? echo utf8_encode($nuterInfos[1]); ?></td>
        <td width="50%"><span class="ui-icon ui-icon-clock" title="Zeitpunkt Reservierung" style="float:left;margin-right:2em;"></span><? echo timeCdZuDatumMitZeit($bemerkungen[2]); ?></td>
    </tr>
    <tr>
        <td width="50%"><span class="ui-icon ui-icon-tag" title="Nummer des Warenkorbs" style="float:left;margin-right:2em;"></span>w-<? echo unserialize(base64_decode($_GET['wk'])); ?></td>
        <td width="50%"><span class="ui-icon ui-icon-pencil" title="Notizen" style="float:left;margin-right:2em;"></span><? echo htmlspecialchars($bemerkungen[0]); ?> <a href="#link" id="notizClick">(bearbeiten)</a></td>
    </tr>
</table>
	

<div id="contText" class="ui-helper-hidden">
        <br><br><div style="margin-left:251px" class="articleBody clear">
        <textarea id="notiz_Edit" class="input_long" cols="50" rows="10" ><? echo htmlspecialchars($bemerkungen[0]); ?></textarea>
        <br><br>
        <a href="#link" id="notiz_button" class="fg-button ui-state-default ui-corner-all" style="margin-bottom: 10px; float: right;">Ändern</a>
        </div>
</div>
<br><br>
<table cellpadding="0" cellspacing="0" border="0" class="display" id="DataWK">	
<thead>
        <tr>
                <th>Gerätename</th>
                <th>Von</th>
                <th>Bis</th>
                <th>Status</th>
                <?
                if ($_SESSION['SE_versandMod']=="1")
                {
                echo "<th>Versand</th>";
                }
                ?>
                <th>Bearbeiten</th>

        </tr>
</thead>
		
<tbody>
<?
$sql = "SELECT geraet,von,bis,abgeholt,gebracht,id,bemerkungen,versandObj  FROM 06_wkObje WHERE wkid = \"".mysql_real_escape_string(unserialize(base64_decode($_GET['wk'])))."\" ORDER BY `von` ASC "; 
$DataDevWK = mysql_query($sql);

while ($DatenWK = mysql_fetch_array($DataDevWK, MYSQL_NUM))
{
        if($DatenWK[3]==NULL && $DatenWK[4]==NULL)
        {
        $status="reserviert";//mind 1 objekt wurde nur reserviert

        }
        if($DatenWK[3]!=NULL && $DatenWK[4]==NULL)
        {
        $status="ausgegeben";
        $abgabeObj=1;//mind 1 objekt ist in der aktiven leihe "draussen"
        $statusmehr=" am ".timeCdZuDatumMitZeit($DatenWK[3]);
        }
        if($DatenWK[3]!=NULL && $DatenWK[4]!=NULL)
        {
        $status="zurückgegeben";//mind 1 objekt wurde zurückgegeben 
        $statusmehr=" am ".timeCdZuDatumMitZeit($DatenWK[4]);
        }			

        //ausgegebendes gerät ist nicht zurückgegeben
        if ($status=="ausgegeben" && time()>$DatenWK[2])
        {
        echo "<tr class='gradeX'>";

        //also das gerät wurde nicht rechtzeitig abgegeben, es stellt sich die frage wie lange

                $zeitspanne=time()-$DatenWK[2];
                $zeitspanne1=round($zeitspanne/3600); //stunden

                if ($zeitspanne1>24)
                {
                $zeitspanne2=round($zeitspanne1/24)." Tag/en";
                }
                else
                {
                $zeitspanne2=$zeitspanne1." Stunden";
                }
        $statusmehr.=" <br>Seit <b>".$zeitspanne2."</b> überfällig";

        }
        else
        {
                //sind die zeiträume "von" oder "bis" abgelaufen?
                if (time()>$DatenWK[1] || time()>$DatenWK[2])
                {
                echo "<tr class='gradeU'>";
                }
                else
                {
                echo "<tr>";
                }
        }
        echo "<td title=\"".htmlspecialchars($DatenWK[6])."\">".utf8_encode(klarNameObj($DatenWK[0]))."<a style=\"float:right\" href=\"../inventar/objEdit/edit.php?z=".base64_encode(serialize($DatenWK[0]))."\" title=\"Objekt ansehen / bearbeiten\" ><div class=\"ui-state-default ui-corner-all\"><span class=\"ui-icon ui-icon-pencil\"></span></div></a></td><td>".timeCdZuDatumMitZeit($DatenWK[1])."</td><td>".timeCdZuDatumMitZeit($DatenWK[2])."</td><td>".$status.$statusmehr."</td>";

        //start versand

        if ($_SESSION['SE_versandMod']=="1")
        {
                if ($DatenWK[7]=="1")
                {
                echo "<td>ja</td>";
                }
                else
                {
                echo "<td>nein</td>";
                }
        }

        //ende versand



        echo "<td>";
        //reserviert, ausleihe mögllich (aber nur wenn ende noch nicht abgelaufen sind) (UND wenn start der ausleihe im res. zeitraum ist oder X stunden davor)
        if ($status=="reserviert" && time()<$DatenWK[2] && time()>=$DatenWK[1]-$_SESSION['SE_TimeFreigabeLeihe']*3600)
        {
        echo "<a href=\"#\" id=\"einzelStart_".($DatenWK[5]+376592)."\" title=\"Ausleihe Start\" ><div class=\"ui-state-default ui-corner-all\"><span class=\"ui-icon ui-icon-play\"></span></div></a>";
        $resObjVorh=1;
        }

        //ausgegeben, rücknahme möglich (immer möglich, auch wenn von-bis veraltert, eine rücknahme muss immer mögllich sein)
        if ($status=="ausgegeben" )
        {
        echo "<a href=\"#\" id=\"einzelEnde_".($DatenWK[5]+8442)."\" title=\"Rücknahme\" ><div class=\"ui-state-default ui-corner-all\"><span class=\"ui-icon ui-icon-stop\"></span></div></a>";
        }		

        /*
        //erstmal nach hinten verschoben
        //nur wenn objekt noch nicht zurückgegeben worden ist, kann das objetzt mit zeit oder drop geändert werden
        */
        if ($status!="zurückgegeben" && $status!="ausgegeben")
        {
        //zeitraum -> immer eingeblendet, ist immer möglich
        echo "<a href=\"#\" p=\"".($DatenWK[5]+6212)."\" id=\"zeitChg".($DatenWK[5]+6212)."\" title=\"Änderung Zeit / Objekt\" ><div class=\"ui-state-default ui-corner-all\"><span class=\"ui-icon ui-icon-calendar\"></span></div></a>";
        }


        //löschen wird bei status reserviert & zurückgegeben angezeigt, also immer wenn nicht ausgegeben 
        if ($status!="ausgegeben")
        {
        //löschen -> immer eingeblendet, wird eh mit ajax gesondert gecheckt.
        echo "<a href=\"#\" id=\"einzelDel_".($DatenWK[5]+7492)."\" title=\"Objekt löschen\" ><div class=\"ui-state-default ui-corner-all\"><span class=\"ui-icon ui-icon-circle-close\"></span></div></a>";
        }		

        echo "</td></tr>";

//<span class=\"ui-icon ui-icon-trash\"></span>

unset($statusmehr);
unset($status);
}

?>
</tbody>
</table>
    <br><br>
    graue Zeilen=Start/Enddatum Reservierung abgelaufen<br>
    rote Zeilen=Abgabezeitpunkt überschritten
    <br><br>
    <?
    if ($abgabeObj=="1")
    {
    echo '<input aria-disabled="false" id="leihRueckgAll" class="ui-button ui-widget ui-state-default ui-corner-all ui-state-hover" style="float:right" value="Rückgabe aller möglicher Objekte" type="submit" rlAll="'.$_GET['wk'].'"> ';
    }

    if ($resObjVorh=="1")
    {
    echo '<input aria-disabled="false" lsAll="'.$_GET['wk'].'" id="leihStartAll" class="ui-button ui-widget ui-state-default ui-corner-all ui-state-hover" style="float:right" value="Leihebeginn aller möglicher Reservierungen" type="submit"> ';
    }
    ?>
    <a href="<? echo $_SESSION["SE_festUrl"]."account/basketControl/01_pdf_mv.inc.php?o=".mysql_real_escape_string($_GET['wk']); ?>" class="fg-button ui-state-default ui-corner-all" style="margin-bottom:10px;float:right"><img src="../../BL_BILDER/pdf.png"> Mietvertrag</a>


    <?
    //anzeige alle objekte löschen, nur wenn kein gerät unterwegs
    if ($abgabeObj!="1")
    {
    ?>
    <div id="dialog-confirm" title="Löschen des Warenkorbs." >
    <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Mit diesem Schritt löschen Sie diesen Warenkorb. <br><br>Es werden alle Angaben zu reservierten und bereits abgegebenden Objekten gelöscht.<br><br>Möchten Sie dem Ersteller eine E-Mail zukommen lassen?  <input name="checkMailInfo" type="checkbox" id="checkMailInfo" value="" checked="checked"/><div id="grundText"><br>Grund (wird dem Kunden auch mitgeteilt)<br><input type="text" name="grundWKLoesch" id="grundWKLoesch" /></div><br><br><br><b>Möchten Sie den Warenkorb unwiderruflich löschen?</b></p>
    </div>
    <a href="#link" id="delWKAll" ws="<? echo $_GET['wk']; ?>" class="fg-button ui-state-default ui-corner-all" style="margin-bottom:10px;float:right"><span class=\"ui-icon ui-icon-trash\"></span> Warenkorb löschen</a>
    <?
    }
    ?>
    </div>


    </article>


    <?
    }
    else
    {
    echo "Leider existiert kein Warenkorb mit dieser Identifikation";
    }

}
//ende voraussetzung registriert
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
//ausblenden, wenn kein admin
if ($_SESSION["User_Recht_Admin"]=="1" || $_SESSION["User_Recht_Ausgabeber"]=="1")
{
?>
<script type="text/javascript">

$("#notizClick").click(function () {
$("#contText").slideToggle();
});
				
$("#notiz_button").click(function(event) {
notiInfo=$("#notiz_Edit").val();
$("#ajaWKCon").load("08_notizE.inc.php?we="+encodeURI(notiInfo)+"|"+"<? echo $_GET['wk'];?>");
});	

$("#checkMailInfo").click(function () {
$("#grundText").toggle();
});

$("#leihStartAll").click(function () {
$("#ajaWKCon").load("02_leiheStartAll.inc.php?ls="+$("#leihStartAll").val("lsAll"));
});

$("#leihRueckgAll").click(function () {
$("#ajaWKCon").load("03_leiheRueckAll.inc.php?la="+$("#leihRueckgAll").val("rlAll"));
});

$("a[id^=einzelStart_]").click(function () {
$("#ajaWKCon").load("05_leiheStartE.inc.php?lsE="+$(this).val("id"));
});

$("a[id^=einzelEnde_]").click(function () {
$("#ajaWKCon").load("06_leiheEndeE.inc.php?leE="+$(this).val("id"));
});

$("a[id^=einzelDel_]").click(function () {
$("#ajaWKCon").load("07_leiheDelE.inc.php?deE="+$(this).val("id"));
});

$("a[id^=zeitChg]").click(function () {
$("#ajaWKCon").load("09_timeChgAusleihzeiten.inc.php?d="+$(this).val("p"));
});

$("#dialog-confirm").dialog({ autoOpen: false });

$("#dialog-confirm").dialog({
			resizable: false,
			height:540,
			modal: true,
			buttons: {
				"Ja": function() {
				var text=$("#grundWKLoesch").val();
				$("#ajaWKCon").load("01_delWK.inc.php?wi="+$("#delWKAll").val("ws")+"|"+encodeURI(text)+"|"+$("#checkMailInfo").val("checked"));
				$( this ).dialog( "close" );
				},
				"Abbrechen": function() {
				$( this ).dialog( "close" );
				}
			}
		});

$("#delWKAll").click(function(event) {
$("#dialog-confirm" ).dialog('open');
});

	var oTable = $('#DataWK').dataTable( {
		"bJQueryUI": true,
		"sPaginationType": "full_numbers"
	});

<?	
if ($bemerkungen[3]=="1")
{
?>
	$.pnotify({
	pnotify_title: 'Hinweis',
	pnotify_text: 'Dieser Warenkorb wurde manuell vor Ort erstellt und ist nicht vorher vom Ausleihenden in BORROW LAND reserviert worden.'
	});
<?
}
?>

$("#loadingAj").hide();
$("#loadingAj").ajaxStart(function(){
   $(this).show();
 });
 $("#loadingAj").ajaxStop(function(){
   $(this).hide();
 });

 
</script>

<?
}
?>

<?
echo utf8_encode($_SESSION["SE_EndeIndex"]);
}
?>

<br><br><br><br><br><br>
</body>
</html>