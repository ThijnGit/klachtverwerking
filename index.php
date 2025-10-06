<?php
require './vendor/autoload.php';
use Monolog\Level;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$onderwerp = "Klacht";
echo "<form action='./index.php' method= 'POST'>
        <label for=''>Naam</label>
        <input type='text' name='Naam' required>
        <br>
        <label for='Email'>Email</label>
        <input type='email' name='Email' required>
        <br>
        <label for='Beschrijvingklacht'>Omschrijf je klacht</label>
        <input type='text' name='BeschrijvingKlacht' required>
        <br>
        <input type='submit' value='verstuur'>
    </form>";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $naam_user = $_POST["Naam"];
    $email_user = $_POST["Email"];
    $beschrijvingklacht = $_POST["BeschrijvingKlacht"];
    $mail = new PHPMailer(true);
    try {
        // SMTP instellingen voor Gmail
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->$_ENV['MIJN_CC'];
        $mail->$_ENV['PASSWORD'];    // Gmail app-wachtwoord
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        // Ontvangers
        $mail->setFrom('no-reply@gmail.com', 'Uw Bedrijf'); // afzender
        $mail->addAddress($email_user, $naam_user);          // gebruiker
        $mail->addCC($CC);                                   // jezelf in cc

        // Inhoud
        $mail->isHTML(false); // platte tekst
        $mail->Subject = 'Uw klacht is in behandeling';
        $mail->Body    = "Beste $naam_user,\n\nBedankt voor uw inzending.\n\nNaam: $naam_user\nE-mail: $email_user\nBericht: $beschrijvingklacht\n\nMet vriendelijke groet,\nUw Bedrijf";

        $mail->send();
        echo "Bericht is verzonden!";
        
        $log = new Logger('klachten');
        $log->pushHandler(new StreamHandler(__DIR__ . '/info.log', logger::INFO));
        $log->info("Nieuwe klacht van $naam_user, Email: $email_user, Klacht: $beschrijvingklacht");
    } catch (Exception $e) {
        echo "Bericht kon niet worden verzonden. Mailer Error: {$mail->ErrorInfo}";
    }
}

//oh oh
?>
