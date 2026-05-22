<?php

namespace App\Services;

use App\Models\PushSubscription;
use App\Models\User;
use Illuminate\Support\Facades\Http;

class PushNotificationService
{
    public function subscribe(User $user, array $data): PushSubscription
    {
        return $user->pushSubscriptions()->updateOrCreate(
            ['endpoint' => $data['endpoint']],
            [
                'auth_key' => $data['auth_key'] ?? null,
                'p256dh_key' => $data['p256dh_key'] ?? null,
                'device_type' => $data['device_type'] ?? 'web',
            ]
        );
    }

    public function unsubscribe(User $user, string $endpoint): bool
    {
        return $user->pushSubscriptions()->where('endpoint', $endpoint)->delete() > 0;
    }

    public function send(User $user, string $title, string $body, array $data = []): void
    {
        $subscriptions = $user->pushSubscriptions;
        foreach ($subscriptions as $sub) {
            $this->sendToSubscription($sub, $title, $body, $data);
        }
    }

    public function sendToAll(array $userIds, string $title, string $body, array $data = []): void
    {
        $subscriptions = PushSubscription::whereIn('user_id', $userIds)->get();
        foreach ($subscriptions as $sub) {
            $this->sendToSubscription($sub, $title, $body, $data);
        }
    }

    protected function sendToSubscription(PushSubscription $sub, string $title, string $body, array $data = []): void
    {
        $payload = json_encode([
            'title' => $title,
            'body' => $body,
            'icon' => '/icon-192x192.png',
            'badge' => '/icon-192x192.png',
            'data' => $data,
            'vibrate' => [200, 100, 200],
        ]);

        $info = [
            'endpoint' => $sub->endpoint,
            'auth' => $sub->auth_key,
            'p256dh' => $sub->p256dh_key,
        ];

        $headers = $this->getHeaders($info, $payload);

        try {
            Http::withHeaders($headers)
                ->timeout(10)
                ->withBody($payload, 'application/json')
                ->post($sub->endpoint);
        } catch (\Exception $e) {
            if (str_contains($e->getMessage(), '410') || str_contains($e->getMessage(), '404')) {
                $sub->delete();
            }
        }
    }

    protected function getHeaders(array $info, string $payload): array
    {
        if (!$info['auth'] || !$info['p256dh']) {
            return [];
        }

        $key = $this->urlSafeBase64Decode($info['p256dh']);
        $auth = $this->urlSafeBase64Decode($info['auth']);
        $salt = random_bytes(16);

        $localPrivateKey = $this->getLocalPrivateKey();
        $localPublicKey = $this->getLocalPublicKey();

        $sharedSecret = $this->computeSharedSecret($localPrivateKey, $key);
        $pseudoEncKey = $this->hkdf($salt, $sharedSecret, 'P-256', 32);
        $contentEncKey = $this->hkdf($salt, $sharedSecret, 'Content-Encoding: aes128gcm', 32);

        $iv = random_bytes(12);
        $ciphertext = openssl_encrypt($payload, 'aes-128-gcm', $contentEncKey, OPENSSL_RAW_DATA, $iv, $tag);

        $record = $salt . $iv . $tag . $ciphertext;

        return [
            'Content-Type' => 'application/octet-stream',
            'Content-Encoding' => 'aes128gcm',
            'Encryption' => 'salt=' . rtrim(strtr(base64_encode($salt), '+/', '-_'), '='),
            'Crypto-Key' => 'dh=' . rtrim(strtr(base64_encode($pseudoEncKey), '+/', '-_'), '='),
            'TTL' => '86400',
        ];
    }

    protected function urlSafeBase64Decode(string $data): string
    {
        return base64_decode(strtr($data, '-_', '+/'));
    }

    protected function getLocalPrivateKey(): string
    {
        $config = [
            'curve_name' => 'prime256v1',
            'private_key_type' => OPENSSL_KEYTYPE_EC,
        ];
        $res = openssl_pkey_new($config);
        openssl_pkey_export($res, $privKey);
        $details = openssl_pkey_get_details($res);
        return $privKey;
    }

    protected function getLocalPublicKey(): string
    {
        return '';
    }

    protected function computeSharedSecret(string $privateKey, string $publicKey): string
    {
        return '';
    }

    protected function hkdf(string $salt, string $ikm, string $info, int $length): string
    {
        $prk = hash_hmac('sha256', $ikm, $salt, true);
        $t = '';
        $result = '';
        for ($i = 1; strlen($result) < $length; $i++) {
            $t = hash_hmac('sha256', $t . $info . chr($i), $prk, true);
            $result .= $t;
        }
        return substr($result, 0, $length);
    }
}
