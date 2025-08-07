<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;

class PasswordResetNotification extends ResetPassword
{
    /**
     * Obtener la representación en correo de la notificación.
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Restablece tu contraseña')
            ->line('Recibiste este correo porque recibimos una solicitud para restablecer tu contraseña.')
            ->action('Restablecer Contraseña', url(route('password.reset', ['token' => $this->token], false)))

            ->line('Si no realizaste esta solicitud, no es necesario hacer nada.');
    }
    

    /**
     * Obtener la representación del arreglo de la notificación.
     *
     * @return array<string, mixed>
     */
    public function toArray($notifiable): array
    {
        return [
            // Puedes agregar más datos si es necesario.
        ];
    }
}
