<?
session_start();

	if (isset($_SESSION["User_ID"]))
	{
	
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

	//sinn dieser datei: löschen von elementen aus dem warenkorb verzeichnis
	$zuloeschendesElement=$_GET['o'];
	$arrayUebergabe=explode("__", $zuloeschendesElement);


	if ($arrayUebergabe[0]=="dWk" && is_numeric($arrayUebergabe[1]))
	{
	$loeschendesObjekt=$arrayUebergabe[1];

	$anzahlElementeWK=count($_SESSION["User_WK"]);
	
	//wenn keine elemente im wk, fehlermeldung
		if ($anzahlElementeWK==0)
		{
			?>
			<script>
			$.pnotify({
			pnotify_title: 'Fehler Warenkorb',
			pnotify_text: 'Es befinden sich keine Elemente mehr im Warenkorb.',
			pnotify_type: 'error'
			});
			</script>	
			<?	
		}
		else
		{
			for ($k=0;$k<$anzahlElementeWK;$k++)
			{
				if ($k==($arrayUebergabe[1]-569823))
				{
				unset($_SESSION["User_WK"][$k]);
				$_SESSION["User_WK"] = array_values($_SESSION["User_WK"]);
				
				?>
				<script>				
				$.pnotify({
				pnotify_title: 'Warenkorb',
				pnotify_text: 'Das Objekt wurde erfolgreich entfernt.',
				});
				</script>
				<?	

				//anfang ajax
	
				echo "<table class='ui-widget-content ui-corner-all' width='100%' id='wk_content_tab' style='padding:10px;>";
				echo "<tr><td colspan='5'><br></td></tr>";
				echo "<tr><td><h4></h4></td><td></td><td><h4>Ausleihezeitraum</h4></td>";
				//wenn versand, dann anderer tabellenteil
				if ($_SESSION['SE_versandMod']=="1")
				{
				echo "<td><h4>Versand?</h4></td>";
				}
				else
				{
				echo "<td></td>";
				}
				//ende andere darstellung bei versand
				echo "<td width='80px'><h4>entfernen</h4></td></tr>";
				echo "<tr><td colspan='5'><br></td></tr>";
				
				
				
				for($i=0;$i<count($_SESSION["User_WK"]);$i++)
				{
					if ($_SESSION["User_WK"][$i]["name"]!="")
					{

						//anzeige hg name, wenn hg aktiviert ist
						if ($_SESSION["SE_ViewLeihmodHauptg"]=="1")
						{
						echo "<tr id='tab_".(569823+$i)."'><td>".utf8_encode(klarNameHG($_SESSION["User_WK"][$i]["hgName"]))."</td><td></td><td>".date("d.m.Y G:i",$_SESSION["User_WK"][$i]["zeitStart"])." - ".date("d.m.Y G:i",$_SESSION["User_WK"][$i]["zeitEnde"])."</td>";
						}
						else
						{
						echo "<tr id='tab_".(569823+$i)."'><td>".utf8_encode(klarNameObj($_SESSION["User_WK"][$i]["name"]))."</td><td></td><td>".date("d.m.Y G:i",$_SESSION["User_WK"][$i]["zeitStart"])." - ".date("d.m.Y G:i",$_SESSION["User_WK"][$i]["zeitEnde"])."</td>";
						}
						//versandinfo
						if ($_SESSION['SE_versandMod']=="1" && $_SESSION["User_WK"][$i]["versand"]=="1")
						{
						echo "<td>ja</td>";
						}
						else
						{
						echo "<td></td>";
						}
						//ende versandinfo
						echo "<td width='80px'><a href='#link' delwk='dWk__".(569823+$i)."' title='entfernen' ><div class='ui-state-default ui-corner-all'><span class='ui-icon ui-icon-trash'></span></div></a></td></tr>\n";
					}
					else
					{
					//jedes item im warenkorb muss eine id haben, sonst fehler
					?>
					<script>
					$.pnotify({
					pnotify_title: 'Fehler Warenkorb',
					pnotify_text: 'Fehler 82',
					pnotify_type: 'error'
					});
					</script>	
					<?	
					}
				}
				echo "<tr><td colspan='5'><br></td></tr>";
				echo "</table>";

				//ende ajax
				
				}
			}
		

			//wenn keine elemente mehr vorhanden sind....
			if (count($_SESSION["User_WK"])==0)
			{
			?>
			<script>
			$("#fehlermeldungenWK").hide();
			$("#letsTakeALook").hide();
			$("#wk_content_tab").hide();
			$("#articleLogin1").append("Derzeit befinden sich keine Objekte im Warenkorb.");
			</script>
			<?
			}
		
		
		
		
		
		
		
		
		
		}
	}
	else
	{
		if (!isset($_SESSION["User_ID"]))
		{
			//Session Daten löschen 
			/////////////////////////////////////////////
			$includeName="../../_04_logoutSess.inc.php";
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
		exit;
		}


	}
}
?>
<script>
$("a[delwk^=dWk__]").click(function(event) {
$("#preLoadWK").load("01_wkCheck.inc.php?o="+$(this).val("delwk"));
});

<?
if (count($_SESSION["User_WK"])==0)
{
	?>
	$('#wk').remove();
	<?
}
else
{
	?>
	$("#wk").html("<li><a href='<? echo $_SESSION["SE_festUrl"]; ?>account/basket' title='Warenkorb'><? echo wkCountOhneLeer(); ?><div class='ui-state-default ui-corner-all'><span class='ui-icon ui-icon-cart'></span></div></a></li>"); 
	<?
}
?>
</script>