<?php

namespace App\Services;

use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;

/**
 * Minimum-fill-time anti-spam trap for the public consultation form —
 * NOT a CSRF replacement (CSRF is handled separately via @csrf) and not
 * a CAPTCHA. Encodes only a timestamp, tamper-evident via Laravel's
 * encrypter (APP_KEY-backed), so a bot cannot forge an old-enough token
 * without ever having loaded the real form.
 */
class ConsultationFormTokenService
{
    public function generate(): string
    {
        return Crypt::encryptString((string) now()->timestamp);
    }

    /**
     * Seconds elapsed since the token was generated, or null if the token
     * is missing, tampered with, or otherwise unreadable.
     */
    public function secondsSinceIssued(?string $token): ?int
    {
        if (! $token) {
            return null;
        }

        try {
            $issuedAt = (int) Crypt::decryptString($token);
        } catch (DecryptException) {
            return null;
        }

        return max(0, now()->timestamp - $issuedAt);
    }
}
