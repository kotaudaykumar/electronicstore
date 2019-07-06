<?php
$name=$_POST['name'];
$visitor_email=$_POST['email'];
$message=$_POST['message'];

$email_form = 'kotauday.eidiko@gmail.com';
$email_subject = "New Form Submission";
$email_body = "user Name: $name.\n"."user Email: $visitor_email.\n"."User Message: $message.\n";

$to = "kotauday95@gmail.com";

$headers = "From: $email_form \r\n";

$headers .= "Reply-To: $visitor_email \r\n";
mail($to,$email_subject,$email_body,$headers);

header("Location: ../mail_success.html");
?>