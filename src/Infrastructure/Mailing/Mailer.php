<?php

    namespace App\Infrastructure\Mailing;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

    class Mailer {

        private $mailer;

        public function __construct()
        {
            $this->mailer = new PHPMailer(true); ## True pour activer les execption
        }

        /**
         * Permet d'envoyer des demandes de contact des utilisateurs à l'administrateur
         * @param string $email
         * @param string $sujet
         * @param string $messages
         * @return void
        */
        public function contact(string $email, string $sujet, string $messages) 
        {
            $mail = new PHPMailer(true);
            ## $mail->isSendmail(); - Pour utiliser sendmail
            $mail->isSMTP(); 

            $mail->Host = 'localhost'; //'smtp.gmail.com'; Configurer le serveur SMTP pour envoyer
            $mail->Port = 1025; // 587; Port TCP auquel se connecter; utilisez 587 si vous définissez `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
            $mail->SMTPAuth = false; //$mail->SMTPAuth = true; Activer SMTP
            $mail->SMTPSecure = false; // PHPMailer::ENCRYPTION_STARTTLS; Activer le crytage TLS implicite
            //$mail->Username = bakayokoadama507@gmail.com; Nom d'utilisateur SMTP
            //$mail->Password = 'humnoaixdpfjymlt'; Mot de passe SMTP

            $mail->CharSet = "UFT-8";
            $mail->setFrom($email);
            $mail->addAddress('bakayokoadama507@gmail.com');
            $mail->addReplyTo($email); ## Repondre à qui
            // $mail->addAddress('joe@example.net', 'Joe User'); Si on veut envoyer à d'autre, le nom est optionel

            $mail->isHTML(true);
            $mail->Subject = $sujet;
            $mail->Body = $messages;
            $mail->AltBody = $messages;
            $mail->send();
        }

        /**
         * Envoi un email à celui qui le demande
         * @param string $email
         * @param string $sujet
         * @param string $messages
         * @return void
        */
        public function token(string $email, string $sujet, string $messages)
        {
            $mail = new PHPMailer(true);
            // $mail->isSendmail();
            $mail->isSMTP();

            // Mailpit
            $mail->Host = 'localhost';
            $mail->Port = 1025;
            $mail->SMTPAuth = false;
            $mail->SMTPSecure = false;

            // $mail->Host       = 'smtp.gmail.com';
            // $mail->SMTPAuth   = true;
            // $mail->Username   = 'bakayokoadama507@gmail.com';
            // $mail->Password   = 'humnoaixdpfjymlt';
            // $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            // $mail->Port       = 587;

            $mail->CharSet = "UFT-8";
            $mail->setFrom($email);
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = $sujet;
            $mail->Body = $messages;
            $mail->AltBody = $messages;
            $mail->send();
        }

        /**
         * Lis un fichier et le retourne en chaîne de caractère
         * @param mixed $url
         * @return bool|string
        */
        public static function getPage($url, array $data = []) 
        {
            extract($data);
            ob_start();
            require $url;
            $content = ob_get_contents();
            ob_end_clean();
            return $content;
        }

    }