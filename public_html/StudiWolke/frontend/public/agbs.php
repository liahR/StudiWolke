<?php
    session_start();
    // Prüfen ob Benutzer nicht eingeloggt ist + ordner id setzen 
    if (!isset($_SESSION["benutzer_id"]))
{
    header("Location: login.html");
}
else {
    $benutzer_id = $_SESSION["benutzer_id"];
}

    $pdo = new PDO('mysql:: host=mars.iuk.hdm-stuttgart.de;dbname=u-lr090', 'lr090', 'eetho6Choh', array('charset' => 'utf8'));

?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico" id="favicon">
    <link rel="stylesheet" type="text/css" href="allgemein.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AGB's</title>
</head>
<body>
<header>
    <?php
     // SQL-Abfrage zum Abrufen des Profilbilds des Benutzers
     $stmt = $pdo->prepare("SELECT profilbild FROM benutzer WHERE benutzer_id=:benutzer_id");
     $stmt->bindValue(':benutzer_id', $_SESSION['benutzer_id']);
     if ($stmt->execute()) {
        while ($row=$stmt->fetch()) {
            if (!empty($row["profilbild"])) {
                echo '<div class="profilbild"><a href="account.php"><img src="https://mars.iuk.hdm-stuttgart.de/~lr090/StudiWolke/frontend/profilbilder/' . $row["profilbild"] . '"></a></div>';
            }
        }
     }
    ?>
		<div class="logo">
			<a href="index.php"><img src="Logo StudiWolke.png"></a>
		</div>
		<nav>
			<ul>
				<li><a href="index.php">Start</a></li>
				<li><a href="hilfe.php">Support</a></li>
			</ul>
		</nav>
	</header>
	<body>
   <h1> Allgemeine Geschäftsbedingungen von StudiWolke </h1>
        <h2>Willkommen bei StudiWolke!</h2>
        <p><b>§ 1 Geltungsbereich und Anbieter</b>
        (1) Die Allgemeinen Geschäftsbedingungen (nachfolgend „AGB" genannt) regeln das Vertragsverhältnis zwischen Studenten GmbH (nachfolgend Anbieter) und Ihnen (nachfolgend Besteller), in ihrer zum Zeitpunkt des Vertragsabschlusses gültigen Fassung.<br>
        (2) Abweichende AGB des Bestellers werden zurückgewiesen.
        Bitte lesen Sie diese Bedingungen aufmerksam, bevor Sie eine Dienstleistung der Studenten GmbH in
        Anspruch nehmen.<br>
        (3) Auf StudiWolke bieten wir Ihnen folgende Dienstleistungen an:
        Dokumente und Daten, Fotos, Filme und sogar Anwendungen müssen Studenten nicht länger nur auf der Festplatte mobiler Geräte oder des PCs zu Hause bearbeiten und speichern. Sie können auf entfernte Server ausgelagert und mit anderen Studenten geteilt werden - in der sogenannte StudiWolke.<br><br>
        <b>§ 2 Zustandekommen des Vertrages</b><br>
        (1) Verträge auf diesem Portal können ausschließlich in deutscher Sprache abgeschlossen werden.<br>
        (2) Der Besteller muss das 18. Lebensiahr vollendet haben.<br>
        (3) Der Zugang zur Nutzung des StudiWolke-Service setzt die Anmeldung voraus.<br>
        (4) Mit der Anmeldung erkennt der Besteller die vorliegenden AGB an. Mit der Anmeldung entsteht ein Vertragsverhältnis zwischen StudiWolke und dem angemeldeten Besteller, das sich nach den Regelungen dieser AGB richtet.<br>
        (5) Die Präsentation der Dienstleistung auf der Website stellt kein rechtlich wirksames Angebot dar. Durch die Präsentation der Dienstleistung wird der Kunde lediglich dazu aufgefordert ein Angebot zu machen.<br>
        (6) Mit Bestellung eines kostenpflichtigen Dienstes geht der angemeldete Besteller ein weiteres, von der Anmeldung getrenntes Vertragsverhältnis mit StudiWolke ein. Der Nutzer wird vor Abschluss dieses Vertragsverhältnisses über den jeweiligen kostenpflichtigen Dienst und die Zahlungsbedingungen informiert.
        Das Vertragsverhältnis entsteht indem der Besteller die Bestellung und Zahlungsverpflichtung durch das
        Anklicken des Buttons „kaufen" bestätigt.<br>
        (7) Sie stimmen zu, dass Sie Rechnungen elektronisch erhalten. Elektronische Rechnungen werden Ihnen per E-Mail oder in dem Kundenkonto der Webseite zur Verfügung gestellt. Wir werden Sie für jede Dienstleistung darüber informieren, ob eine elektronische Rechnung verfügbar ist. Weitere Informationen über elektronische
        Rechnungen erhalten Sie auf unserer Website.<br><br>
        <b>§ 3 Beschreibung des Leistungsumfanges</b><br>
        Der Leistungsumfang von StudiWolke besteht aus folgenden Dienstleistungen:
        Verwalten von Daten wie Dokumenten, Fotos und Videos<br>
        <b>§ 4 Preise und Versandkosten</b><br>
        (1) Zur Nutzung von StudiWolke ist zunächst eine Registrierung notwendig.<br>
        (2) Um die Dienstleistungen der Website kaufen zu können, muss der Nutzer sich registrieren und ein
        Benutzerkonto erstellen.<br>
        (3) Sofern der Nutzer einen kostenpflichtigen Dienst in Anspruch nehmen möchte, wird er vorher auf die Kostenpflichtigkeit hingewiesen. So werden ihm insbesondere der jeweilige zusätzliche Leistungsumfang, die anfallenden Kosten und die Zahlungsweise aufgeführt.<br>
        (4) Der Anbieter behält sich das Recht vor, für verschiedene Buchungszeitpunkte und Nutzergruppen und insbesondere für verschiedene Nutzungszeiträume unterschiedliche Entgeltmodelle zu berechnen, wie auch verschiedene Leistungsumfange anzubieten.<br>
        <b>§ 5 Zahlungsbedingungen</b><br>
        (1) Ein anfallendes Entgelt ist im Voraus, zum Zeitpunkt der Fälligkeit ohne Abzug an StudiWolke zu entrichten.<br>
        (2) Mit der Anmeldung, der Angabe der für das Bezahlverfahren notwendigen Informationen sowie der Nutzung des kostenpflichtigen Dienstes erteilt der Nutzer dem Betreiber die Ermächtigung zum Einzug des entsprechenden Betrags.<br>
        (3) Ein kostenpflichtiger Dienst verlängert sich um den jeweils gebuchten Zeitraum (Abonnement)
        automatisch, soweit dieser nicht per Telefon, E-Mail oder Brief gekündigt wird.<br>
        (4) Das Abonnement wird zum folgenden Zeitpunkt eingezogen: Am ersten Tag des Monats.<br>
        (5) Bestimmte Zahlungsarten können im Einzelfall von dem Anbieter ausgeschlossen werden.<br>
        (6) Dem Besteller ist nicht gestattet die Dienstleistung durch das Senden von Bargeld oder Schecks zu bezahlen.<br>
        (7) Sollte der Besteller ein Online-Zahlungsverfahren wählen, ermächtigt der Besteller den Anbieter dadurch, die fälligen Beträge zum Zeitpunkt der Bestellung einzuziehen.<br>
        (8) Sollte der Anbieter die Bezahlung per Vorkasse anbieten und der Besteller diese Zahlungsart wählen, hat der Besteller den Rechnungsbetrag innerhalb von fünf Kalendertagen nach Eingang der Bestellung, auf das
        Konto des Anbieters zu überweisen.<br>
        (9) Sollte der Anbieter die Bezahlung per Kreditkarte anbieten und der Besteller diese Zahlungsart wählen, ermächtigt dieser den Anbieter ausdrücklich dazu, die fälligen Beträge einzuziehen.<br>
        (10) Sollte der Anbieter die Bezahlung per Lastschrift anbieten und der Besteller diese Zahlungsart wählen, erteilt der Besteller dem Anbieter ein SEPA Basismandat. Sollte es bei der Zahlung per Lastschrift zu einer Rückbuchung einer Zahlungstransaktion mangels Kontodeckung oder aufgrund falsch übermittelter Daten der Bankverbindung kommen, so hat der Besteller dafür die Kosten zu tragen.<br>
        (11) Sollte der Besteller mit der Zahlung in Verzug kommen, so behält sich der Anbieter die Geltendmachung des Verzugschadens vor.<br>
        (12) Die Abwicklung kann über folgende Zahlungsmittel erfolgen:<br>
        - Paypal<br>
        - Kreditkarte<br>
        - Lastschrift:<br>
        Im Falle einer vom Besteller zu vertretenden Rücklastschrift erhebt die Studenten GmbH einen pauschalierten Schadensersatz in Höhe von 8 € (acht Euro). Der Besteller kann nachweisen, dass ein Schaden überhaupt nicht entstanden oder wesentlich niedriger ist als die Pauschale. Die vorstehenden Regelungen gelten entsprechend für Zahlungen des Kaufpreises von Waren, die von Drittanbietern verkauft werden.<br>
        - Sofortüberweisung<br><br>
        <b>§ 6 Anmeldung und Kündigung</b><br>
        (1) Weiterhin erklärt der Besteller, dass er und nach seiner Kenntnis auch kein Mitglied seines Haushaltes nicht wegen einer vorsätzlichen Straftat die die Sicherheit von Dritten gefährdet vorbestraft ist, insbesondere nicht wegen einer Straftat gegen die sexuelle Selbstbestimmung (§§ 174 ff. StGB, einer Straftat gegen das Leben (§§ 211 ff. StGB), einer Straftat gegen die körperliche Unversehrtheit (§ 223 ff. StGB), einer Straftat gegen die persönliche Freiheit (§§ 232 ff. StGB), oder wegen eines Diebstahl und Unterschlagung (§§ 242 ff.
        StGB) oder des Raubes und der Erpressung (§§ 249 ff. StGB) oder wegen Drogenmissbrauch.<br>
        (2) Ein Nutzerkonto ist für seine/ihre alleinige und persönliche Nutzung und ein Nutzer darf Dritte nicht autorisieren dieses Konto zu nutzen. Ein Nutzer darf sein/ ihr Konto nicht an Dritte übertragen.<br>
        (3) Ein Nutzer ist, unter Vorbehalt, jederzeit berechtigt, sich ohne Angabe eines Grundes schriftlich per Post, E-Mail oder Telefon abzumelden. Gleichzeitig besteht bei die Möglichkeit, innerhalb der Daten und Einstellungen im Nutzer-Account diesen vollständig und eigenhändig zu deaktivieren. Das vorher geschlossene Vertragsverhältnis ist damit beendet.<br>
        (4) Hat ein Nutzer sich für einen entgeltlichen Dienst angemeldet, so kann er spätestens 30 Tage vor dem Buchungszeitraum kündigen. Wird diese Frist nicht eingehalten, so verlängert sich der kostenpflichtige Dienst je nach gewählter Buchungszeit um diese und die Kündigung wird erst zum Ende des Folgebuchungszeitraumes wirksam. Eine Kündigung ist per Telefon, E-Mail oder Brief möglich und wird von uns schriftlich bestätigt. Damit Ihre Kündigung zugeordnet werden kann sollen der vollständige Name, die hinterlegte E-Mail-Adresse und die Anschrift des Kunden angegeben werden. Im Fall einer Kündigung per Telefon wird das individuelle Telefon-Passwort benötigt.<br>
        (5) StudiWolke kann den Vertrag nach eigenem Ermessen, mit oder ohne vorherige Ankündigung und ohne Angabe von Gründen, zu jeder Zeit kündigen. StudiWolke hält sich weiterhin das Recht vor, Profile und /oder ieden Inhalt der auf der Website durch oder von dem Nutzer veröffentlich wurde zu entfernen. Falls
        StudiWolke die Registrierung des Nutzers beendet und/oder Profile oder veröffentliche Inhalte des Nutzers entfernt, besteht für StudiWolke keine Verpflichtung den Nutzer darüber noch über den Grund der Beendigung oder der Entfernung zu informieren.<br>
        (6) Im Anschluss an jede Beendigung von jedweder individuellen Nutzung der Services von StudiWolke, hält StudiWolke sich das Recht vor, eine Information hierüber an andere registrierte Nutzer mit denen StudiWolke annimmt, dass diese in Kontakt mit dem Nutzer standen, zu versenden. StudiWolke's Entscheidung die Registrierung des Nutzers zu beenden und/oder weitere Nutzer zu benachrichtigen mit dem StudiWolke annimmt, dass der Nutzer in Kontakt stand, impliziert nicht bzw. sagt keinesfalls aus, dass StudiWolke Aussagen über den individuellen Charakter, generelle Reputation, persönliche Charakteristika noch über den
        Lebensstil trifft.<br>
        (7) Die Nutzer sind verpflichtet, in Ihrem Profil und sonstigen Bereichen des Portals keine absichtlichen oder betrügerischen Falschangaben zu machen. Solche Angaben können zivilrechtliche Schritte nach sich ziehen.
        Der Betreiber behält sich darüber hinaus das Recht vor, in einem solchen Fall das bestehende
        Vertragsverhältnis mit sofortiger Wirkung aufzulösen.<br>
        (8) Wird der Zugang eines Nutzers wegen schuldhaften Vertragsverstoßes gesperrt und/oder das Vertragsverhältnis aufgelöst, hat der Nutzer für die verbleibende Vertragslaufzeit Schadenersatz in Höhe des vereinbarten Entgelts abzüglich der ersparten Aufwendungenzu zahlen. Die Höhe der ersparten Aufwendungen wird pauschal auf 10% des Entgelts angesetzt. Es bleibt beiden Vertragsparteien unbenommen nachzuweisen, dass der Schaden, und/oder die ersparten Aufwendungen tatsächlich höher oder niedriger sind.<br>
        (9) Nach Beendigung des Vertragsverhältnisses werden sämtliche Daten des Nutzers von StudiWolke gelöscht.<br><br>
        <b>§ 7 Haftungsbegrenzung (Dienstleistungen)</b><br>
        (1) StudiWolke übernimmt keine Verantwortung für den Inhalt und die Richtigkeit der Angaben in den Anmelde- und Profildaten der Besteller sowie weiteren von den Bestellern generierten Inhalten.<br>
        (2) In Bezug auf die gesuchte oder angebotene Dienstleistung kommt der Vertrag ausschließlich zwischen den jeweilig beteiligten Bestellern zustande. Daher haftet StudiWolke nicht für Leistungen der teilnehmenden Besteller. Entsprechend sind alle Angelegenheiten bzgl. der Beziehung zwischen den Bestellern einschließlich, und ohne Ausnahme, der Dienstleistungen die ein Suchender erhalten hat oder Zahlungen die an Besteller fällig sind, direkt an die jeweilige Partei des zu richten. StudiWolke kann hierfür nicht verantwortlich gemacht werden und widerspricht hiermit ausdrücklich allen etwaigen Haftungsansprüchen welcher Art auch immer einschließlich Forderungen, Leistungen, direkte oder indirekte Beschädigungen jeder Art, bewusst oder unbewusst, vermutet oder unvermutet, offengelegt oder nicht, in welcher Art auch immer im Zusammenhang mit den genannten Angelegenheiten.<br>
        (3) Für Schäden aus der Verletzung des Lebens, des Körpers oder der Gesundheit haftet Studenten GmbH nur, wenn sie auf einer vorsätzlichen oder fahrlässigen Pflichtverletzung von Studenten GmbH oder einer vorsätzlichen oder fahrlässigen Pflichtverletzung eines gesetzlichen Vertreters oder Erfüllungsgehilfen von
        Studenten GmbH beruhen.<br>
        (4) Für sonstige Schäden, soweit sie nicht auf der Verletzung von Kardinalpflichten (solche Pflichten, deren Erfüllung die ordnungsgemäße Durchführung des Vertrages überhaupt erst ermöglichen und auf deren Einhaltung der Vertragspartner regelmäßig vertrauen darf) beruhen, haftet Studenten GmbH Europe nur, wenn sie auf einer vorsätzlichen oder grob fahrlässigen Pflichtverletzung von Studenten GmbH oder auf einer vorsätzlichen oder grob fahrlässigen Pflichtverletzung eines gesetzlichen Vertreters oder
        Erfüllungsgehilfen von Studenten GmbH beruhen. <br>     
        (5) Die Schadensersatzansprüche sind, auf den vorhersehbaren, vertragstypischen Schaden begrenzt. Sie betragen im Falle des Verzuges höchstens 5% des Auftragswertes.<br>
        (6) Schadenersatzansprüche, die auf der Verletzung des Lebens, des Körpers oder der Gesundheit oder der Freiheit beruhen, verjähren nach 30 Jahren; im Ubrigen nach 1 Jahr, wobei die Verjährung mit dem Schluss des Jahres, in dem der Anspruch entstanden ist und der Gläubiger von den Anspruch begründenden Umständen und der Person des Schuldners Kenntnis erlangt oder ohne grobe Fahrlässigkeit erlangen müsste
        (§ 199 Abs.1 BGB).<br>
        (7) Der Anbieter behält sich das Recht vor, den Inhalt eines von einem Nutzer verfassten Textes sowie hochgeladener Dateien auf die Einhaltung von Gesetz und Recht hin zu überprüfen und, wenn nötig, ganz oder teilweise zu löschen.<br><br>
        <b>§ 8 Aufrechnung und Zurückbehaltungsrecht</b><br>
        (1) Dem Besteller steht das Recht zur Aufrechnung nur zu, wenn die Gegenforderung des Bestellers rechtskräftig festgestellt worden ist oder von dem Anbieter nicht bestritten wurde.<br>
        (2) Der Besteller kann ein Zurückbehaltungsrecht nur ausüben, soweit Ihre Gegenforderung auf demselben
        Vertragsverhältnis beruht.<br><br>
        <b>§ 9 Widerrufsbelehrung</b><br>
        (1) Ist der Besteller ein Verbraucher, so hat er ein Widerrufsrecht nach Maßgabe der folgenden
        Bestimmungen:<br>
        (2) Widerrufsrecht<br>
        Sie haben das Recht, binnen vierzehn Tagen ohne Angabe von Gründen diesen Vertrag zu widerrufen.
        Die Widerrufsfrist für Dienstleistungen beträgt vierzehn Tage ab dem Tag des Vertragsabschlusses.
        Um Ihr Widerrufsrecht auszuüben, müssen Sie uns:<br>
        StudiWolke GmbH & Co. KG<br>
        Königsstraße 1 12345 Stuttgart<br>
        Telefon: Telefon: 01234 567890<br><br>

        mittels einer eindeutigen Erklärung (z. B. ein mit der Post versandter Brief, Telefax oder E-Mail) über Ihren Entschluss, diesen Vertrag zu widerrufen, informieren. Sie können dafür das Muster-Widerrufsformular auf unserer Internetseite verwenden oder uns eine andere eindeutige Erklärung übermitteln. Machen Sie von dieser Möglichkeit Gebrauch, so werden wir Ihnen unverzüglich (z.B. per E-Mail) eine Bestätigung über den
        Eingang eines solchen Widerrufs übermitteln.
        Zur Wahrung der Widerrufsfrist reicht es aus, dass Sie die Mitteilung über die Ausübung des Widerrufsrechts vor Ablauf der Widerrufsfrist absenden und Sie die Waren über unser Online-Rücksendezentrum innerhalb der unten definierten Frist zurückgesendet haben.
        Für zusätzliche Informationen hinsichtlich der Reichweite, des Inhalts und Erläuterungen zur Ausübung wenden Sie sich bitte an unseren Kundenservice.<br>
        (3) Folgen des Widerrufs<br>
        Wenn Sie diesen Vertrag widerrufen, haben wir Ihnen alle Zahlungen, die wir von Ihnen erhalten haben, einschließlich der Lieferkosten (mit Ausnahme der zusätzlichen Kosten, die sich daraus ergeben, dass Sie eine andere Art der Lieferung als die von uns angebotene, günstigste Standardlieferung gewählt haben), unverzüglich und spätestens binnen 14 Tagen ab dem Tag zurückzuzahlen, an dem die Mitteilung über Ihren Widerruf dieses Vertrags bei uns eingegangen ist. Für diese Rückzahlung verwenden wir dasselbe Zahlungsmittel, das Sie bei der ursprünglichen Transaktion eingesetzt haben, es sei denn, mit Ihnen wurde ausdrücklich etwas anderes vereinbart; in keinem Fall werden Ihnen wegen dieser Rückzahlung Entgelte berechnet.
        Haben Sie verlangt, dass die Dienstleistungen während der Widerrufsfrist beginnen sollen, so haben Sie uns einen angemessenen Betrag zu zahlen, der dem Anteil der bis zu dem Zeitpunkt, zu dem Sie uns von der Ausübung des Widerrufsrechts hinsichtlich dieses Vertrags unterrichten, bereits erbrachten Dienstleistungen im Vergleich zum Gesamtumfang der im Vertrag vorgesehenen Dienstleistungen entspricht.<br>
        (4) Ausnahmen vom Widerrufsrecht<br>
        Sie müssen für einen etwaigen Wertverlust der Waren nur aufkommen, wenn dieser Wertverlust auf einen zur Prüfung der Beschaffenheit, Eigenschaften und Funktionsweise der Waren nicht notwendigen Umgang mit ihnen zurückzuführen ist.
        Das Widerrufsrecht besteht nicht bzw. erlischt bei folgenden Verträgen:<br>
        • zur Lieferung von Waren, die aus Gründen des Gesundheitsschutzes oder aus Hygienegründen nicht zur Rückgabe geeignet sind und deren Versiegelung nach der Lieferung entfernt wurde oder die nach der Lieferung aufgrund ihrer Beschaffenheit untrennbar mit anderen Gütern vermischt wurden;<br>
        • zur Lieferung von Waren, die nach Kundenspezifikation angefertigt werden oder eindeutig auf die persönlichen Bedürfnisse zugeschnitten sind<br>
        • zur Lieferung von Waren, die schnell verderben können oder deren Verfallsdatum schnell überschritten
        würde;<br>
        • bei Dienstleistungen, wenn StudiWolke diese vollständig erbracht hat und Sie vor der Bestellung zur Kenntnis genommen und ausdrücklich zugestimmt haben, dass wir mit der Erbringung der Dienstleistung beginnen können und Sie Ihr Widerrufsrecht bei vollständiger Vertragserfüllung verlieren;<br>
        • zur Lieferung von Zeitungen, Zeitschriften oder Illustrierte, mit Ausnahme von Abonnement-Verträgen;<br>
        und<br>
        • zur Lieferung alkoholischer Getränke, deren Preis beim Abschluss des Kaufvertrags vereinbart wurde, deren Lieferung aber erst nach 30 Tagen erfolgen kann und deren aktueller Wert von Schwankungen auf dem Markt abhängt, auf die der Unternehmer keinen Einfluss hat.<br><br>
        <b>§ 10 Schlussbestimmungen</b><br>
        (1) Vertragssprache ist deutsch.<br>
        (2) Wir bieten keine Produkte oder Dienstleistungen zum Kauf durch Minderjährige an. Unsere Produkte für Kinder können nur von Erwachsenen gekauft werden. Falls Sie unter 18 sind, dürfen Sie StudiWolke nur unter
        Mitwirkung eines Elternteils oder Erziehungsberechtigten nutzen.<br>
        (3) Wenn Sie diese AGB verletzen und wir unternehmen hiergegen nichts, sind wir weiterhin berechtigt, von unseren Rechten bei jeder anderen Gelegenheit, in der Sie diese Verkaufsbedingungen verletzen, Gebrauch zu machen.<br>
        (4) Wir behalten uns das Recht vor, Änderungen an unserer Webseite, Regelwerken, Bedingungen einschließlich dieser AGB jederzeit vorzunehmen. Auf Ihre Bestellung finden jeweils die Verkaufsbedingungen, Vertragsbedingungen und AGB Anwendung, die zu dem Zeitpunkt Ihrer Bestellung in Kraft sind, es sei denn eine Änderung an diesen Bedingungen ist gesetzlich oder auf behördliche Anordnung erforderlich (in diesem Fall finden sie auch auf Bestellungen Anwendung, die Sie zuvor getätigt haben). Falls eine Regelung in diesen Verkaufsbedingungen unwirksam, nichtig oder aus irgendeinem Grund undurchsetzbar ist, gilt diese Regelung als trennbar und beeinflusst die Gültigkeit und Durchsetzbarkeit der verbleibenden Regelungen nicht.<br>
        (5) Die Unwirksamkeit einer Bestimmung berührt die Wirksamkeit der anderen Bestimmungen aus dem Vertrag nicht. Sollte dieser Fall eintreten, soll die Bestimmung nach Sinn und Zweck durch eine andere rechtlich zulässige Bestimmung ersetzt werden, die dem Sinn und Zweck der unwirksamen Bestimmung entspricht.<br>
    </p>
	<footer>
    <hr>
    <div class="logo">
			<a href="index.php"><img src="Logo StudiWolke.png"></a>
		</div>
    <nav>
        <ul>
            <li><a href= "impressum.php">IMPRESSUM</a></li>
            <li><a href= "datenschutz.php">DATENSCHUTZ</a></li>
            <li><a href= "agbs.php">AGBs</a></li>
            <div class="logout_icon">
            <li><a href="../../backend/logout.php"><img src="logout_icon.png" alt="Logout" /></a></li>
            </div>
    
        </ul>
    </nav>	
    <hr>
    <small>&copy; 2023 StudiWolke GmbH & Co. KG</small>
    <hr>
</footer>    
</body>
</html>