<?php

namespace App\Services\Jitsi;

use App\Models\User;
use Jose\Component\Core\AlgorithmManager;
use Jose\Component\KeyManagement\JWKFactory;
use Jose\Component\Signature\Algorithm\RS256;
use Jose\Component\Signature\JWSBuilder;
use Jose\Component\Signature\Serializer\CompactSerializer;

class Jitsi
{
    private $jwk;
    private $algorithm;
    private $jwsBuilder;
    private $serializer;

    public function __construct(
        private string $apiKey,
        private string $appId
    ) {
        $keyFile = storage_path('app/jitsi/rsa-private.key');
        $algorithm = new AlgorithmManager([
            new RS256()
        ]);
        $this->jwk = JWKFactory::createFromKeyFile($keyFile);
        $this->jwsBuilder = new JWSBuilder($algorithm);
    }

    public function generateToken(User $user)
    {
        $payload = json_encode([
            'iss' => 'chat',
            'aud' => 'jitsi',
            'exp' => time() + 7200,
            'nbf' => time() - 10,
            'room' => '*',
            'sub' => $this->appId,
            'context' => [
                'user' => [
                    'moderator' => "false",
                    'email' => $user->email,
                    'name' => $user->fullmame,
                    'avatar' => $user->profile_picture,
                    'id' => $user->id
                ],
                'features' => [
                    'recording' => "false",
                    'livestreaming' => "false",
                    'transcription' => "false",
                    'outbound-call' => "false"
                ]
            ]
        ]);

        $jws = $this->jwsBuilder
            ->create()
            ->withPayload($payload)
            ->addSignature($this->jwk, [
                'alg' => 'RS256',
                'kid' => $this->apiKey,
                'typ' => 'JWT'
            ])
            ->build();

        $serializer = new CompactSerializer();
        $token = $serializer->serialize($jws, 0);

        return $token;
    }
}
