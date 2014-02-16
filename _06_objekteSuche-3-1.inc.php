<?
session_start();

//Funktionen 
/////////////////////////////////////////////
$includeName="_00_basic_func.inc.php";
if (file_exists($includeName))
{
	require($includeName);
}	
else
{
	echo '<br><br><div class="meldung_fehler"><img src="BL_BILDER/Meldungen_Warning.png"> <br>FU_ALL_LOAD_01</div><br><br>';	
	exit();
}

/////////////////////////////////////////////

//Datenbank Verbindung
/////////////////////////////////////////////
$includeName="_01_basic_db.inc.php";
if (file_exists($includeName))
{
	require($includeName);
}	
else
{
	echo '<br><br><div class="meldung_fehler"><img src="BL_BILDER/Meldungen_Warning.png"> <br>DB_FU_LOAD_01</div><br><br>';	
	exit();
}

/////////////////////////////////////////////


//Sessions
/////////////////////////////////////////////
$includeName="_01_basic_sess.inc.php";
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

if (isset($_SESSION["User_ID"]))
{


	$tagsArray = explode("|", ($_GET['fdc']));
	echo "<br><br>";
	
	
	if (count($tagsArray)>=1)
	{
		
		//1. nachsehen ob alle tags in irgendeine objekt vorhanden sind
		//$comma_separated = implode($tagsArray,",");
		
		//namen der hauptgruppen
		$namenHauptGruppen=array_keys($_SESSION["aktuelleObjekte"]);

		//wieviele hauptgruppen existieren überhaupt?
		$anzahlHG=count($namenHauptGruppen);

		if ($anzahlHG>=1)
		{
			for ($k=0;$k < $anzahlHG;$k++)
			{
				for ($l=0;$l<count($_SESSION["aktuelleObjekte"][$namenHauptGruppen[$k]]);$l++)
				{	
				//metatags von dem objekt heraussuchen, die nicht leer sind
				$sql = 'SELECT metatags FROM `04_obj_objekte` WHERE `specid_obj` = \''.$_SESSION["aktuelleObjekte"][$namenHauptGruppen[$k]][$l].'\' AND `metatags` != \'\''; 
				$metaObj = mysql_query($sql);
				$metaObjText = mysql_fetch_row($metaObj);
				
				$tagsAusArray = explode(",", $metaObjText[0]);
				$result = array_intersect($tagsArray, $tagsAusArray);
					if ($metaObjText[0]!="")
					{
						//rückwerte: gleihe anzahl an elementen=volltreffer; weniger elemente als angefragte tags: teilerfolg; keine elemente: unwichtig
						if (count($result)==count($tagsArray) && count($result)!=0)
						{
						//hauptobjekte
						$hauptobjekte[]=$_SESSION["aktuelleObjekte"][$namenHauptGruppen[$k]][$l];
						}

					}
					unset($tagsAusArray);
					unset($result);
				}
			}
			
			//fehlermeldung wnen keine objekte gefunden worden sin
			if (!isset($hauptobjekte))
			{
			echo "Die angegebenden Schlagwörter stimmen mit keinem Objekt überein";
			}
			else
			{
			//var_dump($hauptobjekte);
			}
		}
	}
	
	for ($i=0;$i<count($hauptobjekte);$i++)
	{
	//echo klarNameObj($hauptobjekte[$i])."<br>";
	
	
	
	//objekte 
		echo '<table style="margin-top:5px" objT_id="'.base64_encode(serialize($hauptobjekte[$i])).'" class="clear ui-widget-content" border="0"  cellpadding="3" cellspacing="0" width="896px" height="100px">';
		
		//erste zeile
			echo '<tr height="40" class="ui-widget-header"><td style="margin: 10px;padding:10px"> ';
			echo utf8_encode(klarNameObj($hauptobjekte[$i]));
			
			//PDF Info, wenn Datei vorhanden
			if (is_file('BL_MEDIA/PDF_OBJ/'.base64_encode(serialize($hauptobjekte[$i])).'.pdf') || is_file('BL_MEDIA/PDF_OBJ/'.base64_encode(serialize($hauptobjekte[$i])).'.PDF'))
			{
			echo " <a href='"."BL_MEDIA/PDF_OBJ/".base64_encode(serialize($hauptobjekte[$i])).".pdf' target='_blank'><img align='absmiddle' src='BL_BILDER/pdf.png'></a>";
			}
			//ende pdf info

			echo '</td><td width="60px" align="right" valign="top" colspan="3">';
			if (is_file('BL_MEDIA/PIC_OBJ/'.base64_encode(serialize($hauptobjekte[$i])).'.jpg') || is_file('BL_MEDIA/PIC_OBJ/'.base64_encode(serialize($hauptobjekte[$i])).'.JPG'))
			{
			echo '<img uiz68="BL_MEDIA/PIC_OBJ/'.base64_encode(serialize($hauptobjekte[$i])).'.jpg'.'" hspace="60" src="galPrev3.php?a='.base64_encode(serialize($hauptobjekte[$i])).'">';
			}
			echo '</td>';
			echo '</tr>';
		//ende erste zeile
		
		//zweite zeile: beschreibung 
			echo '<tr class="ui-widget-content"><td style="margin: 15px;padding:15px" colspan="4">';
			
			//lange beschreibung
				$sql = "SELECT langeBeschre FROM `04_obj_objekte` WHERE `specid_obj` = \"".$hauptobjekte[$i]."\" LIMIT 1 "; 
				$DateLangBe = mysql_query($sql);
				$langeBeschIngo = mysql_fetch_row($DateLangBe);

				//gucken ob mehr als 285 zeichen
				if (strlen($langeBeschIngo[0]) > 264)
				{
				$textEdit = substr($langeBeschIngo[0], 0, 260 );
				echo "<div class='Standard_Verdana_12'>".utf8_encode($textEdit)." <a title='".utf8_encode($langeBeschIngo[0])."'>...</a></div>";
				}
				else
				{
				echo "<div class='Standard_Verdana_12'>".utf8_encode($langeBeschIngo[0])."</div>";
				}
				unset($langeBeschIngo[0]);
				unset($textEdit);
			//ende lange beschreibung
			echo '</td></tr>';
		//ende zweite zeile

		//dritte zeile: warenkorb
			echo '<tr class="ui-widget-content ui-corner-all"><td colspan="4" align="right" valign="bottom">';
			echo '<br><a inWK_to_oV="_1_'.base64_encode(serialize($hauptobjekte[$i])).'" href="#link" title="In den Warenkorb (Vor-Ort Abholung)"><div style="float:right;" class="ui-state-default ui-corner-all"><span class="ui-icon ui-icon-circle-plus"></span></div></a>';
			if ($_SESSION['SE_versandMod']=="1")
			{	
			echo '<a inWK_to_mV="_2_'.base64_encode(serialize($hauptobjekte[$i])).'" href="#link" title="In den Warenkorb (Versand)"><div style="float:right;" class="ui-state-default ui-corner-all"><span class="ui-icon ui-icon-mail-open"></span></div></a>';
			}
			echo '</td></tr>';
		//ende dritte zeile
		echo '</table>';
	}
}


