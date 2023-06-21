<?php

namespace App\Utility;

class Mail {

    public static function send($recipient, $username, $message)
    {

        // Set email headers
        $to = 'clementlessieur@hotmail.fr'; //$recipient;
        $subject = 'Message from contact form';
        $headers = "From: sender@example.com\r\n";
        $headers .= "Reply-To: sender@example.com\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

        // Construct email body
        $emailBody = "<h3>You have received a message from $username:</h3>";
        $emailBody .= "<p>$message</p>";

        // Send email
        if (mail($to, $subject, $emailBody, $headers)) {
            return true;
        } else {
            var_dump($to, $subject, $emailBody, $headers);
            return false;
        }
    }
}
