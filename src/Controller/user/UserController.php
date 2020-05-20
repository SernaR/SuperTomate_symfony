<?php

namespace App\Controller\user;

use App\Form\Type\ChangePasswordType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("utilisateur")
 */
class UserController extends AbstractController
{
    const MESSAGE =  'votre mot de passe est modifié';
    /**
     * @Route("/infos", methods="GET|POST", name="user_data")
     */
    public function myData(Request $request, UserPasswordEncoderInterface $encoder, $message = false)
    {
        $user = $this->getUser();
        $message = isset($_GET['message']) ? self::MESSAGE : null;

        $form = $this->createForm(ChangePasswordType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword($encoder->encodePassword($user, $form->get('newPassword')->getData()));

            $this->getDoctrine()->getManager()->flush();
            //$this->addFlash('success', 'user.updated_successfully');

            return $this->redirectToRoute('user_data', array('message' => true));
        }

        return $this->render('app/userPages/myData.html.twig', [
            'form' => $form->createView(),
            'user' => $user,
            'message' => $message,
            'current_menu' => 'data',
        ]);
    }
}
