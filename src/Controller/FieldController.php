<?php

namespace App\Controller;

use App\Entity\Field;
use App\Form\FieldType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Exception\InvalidArgumentException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FieldController extends AbstractController
{
    /**
     * @Route("/field", name="field", methods={"GET", "POST"})
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function index(Request $request, EntityManagerInterface $entityManager)
    {
        $field = new Field();
        $schemaManager = $entityManager->getConnection()->getSchemaManager();
        $fields = $this->createForm(
            FieldType::class,
            $field,
            [
                'entities' => $schemaManager,
            ]
        );
        $fields->handleRequest($request);
        if ($fields->isSubmitted()) {
            if (!$this->getDoctrine()->getRepository(
                Field::class
            )->findOneBy(['fieldName' => $_POST['field']['fieldName']])) {
                $field->setLabel($_POST['field']['label']);
                $field->setEntity($_POST['field']['entity']);
                $field->setFieldName($_POST['field']['fieldName']);
                $entityManager->persist($field);
                $entityManager->flush();
            } else {
                throw new InvalidArgumentException(sprintf(
                    'Le Champ ' . $_POST['field']['fieldName'] . ' existe déjà',
                    get_called_class()
                ));
            }

            return $this->redirect($this->generateUrl('field'));
        } else {
            return $this->render('dashboard/Admin/field/index.html.twig', [
                'entities' => $fields->createView(),
            ]);
        }
    }

    /**
     * @Route("/getFields", name="getFields")
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return JsonResponse
     */
    public function getFields(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $schemaManager = $entityManager->getConnection()->getSchemaManager();
        return new JsonResponse($schemaManager->listTableColumns($_POST['entity']));
    }
}
