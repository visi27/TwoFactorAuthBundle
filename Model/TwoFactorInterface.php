<?php
/**
 * Created by PhpStorm.
 * User: evis
 * Date: 7/3/17
 * Time: 11:25 AM
 */

namespace Evis\TwoFactorAuthBundle\Model;


interface TwoFactorInterface
{
//    /**
//     * Return the user name.
//     *
//     * @return string
//     */
//    public function getUsername();
//    /**
//     * Return the Google Authenticator secret
//     * When an empty string or null is returned, the Google authentication is disabled.
//     *
//     * @return string|null
//     */
//    public function getGoogleAuthenticatorSecret();
//    /**
//     * Set the Google Authenticator secret.
//     *
//     * @param int $googleAuthenticatorSecret
//     */
//    public function setGoogleAuthenticatorSecret($googleAuthenticatorSecret);

    public function getDefaultTwoFactorMethod();

    public function getEmail();

    public function getTwoFactorCode();

    public function getTwoFactorAuthentication();

    public function setTwoFactorCode($code);
}