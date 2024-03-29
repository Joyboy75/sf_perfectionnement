<?php

namespace App\Controller\Front;

use App\Repository\WriterRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WriterController extends AbstractController
{
    /**
     * @Route("/writer", name="writer")
     */
    // public function index(): Response
    // {
    //     return $this->render('writer/index.html.twig', [
    //         'controller_name' => 'WriterController',
    //     ]);
    // }


    
    public function listWriter(WriterRepository $writerRepository)
    {
        $writers = $writerRepository->findAll();

        return $this->render("front/writers.html.twig", ['writers' => $writers]);
    }

    
    public function showWriter($id, WriterRepository $writerRepository)
    {
        $writer = $writerRepository->find($id);

        return $this->render("front/writer.html.twig", ['writer' => $writer]);
    }
}
