<?php

namespace App\Controller;

use App\Entity\Person;
use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Security\UserAuthenticator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/register", name="app_register")
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param GuardAuthenticatorHandler $guardHandler
     * @param UserAuthenticator $authenticator
     * @return Response
     */
    public function register(
        Request $request,
        UserPasswordEncoderInterface $passwordEncoder,
        GuardAuthenticatorHandler $guardHandler,
        UserAuthenticator $authenticator
    ): ?Response {
        $person = new Person();
        $user = new User();
        $person->setUser($user);
        $form = $this->createForm(RegistrationFormType::class, $person);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $person->setAddress($form->get('address')->getData());
            $person->setCountry($form->get('country')->getData());
            $person->setFirstName($form->get('firstName')->getData());
            $person->setLastName($form->get('lastName')->getData());
            $person->setPhoneNumber($form->get('phoneNumber')->getData());

            $user->setEmail($form->get('user')->getData()->getEmail());
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $request->request->all()['registration_form']['user']['password']
                )
            );
            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($user);
            $entityManager->persist($person);

            $entityManager->flush();

            return $guardHandler->authenticateUserAndHandleSuccess(
                $user,
                $request,
                $authenticator,
                'main'
            );
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
