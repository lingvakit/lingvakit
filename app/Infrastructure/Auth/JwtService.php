<?php

declare(strict_types=1);

namespace App\Infrastructure\Auth;

use Cache;
use Exception;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class JwtService
{
    private const string CACHE_KEY = 'ms.jwt.access_token';
    private const int CACHE_TTL = 3500;

    public function getJwtToken(): string
    {
        return Cache::remember(
            key: self::CACHE_KEY,
            ttl: self::CACHE_TTL,
            callback: function () {
                return $this->fetchToken();
            }
        );
    }

    /**
     * @throws Exception
     */
    public function fetchToken(): string
    {
        $url = config('app.url') . '/oauth/token';

        try {
            $response = Http::withoutVerifying()
                ->asForm()
                ->acceptJson()
                ->post($url, [
                    'grant_type' => 'client_credentials',
                    'client_id' => config('auth.jwt.api.client_id'),
                    'client_secret' => config('auth.jwt.api.client_secret'),
                ]);
        } catch (ClientException $exception) {
            throw new RuntimeException(
                'OAuth token request failed: ' . $exception->getMessage(),
            );
        }

        $data = $response->json();

        if (!isset($data['access_token'])) {
            logger()->error('OAuth response without access_token', [
                'response' => $data,
            ]);

            throw new Exception('OAuth response without access_token');
        }

        return $data['access_token'];
    }

    public function clearToken(): void
    {
        Cache::forget(self::CACHE_KEY);
    }
}