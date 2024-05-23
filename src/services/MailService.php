<?php

namespace App\Services;

use App\Models\Token;
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

    public static function sendVerificationEmail($user, $verificationToken)
    {
        self::init();
        $mailTemplate = file_get_contents('../views/Mail/reset-password.html');
        $verificationLink = "https://yourdomain.com/verify?token=$verificationToken";

        $email = (new Email())
            ->from('no-reply@yourdomain.com')
            ->to($user['email'])
            ->subject('Email Verification')
            ->text("Please click on the following link to verify your email: $verificationLink")
            ->html($mailTemplate);

        self::$mailer->send($email);
    }

    public static function sendResetPasswordEmail($user)
    {
        self::init();
        $resetToken = Token::create($user['id']);

        $mailTemplate = file_get_contents( __DIR__ . '/../views/Mail/reset-password.html');
        $mailTemplate = str_replace('[USERNAME]', htmlspecialchars($user['name']), $mailTemplate);
        $mailTemplate = str_replace('[RESET_CODE]', htmlspecialchars($resetToken), $mailTemplate);

        $email = (new Email())
            ->from('no-reply@' . DOMAIN . '.com')
            ->to($user['email'])
            ->subject('Password Reset Request')
            ->html($mailTemplate);

        self::$mailer->send($email);
    }
}
