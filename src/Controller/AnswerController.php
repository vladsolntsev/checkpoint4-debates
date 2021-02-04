<?php

namespace App\Controller;

use App\Entity\Answer;
use App\Entity\Question;
use App\Form\AnswerType;
use App\Repository\AnswerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/answer")
 */
class AnswerController extends AbstractController
{
    /**
     * @Route("/", name="answer_index", methods={"GET"})
     */
    public function index(AnswerRepository $answerRepository): Response
    {
        return $this->render('answer/index.html.twig', [
            'answers' => $answerRepository->findAll(),
        ]);
    }

    /**
     * @Route("/newPositive/{id}", name="answer_new_positive", methods={"GET","POST"})
     */
    public function newPositive(Question $question, Request $request): Response
    {
        $answer = new Answer();
        $form = $this->createForm(AnswerType::class, $answer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $answer->setUser($this->getUser());
            $answer->setType(1);
            $answer->setQuestion($question);
            $answer->setRating(0);
            $entityManager->persist($answer);
            $entityManager->flush();

            return $this->redirectToRoute('one_question', ['id' => $question->getId()]);
        }

        return $this->render('answer/new.html.twig', [
            'answer' => $answer,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/newNegative/{id}", name="answer_new_negative", methods={"GET","POST"})
     */
    public function newNegative(Question $question, Request $request): Response
    {
        $answer = new Answer();
        $form = $this->createForm(AnswerType::class, $answer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $answer->setUser($this->getUser());
            $answer->setType(0);
            $answer->setQuestion($question);
            $answer->setRating(0);
            $entityManager->persist($answer);
            $entityManager->flush();

            return $this->redirectToRoute('one_question', ['id' => $question->getId()]);
        }

        return $this->render('answer/new.html.twig', [
            'answer' => $answer,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/{id}", name="answer_show", methods={"GET"})
     */
    public function show(Answer $answer): Response
    {
        return $this->render('answer/show.html.twig', [
            'answer' => $answer,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="answer_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Answer $answer): Response
    {
        $form = $this->createForm(AnswerType::class, $answer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('profile');
        }

        return $this->render('answer/edit.html.twig', [
            'answer' => $answer,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="answer_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Answer $answer): Response
    {
        if ($this->isCsrfTokenValid('delete' . $answer->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($answer);
            $entityManager->flush();
        }

        return $this->redirectToRoute('profile');
    }

    /**
     * @Route("/ratingUp/{id}", name="answer_rating_up")
     */
    public function answerRatingUp(Answer $answer): Response
    {

        $question = $answer->getQuestion();
        $entityManager = $this->getDoctrine()->getManager();
        $answer->setRating($answer->getRating() + 1);
        $entityManager->persist($answer);
        $entityManager->flush();

        return $this->redirectToRoute('one_question', ['id' => $question->getId()]);
    }

    /**
     * @Route("/ratingDown/{id}", name="answer_rating_down")
     */
    public function answerRatingDown(Answer $answer): Response
    {
        $question = $answer->getQuestion();
        $entityManager = $this->getDoctrine()->getManager();
        $answer->setRating($answer->getRating() - 1);
        $entityManager->persist($answer);
        $entityManager->flush();

        return $this->redirectToRoute('one_question', ['id' => $question->getId()]);
    }

}