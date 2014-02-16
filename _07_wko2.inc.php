<?
//warenkorb steuerung für objekte ohne/mit versand

session_start();

if (isset($_SESSION["User_ID"]))
    {
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

    $zerHacktWk1 = explode("_", $_GET['wk1']);
    $zerHacktWk2 = explode("_", $_GET['wk2']);

    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////mit oder ohne versand? 

    if ($_GET['wk1']=="" && $_GET['wk2']!="")
    {
    //versand
    $objekt=unserialize(base64_decode($zerHacktWk2[2]));
    $versand=1;
    }

    if ($_GET['wk1']!="" && $_GET['wk2']=="")
    {
    //kein versand
    $objekt=unserialize(base64_decode($zerHacktWk1[2]));
    $versand=0;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////objekt ist bekannt und versand eigenschaft auch; begrenzungen des warenkorbs

    $anzahlElementeWK=count($_SESSION["User_WK"]);
    if ($anzahlElementeWK<$_SESSION["SE_AnzahlElemWKMax"])
    {

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////// in welcher hauptgruppe steckt das objekt => wenn gefunden: löschen

    $namenHauptGruppen=array_keys($_SESSION["aktuelleObjekte"]);

    $anzahlHG=count($namenHauptGruppen);
    for ($k=0;$k < $anzahlHG;$k++)
    {
        $anzahlObjekteInHG=count($_SESSION["aktuelleObjekte"][$namenHauptGruppen[$k]]);

        //objekte in den hauptgruppen
        for ($r=0;$r < $anzahlObjekteInHG;$r++)
        {
            //echo $_SESSION["aktuelleObjekte"][$namenHauptGruppen[$k]][$r]."<br>";
            //nachschauen ob angefragtes objekt überhaupt in der auswahl der jetzigen objekte vorhanden ist
            if ($objekt==$_SESSION["aktuelleObjekte"][$namenHauptGruppen[$k]][$r])
            {
            $objektGefundenUndOkay=$_SESSION["aktuelleObjekte"][$namenHauptGruppen[$k]][$r];
            //löschen und array neuordnung
            unset($_SESSION["aktuelleObjekte"][$namenHauptGruppen[$k]][$r]);
            $_SESSION["aktuelleObjekte"][$namenHauptGruppen[$k]] = array_values($_SESSION["aktuelleObjekte"][$namenHauptGruppen[$k]]);
            $hauptgruppeDesObjWK=$namenHauptGruppen[$k];
            $wieoft++;
            }
        }
    }
    //nur weitermachen wenn angefragtes objekt okay und genau einmal gefunden
    if (isset($objektGefundenUndOkay) && $objektGefundenUndOkay!="" && $wieoft=="1")
    {

        //reservieren im warenkorb
        if (!isset($_SESSION["User_WK"]) && $anzahlElementeWK=="0")
        {
        $_SESSION["User_WK"][0]["name"]=$objektGefundenUndOkay;
        $_SESSION["User_WK"][0]["zeitStart"]=$_SESSION["aktuelleZeitStart"];
        $_SESSION["User_WK"][0]["zeitEnde"]=$_SESSION["aktuelleZeitEnde"];
        $_SESSION["User_WK"][0]["hgName"]=$hauptgruppeDesObjWK;
        $_SESSION["User_WK"][0]["versand"]=$versand;
        $anzahlElementeWK++;

        }
        else
        {
        $_SESSION["User_WK"][$anzahlElementeWK]["name"]=$objektGefundenUndOkay;
        $_SESSION["User_WK"][$anzahlElementeWK]["zeitStart"]=$_SESSION["aktuelleZeitStart"];
        $_SESSION["User_WK"][$anzahlElementeWK]["zeitEnde"]=$_SESSION["aktuelleZeitEnde"];
        $_SESSION["User_WK"][$anzahlElementeWK]["hgName"]=$hauptgruppeDesObjWK;
        $_SESSION["User_WK"][$anzahlElementeWK]["versand"]=$versand;
        $anzahlElementeWK++;
        }			

        $anzahlObjekteInBetreffenderHGNacHWKaktion=count($_SESSION["aktuelleObjekte"][$hauptgruppeDesObjWK]);		

        //##################################################################################################eigener teil
        ?>
        <script>
        $("table[obj_id=<? echo base64_encode(serialize($objektGefundenUndOkay));?>]").remove();
            <?
            if ($_SESSION['SE_versandMod']=="1")
            {
            ?>
            $("a[inWK_o_mV^=_2_]").show();
            <?
            }
            ?>			
        $("a[inWK_o_oV^=_1_]").show();
        </script>
        <?
        //wenn letztes objekt aus einer hg, dann überschrift auch entfernen
        if ($anzahlObjekteInBetreffenderHGNacHWKaktion=="0")
        {
            ?>
            <script>
            $("div[id^=d3f<? echo base64_encode(serialize($hauptgruppeDesObjWK)); ?>]").remove();
            </script>	
            <?			
        }
        //##################################################################################################ende eigener teil

        //###################################################################################################hauptgruppe anfang
        //wenn hauptgruppen modus aktiv, und das letzte objekt der hauptgruppe aktiv ist, wird dieses entfernt
        if ($_SESSION["SE_ViewLeihmodHauptg"]=="1" && $anzahlObjekteInBetreffenderHGNacHWKaktion=="0")
        {
        ?>
        <script>
        $("#<? echo base64_encode(serialize($hauptgruppeDesObjWK)); ?>").remove();
        </script>	
        <?			
        }
        //###################################################################################################hauptgruppe ende			


        //###################################################################################################einzelobjekt tag anfang

        if ($_SESSION["SE_ViewLeihmodTag"]=="1")
        {
        ?>
        <script>
        $("table[objT_id=<? echo base64_encode(serialize($objektGefundenUndOkay));?>]").remove();
        </script>	
        <?		
        }
        //###################################################################################################einzelobjekt tag ende

        //usability hinweis für erste objekt im warenkorb
        if ($anzahlElementeWK==1)
        {
                ?>
                <script>
                $.pnotify({
                pnotify_title: 'Hinweis Warenkorb',
                pnotify_text: 'Sie können jetzt auf das Symbol Warenkorb klicken und die Reservierung abschliessen oder weitere Objekte hinzufügen.'
                });
                </script>
                <?
        }			
        ?>
        <script>
        $.pnotify({
        pnotify_title: 'Hinweis Warenkorb',
        pnotify_text: 'Das Objekt <b><? echo htmlspecialchars(utf8_encode(klarNameObj($objektGefundenUndOkay))); ?></b> wurde erfolgreich hinzugefügt.'
        });

        if ($("#ladeEinzelObj table").length==0)
        {
        $("#ladeEinzelObj").append("Weitere Objekte stehen in diesem Zeitraum leider nicht zur Verfügung.<br><br>Sie können mit der Änderung des Zeitraums weitere Objekte hinzufügen.");
        $("div[id^=d3f]").remove();
        }
        </script>
        <?			


        //warenkorb header aktualisierung
        echo '<li><a href="'.$_SESSION["SE_festUrl"].'account/basket" title="Warenkorb">'.wkCountOhneLeer().'<div class="ui-state-default ui-corner-all"><span class="ui-icon ui-icon-cart"></span></div></a></li>';
        }
            else
            {
            ?>
            <script>
            $.pnotify({
            pnotify_title: 'Hinweis Warenkorb',
            pnotify_text: 'Das Objekt wurde nicht gefunden.',
            pnotify_type: 'error'
            });
            </script>
            <?		
            }
    }					
    else
    {
    ?>
    <script>
    $.pnotify({
    pnotify_title: 'Hinweis Warenkorb',
    pnotify_text: 'Die maximale Anzahl an Elementen (<? echo $_SESSION["SE_AnzahlElemWKMax"]; ?>) pro Warenkorb wurde überschritten.',
    pnotify_type: 'error'
    });
    $("table").remove();
    </script>
    <?
    //warenkorb header aktualisierung
    echo '<li><a href="'.$_SESSION["SE_festUrl"].'account/basket" title="Warenkorb">'.wkCountOhneLeer().'<div class="ui-state-default ui-corner-all"><span class="ui-icon ui-icon-cart"></span></div></a></li>';
    }
}