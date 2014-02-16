<article id="article1"> <!-- The new article tag. The id is supplied so it can be scrolled into view. -->
                    <h2>Registrierungsvorgang</h2>
                    <br>Drücken Sie die Tabulator Taste <img src="../BL_BILDER/tabbs.png" border="0" align="absmiddle"> um fortzufahren. Alternativ können Sie auch mit der Maustaste auf die grauen Schaltbereiche klicken.

                    <div class="line"></div>
                    
                    <div class="articleBody clear">
                    
                    	<div id="wrapper">
                <div id="steps">
                <script type="text/javascript">
                        var RecaptchaOptions = {
                        theme : 'clean',lang : 'de',
                        };
               </script>
                    <form id="formElem" name="formElem" action="index.php" method="post">
                                    
                   <?
                    if ($_SESSION["SE_vortextJaNein"]=="1")
                    {
					$sql = "SELECT InhaltDerEinstellung FROM `00_einstellungenSoftware` WHERE `Desc_Session` = \"SE_vortextInhalt\" LIMIT 1"; 
					$datenEinstell = mysql_query($sql);
					$row = mysql_fetch_row($datenEinstell);	
					$textVor=utf8_encode(strip_tags($row[0]));
					
					echo ' <fieldset class="step"> <legend>Information</legend>';
                    echo "<p><textarea name='textarea' readonly >".$textVor."</textarea></p>";
					echo '<p><label for="reg_cbDiscl">Bitte OK eingeben</label>
					<input id="reg_cbDiscl" name="reg_cbDiscl" ';
					if ($_POST["reg_cbDiscl"]!="")
					{
					echo 'value="'.htmlentities($_POST["reg_cbDiscl"],ENT_QUOTES).'"';
					}
					echo ' maxlength="2" autocomplete="off"/></p>';
					echo '</fieldset>';
					}
			

					?>


					   <fieldset class="step">
                            <legend>Allgemein</legend>
                            <p>
							
                                <label for="reg_N">Vorname und Nachname</label>
                    <input id="reg_N" name="reg_N" maxlength="100" 
					<?
                    if ($_POST["reg_N"]!="")
					{
					echo 'value="'.htmlentities($_POST["reg_N"],ENT_QUOTES).'"';
					} 
					?> autocomplete="off"/>
                            </p>
 							<p>
                                <label for="reg_Mail">E-Mail</label>
                                <input id="reg_Mail" name="reg_Mail" maxlength="60" 
					<?
                    if ($_POST["reg_Mail"]!="")
					{
					echo 'value="'.htmlentities($_POST["reg_Mail"],ENT_QUOTES).'"';
					} 
					?> autocomplete="off"/>
                      		</p> 
	<?
	if ($_SESSION["SE_AccessContrYN"]=="1")
	{
	?>                             
        <p>
            <label for="reg_MN"><? echo $_SESSION["SE_AccessContrName"]; ?></label>
            <input id="reg_MN" name="reg_MN" maxlength="50" 
            <?
			if ($_POST["reg_MN"]!="")
			{
			echo 'value="'.htmlentities($_POST["reg_MN"],ENT_QUOTES).'"';
			} 
			?> autocomplete="off"/>
        </p>
	<?
    }
    ?>          
                            <p>
                            <label for="reg_TN">Telefonnummer</label>
                            <input id="reg_TN" name="reg_TN"  maxlength="20" 
            <?
			if ($_POST["reg_TN"]!="")
			{
			echo 'value="'.htmlentities($_POST["reg_TN"],ENT_QUOTES).'"';
			} 
			?> autocomplete="off"/>
                            </p>
    
    
                     
                      </fieldset>
                        
                                     
                    <?
                    if ($_SESSION["SE_AdressModuleYesNo"]=="1")
                    {
					echo '
                        <fieldset class="step">
                            <legend>Adresse</legend>
                            <p>
                                <label for="reg_Ad_StrasseHN">Straße mit Hausnummer</label>
                                <input id="reg_Ad_StrasseHN" name="reg_Ad_StrasseHN" type="text" maxlength="100" ';
			
			if ($_POST["reg_Ad_StrasseHN"]!="")
			{
			echo 'value="'.htmlentities($_POST["reg_Ad_StrasseHN"],ENT_QUOTES).'"';
			} 
								echo ' autocomplete="off"/>
                            </p>
                            <p>
                                <label for="reg_PLZ">Postleitzahl</label>
                                <input id="reg_PLZ" name="reg_PLZ" maxlength="5" ';
			if ($_POST["reg_PLZ"]!="")
			{
			echo 'value="'.htmlentities($_POST["reg_PLZ"],ENT_QUOTES).'"';
			}
								echo ' autocomplete="off"/>
                            </p>
                            <p>
                                <label for="reg_Stadt">Stadt</label>
                                <input id="reg_Stadt" name="reg_Stadt" maxlength="100" ';
			if ($_POST["reg_Stadt"]!="")
			{
			echo 'value="'.htmlentities($_POST["reg_Stadt"],ENT_QUOTES).'"';
			}
								echo ' autocomplete="off"/>
                            </p>

                        </fieldset>
					';
					}

					?>
                    

                        
						<fieldset class="step">
							<legend>Spam-Schutz</legend>
                            
                             <p id="spamHideArea1">Bitte die zwei Wörter mit Lehrzeichen eingeben.<br />
                             Ist eines der Wörter schwer lesbar? Einfach hier  <a href="javascript:Recaptcha.reload();">
                             <img src="../BL_BILDER/recap_refresh.png"  alt="recaptcha reload" /></a> klicken.</p>
                             
                                    <div style="position:inherit;visibility:inherit;float:left;margin-left: 238px;" id="spamHideArea2">
                                    <br /><br /><br />
                                    <script type="text/javascript"
                                    src="http://www.google.com/recaptcha/api/challenge?k=<? echo welcheEinstellung("SE_reCap_public"); ?>">
                                    </script><br />
                                    <noscript>
                                    <iframe src="http://www.google.com/recaptcha/api/noscript?k=<? echo welcheEinstellung("SE_reCap_public"); ?>"
                                    height="300" width="500" ></iframe><br>
                                    <textarea name="recaptcha_challenge_field" id="recaptcha_challenge_field" rows="3" cols="40">
                                    </textarea>
                                    <input type="hidden" name="recaptcha_response_field"  id="recaptcha_response_field" value="manual_challenge">
                                    </noscript>
                                    
                                    <a href="#">Überprüfen</a>
                                    
                                    </div>
                                    
									<div id="spamHideArea4"></div>
						</fieldset>
                            
                            
                        <fieldset class="step">
                        <legend>Abschluss</legend>
						<p class="submit"><br /><br /><br />
                        <button id="registerButton" type="submit" >Daten absenden</button>
                        </p>
                        <?
						//reg_inDiesenRaeumenLiegtEsBequemer für double registr. check
						$unique_id=sha1(uniqid(microtime(),1));
						?>
                        <input name="reg_inDiesenRaeumenLiegtEsBequemer" type="hidden" value="<?php
                        echo $unique_id; 
                        ?>" />
                       
                        
                        <input name="reg_regFormPh" type="hidden" value="1" />                       
                        
						
						<?
						$_SESSION["reg_check2"]=md5(uniqid(mt_rand(),true));
						?>
                        <input name="reg_regFormPh2" type="hidden" value="<? echo $_SESSION["reg_check2"]; ?>" />
                        
                        
                        
                        </fieldset>   


                    </form>
                </div>
                <div id="navigation" style="display:none;">
                    <ul>
			<?
					if ($_SESSION["SE_vortextJaNein"]=="1")
					{
					echo '<li class="selected"><a href="#">Information</a></li><li ><a href="#">Allgemein</a></li>';
					}
					else
					{
					echo '<li class="selected"><a href="#">Allgemein</a></li>';
					}
					
                    if ($_SESSION["SE_AdressModuleYesNo"]=="1")
                    {
					echo '<li><a href="#">Adresse</a></li>';
					}
			?>		   
                    <li><a href="#">Spam-Schutz</a></li> 
                     <li><a href="#">Abschluss</a></li>  

                    </ul>
                </div>
            </div>
                </div>
                </article>