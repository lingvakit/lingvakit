<?php

declare(strict_types=1);

namespace App\Infrastructure\Auth;

use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Http;

class JwtService
{
    public function getJwtToken(): string
    {
        $url = config('app.url') . '/oauth/token';

        try {
            $response = Http::withoutVerifying()->asForm()->post($url, [
                'grant_type' => 'client_credentials',
                'client_id' => env('JWT_CLIENT_ID'),
                'client_secret' => env('JWT_CLIENT_SECRET'),
            ]);
        } catch (ClientException $exception) {
            throw new \Exception($exception->getMessage()) ;
        }

        $data = $response->json();

        if (!isset($data['access_token'])) {
            throw new \Exception('JWT access token is missing');
        }

        return $data['access_token'];
    }
}