BORROW LAND
===========

(english support is coming soon)

Die wichtigsten Installationsschritte sind in der Datei "AA_installation_hints_german.docx"
zusammengefasst.

Im Ordner "AA____________________directory_for_mysql_database_file_to_import" befindet sich eine
MySQL Datei, die einfach in die entsprechende Datenbank importiert werden muss. Das geht
zum Beispiel mit myphpadmin.












===================================================================================================

Grundverständnis zum (technischen Ausleihevorgang):

Vorgang Reservierung
Stand 16.2.2014

--

Aus der Startseite mit Auswahl Start- Ende (Datum & Zeit) wird mit bei jedem Klick ein
Request an _06_objekteSuche-0.inc.php gesendet. Beispiel:

http://<DEINE_URL>/_06_objekteSuche-0.inc.php?oz1=22.02.2014&oz2=8.00&oz3=&oz4=undefined

gesendet. Der Anwender kann sich ja die Reihenfolge aussuchen.

Irgendwann sind alle vier Werte okay, das sieht dann so aus:
http://<DEINE_URL>_06_objekteSuche-0.inc.php?oz1=22.02.2014&oz2=8.00&oz3=24.02.2014&oz4=6.00

Das Datum wird mithilfe von checkdate() geprüft. Wenn dann noch eine User_ID vorhanden ist, 
werden Timestamps genbaut. Diese haben dann folg. Variablen:

$DatumBeginn
$DatumEnde


Verschiedene Überprüfungen finden statt, z.B. ob die Reihenfolge logisch ist.
Es werden auch die maximalen Ausleihetage eingelesen (Unterschied zum Dauerausleiher!)
und geprüft ob das Sinn macht.

Wenn alles okay ist, wird mithilfe der Funktion objekteDieZurVerfuegungStehen() alle Objekte
ausgelesen, die in ersteinmal Frage kommen.
Es werden nur aktive Hauptgruppen und aktive Objekte berücksichtigt.
Zudem wird gematcht, welche Objekte schon verliehen worden sind und wo es Widersprüche gibt.
Das Ergebnis ist das  Session Array 

$_SESSION["aktuelleObjekte"]

Ein Objekt was verfügbar wäre sähe beim var_dump() so aus:

array(1) {
  ["372f5c4d10452b8b6be3a0d23f894e812a0d1e8e"]=>
  array(1) {
    [0]=>
    string(40) "e67c13e295f4cc026eaa94f230f0821a014622f4"
  }
}

"372f5c4d10452b8b6be3a0d23f894e812a0d1e8e" ist der Identifier der Hauptgruppe, alle Elemente darunter sind der
Identifier der dazugehörigen Objekte.

Je nach Einstellung werden die Ausleiheobjekte dem potenziellen Ausleiher präsentiert

_06_objekteSuche-1.inc.php		$_SESSION["SE_ViewLeihmodHauptg"]	Hauptgruppen werden nur angezeigt, es wird zufällig ein Objekt ausgeählt				
_06_objekteSuche-2.inc.php		$_SESSION["SE_ViewLeihmodEinzel"]	Es wird die Hauptgruppe angezeigt, es werden alle Objekte dazu angezeigt (nicht zu empfehlen bei vielen Items oder gleichen Items)
_06_objekteSuche-3.inc.php		$_SESSION["SE_ViewLeihmodTag"]		Es werden alle Objekte angezeigt, die auf die Auswahl der Tags zutreffen.

Jeder Datei werden die gleichen Ausgangsparameter übergeben, also Start- und Ende Datum und Start- und Endzeit. 
Beispiel:
http://<DEINE_URL>/_06_objekteSuche-2.inc.php?oz1=16.02.2014&oz2=4.00&oz3=17.02.2014&oz4=7.00

Somit haben alle drei Bereiche die gleichen Ausgangsdaten:
Alle Objekte, die dazugehörige Hauptgruppe und den genauen Zeitraum der potentiellen Leihe

======================================

Beispiel im Bereich 1 (_06_objekteSuche-1.inc.php):
Hauptgruppen Anzeige mit Auswahl eines zufälligen Objektes beim Klick.

Hier wird im Linkbereich das Tag inWK_HG_oV aufgebaut, die Hauptgruppen Nummern fangen mit "_1_" an.
Der Tag inWK_HG_mV bedeutet "mit Versand" und wird dementsprechend mit "_1_" aufgebaut.
Abhängig davon, ob die Versandoption aktiviert wird, ist auch der Trigger wann ein Objekt 
der Datei "_07_wko.inc.php" zukommt. Erst hier wird das Objekt dem Warenkorb zugeordnet.



