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


if (isset($_SESSION["User_ID"]) && isset($_SESSION["aktuelleObjekte"]))
{
?>
<input style="float:left;" class="ui-state-disabled" value="Hinweise" onmouseover="tooltip2.pnotify_display();" onmousemove="tooltip2.css({'top': event.clientY+12, 'left': event.clientX+12});" onmouseout="tooltip2.pnotify_remove();" type="button" /><br><br>
<?

//namen der hauptgruppen
$namenHauptGruppen=array_keys($_SESSION["aktuelleObjekte"]);

//wieviele hauptgruppen existieren überhaupt?
$anzahlHG=count($namenHauptGruppen);

	for ($k=0;$k < $anzahlHG;$k++)
	{
		//hauptgruppen head
		echo "<div id='d3f".base64_encode(serialize($namenHauptGruppen[$k]))."' class='clear ui-widget-header' style='width:888px;height:50px;padding:15px; margin-left:-23px;margin-top:30px;margin-bottom:10px'>".utf8_encode(klarNameHG($namenHauptGruppen[$k]))."<div style='float:right'>";
		//vorschaubild
		if (is_file('BL_MEDIA/PIC_HG/'.base64_encode(serialize($namenHauptGruppen[$k])).'.jpg') || is_file('BL_MEDIA/PIC_HG/'.base64_encode(serialize($namenHauptGruppen[$k])).'.JPG'))
		{
		echo '<img uiz65="BL_MEDIA/PIC_HG/'.base64_encode(serialize($namenHauptGruppen[$k])).'.jpg'.'" hspace="60" src="galPrev2.php?a='.base64_encode(serialize($namenHauptGruppen[$k])).'">';
		}
		//ende vorschaubild
		echo "</div></div>";
		
		
		for ($l=0;$l<count($_SESSION["aktuelleObjekte"][$namenHauptGruppen[$k]]);$l++)
		{
		//objekte in der hauptgruppe
		echo '<table style="margin-top:5px" obj_id="'.base64_encode(serialize($_SESSION["aktuelleObjekte"][$namenHauptGruppen[$k]][$l])).'" class="clear ui-widget-content" border="0"  cellpadding="3" cellspacing="0" width="896px" height="100px">';
		
		//erste zeile
			echo '<tr height="40" class="ui-widget-header"><td style="margin: 10px;padding:10px"> ';
			echo utf8_encode(klarNameObj($_SESSION["aktuelleObjekte"][$namenHauptGruppen[$k]][$l]));
			
			//PDF Info, wenn Datei vorhanden
			if (is_file('BL_MEDIA/PDF_OBJ/'.base64_encode(serialize($_SESSION["aktuelleObjekte"][$namenHauptGruppen[$k]][$l])).'.pdf') || is_file('BL_MEDIA/PDF_OBJ/'.base64_encode(serialize($_SESSION["aktuelleObjekte"][$namenHauptGruppen[$k]][$l])).'.PDF'))
			{
			echo " <a href='"."BL_MEDIA/PDF_OBJ/".base64_encode(serialize($_SESSION["aktuelleObjekte"][$namenHauptGruppen[$k]][$l])).".pdf' target='_blank'><img align='absmiddle' src='BL_BILDER/pdf.png'></a>";
			}
			//ende pdf info

			echo '</td><td width="60px" align="right" valign="top" colspan="3">';
			if (is_file('BL_MEDIA/PIC_OBJ/'.base64_encode(serialize($_SESSION["aktuelleObjekte"][$namenHauptGruppen[$k]][$l])).'.jpg') || is_file('BL_MEDIA/PIC_OBJ/'.base64_encode(serialize($_SESSION["aktuelleObjekte"][$namenHauptGruppen[$k]][$l])).'.JPG'))
			{
			echo '<img uiz65="BL_MEDIA/PIC_OBJ/'.base64_encode(serialize($_SESSION["aktuelleObjekte"][$namenHauptGruppen[$k]][$l])).'.jpg'.'" hspace="60" src="galPrev3.php?a='.base64_encode(serialize($_SESSION["aktuelleObjekte"][$namenHauptGruppen[$k]][$l])).'">';
			}
			echo '</td>';
			echo '</tr>';
		//ende erste zeile
		
		//zweite zeile: beschreibung 
			echo '<tr class="ui-widget-content"><td style="margin: 15px;padding:15px" colspan="4">';
			
			//lange beschreibung
				$sql = "SELECT langeBeschre FROM `04_obj_objekte` WHERE `specid_obj` = \"".$_SESSION["aktuelleObjekte"][$namenHauptGruppen[$k]][$l]."\" LIMIT 1 "; 
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
			echo '<br><a inWK_o_oV="_1_'.base64_encode(serialize($_SESSION["aktuelleObjekte"][$namenHauptGruppen[$k]][$l])).'" href="#link" title="In den Warenkorb (Vor-Ort Abholung)"><div style="float:right;" class="ui-state-default ui-corner-all"><span class="ui-icon ui-icon-circle-plus"></span></div></a>';
			if ($_SESSION['SE_versandMod']=="1")
			{	
			echo '<a inWK_o_mV="_2_'.base64_encode(serialize($_SESSION["aktuelleObjekte"][$namenHauptGruppen[$k]][$l])).'" href="#link" title="In den Warenkorb (Versand)"><div style="float:right;" class="ui-state-default ui-corner-all"><span class="ui-icon ui-icon-mail-open"></span></div></a>';
			}
			echo '</td></tr>';
		//ende dritte zeile
		echo '</table>';
		}
	}
}
?>



