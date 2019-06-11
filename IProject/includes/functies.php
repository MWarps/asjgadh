<?php
include 'emailRegistreren.php';
include 'emailWachtwoordWijzigen.php';
include 'emailBericht.php';
include 'emailVerkocht.php';
include 'emailGekocht.php';
include 'emailVerwijderdVerkoper.php';
include 'emailVerwijderdHoogstebod.php';
include 'brief.php';
include 'emailVeilingBlockedKoper.php';
include 'emailVeilingBlockedVerkoper.php';

// deze functie geeft de minimumverhoging van het bod bij verschillende bedragen
// wordt gebruikt in: advertentie.php
function BodVerhoging($Euro)
{
    $Verhoging;
    switch ($Euro) {
        case ($Euro < 50) :
            $Verhoging = 0.50;
            break;
        case ($Euro >= 50 && $Euro < 500):
            $Verhoging = 1;
            break;
        case ($Euro >= 500 && $Euro < 1000) :
            $Verhoging = 5;
            break;
        case ($Euro >= 1000 && $Euro < 5000):
            $Verhoging = 10;
            break;
        case ($Euro >= 5000) :
            $Verhoging = 50;
        default:
            break;
    }
    return $Verhoging;
}

//deze functie registreert welke voorwerpen als laatste bekeken zijn door de gebruiker
//wordt gebruikt in: advertentie.php
function gebruikerBekeekVoorwerp($gebruikersnaam, $voorwerpnr)
{
    try {
        require('core/dbconnection.php');
        $sqlSelect = $dbh->prepare("
          INSERT INTO Laatstbekeken (gebruikersnaam, voorwerpnr, datumtijd)
          VALUES (:gebruikersnaam, :voorwerpnr , CURRENT_TIMESTAMP )                                                                  
        ");

        $sqlSelect->execute(
            array(
                ':voorwerpnr' => $voorwerpnr,
                ':gebruikersnaam' => $gebruikersnaam
            )
        );
    } catch (PDOexception $e) {
        echo "er ging iets mis error: {$e->getMessage()}";
    }
}

// deze functie registreert in de database uit welke rubriek het laatst bekeken voorwerp kwam zodat de website de gebruiker artikelen uit deze rubriek aanbeveelt
// wordt gebruikt in: advertentie.php
function gebruikerAanbevolen($gebruikersnaam, $voorwerpnr)
{
    try {
        require('core/dbconnection.php');
        $sqlSelect = $dbh->prepare("
          INSERT INTO Aanbevolen (gebruikersnaam, rubrieknr, datumtijd)
          VALUES (:gebruikersnaam, (SELECT rubrieknr FROM Voorwerpinrubriek WHERE voorwerpnr = :voorwerpnr), CURRENT_TIMESTAMP )                                                                    
        ");

        $sqlSelect->execute(
            array(
                ':voorwerpnr' => $voorwerpnr,
                ':gebruikersnaam' => $gebruikersnaam
            )
        );
    } catch (PDOexception $e) {
        echo "er ging iets mis error: {$e->getMessage()}";
    }
}

// deze functie voegt de link tussen afbeelding en artikel toe aan de database
// wordt gebruikt in: veilenInput.php
function VoegVoorwerpToeAanIllustratie($voorwerpnr, $illustratieFile)
{
    try {
        // SQL insert statement
        require('core/dbconnection.php');
        $sqlInsert = $dbh->prepare("
          INSERT INTO Illustratie (voorwerpnr, illustratieFile )
          VALUES(:voorwerpnr, :IllustratieFile)
        ");

        $sqlInsert->execute(
            array(
                ':voorwerpnr' => $voorwerpnr,
                ':IllustratieFile' => $illustratieFile
            )
        );
    } catch (PDOexception $e) {
        echo "er ging iets mis insert {$e->getMessage()}";
    }

}

// deze functie voegt een artikel aan een rubriek toe
//wordt gebruikt in: veilenInput.php
function VoegVoorwerpAanRubriekToe($voorwerpnr, $rubriek)
{
    try {
        // SQL insert statement
        require('core/dbconnection.php');
        $sqlInsert = $dbh->prepare("
          INSERT INTO Voorwerpinrubriek (rubrieknr, voorwerpnr)
          VALUES (:rubrieknr, :voorwerpnr)
        ");

        $sqlInsert->execute(
            array(
                ':rubrieknr' => $rubriek,
                ':voorwerpnr' => $voorwerpnr

            )
        );
    } catch (PDOexception $e) {
        echo "er ging iets mis insert {$e->getMessage()}";
    }
}

// deze functie voegt een artikel toe aan de database
//wordt gebruikt in: veilenInput.php
function VoegVoorwerpToe($input)
{
    try {
        // SQL insert statement
        require('core/dbconnection.php');
        $sqlInsert = $dbh->prepare("
          INSERT INTO Voorwerp (
          titel, beschrijving, startprijs, betalingswijze, betalingsinstructie,
          plaatsnaam, land, looptijd, verzendkosten, verzendinstructies, verkoper, 
          looptijdeindedagtijdstip
          )
          VALUES (
          :titel, :beschrijving, :startprijs, :betalingswijze, :betalingsinstructie,
          :plaatsnaam, :land, :looptijd, :verzendkosten, :verzendinstructies, :verkoper, 
          DATEADD(DAY, 7, CURRENT_TIMESTAMP)) 
        ");

        $sqlInsert->execute(
            array(
                ':titel' => $input['0'],
                ':beschrijving' => $input['1'],
                ':startprijs' => $input['2'],
                ':betalingswijze' => $input['3'],
                ':betalingsinstructie' => $input['4'],
                ':plaatsnaam' => $input['5'],
                ':land' => $input['6'],
                ':looptijd' => $input['7'],
                ':verzendkosten' => $input['8'],
                ':verzendinstructies' => $input['9'],
                ':verkoper' => $input['10']

            )
        );
    } catch (PDOexception $e) {
        echo "er ging iets mis insert {$e->getMessage()}";
    }

    try {
        // SQL insert statement
        require('core/dbconnection.php');
        $sqlSelect = $dbh->prepare("
          SELECT voorwerpnr FROM Voorwerp WHERE verkoper = :verkoper
          ORDER BY looptijdbegindagtijdstip DESC 
        ");

        $sqlSelect->execute(
            array(
                ':verkoper' => $input['10']
            )
        );
        $records = $sqlSelect->fetch(PDO::FETCH_ASSOC);
        return $records;
    } catch (PDOexception $e) {
        echo "er ging iets mis insert {$e->getMessage()}";
    }

}

// deze functie geeft de meest bekeken(en dus populairste) artikelen op de website
//wordt gebruikt in: index.php
function getPopulairsteArtikelen()
{
    try {
        require('core/dbconnection.php');
        $sqlSelect = $dbh->prepare("
          SELECT TOP 9 * FROM Voorwerp ORDER BY gezien DESC
        ");

        $sqlSelect->execute();

        $records = $sqlSelect->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOexception $e) {
        echo "er ging iets mis errorteset: {$e->getMessage()}";
    }

    foreach ($records as $rij) {
        $details = DetailAdvertentie($rij['voorwerpnr']);
        $locatie = '../pics/';

        $hoogstebieder = zijnErBiedingen($details['voorwerpnr']);
        $hoogstebod = $hoogstebieder['euro'];

        if (!empty($hoogstbieder)) {
            $details['startprijs'] = $hoogstebod;
        }

        if (substr($details['illustratieFile'], 0, 2) == 'ea') {
            $locatie = 'upload/';
        }

        if (strlen($details['titel']) >= 40) {
            $details['titel'] = substr($details['titel'], 0, 40);
            $details['titel'] .= '...';
        }
        echo '
        <div class="col-md-4 py-3">
          <div class="card h-100">
            <div class="card-img-boven">
              <img src="' . $locatie . $details['illustratieFile'] . '" alt="Foto bestaat niet">
            </div>  
          <h5 class="card-header"><a href="advertentie.php?id=' . $details['voorwerpnr'] . '">' . $details['titel'] . '</a></h5>
            <div class="card-body">
              <h4 class="card-text">€ ' . number_format($details['startprijs'], 2, ',', '.') . '</h4>
              <p class="card-text">' . $details['verkoper'] . '<br>
              ' . $details['land'] . ', ' . $details['plaatsnaam'] . '</p>
              <a href="advertentie.php?id=' . $details['voorwerpnr'] . '" class="btn btn-block btn-primary">Ga naar artikel</a>
            </div>
        </div>
        </div>';
    }
}

// deze functie haalt de producten die in de meegegeven rubriek zitten
// wordt gebruikt in: catalogus.php en veilen.php
function getProductenUitRubriek2($rubriek, $aantal)
{
    try {
        require('core/dbconnection.php');
        $sqlSelect = $dbh->prepare("
            WITH cte AS
            (
                SELECT superrubriek, rubrieknummer
                FROM dbo.Rubrieken
                WHERE rubrieknummer = :rubriek
                UNION ALL

                SELECT  a.superrubriek, a.rubrieknummer
        	        FROM dbo.Rubrieken a
        	        INNER JOIN cte s ON a.superrubriek = s.rubrieknummer
             )
            SELECT distinct top 21 * 
        	    FROM dbo.Voorwerpinrubriek
        	    JOIN dbo.Voorwerp on dbo.Voorwerpinrubriek.voorwerpnr = dbo.Voorwerp.voorwerpnr
        	    JOIN cte on dbo.Voorwerpinrubriek.rubrieknr = cte.rubrieknummer;
        ");

        $sqlSelect->execute(
            array(
                ':rubriek' => $rubriek,
                //  ':aantal' => $aantal
            )
        );

        $records = $sqlSelect->fetchAll(PDO::FETCH_ASSOC);

        return $records;
    } catch (PDOexception $e) {
        echo "er ging iets mis error2: {$e->getMessage()}";
    }
}

// deze functie laad 21 artikelen uit de laagste niveau subrubrieken van de rubriek die aan de functie gegeven wordt
// wordt gebruikt in: catalogus.php en veilen.php
function getProductenUitRubriek($rubriek, $aantal)
{
    try {
        require('core/dbconnection.php');
        $sqlSelect = $dbh->prepare("
            WITH cte AS
            (
                SELECT superrubriek, rubrieknummer
                FROM dbo.Rubrieken
                WHERE superrubriek = :rubriek
                UNION ALL

                SELECT  a.superrubriek, a.rubrieknummer
            	FROM dbo.Rubrieken a
            	INNER JOIN cte s ON a.superrubriek = s.rubrieknummer
            )
            SELECT distinct top 21 * 
            	FROM dbo.Voorwerpinrubriek
            	JOIN dbo.Voorwerp on dbo.Voorwerpinrubriek.voorwerpnr = dbo.Voorwerp.voorwerpnr
            	JOIN cte on dbo.Voorwerpinrubriek.rubrieknr = cte.rubrieknummer;
        ");

        $sqlSelect->execute(
            array(
                ':rubriek' => $rubriek,
                //  ':aantal' => $aantal
            )
        );

        $records = $sqlSelect->fetchAll(PDO::FETCH_ASSOC);

        return $records;
    } catch (PDOexception $e) {
        echo "er ging iets mis error2: {$e->getMessage()}";
    }
}

// deze functie laad de 3 artikelen die het laatst door de gebruiker bekeken zijn
// wordt gebruikt in: index.php
function getLaatstBekeken($gebruiker)
{
    try {
        require('core/dbconnection.php');
        $sqlSelect = $dbh->prepare("
          SELECT TOP 3 voorwerpnr FROM LaatstBekeken
          WHERE gebruikersnaam = :gebruikersnaam
	      ORDER BY datumtijd DESC
	    ");

        $sqlSelect->execute(
            array(
                ':gebruikersnaam' => $gebruiker
            )
        );
        $records = $sqlSelect->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOexception $e) {
        echo "er ging iets mis error: {$e->getMessage()}";
    }
    if (empty($records)) {
        echo '<div class="alert alert-success" role="alert">
              U heeft nog geen laatsbekeken voorwerpen!
            </div>';
    } else {
        foreach ($records as $rij) {
            $details = DetailAdvertentie($rij['voorwerpnr']);
            $locatie = '../pics/';

            $hoogstebieder = zijnErBiedingen($details['voorwerpnr']);
            $hoogstbieder = $hoogstebieder['euro'];

            if (!empty($hoogstbieder)) {
                $details['startprijs'] = $hoogstbieder;
            }
            if (substr($details['illustratieFile'], 0, 2) == 'ea') {
                $locatie = 'upload/';
            }

            if (strlen($details['titel']) >= 40) {
                $details['titel'] = substr($details['titel'], 0, 40);
                $details['titel'] .= '...';
            }
            echo '
        <div class="col-md-4 py-3">
        <div class="card h-100">
        <div class="card-img-boven">
          <img src="' . $locatie . $details['illustratieFile'] . '" alt="Foto bestaat niet">
        </div> 
          <h5 class="card-header"><a href="advertentie.php?id=' . $details['voorwerpnr'] . '">' . $details['titel'] . '</a></h5>
            <div class="card-body">
              <h4 class="card-text">€ ' . number_format($details['startprijs'], 2, ',', '.') . '</h4>
              <p class="card-text">' . $details['verkoper'] . '<br>
              ' . $details['land'] . ', ' . $details['plaatsnaam'] . '</p>
              <a href="advertentie.php?id=' . $details['voorwerpnr'] . '" class="btn btn-block btn-primary">Ga naar artikel</a>
            </div>
        </div>
        </div>';
        }
    }
}

// deze functie laadt de advertenties die aanbevolen worden aan de gebruiker
// wordt gebruikt in: index.php
function getAanbevolen($gebruiker)
{
    try {
        require('core/dbconnection.php');
        $sqlSelect = $dbh->prepare("
          SELECT * FROM Aanbevolen
          WHERE gebruikersnaam = :gebruikersnaam
	      ORDER BY datumtijd DESC
	    ");

        $sqlSelect->execute(
            array(
                ':gebruikersnaam' => $gebruiker
            )
        );
        $records = $sqlSelect->fetch(PDO::FETCH_ASSOC);
    } catch (PDOexception $e) {
        echo "er ging iets mis error: {$e->getMessage()}";
    }
    $records = getProductenUitRubriek2($records['rubrieknr'], 3);

    if (empty($records)) {
        echo '    
            <div class="alert alert-success" role="alert">
              U heeft nog geen aanbevolen voorwerpen!
        </div>';
    } else {
        for ($teller = 0; $teller < 3; $teller++) {
            if (!empty($records[$teller]['voorwerpnr'])) {
                $details = DetailAdvertentie($records[$teller]['voorwerpnr']);
                $locatie = '../pics/';

                $hoogstebieder = zijnErBiedingen($details['voorwerpnr']);
                $hoogstbieder = $hoogstebieder['euro'];

                if (!empty($hoogstbieder)) {
                    $details['startprijs'] = $hoogstbieder;
                }

                if (substr($details['illustratieFile'], 0, 2) == 'ea') {
                    $locatie = 'upload/';
                }
                if (strlen($details['titel']) >= 40) {
                    $details['titel'] = substr($details['titel'], 0, 40);
                    $details['titel'] .= '...';
                }
                echo '
        <div class="col-md-4 py-3">
        <div class="card">
        <div class="card-img-boven">
          <img src="' . $locatie . $details['illustratieFile'] . '" alt="Foto bestaat niet">
        </div> 
          <h5 class="card-header"><a href="advertentie.php?id=' . $details['voorwerpnr'] . '">' . $details['titel'] . '</a></h5>
            <div class="card-body">
              <h4 class="card-text">€ ' . number_format($details['startprijs'], 2, ',', '.') . '</h4>
              <p class="card-text">' . $details['verkoper'] . '<br>
              ' . $details['land'] . ', ' . $details['plaatsnaam'] . '</p>
              <a href="advertentie.php?id=' . $details['voorwerpnr'] . '" class="btn btn-block btn-primary">Ga naar artikel</a>
            </div>
        </div>
        </div>';
            }
        }
    }
}

// deze functie laat de illustratie bestanden zien
// wordt gebruikt in: advertentie.php
function HaalIllustratiesOp($voorwerpnr)
{

    try {
        require('core/dbconnection.php');
        $sqlSelect = $dbh->prepare("
          SELECT illustratieFile FROM Voorwerp, Illustratie
          WHERE Voorwerp.voorwerpnr = Illustratie.voorwerpnr
          AND Voorwerp.voorwerpnr = :voorwerpnr
        ");

        $sqlSelect->execute(
            array(
                ':voorwerpnr' => $voorwerpnr
            )
        );

        $records = $sqlSelect->fetchAll(PDO::FETCH_ASSOC);
        return $records;
    } catch (PDOexception $e) {
        echo "er ging iets mis error: {$e->getMessage()}";
    }
}

// deze functie laat het hoogstebod zien
// wordt gebruikt in: advertentie.php
function zijnErBiedingen($voorwerpnr)
{
    try {
        require('core/dbconnection.php');
        $sqlSelect = $dbh->prepare("
          SELECT * FROM bod WHERE voorwerpnr = :voorwerpnr ORDER BY CONVERT(DECIMAL(9,2), euro) DESC 
        ");

        $sqlSelect->execute(
            array(
                ':voorwerpnr' => $voorwerpnr
            )
        );

        $records = $sqlSelect->fetch(PDO::FETCH_ASSOC);
        return $records;
    } catch (PDOexception $e) {
        echo "er ging iets mis error: {$e->getMessage()}";
    }
}

// deze functie update de tabel voorwerpen-> kolom-> gezien met +1 als de gebruiker op de advertentie geklikt
// wordt gebruikt in: advertentie.php
function VoorwerpGezien($voorwerpnr)
{
    try {
        require('core/dbconnection.php');
        $sqlSelect = $dbh->prepare(" 
          UPDATE Voorwerp
          SET gezien = gezien + 1
          WHERE voorwerpnr = :voorwerpnr
        ");

        $sqlSelect->execute(
            array(
                ':voorwerpnr' => $voorwerpnr
            )
        );
    } catch (PDOexception $e) {
        echo "er ging iets mis error: {$e->getMessage()}";
    }
}

// deze functie voegt het bod van de gebruiker toe aan de databse 
// wordt gebruikt in: advertentie.php
function updateBieden($bod, $gebruikersnaam, $voorwerpnr)
{
    try {
        require('core/dbconnection.php');
        $sqlSelect = $dbh->prepare("
          INSERT INTO bod (euro, gebruikersnaam, voorwerpnr)
          VALUES (:bod, :gebruikersnaam, :voorwerpnr)
        ");

        $sqlSelect->execute(
            array(
                ':bod' => $bod,
                ':gebruikersnaam' => $gebruikersnaam,
                ':voorwerpnr' => $voorwerpnr
            )
        );
    } catch (PDOexception $e) {
        echo "er ging iets mis error: {$e->getMessage()}";
    }

}

// deze functie laat de biedingen zien van hoog naar laagst
// wordt gebruikt in: advertentie.php
function Biedingen($voorwerpnr)
{
    try {
        require('core/dbconnection.php');
        $sqlSelect = $dbh->prepare("
          SELECT top 5 * FROM Bod WHERE voorwerpnr = :voorwerpnr ORDER BY CONVERT(DECIMAL(9,2), euro) DESC
        ");

        $sqlSelect->execute(
            array(
                ':voorwerpnr' => $voorwerpnr
            )
        );
        $rows = $sqlSelect->fetchAll(PDO::FETCH_ASSOC);
        //print_r($rows);

        foreach ($rows as $rij) {
            echo '<li class="list-group-item">€' . number_format($rij['euro'], 2, ',', '.') . ' - ' . $rij['gebruikersnaam'] . ' - ' . date("d.m.Y H:i", strtotime($rij['datumentijd'])) . '</li>';
        }
    } catch (PDOexception $e) {
        echo "er ging iets mis errorbiedingen: {$e->getMessage()}";
    }
}

// deze functie geeft alle detail van het voorwerp weer
// wordt gebruikt in: index.php, catalogus.php
function DetailAdvertentie($id)
{
    try {
        require('core/dbconnection.php');
        $sqlSelect = $dbh->prepare("
          SELECT *, illustratieFile FROM Voorwerp, Illustratie
          WHERE Voorwerp.voorwerpnr = Illustratie.voorwerpnr
          AND Voorwerp.voorwerpnr = :id
          AND Voorwerp.veilinggesloten = 0
        ");

        $sqlSelect->execute(
            array(
                ':id' => $id
            )
        );
        $records = $sqlSelect->fetch(PDO::FETCH_ASSOC);

        return $records;
    } catch (PDOexception $e) {
        echo "er ging iets mis error: {$e->getMessage()}";
    }
}

// deze functie geeft alle advertenties van mijnadvertenties weer 
// wordt gebruikt in: mijnadvertenties.php
function DetailAdvertentieMijnAdvertenties($id)
{
    try {
        require('core/dbconnection.php');
        $sqlSelect = $dbh->prepare("
          SELECT *, illustratieFile FROM Voorwerp, Illustratie
          WHERE Voorwerp.voorwerpnr = Illustratie.voorwerpnr
          AND Voorwerp.voorwerpnr = :id
        ");

        $sqlSelect->execute(
            array(
                ':id' => $id
            )
        );
        $records = $sqlSelect->fetch(PDO::FETCH_ASSOC);

        return $records;
    } catch (PDOexception $e) {
        echo "er ging iets mis error: {$e->getMessage()}";
    }
}

// deze functie laat alle advertenties zien op de catalogus pagina 
// wordt gebruikt in: catalogus.php
function haalAdvertentieOp($rubriek)
{
    try {
        $producten = getProductenUitRubriek($rubriek, 20);

        if (empty($producten)) {
            $producten = getProductenUitRubriek2($rubriek, 20);
        }

        foreach ($producten as $rij) {
            $details = DetailAdvertentie($rij['voorwerpnr']);
            $locatie = '../pics/';

            $hoogstebieder = zijnErBiedingen($details['voorwerpnr']);
            $hoogstbieder = $hoogstebieder['euro'];

            if (!empty($hoogstbieder)) {
                $details['startprijs'] = $hoogstbieder;
            }

            if (substr($details['illustratieFile'], 0, 2) == 'ea') {
                $locatie = 'upload/';
            }
            if (strlen($rij['titel']) >= 40) {
                $rij['titel'] = substr($rij['titel'], 0, 40);
                $rij['titel'] .= '...';
            }
            echo '
                <div class="col-md-4 pb-3">
                <div class="card">
                <div class="card-img-boven">
                  <img src="' . $locatie . $details['illustratieFile'] . '" alt="Foto bestaat niet">
                </div> 
                  <h5 class="card-header"><a href="advertentie.php?id=' . $details['voorwerpnr'] . '">' . $details['titel'] . '</a></h5>
                    <div class="card-body">
                      <h4 class="card-text">€ ' . number_format($details['startprijs'], 2, ',', '.') . '</h4>
                      <p class="card-text">' . $details['verkoper'] . '<br>
                      ' . $details['land'] . ', ' . $details['plaatsnaam'] . '</p>
                      <a href="advertentie.php?id=' . $details['voorwerpnr'] . '" class="btn btn-block btn-primary">Ga naar artikel</a>
                    </div>
                </div>
                </div>
            ';
        }
    } catch (PDOexception $e) {
        echo "er ging iets mis error: {$e->getMessage()}";
    }
}


// deze functie haalt de email en type verificatie op
// wordt gebruikt in: register.php
function haalCodeOp($id)
{
    try {
        require('core/dbconnection.php');
        $sqlSelect = $dbh->prepare("
          SELECT email, type FROM Verificatie WHERE verificatiecode = :id
        ");

        $sqlSelect->execute(
            array(
                ':id' => $id
            )
        );
        $records = $sqlSelect->fetch(PDO::FETCH_ASSOC);

        return $records;
    } catch (PDOexception $e) {
        echo "er ging iets mis error: {$e->getMessage()}";
    }
}



// deze functie verwijderd de verificatie code
// wordt gebruikt in: verkoperValidatie.php en register.php
function deleteVerificatieRij($email, $type)
{
    try {
        require('core/dbconnection.php');
        $sqlSelect = $dbh->prepare("
          DELETE FROM Verificatie WHERE email = :email AND type = :type
        ");

        $sqlSelect->execute(
            array(
                ':email' => $email,
                ':type' => $type
            )
        );
    } catch (PDOexception $e) {
        echo "er ging iets mis error: {$e->getMessage()}";
    }
}

// deze functie haalt alle informatie van de gebruiker op 
// wordt gebruikt in: advertentie.php, beheerder.php, header.php, mijnadvertenties.php, overzichtGebruikers.php, stuurbericht.php
function HaalGebruikerOp($gebruikersnaam)
{
    try {
        require('core/dbconnection.php');
        $sqlSelect = $dbh->prepare("
          SELECT * FROM Gebruiker
          WHERE gebruikersnaam = :gebruikersnaam
        ");

        $sqlSelect->execute(
            array(
                ':gebruikersnaam' => $gebruikersnaam
            )
        );

        $records = $sqlSelect->fetch(PDO::FETCH_ASSOC);

        return $records;
    } catch (PDOexception $e) {
        echo "er ging iets mis error: {$e->getMessage()}";
    }
}

// deze functie haalt de verificatie code op
// wordt gebruikt in:
function HaalVerficatiecodeOp($email, $type)
{

    try {
        require('core/dbconnection.php');
        $sqlSelect = $dbh->prepare("
          SELECT verificatiecode, eindtijd FROM Verificatie WHERE email = :email
          AND type = :type 
        ");

        $sqlSelect->execute(
            array(
                ':email' => $email,
                ':type' => $type
            )
        );
        $records = $sqlSelect->fetch(PDO::FETCH_ASSOC);

        return $records;
    } catch (PDOexception $e) {
        echo "er ging iets mis error: {$e->getMessage()}";
    }
}

// deze functie maakt de verificatie code aan door een procedure uit te voeren in op de database 
// wordt gebruikt in: Verkoper.php, Register.php
function VerificatieCodeProcedure($email, $type)
{
    try {
        require('core/dbconnection.php');
        $sqlSelect = $dbh->prepare("
            EXEC verificatie_toevoegen @mail = :email, @type = :type
        ");

        $sqlSelect->execute(
            array(
                ':email' => $email,
                ':type' => $type
            )
        );
    } catch (PDOexception $e) {
        echo "er ging iets mis error: {$e->getMessage()}";
    }
}

// deze functie voegt de verkoper informatie toe aan de database
// wordt gebruikt in: verkoper2.php
function insertVerkoper($input)
{
    try {
        require('core/dbconnection.php');
        $sqlSelect = $dbh->prepare("
          INSERT INTO Verkoper (gebruikersnaam, bank, bankrekeningnummer, creditcard)
          VALUES (:gebruikersnaam, :bank, :bankrekeningnr, :creditcard)
        ");

        $sqlSelect->execute(
            array(
                ':gebruikersnaam' => $input['0'],
                ':bank' => $input['1'],
                ':bankrekeningnr' => $input['2'],
                ':creditcard' => $input['3']
            )
        );
    } catch (PDOexception $e) {
        echo "er ging iets mis insert: {$e->getMessage()}";
    }
}

// deze functie voegt de gebruiker toe aan de database
// wordt gebruikt in: 
function InsertGebruiker($input)
{
    $hashedWachtwoord = password_hash($input['4'], PASSWORD_DEFAULT);
    try {
        // SQL insert statement
        require('core/dbconnection.php');
        $sqlInsert = $dbh->prepare("
          INSERT INTO Gebruiker (
            gebruikersnaam, voornaam, achternaam, geslacht, adresregel1, adresregel2,
            postcode, plaatsnaam, land, geboortedatum, email,
            wachtwoord, vraag, antwoordtekst, verkoper)
          VALUES (
            :rGebruikersnaam, :rVoornaam, :rAchternaam, :rGeslacht, :rAdresregel1, :rAdresregel2,
            :rPostcode, :rPlaatsnaam, :rLand, :rGeboortedatum, :rEmail,
            :rWachtwoord, :rVraag, :rAntwoordtekst, :rVerkoper)
        ");

        $sqlInsert->execute(
            array(
                ':rGebruikersnaam' => $input['0'],
                ':rVoornaam' => $input['1'],
                ':rAchternaam' => $input['2'],
                ':rGeslacht' => $input['3'],
                ':rAdresregel1' => $input['5'],
                ':rAdresregel2' => $input['6'],
                ':rPostcode' => $input['7'],
                ':rPlaatsnaam' => $input['8'],
                ':rLand' => $input['9'],
                ':rGeboortedatum' => $input['10'],
                ':rEmail' => $input['11'],
                ':rWachtwoord' => $hashedWachtwoord,
                ':rVraag' => $input['12'],
                ':rAntwoordtekst' => $input['13'],
                ':rVerkoper' => $input['14']
            )
        );
    } catch (PDOexception $e) {
        echo "er ging iets mis insert {$e->getMessage()}";
    }
}

// deze functie controleerd of de gebruikersnaam al bestaat
// wordt gebruikt in: registerInput.php
function bestaatGebruikersnaam($gebruikersnaam)
{
    try {
        require('core/dbconnection.php');
        $sqlSelect = $dbh->prepare("
          SELECT gebruikersnaam FROM Gebruiker WHERE gebruikersnaam=:gebruikersnaam
        ");

        $sqlSelect->execute(
            array(
                ':gebruikersnaam' => $gebruikersnaam
            )
        );
        $records = $sqlSelect->fetch(PDO::FETCH_ASSOC);
        return $records;
    } catch (PDOexception $e) {
        echo "er ging iets mis error: {$e->getMessage()}";
    }
}

// deze functie controleerd of er al een verificatie mail is verstuurd
// wordt gebruikt in: registerInput.php, verkoper2.php
function bestaatValidatie($email, $type)
{
    try {
        require('core/dbconnection.php');
        $sqlSelect = $dbh->prepare("
          SELECT * FROM Verificatie WHERE email =:email AND type = :type
        ");

        $sqlSelect->execute(
            array(
                ':email' => $email,
                ':type' => $type
            )
        );
        $records = $sqlSelect->fetch(PDO::FETCH_ASSOC);
        return $records;
    } catch (PDOexception $e) {
        echo "er ging iets mis error19: {$e->getMessage()}";
    }
}

// deze functie controleerd of het emailadres al wordt gebruikt
// wordt gebruikt in: register.php
function bestaatEmailadres($email)
{
    try {
        require('core/dbconnection.php');
        $sqlSelect = $dbh->prepare(" SELECT * FROM Gebruiker WHERE email=:email
        ");

        $sqlSelect->execute(
            array(
                ':email' => $email,
            )
        );
        
        $records = $sqlSelect->fetch(PDO::FETCH_ASSOC);
        return $records;
    } catch (PDOexception $e) {
        echo "er ging iets mis error: {$e->getMessage()}";
    }
}

// deze functie laat alle landen zien in een dropdownlist
// wordt gebruikt in: registerInput.php en veilenInput.php
function landen()
{
    try {
        require('core/dbconnection.php');
        $sqlSelect = $dbh->prepare("select NAAM_LAND from Landen");
        $sqlSelect->execute();

        echo '<label for="inputLanden">Land</label>';
        echo '<select name="rLand" class="form-control" id="inputLanden">';
        // Open your drop down box

        // Loop through the query results, outputing the options one by one
        echo '<option value="Nederland" selected>Nederland</option>';
        while ($row = $sqlSelect->fetch(PDO::FETCH_ASSOC)) {

            echo '<option value="' . $row['NAAM_LAND'] . '">' . $row['NAAM_LAND'] . '</option>';
        }
        echo '</select>';// Close your drop down box
    } catch (PDOexception $e) {
        echo "er ging iets mis error: {$e->getMessage()}";
    }
}

// deze functie stuurt een email naar de gebruiker met een link om het wachtwoord te ften
// wordt gebruikt in: wachtwoordreset.php
function StuurWachtwoordResetMailEmail($email, $code)
{

    ini_set('display_errors', 1);
    error_reporting(E_ALL);
    $from = "no-reply@iconcepts.nl";
    $to = $email;
    $subject = "Wachtwoord reset EenmaalAndermaal";
    $message = emailWachtwoordWijzigen($code);

    $headers = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers .= "From:" . $from;

    mail($to, $subject, $message, $headers);
}

// deze functie stuut een email naar de gebruiker met een link om te registeren
// wordt gebruikt in: register.php
function StuurRegistreerEmail($email, $code)
{

    ini_set('display_errors', 1);
    error_reporting(E_ALL);
    $from = "no-reply@iconcepts.nl";
    $to = $email;
    $subject = "Validatie link account registreren";
    $message = emailRegistreren($code);

    $headers = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers .= "From:" . $from;

    mail($to, $subject, $message, $headers);
}

// deze functie laad alle verificaties om verkoper te worden die nog niet verzonden zijn. ook wordt het adress en de brief volgens een template vast opgesteld
// wordt gebruikt in: verkoperVerificatieBrief.php
function verificatiesVinden()
{
    $teller = 0;
    try {
        require('core/dbconnection.php');
        $sqlSelect = $dbh->prepare("
          SELECT Gebruiker.voornaam, Gebruiker.achternaam, Gebruiker.email, Gebruiker.geslacht, Gebruiker.adresregel1, Gebruiker.adresregel2, Gebruiker.postcode, Gebruiker.plaatsnaam, Gebruiker.land, Verificatie.verificatiecode, 
          Verificatie.eindtijd FROM Gebruiker INNER JOIN Verificatie ON Gebruiker.email = Verificatie.email WHERE type = 'brief' AND verzonden = 0
        ");

        $sqlSelect->execute();

        $verkopers = $sqlSelect->fetchAll(PDO::FETCH_ASSOC);

        foreach ($verkopers as $verkoper) {
            $teller++;
            $resultaat = Brief($verkoper);

            echo '<tr>
                    <th scope="row">' . $teller . '</th>
                    <td>' . $resultaat['adress'] . '</td>
                    <td>' . $resultaat['brief'] . '</td>
                    <td>' . $resultaat['email'] . '</td>                    
                    <td><a class="btn btn-primary" href="verkoperVerificatieBrief.php?email=' . $resultaat['email'] . '" role="button">Brief is Verzonden</a></td>';
            echo ' </tr>';
        }
    } catch (PDOexception $e) {
        echo "er ging iets mis error: {$e->getMessage()}";
    }
}


//deze functie registreerd dat de brief verzonden is in de database
// wordt gebruikt in: verkoperVerificatieBrief.php
function verificatieVerzonden($email)
{
    $email = fixEmail($email);
    try {
        require('core/dbconnection.php');
        $sqlSelect = $dbh->prepare("
          UPDATE Verificatie SET verzonden = 1 WHERE email = :email
        ");

        $sqlSelect->execute(
            array(
                ':email' => $email
            )
        );
    } catch (PDOexception $e) {
        echo "er ging iets mis error: {$e->getMessage()}";
    }
}

// Deze functie veranderd de spatie naar een + teken
// de $_GET die gebruikt wordt om de email op te halen en naar verificatieVerzonden te sturen verandert de + tekens in de email adressen naar spaties
// wordt gebruikt in: verkoperVerificatieBrief.php
function fixEmail($email)
{
    $email = str_replace(" ", "+", $email);

    return $email;
}

// deze functie laat de geslachten zien in een dropdownlist
// wordt gebruikt in: registreren2.php
function geslacht()
{
    try {
        require('core/dbconnection.php');
        $sqlSelect = $dbh->prepare("
          SELECT geslacht FROM Geslacht
        ");

        $sqlSelect->execute();

        echo '<label for="inputGeslacht">Geslacht</label>';
        echo '<select name="rGeslacht" class="form-control" id="inputGeslacht" required>';
        // Open your drop down box

        // Loop through the query results, outputing the options one by one
        while ($row = $sqlSelect->fetch(PDO::FETCH_ASSOC)) {
            echo '<option value="' . $row['geslacht'] . '">' . $row['geslacht'] . '</option>';
        }
        echo '</select>';// Close your drop down box
    } catch (PDOexception $e) {
        echo "er ging iets mis error: {$e->getMessage()}";
    }
}

// deze functie update het wachtwoord van de gebruiker
// wordt gebruikt in: wachtwoordReset2.php
function veranderWachtwoord($email, $wachtwoord)
{
    try {
        require('core/dbconnection.php');
        $sqlSelect = $dbh->prepare("
          UPDATE Gebruiker 
          SET wachtwoord = :wachtwoord
          WHERE email = :email
        ");

        $sqlSelect->execute(
            array(
                ':wachtwoord' => $wachtwoord,
                ':email' => $email,
            )
        );
    } catch (PDOexception $e) {
        echo "er ging iets mis error: {$e->getMessage()}";
    }
}

// deze functie stuurt de koper een bericht naar de verkoper toe
// wordt gebruikt in: stuurBericht.php
function stuurbericht($titel, $bericht, $Verzender, $Ontvanger)
{

    ini_set('display_errors', 1);
    error_reporting(E_ALL);
    $from = "no-reply@iconcepts.nl";
    $to = $Ontvanger['email'];
    $subject = "$titel";
    $message = emailBericht($bericht, $Verzender, $Ontvanger);

    $headers = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers .= "From:" . $from;
    mail($to, $subject, $message, $headers);

}

// deze functie update de verkoper naar gevalideerd als de ingevoerde code goed is
// wordt gebruikt in: verkoperValidatie.php
function statusOpValidatieZetten($gebruikersnaam)
{
    try {
        require('core/dbconnection.php');
        $sqlSelect = $dbh->prepare("
          UPDATE Verkoper 
          SET gevalideerd = 1 
          WHERE gebruikersnaam = :gebruikersnaam
        ");

        $sqlSelect->execute(
            array(
                ':gebruikersnaam' => $gebruikersnaam,
            )
        );
    } catch (PDOexception $e) {
        echo "er ging iets mis error: {$e->getMessage()}";
    }
}

function resetVragen()
{
    try {
        require('core/dbconnection.php');
        $sqlSelect = $dbh->query("
          SELECT vraagnr, vraag FROM Vragen
        ");

        echo '<label for="inputGeheimeVraag">Geheime Vraag</label>';
        echo '<select name="rGeheimV" class="form-control" id="inputGeheimeVraag">'; // Open your drop down box
        // Loop through the query results, outputing the options one by one
        while ($row = $sqlSelect->fetch(PDO::FETCH_ASSOC)) {
            echo '<option value="' . $row['vraagnr'] . '">' . $row['vraagnr'] . '.&nbsp' . $row['vraag'] . '</option>';
        }
        echo '</select>';// Close your drop down box
    } catch (PDOexception $e) {
        echo "er ging iets mis error: {$e->getMessage()}";
    }
}

// deze functie haalt de informatie op van de verkoper
// wordt gebruikt in: header.php, veilen.php, mijnadvertenties.php
function gegevensIngevuldVerkoper($gebruikersnaam)
{
    try {
        require('core/dbconnection.php');
        $sqlSelect = $dbh->prepare("
          SELECT * FROM Verkoper WHERE gebruikersnaam = :gebruikersnaam
        ");

        $sqlSelect->execute(
            array(
                ':gebruikersnaam' => $gebruikersnaam
            )
        );
        $verkoperVerificatie = $sqlSelect->fetch(PDO::FETCH_ASSOC);
        return $verkoperVerificatie;
    } catch (PDOexception $e) {
        echo "er ging iets mis error: {$e->getMessage()}";
    }
}

/*function catogorieToevoeging (){
    //    $lengte =  sizeof($_SESSION['catogorie']);
    //    echo $lengte ; echo '<br>';
    //    $lengte ++;
    $array2 = array( $_GET['naam'] =>$_GET['id'] );
    //    if ($id = (end($_SESSION['catogorie']) ) != $_GET['id']){
    //        foreach($_SESSION['catogorie'] as $level => $id){
    //            //$array1 = array ( $_SESSION['catogorie']);
    //            $array1 = array ( $level => $id );
    //        }
    //        print_r($array1);
    //        echo '<br>';
    //        print_r($array2); 
    //       echo '<br>';   
    $_SESSION['catogorie'] = $_SESSION['catogorie']  + $array2; 
}// einde functie*/

// deze functie laat alle categorien zien 
// wordt gebruikt in: header.php, veilen.php, mijnadvertenties.php
function catogorieSoort($pagina)
{
    $teller = 0;
    $titel;
    foreach ($_SESSION['catogorie'] as $level => $id) {
        if ($teller == 0) {
            if ($id == -1) {
                $titel = "Hoofdmenu";
            } else {
                $titel = $level;
            }
            echo '<li class="breadcrumb-item"><a href="' . $pagina . '?id=' . $id . '&naam=' . $level . ' " >' . $titel . '</a></li>';
            $teller++;
        }
    }
}

// deze functie haalt de rubrieksnaam op van de desbetreffende rubrieknummer
// wordt gebruikt in: catalogus.php, veilen.php
function HaalRubriekNaamOp($id)
{
    try {
        require('core/dbconnection.php');
        $sqlSelect = $dbh->prepare("
          SELECT rubrieknaam FROM Rubrieken WHERE rubrieknummer = :id
        ");

        $sqlSelect->execute(
            array(
                ':id' => $id
            )
        );

        $row = $sqlSelect->fetch(PDO::FETCH_ASSOC);
        return $row;
    } catch (PDOexception $e) {
        echo "er ging iets mis error: {$e->getMessage()}";
    }
}

// deze functie haalt de rubrieken op die in de superrubriek vallen
// wordt gebruikt in: catalogus.php, veilen.php
function HaalRubriekop($id)
{
    try {
        require('core/dbconnection.php');
        $sqlSelect = $dbh->prepare("
          SELECT * FROM Rubrieken WHERE superrubriek = :id
        ");

        $sqlSelect->execute(
            array(
                ':id' => $id
            )
        );
        // Loop through the query results, outputing the options one by one    
        while ($row = $sqlSelect->fetch(PDO::FETCH_ASSOC)) {
            echo '<a class="dropdown-item" href="catalogus.php?id=' . $row['rubrieknummer'] . '">' . $row['rubrieknaam'] . '</a>';
        }
    } catch (PDOexception $e) {
        echo "er ging iets mis error: {$e->getMessage()}";
    }
}


function DirectorieVindenVeilen()
{

    $id = (end($_SESSION['catogorie']));
    $teller = 0;
    try {
        require('core/dbconnection.php');
        $catogorien = $dbh->prepare("
          SELECT * FROM Rubrieken WHERE superrubriek = :id 
        ");

        $catogorien->execute(
            array(
                ':id' => $id,
            )
        );

        $print = $catogorien->fetchAll(PDO::FETCH_ASSOC);
        foreach ($print as $Name => $id) {
            echo '<a class="btn btn-outline-dark"  
                  href="veilen.php?id=' . $print[$teller]['rubrieknummer'] . '&naam=' . $print[$teller]['rubrieknaam'] . '" 
                  role="button">' . $print[$teller]['rubrieknaam'] . '</a>';
            $teller++;
        }

        if (empty($print)) {
            $terug = $dbh->prepare("
              SELECT * FROM Rubrieken WHERE rubrieknummer = :id
            ");
            $terug->execute(
                array(
                    ':id' => $id,
                )
            );

            $resultaat = $terug->fetchAll(PDO::FETCH_ASSOC);
            echo  '<p class="btn" >Uw gekozen rubriek is: <strong>'.$resultaat[0]['rubrieknaam'].'<br></strong>
                   <a class="btn btn-lg bg-flame btn-block mt-1" href="veilen.php?id='.$resultaat[0]['superrubriek'].'&naam='.$resultaat[0]['rubrieknaam'].'">Vorige</a>
                   <a class="btn btn-lg bg-flame btn-block mt-1" id="volgende" href=veilenInput.php?id='.$resultaat[0]['rubrieknummer'].'&naam='.$resultaat[0]['rubrieknaam'].' name="volgende">Volgende</a>';
        }
    } catch (PDOexception $e) {
        // echo "er ging iets mis error: {$e->getMessage()}";
    }
}

function directorieVinden($pagina)
{
    $id = (end($_SESSION['catogorie']));
    $teller = 0;
    try {
        require('core/dbconnection.php');
        $catogorien = $dbh->prepare("
          SELECT * FROM Rubrieken WHERE superrubriek = :id 
        ");

        $catogorien->execute(
            array(
                ':id' => $id,
            )
        );

        $print = $catogorien->fetchAll(PDO::FETCH_ASSOC);
        foreach ($print as $Name => $id) {
            echo '<a class="btn btn-outline-dark"  
                    href="' . $pagina . '?id=' . $print[$teller]['rubrieknummer'] . '&naam=' . $print[$teller]['rubrieknaam'] . '" 
                    role="button">' . $print[$teller]['rubrieknaam'] . '</a>';
            $teller++;
        }

        if (empty($print)) {
            $terug = $dbh->prepare("
              SELECT * FROM Rubrieken WHERE rubrieknummer = :id
            ");

            $terug->execute(
                array(
                    ':id' => $id,
                )
            );
            $resultaat = $terug->fetchAll(PDO::FETCH_ASSOC);

            if ($pagina == 'catalogus.php') {
                echo '<a class="btn btn-outline-dark"  
                    href="' . $pagina . '?id=' . $resultaat[0]['superrubriek'] . '&naam=' . $resultaat[0]['rubrieknaam'] . '" 
                    role="button">Er zijn geen sub-catogorien beschikbaar. Klik hier om terug te gaan</a>';
            }
        }
    } catch (PDOexception $e) {
        // echo "er ging iets mis error: {$e->getMessage()}";
    }
}

//deze functie laadt de tabel met gebruikers in in de beheeromgeving overzichtGebruikers.php
function gebruikersvinden($gebruikersnaam)
{
    $teller = 0;
    try {
        require('core/dbconnection.php');
        $gebruikers = $dbh->prepare("
          SELECT gebruikersnaam, voornaam, achternaam, geslacht, postcode, plaatsnaam, land,  email, verkoper, geblokeerd 
          FROM Gebruiker 
          WHERE gebruikersnaam LIKE :gebruikersnaam 
        ");

        // kan geen like '% $gebruiker%' door prepared statement
        $gebruikers->execute(
            array(
                ':gebruikersnaam' => '%' . $gebruikersnaam . '%',
            )
        );
        $resultaten = $gebruikers->fetchAll(PDO::FETCH_ASSOC);
        foreach ($resultaten as $resultaat) {
            $teller++;
            $verkoper = "error";
            $geblokkeerd = "error";
            if ($resultaat['verkoper'] == 1) {
                $verkoper = "Ja";
            } else {
                $verkoper = "nee";
            }
            if ($resultaat['geblokkeerd'] == 1) {
                $geblokkeerd = "Ja";
            } else {
                $geblokkeerd = "Nee";
            }
            echo '<tr>
                    <th scope="row">' . $teller . '</th>
                    <td>' . $resultaat['gebruikersnaam'] . '</td>
                    <td>' . $resultaat['voornaam'] . '</td>
                    <td>' . $resultaat['achternaam'] . '</td>
                    <td>' . $resultaat['postcode'] . '</td>
                    <td>' . $resultaat['plaatsnaam'] . '</td>
                    <td>' . $resultaat['land'] . '</td>
                    <td>' . $resultaat['email'] . '</td> 
                    <td>' . $verkoper . '</td>       
                    <td>' . $geblokkeerd . '</td> 
                      ';
            blokeren($geblokkeerd, $teller, $resultaat['gebruikersnaam']);
            echo ' </tr>';
        }
    } catch (PDOexception $e) {
        // echo "er ging iets mis error: {$e->getMessage()}";
    }
}

//deze functie regelt de blokkeer/deblokkeer knop die rechts naast de gebruiker staat in de beheeromgeving
function blokeren($geblokkeerd, $teller, $gebruiker)
{
    if ($geblokkeerd == "Ja") {
        echo ' <td>   
    <a class="btn btn-primary" href="overzichtGebruikers.php?id=' . $teller . '&naam=' . $gebruiker . '" role="button">Deblokkeer</a> 
   </td> ';
    } else if ($geblokkeerd == "Nee") {
        echo ' <td>
    <a class="btn btn-primary" href="overzichtGebruikers.php?id=' . $teller . '&naam=' . $gebruiker . '" role="button">Blokkeer</a>
      </td>  ';
    }
}

//deze functie blokkeert of deblokkeert de gebruiker in de database als de beheerder dit via de beheerdersomgeving dit aanstuurt
function gebruikerblok($gebruikersnaam)
{
    try {
        require('core/dbconnection.php');
        $blokeren = $dbh->prepare(" UPDATE Gebruiker
                                    SET geblokkeerd = 1
                                    WHERE gebruikersnaam like :gebruiker
                                    ");
        $deblokeren = $dbh->prepare(" UPDATE Gebruiker
                                    SET geblokkeerd = 0
                                    WHERE gebruikersnaam like :gebruiker
                                    ");
        $gebruiker = $dbh->prepare(" SELECT * FROM Gebruiker where gebruikersnaam like :gebruiker
                                    ");
        $gebruiker->execute(
            array(
                ':gebruiker' => $gebruikersnaam,
            )
        );
        $resultaat = $gebruiker->fetchAll(PDO::FETCH_ASSOC);
        if ($resultaat[0]['geblokkeerd'] == 1) {
            StuurGebruikerDeblockedEmail($resultaat[0]['gebruikersnaam']);
            $deblokeren->execute(
                array(
                    ':gebruiker' => $resultaat[0]['gebruikersnaam'],
                )
            );
        } else if ($resultaat[0]['geblokkeerd'] == 0) {
            StuurGebruikerBlockedEmail($resultaat[0]['gebruikersnaam']);
            $blokeren->execute(
                array(
                    ':gebruiker' => $resultaat[0]['gebruikersnaam'],
                )
            );
        }
    } catch (PDOexception $e) {
        //        echo "er ging iets mis error: {$e->getMessage()}";
    }
}

// stuurt email naar gebruiker wanneer deze geblokkeerd is
function StuurGebruikerBlockedEmail($gebruikersnaam)
{
    try {
        require('core/dbconnection.php');
        $sqlSelect = $dbh->prepare("
          SELECT email, voornaam FROM Gebruiker WHERE gebruikersnaam = :gebruikersnaam
        ");

        $sqlSelect->execute(
            array(
                ':gebruikersnaam' => $gebruikersnaam,
            )
        );
        $records = $sqlSelect->fetch(PDO::FETCH_ASSOC);

        ini_set('display_errors', 1);
        error_reporting(E_ALL);
        $from = "no-reply@iconcepts.nl";
        $to = $records['email'];
        $subject = "Account geblokkeerd";
        $message = 'Beste  ' . $records['voornaam'] . ',


         Helaas moeten wij u op de hoogte stellen dat uw account is geblokkeerd. Dit kan meerdere redenen hebben.
         Om meer informatie te krijgen kunt u contact met ons opnemen door een mail te sturen naar: EenmaalAndermaal@gmail.com
         Vermeld in deze mail uw gebruikersnaam.
         Wij hopen u zodoende genoeg informatie te hebben gegeven.

         Met vriendelijke groeten,

         EenmaalAndermaal  
         ';
        $headers = "From:" . $from;
        mail($to, $subject, $message, $headers);
    } catch (PDOexception $e) {
        echo "er ging iets mis error: {$e->getMessage()}";
    }
}

//stuurt email naar gebruiker wanneer deze gedeblokkeerd is
function StuurGebruikerDeblockedEmail($gebruikersnaam)
{
    try {
        require('core/dbconnection.php');
        $sqlSelect = $dbh->prepare("
          SELECT email, voornaam FROM Gebruiker WHERE gebruikersnaam = :gebruikersnaam
        ");

        $sqlSelect->execute(
            array(
                ':gebruikersnaam' => $gebruikersnaam,
            )
        );
        $records = $sqlSelect->fetch(PDO::FETCH_ASSOC);

        ini_set('display_errors', 1);
        error_reporting(E_ALL);
        $from = "no-reply@iconcepts.nl";
        $to = $records['email'];
        $subject = "Account gedeblokkeerd";
        $message = ' Beste ' . $records['voornaam'] . ',

        Uw account is gedeblokkeerd. U kunt nu weer inloggen.
        Wij hopen u zodoende genoeg informatie te hebben gegeven.

        Met vriendelijke groeten,

        EenmaalAndermaal     
        ';
        $headers = "From:" . $from;
        mail($to, $subject, $message, $headers);
    } catch (PDOexception $e) {
        echo "er ging iets mis error: {$e->getMessage()}";
    }
}

function veilingenVinden($veilingnaam){
    $teller = 0 ;
    try {
        require('core/dbconnection.php');
        $veilingen = $dbh->prepare("
          SELECT * FROM Voorwerp WHERE titel LIKE :titel
        ");
        $veilingen->execute(
            array(
                ':titel' => '%' . $veilingnaam . '%',
            )
        );
        $veiling = $veilingen->fetchAll(PDO::FETCH_ASSOC);
        foreach ($veiling as $resultaat) {
            $teller++;
            $geblokkeerd = "error";
            if ($resultaat['geblokkeerd'] == 1) {
                $geblokkeerd = "Ja";
            } else {
                $geblokkeerd = "Nee";
            }
            echo '<tr>
                    <th scope="row">' . $teller . '</th>
                    <td>' . $resultaat['voorwerpnr'] . '</td>
                    <td>' . $resultaat['titel'] . '</td>
                    <td>' . $resultaat['startprijs'] . '</td>
                    <td>' . $resultaat['betalingswijze'] . '</td>
                    <td>' . $resultaat['plaatsnaam'] . '</td>
                    <td>' . $resultaat['land'] . '</td>
                    <td>' . $resultaat['looptijd'] . '</td>
                    <td>' . $resultaat['looptijdbegindagtijdstip'] . '</td> 
                    <td>' . $resultaat['looptijdeindedagtijdstip'] . '</td> 
                    <td>' . $resultaat['verkoper'] . '</td> 
                    <td>' . $resultaat['veilinggesloten'] . '</td> 
                    <td>' . $geblokkeerd . '</td> 
                    <td>' . $resultaat['blokkeerdatum'] . '</td>
                      ';
            veilingblokeren($geblokkeerd, $resultaat['voorwerpnr'], $resultaat['titel']);

            echo '</tr>';
        }
    } catch (PDOexception $e) {
        echo "er ging iets mis error: {$e->getMessage()}";
    }
}

function veilingblokeren($geblokkeerd, $voorwerpnummer, $titel){
    if ($geblokkeerd == "Ja"){
        echo ' <td>   
    <a class="btn btn-primary" href="overzichtVeilingen.php?voorwerpnummer=' . $voorwerpnummer . '&naam=' . $titel . '" role="button">Deblokkeer</a> 
   </td> ';
    } else if ($geblokkeerd == "Nee") {
        echo ' <td>
    <a class="btn btn-primary" href="overzichtVeilingen.php?voorwerpnummer=' . $voorwerpnummer . '&naam=' . $titel . '" role="button">Blokkeer</a>
      </td>  ';
    }
}

// verplaatst naar beheerderFuncties.php
function veilingblok($voorwerpnummer){
    try {
        require('core/dbconnection.php');

        $blokeren = $dbh->prepare(" 
          UPDATE Voorwerp
          SET geblokkeerd = 1, blokkeerdatum = CURRENT_TIMESTAMP
          WHERE voorwerpnr LIKE :voorwerpnummer
        ");

        $deblokeren = $dbh->prepare("
          UPDATE Voorwerp
          SET geblokkeerd = 0
          WHERE voorwerpnr LIKE :voorwerpnummer
        ");

        $veiling = $dbh->prepare("
          SELECT * FROM Voorwerp WHERE voorwerpnr LIKE :voorwerpnummer
        ");

        $veiling->execute(
            array(
                ':voorwerpnummer' => $voorwerpnummer,
            )
        );

        $resultaat = $veiling->fetch(PDO::FETCH_ASSOC);

        if ($resultaat['geblokkeerd'] == 1) {
            $deblokeren->execute(
                array(
                    ':voorwerpnummer' => $resultaat['voorwerpnr'],
                )
            );

            veilingeindberekenen($resultaat['voorwerpnr']);
        } else if ($resultaat['geblokkeerd'] == 0) {

            $veiling = HaalBiederEnVerkoperOp($voorwerpnummer, $resultaat['verkoper']);
            VerstuurVeilingBlockedMail($veiling, true);

            if (count($veiling) == 3) {
                VerstuurVeilingBlockedMail($veiling, false);
            }
            $blokeren->execute(
                array(
                    ':voorwerpnummer' => $resultaat['voorwerpnr']
                )
            );
        }
    } catch (PDOexception $e) {
        echo "er ging iets mis error: {$e->getMessage()}";
    }
}

function checkGEBLOKKEERD($gebruiker){
    try {
        require('core/dbconnection.php');
        $geblokeerd = $dbh->prepare("
          SELECT gebruikersnaam, geblokeerd FROM Gebruiker WHERE gebruikersnaam LIKE :gebruiker  
        ");

        $geblokeerd->execute(
            array(
                ':gebruiker' => $gebruiker,
            )
        );

        while ($resultaat = $geblokkeerd->fetchAll(PDO::FETCH_ASSOC)) {
            if ($resultaat[0]['geblokkeerd'] == 1) {
                return true;
            } else if ($resultaat[0]['geblokkeerd'] == 0) {
                return false;
            } else if (empty($resultaat[0]['geblokkeerd'])) {
                //header("Location: includes/404error.php");
            }
        }
    } catch (PDOexception $e) {
        //    echo "er ging iets mis error: {$e->getMessage()}";
    }
}

function checkBEHEERDER($gebruiker)
{
    try {
        require('core/dbconnection.php');
        $geblokkeerd = $dbh ->prepare (" 
          SELECT gebruikersnaam, beheerder FROM Gebruiker WHERE gebruikersnaam LIKE :gebruiker 
        ");

        $geblokkeerd->execute(
            array(
                ':gebruiker' => $gebruiker,
            )
        );

        while ($resultaat = $geblokkeerd->fetchAll(PDO::FETCH_ASSOC)) {
            if ($resultaat[0]['beheerder'] == 1) {
                return true;
            } else if ($resultaat[0]['beheerder'] == 0) {
                return false;
            } else if (empty($resultaat['beheerder'])) {
                //header("Location: includes/404error.php");
            }
        }
    } catch (PDOexception $e) {
        echo "er ging iets mis error: {$e->getMessage()}";
        // blijft error geven vanwegen het niet meer opkunnen halen van meet data. 
    }
}

function veilingeindberekenen ($voorwerpnummer){
    // de overgebleven dagen die de veiling nog open is.
    try {
        require('core/dbconnection.php');
        $informatie = $dbh->prepare("
          SELECT * FROM Voorwerp WHERE voorwerpnr = :voorwerpnr
        ");
        // haalt de algemene informatie op die nodig is voor de berekening
        $einddatum = $dbh->prepare("
            UPDATE Voorwerp 
            SET looptijdeindedagtijdstip = (SELECT DATEADD(DAY, (SELECT DATEDIFF(DAY, CURRENT_TIMESTAMP, blokkeerdatum) 
                                            FROM Voorwerp 
                                            WHERE blokkeerdatum > '2000-01-01' AND voorwerpnr = :voorwerpnr),
                                           (SELECT looptijdeindedagtijdstip 
                                            FROM Voorwerp 
                                            WHERE voorwerpnr = :voorwerpnr1)))
		    WHERE voorwerpnr = :voorwerpnr2
		    "); // insert de       nieuwe einddatum gebaseerd op de ( looptijd - het aantal dagen tussen begin- en blokeer- datum )
        //====================================================================================================//
        // informatie query runnen en afhandelen.
        $informatie->execute(
            array(
                ':voorwerpnr' => $voorwerpnummer
            )
        );

        $einddatum->execute(
            array(
                ':voorwerpnr' => $voorwerpnummer,
                ':voorwerpnr1' => $voorwerpnummer,
                ':voorwerpnr2' => $voorwerpnummer
            )
        );
    } catch (PDOexception $e) {
        echo "er ging iets mis error123: {$e->getMessage()}";
    }
}

function HaalMijnAdvertentieOp($gebruikersnaam){
  try {
      require('core/dbconnection.php');
      $sqlSelect = $dbh ->prepare ("
        SELECT voorwerpnr FROM Voorwerp WHERE verkoper = :gebruiker 
      ");

        $sqlSelect->execute(
            array(
                ':gebruiker' => $gebruikersnaam
            )
        );
        $resultaat = $sqlSelect->fetchAll(PDO::FETCH_ASSOC);
        return $resultaat;
    } catch (PDOexception $e) {
        "er ging iets mis error: {$e->getMessage()}";
    }
}

function HaalBiederEnVerkoperOp($voorwerpnr, $verkoper)
{
    try {
        require('core/dbconnection.php');
        $sqlSelect = $dbh->prepare("
        SELECT * FROM Gebruiker WHERE gebruikersnaam = (SELECT top 1 gebruikersnaam FROM bod WHERE voorwerpnr = :voorwerpnr ORDER BY CONVERT(DECIMAL(9,2), euro) DESC)
      ");

        $sqlSelect2 = $dbh->prepare("
        SELECT * FROM Gebruiker WHERE gebruikersnaam = :verkoper
      ");

        $sqlSelect3 = $dbh->prepare("
        SELECT * FROM Voorwerp WHERE voorwerpnr = :voorwerpnr
      ");

        $sqlSelect->execute(
            array(':voorwerpnr' => $voorwerpnr));
        $sqlSelect2->execute(
            array(':verkoper' => $verkoper));
        $sqlSelect3->execute(
            array(':voorwerpnr' => $voorwerpnr));

        $records = $sqlSelect->fetchAll(PDO::FETCH_ASSOC);
        array_push($records, $sqlSelect2->fetch(PDO::FETCH_ASSOC));
        array_push($records, $sqlSelect3->fetch(PDO::FETCH_ASSOC));

        return $records;
    } catch (PDOexception $e) {
        "er ging iets mis error: {$e->getMessage()}";
    }

}


function VerkoopVeiling($voorwerpnr)
{

    try {
        require('core/dbconnection.php');
        $sqlUpdate = $dbh->prepare("UPDATE Voorwerp
                                    SET koper = (select top 1 gebruikersnaam from bod where voorwerpnr = :voorwerpnr order by convert(decimal(9,2), euro) desc),
                                        verkoopprijs = (select top 1 euro from bod where voorwerpnr = :voorwerpnr1 order by convert(decimal(9,2), euro) desc),
                                        veilinggesloten = 1
                                    WHERE voorwerpnr = :voorwerpnr2");
        $sqlUpdate->execute(
            array(
                ':voorwerpnr' => $voorwerpnr,
                ':voorwerpnr1' => $voorwerpnr,
                ':voorwerpnr2' => $voorwerpnr
            ));

    } catch (PDOexception $e) {
        "er ging iets mis error: {$e->getMessage()}";
    }
}

function VerwijderVeiling($voorwerpnr)
{

    try {
        require('core/dbconnection.php');
        $sqlDelete1 = $dbh->prepare("
        DELETE FROM Voorwerpinrubriek WHERE voorwerpnr = :voorwerpnr
      ");

        $sqlDelete2 = $dbh->prepare("
        DELETE FROM laatstbekeken WHERE voorwerpnr = :voorwerpnr
      ");

        $sqlDelete3 = $dbh->prepare("
        DELETE FROM Voorwerp WHERE voorwerpnr = :voorwerpnr
      ");

        $sqlDelete1->execute(array(':voorwerpnr' => $voorwerpnr));
        $sqlDelete2->execute(array(':voorwerpnr' => $voorwerpnr));
        $sqlDelete3->execute(array(':voorwerpnr' => $voorwerpnr));

    } catch (PDOexception $e) {
        "er ging iets mis error: {$e->getMessage()}";
    }
}

// deze functie verstuurd een mail naar de verkoper en hoogstebieder dat het voorwerp is verkocht
// wordt gebruikt in: mijnadvertenties.php
function VerstuurVerkoopMail($veiling)
{
    $verkoper = $veiling[1]['email'];
    $koper = $veiling[0]['email'];

    ini_set('display_errors', 1);
    error_reporting(E_ALL);
    $from = "no-reply@iconcepts.nl";
    $to = $verkoper;
    $subject = "EenmaalAndermaal u heeft een voorwerp Verkocht!";
    $message = emailVerkocht($veiling);
    $headers = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers .= "From:" . $from;

    mail($to, $subject, $message, $headers);

    ini_set('display_errors', 1);
    error_reporting(E_ALL);
    $from = "no-reply@iconcepts.nl";
    $to = $koper;
    $subject = "EenmaalAndermaal u heeft een voorwerp Gekocht!";
    $message = emailGekocht($veiling);

    $headers = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers .= "From:" . $from;

    mail($to, $subject, $message, $headers);

}

// deze functie verstuurd een mail naar de verkoper en hoogstebieder dat de advertentie is geblokkeerd
// wordt gebruikt in: overzichtveilingen.php
function VerstuurVeilingBlockedMail($veiling, $ontvanger)
{
    $voorwerp = 1;
    $verkoper = 0;
    if (count($veiling) == 3) {
        $verkoper = 1;
        $voorwerp = 2;
    }

    $verkopermail = $veiling[$verkoper]['email'];
    $kopermail = $veiling[0]['email'];

    if ($ontvanger) {
        ini_set('display_errors', 1);
        error_reporting(E_ALL);
        $from = "no-reply@iconcepts.nl";
        $to = $verkopermail;
        $subject = "EenmaalAndermaal uw veiling is geblokkeerd";
        $message = emailVeilingBlockedVerkoper($veiling, $voorwerp);

        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= "From:" . $from;

        mail($to, $subject, $message, $headers);
    }

    if ($ontvanger == false) {
        ini_set('display_errors', 1);
        error_reporting(E_ALL);
        $from = "no-reply@iconcepts.nl";
        $to = $kopermail;
        $subject = "EenmaalAndermaal geboden voorwerp is geblokkeerd";
        $message = emailVeilingBlockedKoper($veiling);

        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= "From:" . $from;

        mail($to, $subject, $message, $headers);
    }
}

// deze functie verstuurd een mail naar de verkoper en hoogstebieder dat het voorwerp handmatig is verwijderd door de verkoper
// wordt gebruikt in: mijnadvertenties.php
function VerstuurVerwijderMail($veiling, $ontvanger)
{
    $voorwerp = 1;
    $verkoper = 0;
    if (count($veiling) == 3) {
        $voorwerp = 2;
        $verkoper = 1;
    }
    $verkopermail = $veiling[$verkoper]['email'];
    $kopermail = $veiling[0]['email'];

    if ($ontvanger == false) {
        ini_set('display_errors', 1);
        error_reporting(E_ALL);
        $from = "no-reply@iconcepts.nl";
        $to = $verkopermail;
        $subject = "EenmaalAndermaal uw voorwerp is verwijderd";
        $message = EmailVerwijderdVerkoper($veiling, $voorwerp);

        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= "From:" . $from;

        mail($to, $subject, $message, $headers);
    }


    if ($ontvanger) {
        ini_set('display_errors', 1);
        error_reporting(E_ALL);
        $from = "no-reply@iconcepts.nl";
        $to = $kopermail;
        $subject = "EenmaalAndermaal geboden voorwerp is verwijderd";
        $message = emailVeilingBlockedKoper($veiling);

        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= "From:" . $from;

        mail($to, $subject, $message, $headers);
    }

}

// deze functie verstuurd een mail naar de verkoper waar de advertentie over datum is
// wordt gebruikt in:
function VerstuurEindeLooptijdMail($veiling, $ontvanger)
{
    $voorwerp = 1;
    $verkoper = 0;
    if (count($veiling) == 3) {
        $voorwerp = 2;
        $verkoper = 1;
    }
    $verkopermail = $veiling[$verkoper]['email'];
    $kopermail = $veiling[0]['email'];

    if ($ontvanger == false) {
        ini_set('display_errors', 1);
        error_reporting(E_ALL);
        $from = "no-reply@iconcepts.nl";
        $to = $verkopermail;
        $subject = "EenmaalAndermaal uw voorwerp is verwijderd";
        $message = emailEindeLooptijdVerkoper($veiling, $voorwerp);

        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= "From:" . $from;

        mail($to, $subject, $message, $headers);
    }

    if ($ontvanger) {
        ini_set('display_errors', 1);
        error_reporting(E_ALL);
        $from = "no-reply@iconcepts.nl";
        $to = $kopermail;
        $subject = "EenmaalAndermaal geboden voorwerp is verwijderd";
        $message = emailEindeLooptijdKoper($veiling);

        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= "From:" . $from;

        mail($to, $subject, $message, $headers);
    }
}

// deze functie voegt de waardes toe van een beoordeling
// wordt gebruikt in: rating.php
function updateRecentie($waarde, $verkoper)
{
    try {
        require('core/dbconnection.php');
        $sqlSelect = $dbh->prepare("
          INSERT INTO Recenties (waardenr, verkoper)
          VALUES(:waarde, :verkoper)
        ");

        $sqlSelect->execute(
            array(
                ':waarde' => $waarde,
                ':verkoper' => $verkoper
            )
        );
    } catch (PDOexception $e) {
        echo "er ging iets mis error: {$e->getMessage()}";
    }
}

// deze functie haalt het aantal recenties op en het gemiddelde
// wordt gebruikt in: advertentie.php
function haalRecentieOp($verkoper)
{
    try {
        require('core/dbconnection.php');
        $sqlSelect = $dbh->prepare(" SELECT sum(waardenr) / count(waardenr) AS recentie FROM Recenties WHERE verkoper = :verkoper
                                     UNION
                                     SELECT count(waardenr) as recentie from Recenties
                                     where verkoper = :verkoper2
                                     ");

        $sqlSelect->execute(
            array(
                ':verkoper' => $verkoper,
                ':verkoper2' => $verkoper
            ));

        $records = $sqlSelect->fetchAll(PDO::FETCH_ASSOC);

        return $records;
    } catch (PDOexception $e) {
        echo "er ging iets mis error2: {$e->getMessage()}";
    }
}


?>