?>
<script>
$("a[inWK_to_oV^=_1_]").click(function(event) {
$("#wk").load("_07_wko3.inc.php?wk1="+$(this).attr("inWK_to_oV"));
$("a[inWK_to_oV^=_1_]").hide();
<?
//nur wenn versandmodul aktiviert ist, werden auch die symbole ausgeblendet bei einer warenkorb aktion
if ($_SESSION['SE_versandMod']=="1")
{	
echo '$("a[inWK_to_mV^=_2_]").hide();';
}
?>
});
<?
if ($_SESSION['SE_versandMod']=="1")
{
//nur wenn versandmodul aktiviert ist, werden auch die symbole ausgeblendet bei einer warenkorb aktion
?>
$("a[inWK_to_mV^=_2_]").click(function(event) {
$("#wk").load("_07_wko3.inc.php?wk2="+$(this).attr("inWK_to_mV"));
$("a[inWK_to_mV^=_2_]").hide();
$("a[inWK_to_oV^=_1_]").hide();
});
<?
}
?>

$("#loadingAj").hide();

$('table img,div img').imgPreview({
	containerID: 'imgPreviewWithStyles',
	srcAttr: 'uiz68',
	preloadImages: 'false',
	imgCSS: {
		// Limit preview size:
		height: 200
	},
	// When container is shown:
	onShow: function(link){
		// Animate link:
		$(link).stop().animate({opacity:0.4});
		// Reset image:
		$('img', this).stop().css({opacity:0});
	},
	// When image has loaded:
	onLoad: function(){
		// Animate image
		$(this).animate({opacity:1}, 300);
	},
	// When container hides: 
	onHide: function(link){
		// Animate link:
		$(link).stop().animate({opacity:1});
	}
});	


</script>