<script>
tooltip2 = $.pnotify({
	pnotify_title: "Hinweise",
	pnotify_text: "Nachfolgend erhalten Sie eine Übersicht aller verfügbarer Objekte in dem angefragten Zeitraum. Sie können den Zeitraum neben der Angabe der aktuellen Ausleihezeiten verändern.<br><br> Mithilfe des + Symbols legen Sie gewünschte Objekte in den Warenkorb.<br><br>Schnellsuche im Browser: <img src='BL_BILDER/strgF.png' align='absmiddle' border='0'><br><br><?
	if ($_SESSION['SE_versandMod']=="1")
	{
	echo "Weiterhin können Sie mithilfe des Versand-Symbols Objekte reservieren und gleichzeitig für den Versand markieren. Klicken Sie hierzu einfach auf dieses Symbol: <div class='clear' ><span class='ui-icon ui-icon-mail-open'></span></div>";
	}
	?>",
	pnotify_hide: false,
	pnotify_closer: false,
	pnotify_history: false,
	pnotify_animate_speed: 100,
	pnotify_opacity: 1,
	pnotify_notice_icon: "ui-icon ui-icon-comment",
	// Setting stack to false causes Pines Notify to ignore this notice when positioning.
	pnotify_stack: false,
	pnotify_after_init: function(pnotify){
		// Remove the notice if the user mouses over it.
		pnotify.mouseout(function(){
			pnotify.pnotify_remove();
		});
	},
	pnotify_before_open: function(pnotify){
		// This prevents the notice from displaying when it's created.
		pnotify.pnotify({
			pnotify_before_open: null
		});
		return false;
	}
});

$("a[inWK_o_oV^=_1_]").click(function(event) {
$("#wk").load("_07_wko2.inc.php?wk1="+$(this).attr("inWK_o_oV"));
$("a[inWK_o_oV^=_1_]").hide();
<?
//nur wenn versandmodul aktiviert ist, werden auch die symbole ausgeblendet bei einer warenkorb aktion
if ($_SESSION['SE_versandMod']=="1")
{	
echo '$("a[inWK_o_mV^=_2_]").hide();';
}
?>
});
<?
if ($_SESSION['SE_versandMod']=="1")
{
//nur wenn versandmodul aktiviert ist, werden auch die symbole ausgeblendet bei einer warenkorb aktion
?>
$("a[inWK_o_mV^=_2_]").click(function(event) {
$("#wk").load("_07_wko2.inc.php?wk2="+$(this).attr("inWK_o_mV"));
$("a[inWK_o_mV^=_2_]").hide();
$("a[inWK_o_oV^=_1_]").hide();
});
<?
}
?>
$('table img,div img').imgPreview({
	containerID: 'imgPreviewWithStyles',
	srcAttr: 'uiz65',
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