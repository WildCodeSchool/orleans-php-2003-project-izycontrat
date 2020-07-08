<?php

namespace App\Controller;

use App\Entity\Document;
use App\Entity\Person;
use App\Entity\User;
use App\Form\DocumentType;
use App\Repository\DocumentRepository;
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
        return $this->render('document/index.html.twig', [
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
        $persons = new Person();
        $user = new User();
        $filesystem = new Filesystem();
        try {
            $filesystem->mkdir($this->getParameter('document_directory'));
        } catch (IOExceptionInterface $exception) {
            echo "An error occurred while creating your directory at ".$exception->getPath();
        }
        $persons->setUser(new User());
        $form = $this->createForm(DocumentType::class, $document);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $originalFilename = $form->getData()['fileName'];
            // this is needed to safely include the file name as part of the URL
            $safeFilename = $slugger->slug($originalFilename);
            $newFilename = $safeFilename.'_'.uniqid().'.'.'html.twig';
            // updates the 'brochureFilename' property to store the PDF file name
            // instead of its contents
            $document->setFileName($newFilename);
            $file = $this->getParameter('document_directory') . '/' . $document->getFileName();
            $filesystem->dumpFile($file, $document->getContent());
            $entityManager->persist($document);
            $entityManager->flush();
            return $this->redirectToRoute('document_home');
        }
        return $this->render('document/editor.html.twig', [
            'form' => $form->createView(),
            'persons' => explode(',', $persons),
            'users' => explode(',', $user),
        ]);
    }
}
