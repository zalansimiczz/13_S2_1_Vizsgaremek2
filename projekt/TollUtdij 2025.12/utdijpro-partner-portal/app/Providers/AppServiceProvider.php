<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        
    }

    public function boot(): void
    {
        VerifyEmail::toMailUsing(function (object $notifiable, string $url) {
        return (new MailMessage)
            ->subject('TollÚtdíj - Erősítsd meg az email címed!')
            ->line('Ahhoz, hogy ellenőrizni tudjuk a regisztráció során megadott e-mail címed helyességét, kérjük, erősítsd meg az alábbi linken!')
            ->action('E-mail cím megerősítése', $url)
            ->line('Miért fontos ez? A megerősítésed segít nekünk megbizonyosodni arról, hogy a megadott e-mail címedet nem egy illetéktelen, harmadik személy adta meg. Amennyiben nem te adtad meg az email címet, akkor egyszerűen hagyd figyelmen kívül ezt az üzenetet!');
    });
    }
}
