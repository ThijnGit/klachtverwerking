<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Formuliergegevens ophalen
    $naam = htmlspecialchars($_POST['naam']);
    $email = htmlspecialchars($_POST['email']);
    $berichtFormulier = htmlspecialchars($_POST['bericht']);

    // E-mail onderwerp en bericht
    $onderwerp = 'Uw klacht is in behandeling';
    $bericht = "Beste $naam,\n\nBedankt voor uw inzending. Hier zijn de gegevens die u heeft ingevuld:\n\n";
    $bericht .= "Naam: $naam\n";
    $bericht .= "E-mail: $email\n";
    $bericht .= "Bericht: $berichtFormulier\n\n";
    $bericht .= "Met vriendelijke groet,\nUw Bedrijf";

    // Headers (je voegt jezelf toe in cc)
    $headers = "From: no-reply@jouwbedrijf.nl\r\n";
    $headers .= "Cc: jouwemail@example.com\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    // Verstuur de e-mail
    if (mail($email, $onderwerp, $bericht, $headers)) {
        echo "E-mail succesvol verzonden!";
    } else {
        echo "Er is een fout opgetreden bij het verzenden van de e-mail.";
    }
}
?>
