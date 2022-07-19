<?php

namespace Module\mail\Model;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class PHPMailerService
{

        static private $Username;
        static private $Password;

        function __construct($u = null, $p = null)
        {
                if ($u != null && $p != null) {
                        self::$Username = $u;
                        self::$Password = $p;
                }
        }

        function sendMail()
        {
                $mail = new PHPMailer();
                //Tell PHPMailer to use SMTP
                $mail->isSMTP();
                //Enable SMTP debugging
                // SMTP::DEBUG_OFF = off (for production use)
                // SMTP::DEBUG_CLIENT = client messages
                // SMTP::DEBUG_SERVER = client and server messages
                $mail->SMTPDebug = SMTP::DEBUG_OFF;
                //Set the hostname of the mail server
                $mail->Host = 'smtp.gmail.com';
                // use
                // $mail->Host = gethostbyname('smtp.gmail.com');
                // if your network does not support SMTP over IPv6
                //Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
                $mail->Port = 587;

                //Set the encryption mechanism to use - STARTTLS or SMTPS
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

                //Whether to use SMTP authentication
                $mail->SMTPAuth = true;

                //Username to use for SMTP authentication - use full email address for gmail
                $mail->Username = self::$Username;

                //Password to use for SMTP authentication
                $mail->Password = self::$Password;

                //Set who the message is to be sent from
                $mail->setFrom('namdong92@gmail.com', 'First Last');

                //Set an alternative reply-to address
                $mail->addReplyTo('namdong92@gmail.com', 'First Last');

                //Set who the message is to be sent to
                $mail->addAddress('namdong92@gmail.com', 'John Doe');

                //Set the subject line
                $mail->Subject = 'PHPMailer GMail SMTP test';

                $mail->msgHTML("Noi dung mail", __DIR__);

                //Replace the plain text body with one created manually
                $mail->AltBody = '';

                //send the message, check for errors
                if (!$mail->send()) {
                        echo 'Mailer Error: ' . $mail->ErrorInfo;
                } else {
                        echo 'Message sent!';
                }
        }

        function save_mail($mail)
        {
                //You can change 'Sent Mail' to any other folder or tag
                $path = '{imap.gmail.com:993/imap/ssl}[Gmail]/Sent Mail';

                //Tell your server to open an IMAP connection using the same username and password as you used for SMTP
                $imapStream = imap_open($path, $mail->Username, $mail->Password);

                $result = imap_append($imapStream, $path, $mail->getSentMIMEMessage());
                imap_close($imapStream);

                return $result;
        }
}
