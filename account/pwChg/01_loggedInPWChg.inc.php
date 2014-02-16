			<article id="articlePWChg1"> <!-- The new article tag. The id is supplied so it can be scrolled into view. -->
			<h2>Änderung des Passwortes</h2>
			<div class="line"></div>
			<div id="contentPWChg" class="articleBody clear" style="margin-left:251px">
			<p>Sie können hier Ihr eigenes Passwort ändern.<br>Bitte beachten Sie, dass das neue Passwort mind. 6 Zeichen <br>haben muss und ausschließlich aus Zahlen und Buchstaben<br> bestehen darf.</p>
			
		<br><br>	
		<form id="PWChgForm" autocomplete="off" method="post" action="index.php">
		<h4>altes Passwort</h4>
		<input id="field_pw1" name="field_pw1" class="login_inputtext" type="password">
		
		<br><br><br><br>

		<h4>neues Passwort</h4>
		<input id="field_pw2" name="field_pw2" class="login_inputtext password" type="password">
		
		<br><br>

		<h4>neues Passwort - bitte nochmal eingeben</h4>
		<input id="field_pw3" name="field_pw3" class="login_inputtext password" type="password">
		
		<br><br>
		<input name="dmh83vhW4" type="hidden" value="<?
		$zufallswert=md5(uniqid(mt_rand(),true));
		$_SESSION["pwChg_ctrl1"]=$zufallswert;
		echo $zufallswert;
		?>"><br><br>
		<input id="sendPWChg" aria-disabled="false" class="ui-button ui-widget ui-state-default ui-corner-all" value="Passwort ändern" type="submit">
		</form>
		</div>
		
		<?
		if ($successPWUserChg=="1")
		{
		?>
		<div id="contentPWChg" class="articleBody clear">
		<p>Das Passwort wurde erfolgreich geändert. <br>Sie können <a href="../">hier</a> zum Hauptmenü zurückkehren.</p>
		</div>
		<?
		}
		
		?>
		</article>

