<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'config.php';

if(isset($_POST["email"])){
$emailTo = $_POST["email"];


$code = uniqid(true);
$query = mysqli_query($con, "INSERT INTO resetPasswords (code, email) VALUES ('$code', '$emailTo')");
if(!$query) {
    exit("Error");
}
    $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
    try {
        //Server settings
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = '122015021@sastra.ac.in';                 // SMTP username
        $mail->Password = 'thunder0101';                           // SMTP password
        $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 465;                                    // TCP port to connect to

        //Recipients
        $mail->setFrom('rohitchatla@gmail.com', 'Example');
        $mail->addAddress($emailTo);     // Add a recipient
        $mail->addReplyTo('noreply@example.com', 'noreply');
        

      

        //Content
        $url = "http://" . $_SERVER["HTTP_HOST"] . dirname($_SERVER["PHP_SELF"]) . "/resetpass.php?code=$code";
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = 'Your password reset link';
        $mail->Body    = "<h1>You requested a password reset</h1> click <a href='$url'>this</a> to do so";
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
        $mail->send();
        echo 'Reset password link has been sent to your email';
    } catch (Exception $e) {
        echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
    }
exit();
    }
?>





<form method="post">
   <input type="text" name="email" placeholder="Email">
   <br>
   <input type="submit" name="submit" placeholder="Re-Email">
</form>