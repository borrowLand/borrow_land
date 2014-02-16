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
  <h1><a href="../../index.php" title="Startseite"><img src="../../BL_BILDER/start_00.png"></a> <a href="../../index.php"  title="Startseite">borrow land</a></h1>
</hgroup>

	</header>
	<section id="articles"> <!-- A new section with the articles -->

	<?
	if (isset($_SESSION["User_ID"]))
	{
			?>
			
				<article id="articleLogin1"> <!-- The new article tag. The id is supplied so it can be scrolled into view. -->
					<h2>Deaktiviertes Benutzerprofil</h2>
					
					<div class="line"></div>
					
					<div class="articleBody clear">
					
						<figure> <!-- The figure tag marks data (usually an image) that is part of the article -->
						<a href="../../"><img src="../../BL_BILDER/deact.jpg" alt="Deaktivierung" width="200" height="95" /></a>
						</figure>
						
						<p>Leider wurde das Profil deaktiviert. <br>Sie können <a href="mailto:<?echo $_SESSION['SE_adminEMail'];?>">hier</a> (<?echo $_SESSION['SE_adminEMail'];?>) eine Nachricht an die Verwaltung der Leihe schreiben. </p>
				  </div>

				</article>

				
			<?
			
		//Session Daten löschen 
		/////////////////////////////////////////////
		$includeName="../../_04_logoutSess.inc.php";
		if (file_exists($includeName))
		{
		require($includeName);
		}	
		else
		{
		echo '<br><br><div class="meldung_fehler"><img src="BL_BILDER/Meldungen_Warning.png"> <br>CHECK_ALL_LOAD_01</div><br><br>';	
		exit();
		}

		/////////////////////////////////////////////
			
			
			
			
	}
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
				
<?
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
	        
       
		</section> <!-- Closing the #page section -->

		 

        
<!-- JavaScript Includes -->
<?
echo nl2br($_SESSION["SE_jQuerUI"]);
echo utf8_encode($_SESSION["SE_EndeIndex"]);
?>
</body>
</html>