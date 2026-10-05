<?php
require __DIR__ . '/../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Klachtenformulier</title>
</head>
<body>
    <h1>Klachtenformulier</h1>

    <?php
    if (isset($_POST['verstuur'])) {
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->SMTPAuth = true;
        $mail->Host = $_ENV['MAIL_HOST'];
        $mail->Username = $_ENV['MAIL_USERNAME'];
        $mail->Password = $_ENV['MAIL_PASSWORD'];
        $mail->Port = $_ENV['MAIL_PORT'];

        $mail->setFrom($_ENV['MAIL_FROM']);
        $mail->addAddress($_POST['email']);
        $mail->addCC($_ENV['MAIL_CC']);

        $mail->Subject = 'Uw klacht is in behandeling';
        $mail->Body = "Naam: " . $_POST['name'] . "\nEmail: " . $_POST['email'] . "\nKlacht: " . $_POST['complaint'];

        if ($mail->send()) {
            echo "Bedankt, uw klacht is verstuurd!";
        } else {
            echo "Versturen mislukt: " . $mail->ErrorInfo;
        }
    }
    ?>

    <form method="POST">
        <input type="text" name="name" placeholder="Naam" required>
        <input type="email" name="email" placeholder="Email" required>
        <textarea name="complaint" placeholder="Klacht" required></textarea>
        <button type="submit" name="verstuur">Verstuur</button>
    </form>
</body>
</html>