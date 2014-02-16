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

?>
<input style="float:left;" class="ui-state-disabled" value="Hinweise" onmouseover="tooltip3.pnotify_display();" onmousemove="tooltip3.css({'top': event.clientY+12, 'left': event.clientX+12});" onmouseout="tooltip3.pnotify_remove();" type="button" /><br><br>
<?



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
				if ($metaObjText!="")
				{
				$alleTags .= $metaObjText[0].',';
				}
			}
		}
		
		//in array überführen
		$tagsArray = explode(",", $alleTags);
		$tagsArray = array_values(array_unique($tagsArray));
		shuffle($tagsArray);
	
//alle tags oder die festgelegte einstellung
if (welcheEinstellung("SE_tagAnzahl")==0)
{
	for ($i=0;$i<count($tagsArray);$i++)
	{
		if ($tagsArray[$i]!="")
		{
		echo '<div style="display:inline-block;padding-top:30px;margin-left:5px;" id="t_'.$i.'"><span class="tagCSS1">'.utf8_encode($tagsArray[$i]).'</span><span class="tagCSS2"></span><span class="tagCSS3"></span></div>';
		}
	}
}
else
{
	for ($i=0;$i<welcheEinstellung("SE_tagAnzahl");$i++)
	{
		if ($tagsArray[$i]!="")
		{
		echo '<div style="display:inline-block;padding-top:30px;margin-left:5px;" id="t_'.$i.'"><span class="tagCSS1">'.utf8_encode($tagsArray[$i]).'</span><span class="tagCSS2"></span><span class="tagCSS3"></span></div>';
		}
	}
}
	
	

?>
	
<div id="akld86Jbn"></div>

<script>
$("#loadingAj").hide();

function GebDochMalWeiter()
{
daten = new Array();
var daten2;
$("div[id^=t_]").filter(".ui-priority-secondary").each(function(index) {
daten=daten.concat($(this).text());
});
var daten2 = daten.join("|");

$("#akld86Jbn").load("_06_objekteSuche-3-1.inc.php?fdc="+escape(daten2));
daten = new Array();
var daten2;
	
}

$("div[id^=t_]").click(function () { 
$(this).toggleClass("ui-priority-secondary");
GebDochMalWeiter();
});

tooltip3 = $.pnotify({
pnotify_title: "Hinweise",
pnotify_text: "Klicken Sie einfach die Schlagwörter an, die Sie zur Auswahl benötigen. Mit einem weiteren Klick heben Sie die Auswahl auf. Den Zeitraum können Sie neben der Angabe der aktuellen Ausleihezeiten verändern.<br><br> Mithilfe des + Symbols legen Sie gewünschte Objekte in den Warenkorb.<br><br>Schnellsuche im Browser: <img src='BL_BILDER/strgF.png' align='absmiddle' border='0'><br><br><?
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


 
</script>
	<?
	}	
}