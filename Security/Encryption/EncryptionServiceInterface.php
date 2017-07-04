<?php

namespace Evis\TwoFactorAuthBundle\Security\Encryption;

/**
 * Interface EncryptionServiceInterface
 * @package Evis\TwoFactorAuthBundle\Security\Encryption
 */
interface EncryptionServiceInterface{
    /**
     * @param $plainText
     * @return mixed
     */
    public function encrypt($plainText);

    /**
     * @param $encryptedText
     * @return mixed
     */
    public function decrypt($encryptedText);
}
