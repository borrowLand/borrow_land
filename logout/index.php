<?
session_start();

//Funktionen 
/////////////////////////////////////////////
$includeName="../_00_basic_func.inc.php";
if (file_exists($includeName))
{
require($includeName);
}	
else
{
echo '<br><br><div class="meldung_fehler"><img src="../BL_BILDER/Meldungen_Warning.png"> <br>FU_ALL_LOAD_01</div><br><br>';	
exit();
}

/////////////////////////////////////////////

//Datenbank Verbindung
/////////////////////////////////////////////
$includeName="../_01_basic_db.inc.php";
if (file_exists($includeName))
{
require($includeName);
}	
else
{
echo '<br><br><div class="meldung_fehler"><img src="../BL_BILDER/Meldungen_Warning.png"> <br>DB_FU_LOAD_01</div><br><br>';	
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
<br><br><br><br><div class="meldung_fehler"><img src="../BL_BILDER/Meldungen_Warning.png">Diese Webseite läuft leider nur, wenn Sie <a href="http://de.wikipedia.org/wiki/Javascript" target="_blank">Javascript</a> zulassen. <br>Bitte aktivieren Sie diesen technischen Standard in Ihrem Browser, Danke!</div>
<br><br>
</NOSCRIPT>	

<section id="page"> 

<header>
           
<?
//#############Anfang Überschrift
?>
<hgroup><h1><a href="../index.php" title="Startseite"><img src="../BL_BILDER/start_00.png"></a> <a href="../index.php" title="Startseite">borrow land</a></h1>
<?
$oeffentlich=1;
if ($oeffentlich=="1")
{
?>
<div id="ueberschr_all"><a href="../">/Leihe</a>/Logout</div>
</hgroup>
<?
}
else
{
	if (isset($_SESSION["User_ID"]) && $_SESSION["User_ID"]!="")
	{	
	?>
	<div id="ueberschr_all"><a href="../">/Leihe</a>/Logout</div>
	</hgroup>
	<?
	}
}
//#############Ende Überschrift	



	//navigation
	/////////////////////////////////////////////
	$includeName="../_00_basic_nav.inc.php";
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

<section id="articles"> <!-- A new section with the articles -->

			
			
	<?
	if (isset($_SESSION["User_ID"]))
	{
	
		//Session Daten löschen 
		/////////////////////////////////////////////
		$includeName="../_04_logoutSess.inc.php";
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

	
	?>
					<!-- Article 1 start -->

                <? //<div class="line"></div>  <!-- Dividing line --> ?>
                
                <article id="article1"> <!-- The new article tag. The id is supplied so it can be scrolled into view. -->
                    <h2>Ausloggen</h2>
                    
                    <div class="line"></div>
                    
						<div class="articleBody clear">
							<figure> <!-- The figure tag marks data (usually an image) that is part of the article -->
							<a href="../index.php"><img src="../BL_BILDER/logout_01.jpg" alt="Beginn Ausleihe" width="200" height="95" /></a>
							</figure>
						<p>Ihr Auslogg-Vorgang wurde erfolgreich abgeschlossen.<br>Bitte schliessen Sie dieses Fenster.</p>
						<p>&nbsp;</p>
					</div>

                </article>
                
				<!-- Article 1 end -->
	<?

	}
	
	else
	{
?>
					<!-- Article 2 start -->

                <? //<div class="line"></div>  <!-- Dividing line --> ?>
                
                <article id="article2"> <!-- The new article tag. The id is supplied so it can be scrolled into view. -->
                    <h2>Ausloggen</h2>
                    
                    <div class="line"></div>
                    
						<div class="articleBody clear">
							<figure> <!-- The figure tag marks data (usually an image) that is part of the article -->
							<a href="../login/index.php"><img src="../BL_BILDER/logout_02.jpg" alt="Beginn Ausleihe" width="200" height="95" /></a>
							</figure>
						<p>Zum Ausloggen müssen Sie sich ersteinmal <a href="../login">hier</a> einloggen :-)</p>
						<p>&nbsp;</p>
					</div>

                </article>
                
				<!-- Article 2 end -->
<?




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
$includeName="../_00_basic_footer.php";
if (file_exists($includeName))
{
include_once($includeName);
}	
else
{
echo '<br><br><div class="meldung_fehler"><img src="../BL_BILDER/Meldungen_Warning.png"> <br>FOOTER_FU_LOAD</div><br><br>';	
exit();
}

/////////////////////////////////////////////			
?>  
	        
       
		</section> <!-- Closing the #page section -->

		 

        
<!-- JavaScript Includes -->
<?
echo nl2br($_SESSION["SE_jQuerUI"]);
?>

		


<?
echo utf8_encode($_SESSION["SE_EndeIndex"]);
?>
</body>
</html>