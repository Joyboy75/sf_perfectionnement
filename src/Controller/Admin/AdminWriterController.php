<?php

namespace App\Controller\Admin;

use App\Entity\Writer;
use App\Form\WriterType;
use Symfony\Component\Mime\Email;
use App\Repository\WriterRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\MailerInterface;

class AdminWriterController extends AbstractController
{
    
    public function adminListWriter(WriterRepository $writerRepository)
    {
        $writers = $writerRepository->findAll();

        return $this->render("admin/writers.html.twig", ['writers' => $writers]);
    }

    
    public function adminShowWriter($id, WriterRepository $writerRepository)
    {
        $writer = $writerRepository->find($id);

        return $this->render("admin/writer.html.twig", ['writer' => $writer]);
    }

    
    public function adminUpdateWriter(
        $id,
        WriterRepository $writerRepository,
        Request $request,
        EntityManagerInterface $entityManagerInterface
    ) {

        $writer = $writerRepository->find($id);

        $writerForm = $this->createForm(WriterType::class, $writer);

        $writerForm->handleRequest($request);

        if ($writerForm->isSubmitted() && $writerForm->isValid()) {

            $entityManagerInterface->persist($writer);
            $entityManagerInterface->flush();

            return $this->redirectToRoute("admin_writer_list");
        }


        return $this->render("admin/writerform.html.twig", ['writerForm' => $writerForm->createView()]);
    }

    
    public function adminCreateWriter(
        Request $request,
        EntityManagerInterface $entityManagerInterface,
        MailerInterface $mailerInterface
    ) {
        $writer = new Writer();

        $writerForm = $this->createForm(WriterType::class, $writer);

        $writerForm->handleRequest($request);

        if ($writerForm->isSubmitted() && $writerForm->isValid()) {


            $entityManagerInterface->persist($writer);
            $entityManagerInterface->flush();

            $email = (new Email())
                    ->from('test@test.com')
                    ->to('test@test.fr')
                    ->subject('Création d\'un auteur')
                    ->html('<p> Vous êtes un nouvel auteur sur le projet </p>');


                $mailerInterface->send($email);

            return $this->redirectToRoute("admin_writer_list");
        }


        return $this->render("admin/writerform.html.twig", ['writerForm' => $writerForm->createView()]);
    }

    
    public function adminDeleteWriter(
        $id,
        WriterRepository $writerRepository,
        EntityManagerInterface $entityManagerInterface
    ) {

        $writer = $writerRepository->find($id);

        $entityManagerInterface->remove($writer);

        $entityManagerInterface->flush();

        return $this->redirectToRoute("admin_writer_list");
    }

    
    public function adminSearch(Request $request, WriterRepository $writerRepository)
    {

        // Récupérer les données rentrées dans le formulaire
        $term = $request->query->get('term');
        // query correspond à l'outil qui permet de récupérer les données d'un formulaire en get
        // pour un formulaire en post on utilise query

        $writers = $writerRepository->searchByTerm($term);

        if($term){
        return $this->render('admin/search.html.twig', ['writers' => $writers, 'term' => $term]);

    }
    }
}