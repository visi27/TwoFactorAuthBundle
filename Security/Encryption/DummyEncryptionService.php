<?php

/*
 *
 * (c) Evis Bregu <evis.bregu@gmail.com>
 *
 */

namespace Evis\TwoFactorAuthBundle\Security\Encryption;


use Psr\Log\LoggerInterface;

class DummyEncryptionService implements EncryptionServiceInterface
{
    /**
     * @var string
     */
    private $key;
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * EncryptionService constructor.
     *
     * @param string          $key
     * @param LoggerInterface $logger
     */
    public function __construct($key, LoggerInterface $logger)
    {

        $this->key = $key;
        $this->logger = $logger;
    }
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
