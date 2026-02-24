<?php

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'global.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (isset($_POST['h-captcha-response']) && !empty($_POST['h-captcha-response'])) {
	$data = array(
		'secret' => "0xE4318d58C894FdDb88c5B7d8Dc5ba141b11A7d64",
		'response' => $_POST['h-captcha-response']
	);

	$verify = curl_init();
	curl_setopt($verify, CURLOPT_URL, "https://hcaptcha.com/siteverify");
	curl_setopt($verify, CURLOPT_POST, true);
	curl_setopt($verify, CURLOPT_POSTFIELDS, http_build_query($data));
	curl_setopt($verify, CURLOPT_RETURNTRANSFER, true);
	$response = curl_exec($verify);

	$responseData = json_decode($response);

	if ($responseData->success) {

		$name = $_POST["name"];
		$email = $_POST["email"];
		$subject = $_POST["subject"];
		$message = $_POST["message"];

		$mail = sendEmail($name, $email, $subject, $message);
	} else {
		$mail = "false";

	}
} elseif (isset($_POST['h-captcha-response']) && empty($_POST['h-captcha-response'])) {
	$mail = "false";

}


function sendEmail($name, $email, $subject, $text_message)
{
	$mail = new PHPMailer(true);

	try {
		// Configure the SMTP server
		$mail->isSMTP();
		$mail->Host = 'mail.i1f.me';
		$mail->Port = 465;
		$mail->SMTPAuth = true;
		$mail->Username = EMAIL;
		$mail->Password = PASSWORD;
		$mail->SMTPSecure = 'ssl';

		// Set the sender and recipient
		$mail->setFrom(EMAIL, DOMAIN);
		$mail->addAddress(EMAIL, DOMAIN);


		// Configure mail content
		$mail->isHTML(true);
		$mail->Subject = "Contact " . EMAIL;
		$mail->Body = "<p>Form details below." . "<br>" . "Name: " . $name . "<br>" . "Email: " . $email . "<br>" . "Subject: " . $subject . "<br>" . "Message: " . $text_message . "</p>";

		//https://".DOMAIN."/
		$mail->send();
		header("Location:index.php?page=contact&mail=true#contactForm");
		exit;
	} catch (Exception $e) {
		header("Location:index.php?page=contact&mail=false#contactForm");
		exit;
	}
}


?>