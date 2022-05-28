<?php

namespace App\Controller;

use App\Entity\UrlMinimizer;
use App\Form\UrlMinimizerType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\UrlMinimizerRepository;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UrlMinimizerController extends AbstractController
{
    #[Route('/', name: 'minimizer')]
    public function index(
        Request $request,
        ManagerRegistry $doctrine,
        ValidatorInterface $validator,
    ): Response
    {

        $urlMinimizer = new UrlMinimizer();
        $form = $this->createForm(UrlMinimizerType::class, $urlMinimizer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            $urlMinimizer = $form->getData();

            $errors = $validator->validate($urlMinimizer);
            if (count($errors) > 0) {
                return new Response((string) $errors, 400);
            }
            $entityManager->persist($urlMinimizer);
            $entityManager->flush();

            return $this->redirectToRoute('success', [
                'minimizedUrl' => $urlMinimizer->getMinimizedurl()
            ]);
        }

        return $this->render('url/minimizer.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/url/success/{minimizedUrl}', name: 'success')]
    public function success(
        Request $request,
        ManagerRegistry $doctrine,
        UrlMinimizerRepository $urlMinimizerRepository,
        $minimizedUrl
    ): Response
    {
        $urlMinimizer = $urlMinimizerRepository
            ->findOneBy([
                'minimizedUrl' => $minimizedUrl,
                'active' => UrlMinimizer::IS_ACTIVE
            ]);

        if (!$urlMinimizer) {
            throw $this->createNotFoundException(
                'No active record in database'
            );
        }

        return $this->render('url/success.html.twig', [
            'urlMinimizer' => $urlMinimizer
        ]);
    }

    #[Route('/redirect/{minimizedUrl}', name: 'redirectMinimizedUrl')]
    public function redirectMinimizedUrl(
        UrlMinimizerRepository $urlMinimizerRepository,
        ManagerRegistry $doctrine,
        $minimizedUrl
    )
    {
        $urlMinimizer = $urlMinimizerRepository
            ->findOneBy([
                'minimizedUrl' => $minimizedUrl,
                'active' => true
            ]);

        if (!$urlMinimizer) {
            throw $this->createNotFoundException(
                'No active record in database'
            );
        }

        $newClickCount = $urlMinimizer->getClickCount()+1;
        $urlMinimizer->setClickCount($newClickCount);
        $entityManager = $doctrine->getManager();
        $entityManager->persist($urlMinimizer);
        $entityManager->flush();


        return $this->redirect($urlMinimizer->getUrl());
    }

    #[Route('/statistic/{minimizedUrl}', name: 'statistic')]
    public function statistic(
        UrlMinimizerRepository $urlMinimizerRepository,
        $minimizedUrl,
    )
    {
        $urlMinimizer = $urlMinimizerRepository
            ->findOneBy([
                'minimizedUrl' => $minimizedUrl,
            ]);

        if (!$urlMinimizer) {
            throw $this->createNotFoundException(
                'No record in database'
            );
        }

        return $this->render('url/statistic.html.twig', [
            'urlMinimizer' => $urlMinimizer
        ]);
    }
}
