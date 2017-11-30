<?php

namespace star\TODOBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use star\TODOBundle\Entity\Users;
class RegisterController extends Controller
{
    /**
     * @Route("/register",name="register")
     */
    public function RegisterAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = new Users();
        $form = $this->createForm("star\TODOBundle\Form\RegisterType",$user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

                $em->persist($user);
                $em->flush();
                return $this->redirectToRoute('login');
        }
        return $this->render('starTODOBundle:Register:register.html.twig', array(
            'form'=>$form->createView()
        ));
    }

}
