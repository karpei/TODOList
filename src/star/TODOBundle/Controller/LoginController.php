<?php

namespace star\TODOBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class LoginController extends Controller
{
    /**
     * @Route("/login", name="login")
     */
    public function loginAction(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');
        $errors = $authenticationUtils->getLastAuthenticationError();
        $LastUsername = $authenticationUtils->getLastUsername();
        return $this->render('starTODOBundle:Login:login.html.twig', array(
            'errors' => $errors,
            'username' => $LastUsername
        ));
    }

    /**
     * @Route("/logout", name="logout")
     */

    public function logoutAction(){}

}
