<?php

/*
 *
 * (c) Evis Bregu <evis.bregu@gmail.com>
 *
 */

namespace Evis\TwoFactorAuthBundle\Security\TwoFactor;

use Evis\TwoFactorAuthBundle\Model\TwoFactorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

interface HelperInterface
{
    public function is2faActive(TwoFactorInterface $user);

    public function checkCode($authCode, $code);

    public function getSessionKey(TokenInterface $token);
}
