<?php
$to      = 'jonasschen@gmail.com';
$subject = 'Teste PHP';
$message = 'Ol�, isto � um teste';
$headers = 'From: jonas.schen@mca.com.br' . "\r\n" .
           'Reply-To: jonas.schen@blcobranca.com.br' . "\r\n" .
           'X-Mailer: PHP/' . phpversion();

mail($to, $subject, $message, $headers);
?>