<?php


$to = "l684754@mvrht.com";
$subject = "Test mail for zhaowenluo.com";
$message = "Thanks for cominig to my site";
$headers = "From: zhaowenluo.com\r\n";


$sent = mail($to, $subject, $message, $headers);
echo "Maul was sent: $sent";

?>