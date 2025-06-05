<?php

namespace App\Controller;

use App\Entity\JobApplication;
use App\Repository\JobRepository;
use App\Repository\JobCategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class JobController extends AbstractController
{
    #[Route('/jobs', name: 'app_jobs')]
    public function index(
        Request $request,
        JobRepository $jobRepository,
        JobCategoryRepository $categoryRepository
    ): Response {
        $page = $request->query->getInt('page', 1);
        $category = $request->query->get('category');
        $country = $request->query->get('country');

        $jobs = $jobRepository->findByFilters($category, $country, $page);
        $categories = $categoryRepository->findAll();
        $countries = $jobRepository->findAllCountries();

        return $this->render('job/index.html.twig', [
            'jobs' => $jobs,
            'categories' => $categories,
            'countries' => $countries,
            'current_category' => $category,
            'current_country' => $country,
        ]);
    }

    #[Route('/jobs/{id}', name: 'app_job_show')]
    public function show(int $id, JobRepository $jobRepository): Response
    {
        $job = $jobRepository->find($id);

        if (!$job) {
            throw $this->createNotFoundException('L\'offre demandée n\'existe pas.');
        }

        return $this->render('job/show.html.twig', [
            'job' => $job
        ]);
    }

    #[Route('/jobs/{id}/apply', name: 'app_job_apply', methods: ['POST'])]
    #[IsGranted('ROLE_USER')]
    public function apply(
        int $id,
        Request $request,
        JobRepository $jobRepository,
        EntityManagerInterface $entityManager
    ): Response {
        $job = $jobRepository->find($id);

        if (!$job) {
            throw $this->createNotFoundException('L\'offre demandée n\'existe pas.');
        }

        $coverLetter = $request->request->get('coverLetter');

        if (!$coverLetter) {
            $this->addFlash('error', 'La lettre de motivation est requise.');
            return $this->redirectToRoute('app_job_show', ['id' => $id]);
        }

        $application = new JobApplication();
        $application->setJob($job);
        $application->setUser($this->getUser());
        $application->setCoverLetter($coverLetter);
        $application->setCreateAt(new \DateTimeImmutable());

        $entityManager->persist($application);
        $entityManager->flush();

        $this->addFlash('success', 'Votre candidature a été envoyée avec succès !');

        return $this->redirectToRoute('app_job_show', ['id' => $id]);
    }
} 