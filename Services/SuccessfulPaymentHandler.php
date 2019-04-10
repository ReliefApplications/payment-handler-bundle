<?php

declare(strict_types=1);

namespace RA\PaymentHandlerBundle\Services;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use function base64_decode;
use function file_get_contents;
use function json_decode;
use function openssl_pkey_get_public;
use function openssl_public_decrypt;

class SuccessfulPaymentHandler
{
    /**
     * @return mixed[]
     *
     * @throws HttpException
     */
    public static function getPayload(Request &$request) : array
    {
        $encrypted = base64_decode($request->request->get('data'));
        if (! $encrypted) {
            throw new BadRequestHttpException('The encrypted data is not defined in data');
        }
        $keyPath   = __DIR__ . '/../Resources/key/public.pem';
        $key       = openssl_pkey_get_public(file_get_contents($keyPath));
        $decrypted = '';

        $decryptionSuccessful = openssl_public_decrypt($encrypted, $decrypted, $key);

        if (! $decryptionSuccessful) {
            throw new HttpException(500, 'Could not decrypt');
        }

        return (array) json_decode($decrypted, true);
    }
}