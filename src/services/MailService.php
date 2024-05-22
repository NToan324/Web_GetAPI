<?php

namespace App\Services;

use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mime\Email;

class MailService
{
    private static $mailer;

    public static function init()
    {
        if (self::$mailer === null) {
            // Update the DSN with your actual mail server configuration

            $transport = Transport::fromDsn('smtp://coolxmode@gmail.com:xprmqlerbsttqxht@smtp.gmail.com:587');
            self::$mailer = new Mailer($transport);
        }
    }

    public static function sendVerificationEmail($to, $verificationToken)
    {
        self::init();

        $verificationLink = "https://yourdomain.com/verify?token=$verificationToken";

        $email = (new Email())
            ->from('no-reply@yourdomain.com')
            ->to($to)
            ->subject('Email Verification')
            ->text("Please click on the following link to verify your email: $verificationLink")
            ->html("<p>Please click on the following link to verify your email: <a href=\"$verificationLink\">$verificationLink</a></p>");

        self::$mailer->send($email);
    }

    public static function sendResetPasswordEmail($to, $resetToken)
    {
        self::init();

        $resetLink = "http://" . DOMAIN . "/reset-password?token=$resetToken";

        $email = (new Email())
            ->from('no-reply@'. DOMAIN . '.com')
            ->to($to)
            ->subject('Password Reset Request')
            ->html("<p>Please click on the following link to reset your password: <a href=\"$resetLink\">$resetLink</a></p>");
            // TODO: reset password mail
        self::$mailer->send($email);
    }
}
