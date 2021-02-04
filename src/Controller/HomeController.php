<?php

namespace App\Controller;

use App\Entity\Question;
use App\Repository\AnswerRepository;
use App\Repository\QuestionRepository;
use http\Env\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="app_index")
     */
    public function index(QuestionRepository $questionRepository): Response
    {
        $top5Questions = $questionRepository->findTopFiveQuestions();
        $last5Questions = $questionRepository->findLastFiveQuestions();
        return $this->render('index.html.twig', [
            'topQuestions' => $top5Questions,
            'lastQuestions' => $last5Questions,
        ]);
    }

    /**
     * @Route("/top", name="top")
     */
    public function top(QuestionRepository $questionRepository): Response
    {
        $topQuestions = $questionRepository->findTopQuestions();
        return $this->render('top.html.twig', [
            'topAllQuestions' => $topQuestions,
        ]);
    }

    /**
     * @Route("/show/{id}", name="one_question", methods={"GET"})
     */
    public function showQuestion(Question $question, AnswerRepository $answerRepository): Response
    {

        $answers = $answerRepository->findAllByQuestion($question);

        return $this->render('rand.html.twig', [
            'question' => $question,
            'answers' => $answers,
        ]);
    }

    /**
     * @Route("/rand/", name="rand", methods={"GET"})
     */
    public function showRand(QuestionRepository $questionRepository, AnswerRepository $answerRepository): Response
    {
        $question = $questionRepository->findRandQuestion();

        $answers = $answerRepository->findAllByQuestion($question);

        return $this->render('rand.html.twig', [
            'question' => $question,
            'answers' => $answers,
        ]);
    }

    /**
     * @Route("/profile", name="profile")
     */
    public function profile(QuestionRepository $questionRepository, AnswerRepository $answerRepository): Response
    {
        $questions = $questionRepository->findBy(['user' => $this->getUser()]);
        $answers = $answerRepository->findBy(['user' => $this->getUser()]);

        return $this->render('/profile/profile.html.twig', [
            'questions' => $questions,
            'answers' => $answers,
        ]);
    }

    /**
     * @Route("/admin", name="admin_profile")
     */
    public function admin(QuestionRepository $questionRepository, AnswerRepository $answerRepository): Response
    {
        $questions = $questionRepository->findBy(['user' => $this->getUser()]);
        $answers = $answerRepository->findBy(['user' => $this->getUser()]);

        return $this->render('/admin/admin_profile.html.twig', [
            'questions' => $questions,
            'answers' => $answers,
        ]);
    }




}