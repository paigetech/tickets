<?php $name = $_POST['contact_id'];
$email = "paigetech@gmail.com";
$message = $_POST['summary'];
$formcontent="From: $name \n Message: $message";
$recipient = "phubbell@umn.edu";
$subject = "Contact Form";
$headers = "From: $email \r\n";
$headers = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers .= 'From:' . $email . "\r\n";
mail($recipient, $subject, $formcontent, $mailheader) or die("Error!");
echo "Thank You!";
echo $recipient, $subject, $formcontent, $mailheader;
?>
 