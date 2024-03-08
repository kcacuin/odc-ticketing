<?php

namespace App\Mail;

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

class CustomPHPMailer
{
    protected $mailer;

    public function __construct()
    {
        $this->mailer = new PHPMailer(true);

        // Configure PHPMailer settings
        $this->mailer->isSMTP();
        $this->mailer->Host = env('MAIL_HOST');
        $this->mailer->Port = env('MAIL_PORT');
        $this->mailer->SMTPAuth = true;
        $this->mailer->Username = env('MAIL_USERNAME');
        $this->mailer->Password = env('MAIL_PASSWORD');
        $this->mailer->SMTPSecure = env('MAIL_ENCRYPTION', 'tls');
        $this->mailer->SMTPDebug = 2; // Set to 0 for production
    }

    public function sendEmail($recipient, $subject, $body)
    {
        try {
            // Set email parameters
            $this->mailer->setFrom(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
            $this->mailer->addAddress($recipient);
            $this->mailer->Subject = $subject;
            $this->mailer->Body = $body;

            // Send the email
            $this->mailer->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}
