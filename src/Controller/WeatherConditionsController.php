<?php

namespace App\Controller;

use App\Entity\WeatherConditions;
use App\Form\WeatherConditionsType;
use App\Repository\WeatherConditionsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/weather/conditions')]
final class WeatherConditionsController extends AbstractController
{
    #[Route(name: 'app_weather_conditions_index', methods: ['GET'])]
    public function index(WeatherConditionsRepository $weatherConditionsRepository): Response
    {
        return $this->render('weather_conditions/index.html.twig', [
            'weather_conditions' => $weatherConditionsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_weather_conditions_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $weatherCondition = new WeatherConditions();
        $form = $this->createForm(WeatherConditionsType::class, $weatherCondition, [
            'validation_groups'=>'create',
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($weatherCondition);
            $entityManager->flush();

            return $this->redirectToRoute('app_weather_conditions_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('weather_conditions/new.html.twig', [
            'weather_condition' => $weatherCondition,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_weather_conditions_show', methods: ['GET'])]
    public function show(WeatherConditions $weatherCondition): Response
    {
        return $this->render('weather_conditions/show.html.twig', [
            'weather_condition' => $weatherCondition,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_weather_conditions_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, WeatherConditions $weatherCondition, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(WeatherConditionsType::class, $weatherCondition);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_weather_conditions_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('weather_conditions/edit.html.twig', [
            'weather_condition' => $weatherCondition,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_weather_conditions_delete', methods: ['POST'])]
    public function delete(Request $request, WeatherConditions $weatherCondition, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$weatherCondition->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($weatherCondition);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_weather_conditions_index', [], Response::HTTP_SEE_OTHER);
    }
}
