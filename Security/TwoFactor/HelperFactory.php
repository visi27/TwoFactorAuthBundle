<?php

/*
 *
 * (c) Evis Bregu <evis.bregu@gmail.com>
 *
 */

namespace Evis\TwoFactorAuthBundle\Security\TwoFactor;


use Evis\TwoFactorAuthBundle\Model\TwoFactorInterface;

class HelperFactory
{
    /**
     * @var HelperInterface
     */
    private $emailHelper;
    /**
     * @var HelperInterface
     */
    private $googleHelper;

    public function __construct(HelperInterface $emailHelper, HelperInterface $googleHelper)
    {
        $this->emailHelper = $emailHelper;
        $this->googleHelper = $googleHelper;
    }

    public function getHelper(TwoFactorInterface $user)
    {
        switch ($user->getDefaultTwoFactorMethod()) {
            case 'email':
                return $this->emailHelper;
                break;
            case 'google':
                return $this->googleHelper;
                break;
            default:
                return $this->emailHelper;
        }
    }
}
