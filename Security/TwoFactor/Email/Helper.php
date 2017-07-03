<?php

/*
 *
 * (c) Evis Bregu <evis.bregu@gmail.com>
 *
 */

namespace Evis\TwoFactorAuthBundle\Security\TwoFactor\Email;


use Evis\TwoFactorAuthBundle\Model\TwoFactorInterface;
use Evis\TwoFactorAuthBundle\Security\TwoFactor\HelperInterface;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class Helper implements HelperInterface
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    /**
     * @var object
     */
    private $mailer;

    /**
     * Construct the helper service for mail authenticator.
     *
     * @param \Doctrine\ORM\EntityManager $em
     * @param object                      $mailer
     */
    public function __construct(EntityManager $em, $mailer)
    {
        $this->em = $em;
        $this->mailer = $mailer;
    }

    /**
     * Generate a new authentication code an send it to the user.
     *
     * @param TwoFactorInterface $user
     */
    public function generateAndSend(TwoFactorInterface $user)
    {
        $code = mt_rand(1000, 9999);
        $user->setTwoFactorCode($code);
        $this->em->persist($user);
        $this->em->flush();
        $this->sendCode($user);
    }

    /**
     * Send email with code to user.
     *
     * @param TwoFactorInterface $user
     */
    private function sendCode(TwoFactorInterface $user)
    {
        $message = new \Swift_Message();
        $message
            ->setTo($user->getEmail())
            ->setSubject('Acme Authentication Code')
            ->setFrom('security@acme.com')
            ->setBody($user->getTwoFactorCode())
        ;
        $this->mailer->send($message);
    }

    /**
     * Validates the code, which was entered by the user.
     *
     * @param $authCode
     * @param $code
     *
     * @return bool
     *
     * @internal param User|UserInterface $user
     */
    public function checkCode($authCode, $code)
    {
        return $authCode === $code;
    }

    /**
     * Generates the attribute key for the session.
     *
     * @param \Symfony\Component\Security\Core\Authentication\Token\TokenInterface $token
     *
     * @return string
     */
    public function getSessionKey(TokenInterface $token)
    {
        return sprintf('two_factor_%s_%s', $token->getProviderKey(), $token->getUsername());
    }

    /**
     * @param TwoFactorInterface $user
     *
     * @return bool
     */
    public function is2faActive(TwoFactorInterface $user)
    {
        return $user->getTwoFactorAuthentication();
    }
}
