<?php

declare(strict_types=1);

namespace App\Services;

use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;

class EncryptionService
{
    const CIPHERING = "AES-128-CBC";

    private $params;

    private $userKey;

    public function __construct(ContainerBagInterface $params)
    {
        $this->params = $params;
    }

    public function encryptData(string $data): string
    {
        $ivLen = openssl_cipher_iv_length(self::CIPHERING);
        $iv = openssl_random_pseudo_bytes($ivLen);
        $ciphertext_raw = openssl_encrypt(
            $data, 
            self::CIPHERING,
            $this->params->get('parameter_secret'),
            $options=OPENSSL_RAW_DATA,
            $iv
        );
        $hmac = hash_hmac(
            'sha256', 
            $ciphertext_raw, 
            $this->params->get('parameter_secret'),
            $as_binary=true
        );
        return base64_encode($iv.$hmac.$ciphertext_raw);
    }

    public function decryptData(string $encodedData): string
    {
        $c = base64_decode($encodedData);
        $ivLen = openssl_cipher_iv_length(self::CIPHERING);
        $iv = substr($c, 0, $ivLen);
        substr($c, $ivLen, $sha2len=32);
        $ciphertext_raw = substr($c, $ivLen+$sha2len);
        return openssl_decrypt(
            $ciphertext_raw, 
            self::CIPHERING,
            $this->params->get('parameter_secret'),
            $options=OPENSSL_RAW_DATA,
            $iv
        );
    }

    public function hashData(string $data): string
    {
        $hexString = unpack('H*', $data);
        $hex = array_shift($hexString);

        return base64_encode($hex);
    }

    public function unHashData(string $encodedData): string{
        return hex2bin(base64_decode($encodedData));
    }
}
