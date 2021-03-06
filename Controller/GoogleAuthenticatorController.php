<?php

/*
 *
 * (c) Evis Bregu <evis.bregu@gmail.com>
 *
 */

namespace Evis\TwoFactorAuthBundle\Controller;

use Evis\TwoFactorAuthBundle\Model\TwoFactorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class GoogleAuthenticatorController.
 *
 * @Security("is_granted('ROLE_USER')")
 */
class GoogleAuthenticatorController extends Controller
{
    /**
     * @Route("/_otp/activate", name="auth_activate_otp")
     *
     * @param Request $request
     *
     * @return RedirectResponse|Response
     */
    public function activateGoogleAuthenticatorAction(Request $request)
    {
        /**
         * @var TwoFactorInterface
         */
        $user = $this->getUser();
        if (!$user) {
            return new Response('You need to login');
        }

        if ($user->getTwoFactorAuthentication()) {
            //Flag authentication complete
            $this->addFlash('error', 'Google Authenticator Is Already Active');

            return $this->redirectToRoute($this->getParameter('user_dashboard_route'));
        }

        $helper = $this->get('evis_two_factor_auth.security.twofactor.google.provider');

        if ($request->getMethod() === 'POST') {
            //check authentication key
            //Check the authentication code
            $authKey = $this->get($this->getParameter('encryption_service'))->decrypt($user->getGoogleAuthenticatorCode());
            if ($helper->checkCode($authKey, $request->get('_auth_code')) === true) {
                //activate 2fa authenticator
                $user->setTwoFactorAuthentication(true);
                $user->setDefaultTwoFactorMethod('google');

                $this->getDoctrine()->getManager()->persist($user);
                $this->getDoctrine()->getManager()->flush();
                $this->addFlash('success', 'Google Authenticator Activated');

                return $this->redirectToRoute($this->getParameter('user_dashboard_route'));
            }
            $this->addFlash('error', 'Invalid Code');
            $qrCodeUrl = $helper->getUrl($user, $authKey);

            return $this->render('EvisTwoFactorAuthBundle:twofactor:activate.html.twig', ['qrCodeURL' => $qrCodeUrl]);
        }
            //generate new key
            $code = $helper->generateSecret();

        $user->setGoogleAuthenticatorCode('');
        $user->setPlainGoogleAuthenticatorCode($code);
        $this->getDoctrine()->getManager()->persist($user);
        $this->getDoctrine()->getManager()->flush();

        $qrCodeUrl = $helper->getUrl($user, $code);

        return $this->render('EvisTwoFactorAuthBundle:twofactor:activate.html.twig', ['qrCodeURL' => $qrCodeUrl]);
    }
}
