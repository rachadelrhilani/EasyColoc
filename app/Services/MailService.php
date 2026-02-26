<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class MailService
{
    public static function envoyerInvitation($emailDestinataire, $urlAction, $nomColoc)
    {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'rachdos76@gmail.com';
            $mail->Password   = 'yvsnsvpnyrlslhsd'; // Ton code de 16 lettres
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Crucial pour le port 465
            $mail->Port       = 465;
            $mail->CharSet    = 'UTF-8';

            $mail->setFrom(config('mail.from.address'), config('mail.from.name'));
            $mail->addAddress($emailDestinataire);

            $mail->isHTML(true);
            $mail->Subject = "Invitation à rejoindre la colocation : $nomColoc";

            $mail->Body = "
            <div style='font-family: sans-serif; padding: 20px; color: #333; border: 1px solid #eee; border-radius: 10px;'>
                <h2 style='color: #4f46e5;'>Bonjour !</h2>
                <p>Vous avez été invité à rejoindre la colocation <strong>$nomColoc</strong>.</p>
                <div style='margin: 30px 0;'>
                    <a href='$urlAction' style='background-color: #4f46e5; color: white; padding: 12px 25px; text-decoration: none; border-radius: 8px; font-weight: bold; display: inline-block;'>
                        Voir l'invitation
                    </a>
                </div>
                <p style='font-size: 11px; color: #999;'>Si le bouton ne fonctionne pas, copiez ce lien : $urlAction</p>
            </div>
        ";

            $mail->send();
            return true;
        } catch (Exception $e) {
            // En cas d'erreur, tu peux logger pour débugger :
            dd($mail->ErrorInfo, $e->getMessage());
            return false;
        }
    }
}
