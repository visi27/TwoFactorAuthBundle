<?php

namespace Evis\TwoFactorAuthBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('EvisTwoFactorAuthBundle:Default:index.html.twig');
    }
}
