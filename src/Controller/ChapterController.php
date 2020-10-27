<?php

namespace App\Controller;

use App\Entity\Book;
use App\Entity\Chapter;
use App\Form\ChapterType;
use App\Repository\ChapterRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/chapter")
 */
class ChapterController extends AbstractController
{
    /**
     * @Route("/", name="chapter_index", methods={"GET","POST"})
     */
    public function index(ChapterRepository $chapterRepository)
    {
        dump($chapterRepository->findAll());
        exit;
    }

    /**
     * @Route("/new/{book}", name="chapter_new", methods={"GET","POST"})
     */
    public function new(Book $book, Request $request): Response
    {
        $chapter = new Chapter($book);
        $form = $this->createForm(ChapterType::class, $chapter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($chapter);
            $entityManager->flush();

            return $this->redirectToRoute('book_show', [
                'id' => $chapter->getBook()->getId(),
            ]);
        }

        return $this->render('chapter/new.html.twig', [
            'chapter' => $chapter,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="chapter_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Chapter $chapter): Response
    {
        $form = $this->createForm(ChapterType::class, $chapter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('book_show', [
                'id' => $chapter->getBook()->getId(),
            ]);
        }

        return $this->render('chapter/edit.html.twig', [
            'chapter' => $chapter,
            'form' => $form->createView(),
        ]);
    }
}
