<?php

namespace App\Controller;

use App\Entity\Person;
use App\Entity\User;
use App\Form\RegistrationLawyerType;
use App\Form\RegistrationUserType;
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
     * @Route("/register/user", name="user_register")
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param GuardAuthenticatorHandler $guardHandler
     * @param UserAuthenticator $authenticator
     * @return Response
     */
    public function registerUser(
        Request $request,
        UserPasswordEncoderInterface $passwordEncoder,
        GuardAuthenticatorHandler $guardHandler,
        UserAuthenticator $authenticator
    ): ?Response {
        if ($this->getUser()) {
            return $this->redirectToRoute('app_home');
        }
        $person = new Person();
        $user = new User();
        $person->setUser($user);
        $form = $this->createForm(RegistrationUserType::class, $person);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $person->setAddress($form->get('address')->getData());
            $person->setCountry($form->get('country')->getData());
            $person->setFirstName($form->get('firstName')->getData());
            $person->setLastName($form->get('lastName')->getData());
            $person->setPhoneNumber($form->get('phoneNumber')->getData());
            $user->setEmail($request->request->get('registration_user')['user']['email']);
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $request->request->all()['registration_user']['user']['password']
                )
            );
            $user->setIsVerified(false);
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

        return $this->render('registration/user.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/register/lawyer", name="lawyer_register")
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param GuardAuthenticatorHandler $guardHandler
     * @param UserAuthenticator $authenticator
     * @return Response
     */
    public function registerLawyer(
        Request $request,
        UserPasswordEncoderInterface $passwordEncoder,
        GuardAuthenticatorHandler $guardHandler,
        UserAuthenticator $authenticator
    ): ?Response {
        if ($this->getUser()) {
            return $this->redirectToRoute('app_home');
        }
        $person = new Person();
        $user = new User();
        $person->setUser($user);
        $form = $this->createForm(RegistrationLawyerType::class, $person);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $person->setAddress($form->get('address')->getData());
            $person->setCountry($form->get('country')->getData());
            $person->setFirstName($form->get('firstName')->getData());
            $person->setLastName($form->get('lastName')->getData());
            $person->setPhoneNumber($form->get('phoneNumber')->getData());
            $person->setSpecialization($form->get('specialization')->getData());
            $user->setEmail($request->request->get('registration_user')['user']['email']);
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $request->request->all()['registration_user']['user']['password']
                )
            );
            $user->setIsVerified(false);
            $user->setRoles(['ROLE_LAWYER']);
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

        return $this->render('registration/lawyer.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
