<?php

/*
 *
 * (c) Evis Bregu <evis.bregu@gmail.com>
 *
 */

namespace Evis\TwoFactorAuthBundle\Security\Encryption;


class DummyEncryptionService implements EncryptionServiceInterface
{

    /**
     * @param $plainText
     *
     * @return string
     */
    public function encrypt($plainText)
    {
       return $plainText;
    }

    public function decrypt($encryptedText)
    {
        return $encryptedText;
    }
}
