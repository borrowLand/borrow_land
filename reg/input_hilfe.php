$(document).ready(function(){
			
/*-----------------------------------------------------------------------------------------------*/			
/*Beginn email check*/
    	
	var emailok = false;
	var myForm = $("#formElem"), email = $("#reg_Mail"); 

	//send ajax request to check email
	email.blur(function(){
    
		$.ajax({
			type: "POST",
			data: "a="+$(this).val(),
			url: "00_aj_01.php",
			beforeSend: function(){
						/* Hinweis Daten werden überprüft */
			},
			success: function(data){
				if(data == "invalid" && $("#reg_Mail").val() != "")
				{
					emailok = false;
						$.pnotify({
						pnotify_title: 'Hinweis E-Mail',
						pnotify_text: 'Bitte geben Sie eine gültige E-Mail Adresse ein. (z.B. name@organisation.com).',
						pnotify_animation: {effect_in: 'show', effect_out: 'slide'}
						});
						
						$("#reg_Mail").val("");
				}
				else if(data >= 1 && $("#reg_Mail").val() != "")
				{
					emailok = false;
						$.pnotify({
						pnotify_title: 'Fehler E-Mail',
						pnotify_text: 'Diese E-Mail Adresse kann nicht mehr verwendet werden. Falls das Passwort vergessen wurde, kann es <a href=\"../login\"><b>hier</b></a> neu erstellt werden.',
						pnotify_type: 'error'
						});
						
						$("#reg_Mail").val("");
				}
				else
				{
						/* Hinweis Daten okay */
				}
			}
		});
	});
	


                
/*Ende email check*/
/*-----------------------------------------------------------------------------------------------*/			
	
	             
/*Anfang Check andere Werte*/
/*-----------------------------------------------------------------------------------------------*/			
 

	/* OK Eingabe, wenn aktiviert*/
	
	<?
	if ($_SESSION["SE_vortextJaNein"]=="1")			//php theater, falls Software ohne eingangstext arbeitet
	{
	?>
			$('#reg_cbDiscl').blur(function() {

					
						if($("#reg_cbDiscl").val() != "OK" )
						{
									$.pnotify({
									pnotify_title: 'Hinweis Information',
									pnotify_text: 'Bitte die Eingangsinformation mit OK (Großbuchstaben) bestätigen.',
									pnotify_animation: {effect_in: 'show', effect_out: 'slide'}
									});
						$("#reg_cbDiscl").val("");
						}
			});	
	<?			
	}		
	?>

		/* Ende OK Eingabe, wenn aktiviert */
	
	/* Namensüberprüfung */
	
		$('#reg_N').blur(function() {

				
			if($("#reg_N").val().length <=4 && $("#reg_N").val() != "")
			{
				$.pnotify({
				pnotify_title: 'Hinweis Name',
				pnotify_text: 'Bitte geben Sie einen Namen mit mehr als 4 Zeichen ein.',
				pnotify_animation: {effect_in: 'show', effect_out: 'slide'}
				});
				$("#reg_N").val("");
			}
					
			if($("#reg_N").val().length >=99 && $("#reg_N").val() != "")
			{
				$.pnotify({
				pnotify_title: 'Hinweis Name',
				pnotify_text: 'Bitte geben Sie einen Namen mit weniger als 100 Zeichen ein.',
				pnotify_animation: {effect_in: 'show', effect_out: 'slide'}
				});
				$("#reg_N").val("");
			}
		});	
	
		/* Ende Namensüberprüfung */
		
	/*Telefonnummer */
		
		$("#reg_TN").numeric();

		
		$('#reg_TN').blur(function() {

				
			if($("#reg_TN").val().length <=5 && $("#reg_TN").val() != "")
			{
				$.pnotify({
				pnotify_title: 'Hinweis Telefonnummer',
				pnotify_text: 'Bitte geben Sie eine Telefonnummer mit mehr als 5 Zeichen ein.',
				pnotify_animation: {effect_in: 'show', effect_out: 'slide'}
				});
				$("#reg_TN").val("");
			}
				
			if($("#reg_TN").val().length >=19 && $("#reg_TN").val() != "")
			{
				$.pnotify({
				pnotify_title: 'Hinweis Telefonnummer',
				pnotify_text: 'Bitte geben Sie eine Telefonnummer mit nicht mehr als 20 Zeichen ein.',
				pnotify_animation: {effect_in: 'show', effect_out: 'slide'}
				});
				$("#reg_TN").val("");
			}
			
		});	
	
		/* Ende Telefonnummer */
	
	/* Matrikel ID  */
	
				<?
				if ($_SESSION["SE_AccessContrYN"]=="1")			//php theater, falls Software prüfung der id anfordert
				{
				?> 
				

		
	var myForm = $("#formElem"), mncheck = $("#reg_MN"); 

	//send ajax request to check email
	mncheck.blur(function(){
		$.ajax({
			type: "POST",
			data: "b=" + $(this).val(),
			url: "00_aj_02.php",
			beforeSend: function(){
						/* Hinweis Daten werden überprüft */
			},
			success: function(data){
				if(data == "invalid" && $("#reg_MN").val() != "")
				{
						
						$.pnotify({
						pnotify_title: 'Hinweis Matrikel-ID',
						pnotify_text: 'Bitte geben Sie eine gültige Matrikel-ID ein.',
						pnotify_animation: {effect_in: 'show', effect_out: 'slide'}
						});
					$("#reg_MN").val("");	
				}

				else
				{
						/* Hinweis Daten okay */
				}
			}
		});
	});
				<?
				}
				?>
		
		/* Ende Matrikel ID */
  
	/* Adressteil */
					
	                
					<?
                    if ($_SESSION["SE_AdressModuleYesNo"]=="1")
                    {
					?>

	/*Strasse und Hausnummer */
		
		
		$('#reg_Ad_StrasseHN').blur(function() {

				
			if($("#reg_Ad_StrasseHN").val().length <=5 && $("#reg_Ad_StrasseHN").val() != "")
			{
				$.pnotify({
				pnotify_title: 'Hinweis Adresse',
				pnotify_text: 'Bitte geben Sie eine Strasse mit Hausnummer mit mehr als 5 Zeichen ein.',
				pnotify_animation: {effect_in: 'show', effect_out: 'slide'}
				});
				$("#reg_Ad_StrasseHN").val("");
			}
				
			if($("#reg_Ad_StrasseHN").val().length >=100 && $("#reg_Ad_StrasseHN").val() != "")
			{
				$.pnotify({
				pnotify_title: 'Hinweis Adresse',
				pnotify_text: 'Bitte geben Sie eine Strasse mit Hausnummer mit nicht mehr als 100 Zeichen ein.',
				pnotify_animation: {effect_in: 'show', effect_out: 'slide'}
				});
				$("#reg_Ad_StrasseHN").val("");
			}
			
		});	
	
		/* Ende Strasse und Hausnummer */

	/* PLZ */
		
		$("#reg_PLZ").numeric();

		$('#reg_PLZ').blur(function() {
				
			if($("#reg_PLZ").val().length != "5" && $("#reg_PLZ").val() != "")
			{
                $.pnotify({
				pnotify_title: 'Hinweis Postleitzahl',
				pnotify_text: 'Bitte geben Sie eine Postleitzahl mit 5 Zahlen ein.',
				pnotify_animation: {effect_in: 'show', effect_out: 'slide'}
				});
				$("#reg_PLZ").val("");
			}
				
		});	
	
		/* Ende PLZ */

	/* Anfang Stadt */
		
		$('#reg_Stadt').blur(function() {

			if($("#reg_Stadt").val().length <= "2" && $("#reg_Stadt").val() != "")
			{
				$.pnotify({
				pnotify_title: 'Hinweis Stadt',
				pnotify_text: 'Bitte geben Sie eine Stadt mit mindestens 3 Buchstaben ein.',
				pnotify_animation: {effect_in: 'show', effect_out: 'slide'}
				});
				$("#reg_Stadt").val("");
			}

			if($("#reg_Stadt").val().length >=100 && $("#reg_Stadt").val() != "")
			{
				$.pnotify({
				pnotify_title: 'Hinweis Stadt',
				pnotify_text: 'Bitte geben Sie eine Stadt mit nicht mehr als 100 Zeichen ein.',
				pnotify_animation: {effect_in: 'show', effect_out: 'slide'}
				});
				$("#reg_Stadt").val("");
			}				
		});	
	
		/* Ende Stadt */

					<?
					}
					?>  
  
  
		/* Ende Adressteil */

	/* Anfang recap */


    	$('#recaptcha_response_field').blur(function() {
		
        $.ajax({
			type: "POST",
			data: "c="+$("#recaptcha_response_field").val()+"&d="+$("#recaptcha_challenge_field").val(),
			url: "00_aj_03.php",
			beforeSend: function(){
			},
			success: function(data){
				if(data == 'invalid' && $("#recaptcha_response_field").val() != '')
				{
						Recaptcha.reload();
						$.pnotify({
						pnotify_title: 'Hinweis Spam-Schutz',
						pnotify_text: 'Bitte geben Sie nochmals die zwei Wörter ein.',
						pnotify_animation: {effect_in: 'show', effect_out: 'slide'}
						});
					$("#recaptcha_widget_div").after("<span class=\"errors\"></span>");
                    //$("#recaptcha_response_field").val();	
				}

				if(data == '0' && $("#recaptcha_response_field").val() != '')
				{
						/* Hinweis Daten okay */
                        $("#spamHideArea1").remove();
                        $("#spamHideArea2").remove();
                       	$("#spamHideArea4").after("<p>Die Wörter wurden erfolgreich eingeben.</p>");
                        
                        
                        
				}
			}
		});
	});


		/* Ende recap */

});

/*Ende Check andere Werte**/
/*-----------------------------------------------------------------------------------------------*/		

