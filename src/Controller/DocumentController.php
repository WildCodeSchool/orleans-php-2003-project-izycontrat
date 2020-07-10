<?php

namespace App\Controller;

use App\Entity\Document;
use App\Entity\Field;
use App\Form\DocumentType;
use App\Repository\DocumentRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

/**
 * @Route(name="document_")
 */
class DocumentController extends AbstractController
{
    /**
     * @Route("/document", name="home")
     * @param DocumentRepository $documents
     * @return Response
     */
    public function index(DocumentRepository $documents)
    {
        return $this->render('dashboard/Admin/document/index.html.twig', [
            'documents' => $documents->findAll(),
        ]);
    }

    /**
     * @Route("/document/new", name="new")
     * @param Request $request
     * @param SluggerInterface $slugger
     * @return Response
     */
    public function new(Request $request, SluggerInterface $slugger)
    {
        $document = new Document();
        $entityManager = $this->getDoctrine()->getManager();
        $fields = $entityManager->getRepository(Field::class)->findAll();
        $filesystem = new Filesystem();
        try {
            $filesystem->mkdir($this->getParameter('document_directory'));
        } catch (IOExceptionInterface $exception) {
            echo "An error occurred while creating your directory at ".$exception->getPath();
        }
        $form = $this->createForm(DocumentType::class, $document);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $originalFilename = $form->getData()->getFileName();
            // this is needed to safely include the file name as part of the URL
            $safeFilename = $slugger->slug($originalFilename);
            $newFilename = $safeFilename.'_'.uniqid().'.'.'html.twig';
            // updates the 'brochureFilename' property to store the PDF file name
            // instead of its contents
            $document->setFileName($newFilename);
            $entityManager->persist($document);
            $entityManager->flush();
            return $this->redirectToRoute('document_home');
        }
        return $this->render('dashboard/Admin/document/editor.html.twig', [
            'form' => $form->createView(),
            'fields' => $fields,
        ]);
    }

    /**
     * @Route("/document/{id}/edit", name="edit")
     * @param Request $request
     * @param SluggerInterface $slugger
     * @param Document $document
     * @return Response
     */
    public function edit(Request $request, SluggerInterface $slugger, Document $document)
    {
        $document->setFileName(explode('_', (string)$document->getFileName())[0]);
        $entityManager = $this->getDoctrine()->getManager();
        $fields = $entityManager->getRepository(Field::class)->findAll();
        $form = $this->createForm(DocumentType::class, $document);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $originalFilename = $document->getFileName();
            // this is needed to safely include the file name as part of the URL
            $safeFilename = $slugger->slug((string)$originalFilename);
            $newFilename = $safeFilename.'_'.uniqid().'.'.'html.twig';
            // updates the 'brochureFilename' property to store the PDF file name
            // instead of its contents
            $document->setFileName($newFilename);
            $entityManager->persist($document);
            $entityManager->flush();
            return $this->redirectToRoute('document_home');
        }
        return $this->render('dashboard/Admin/document/editor.html.twig', [
            'form' => $form->createView(),
            'fields' => $fields,
        ]);
    }

    /**
     * @Route("/{id}", name="delete", methods={"DELETE"})
     * @IsGranted("ROLE_ADMIN")
     * @param Request $request
     * @param Document $document
     * @return Response
     */
    public function delete(Request $request, Document $document): Response
    {
        if ($this->isCsrfTokenValid('delete' . $document->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($document);
            $entityManager->flush();
            $this->addFlash('danger', 'Le document a bien été supprimé');
        }

        return $this->redirectToRoute('document_home');
    }
}
