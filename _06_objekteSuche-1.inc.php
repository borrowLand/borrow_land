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
<input style="float:left;" class="ui-state-disabled" value="Hinweise" onmouseover="tooltip.pnotify_display();" onmousemove="tooltip.css({'top': event.clientY+12, 'left': event.clientX+12});" onmouseout="tooltip.pnotify_remove();" type="button" /><br><br>
<?



/*
neu initialisierung nur mit direkter nennung des hauptgruppen arrays.
var_dump($_SESSION["aktuelleObjekte"]);
unset($_SESSION["aktuelleObjekte"][d47f691b5f7dc39f6c952f1ed11808191bc8a125][3]);
$_SESSION["aktuelleObjekte"][d47f691b5f7dc39f6c952f1ed11808191bc8a125] = array_values($_SESSION["aktuelleObjekte"][d47f691b5f7dc39f6c952f1ed11808191bc8a125]);
var_dump($_SESSION["aktuelleObjekte"]);
key suche:  unset(array_search(876, $array)); 
*/

//namen der hauptgruppen
$namenHauptGruppen=array_keys($_SESSION["aktuelleObjekte"]);

//wieviele hauptgruppen existieren überhaupt?
$anzahlHG=count($namenHauptGruppen);

	for ($k=0;$k < $anzahlHG;$k++)
	{

	echo '<table id="'.base64_encode(serialize($namenHauptGruppen[$k])).'" class="clear ui-widget-content" border="0" style="margin-top:30px;margin-bottom:10px" cellpadding="3" cellspacing="0" width="870px" height="100px">';

	//anfang erste zeile: bild, überschrift, warenkorb
		echo '<tr height="40" class="ui-widget-header" ><td style="margin: 5px;padding:5px" colspan="3"> ';
		echo utf8_encode(klarNameHG($namenHauptGruppen[$k]));
		
		//PDF Info, wenn Datei vorhanden
		if (is_file('BL_MEDIA/PDF_HG/'.base64_encode(serialize($namenHauptGruppen[$k])).'.pdf') || is_file('BL_MEDIA/PDF_HG/'.base64_encode(serialize($namenHauptGruppen[$k])).'.PDF'))
		{
		echo " <a href='"."BL_MEDIA/PDF_HG/".base64_encode(serialize($namenHauptGruppen[$k])).".pdf' target='_blank'><img align='absmiddle' src='BL_BILDER/pdf.png'></a>";
		}
		//ende pdf info
		
		echo '</td>';
		//vorschaubild
			echo '<td width="56px" align="right" valign="top">';
			if (is_file('BL_MEDIA/PIC_HG/'.base64_encode(serialize($namenHauptGruppen[$k])).'.jpg') || is_file('BL_MEDIA/PIC_HG/'.base64_encode(serialize($namenHauptGruppen[$k])).'.JPG'))
			{
			echo '<img uiz64="BL_MEDIA/PIC_HG/'.base64_encode(serialize($namenHauptGruppen[$k])).'.jpg'.'" hspace="60" src="galPrev2.php?a='.base64_encode(serialize($namenHauptGruppen[$k])).'">';
			}
			echo '</td>';
		//ende vorschaubild
		echo '</tr>';
	//ende erste zeile
	
	//zweite zeile: beschreibung 
		echo '<tr class="ui-widget-content"><td style="margin: 10px;padding:10px" colspan="4">';
		
		//lange beschreibung
			$sql = "SELECT langeBeschre FROM `03_obj_hauptgruppen` WHERE `specid_hg` = \"".$namenHauptGruppen[$k]."\" LIMIT 1 "; 
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
	echo '<tr align="right" class="ui-widget-content ui-corner-all"><td colspan="4" align="right" valign="bottom">';
	echo '<br><a inWK_HG_oV="_1_'.base64_encode(serialize($namenHauptGruppen[$k])).'" href="#link" title="In den Warenkorb (Vor-Ort Abholung)"><div style="float:right;" class="ui-state-default ui-corner-all"><span class="ui-icon ui-icon-circle-plus"></span></div></a>';
	if ($_SESSION['SE_versandMod']=="1")
	{	
	echo '<a inWK_HG_mV="_2_'.base64_encode(serialize($namenHauptGruppen[$k])).'" href="#link" title="In den Warenkorb (Versand)"><div style="float:right;" class="ui-state-default ui-corner-all"><span class="ui-icon ui-icon-mail-open"></span></div></a>';
	}
	echo '</td></tr>';
	
	
	
	//ende dritte zeile
	echo '</table>';
	
	}
}
?>

<script>
tooltip = $.pnotify({
	pnotify_title: "Hinweise",
	pnotify_text: "Nachfolgend erhalten Sie eine Übersicht aller verfügbarer Hauptgruppen in dem angefragten Zeitraum. Sie können den Zeitraum neben der Angabe der aktuellen Ausleihezeiten verändern.<br><br> Mithilfe des + Symbols legen Sie gewünschte Objekte aus den Hauptgruppen in den Warenkorb.<br><br>Schnellsuche im Browser: <img src='BL_BILDER/strgF.png' align='absmiddle' border='0'><br><br><?
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

$("a[inWK_HG_oV^=_1_]").click(function(event) {
$("#wk").load("_07_wko.inc.php?wk1="+$(this).attr("inWK_HG_oV"));
$("a[inWK_HG_oV^=_1_]").hide();
<?

//nur wenn versandmodul aktiviert ist, werden auch die symbole ausgeblendet bei einer warenkorb aktion
if ($_SESSION['SE_versandMod']=="1")
{	
echo '$("a[inWK_HG_mV^=_2_]").hide();';
}
?>
});


<?
if ($_SESSION['SE_versandMod']=="1")
{
//nur wenn versandmodul aktiviert ist, werden auch die symbole ausgeblendet bei einer warenkorb aktion
?>
$("a[inWK_HG_mV^=_2_]").click(function(event) {
$("#wk").load("_07_wko.inc.php?wk2="+$(this).val());
$("a[inWK_HG_oV^=_1_]").hide();
$("a[inWK_HG_mV^=_2_]").hide();
});
<?
}
?>
$('table img').imgPreview({
	containerID: 'imgPreviewWithStyles',
	srcAttr: 'uiz64',
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