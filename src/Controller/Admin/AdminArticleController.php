<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class AdminArticleController extends AbstractController{

    /**
     * @Route("admin/articles", name="admin_article_list")
     */
    public function adminArticleList(ArticleRepository $articleRepository){

        $articles = $articleRepository->findAll();
    
            return $this->render("admin/articles.html.twig", ['articles' => $articles]);
        }
    
         /**
         * @Route("admin/article/{id}", name="admin_article_show")
         */
        public function adminArticleShow($id,ArticleRepository $articleRepository){
    
            $article = $articleRepository->find($id);
        
                return $this->render("admin/article.html.twig", ['article' => $article]);
            }

            /**
     * @Route("admin/create/article/", name="admin_create_article")
     */
    public function adminCategoryCreate(Request $request, EntityManagerInterface $entityManagerInterface){
        $article = new Article();

        $articleForm = $this->createForm(ArticleType::class, $article);

        $articleForm->handleRequest($request);

        if($articleForm->isSubmitted() && $articleForm->isValid()){
            $entityManagerInterface->persist($article);
            $entityManagerInterface->flush();
            
            $this->addFlash(
                'notice',
                'Un article a été créé'
            );

            return $this->redirectToRoute('admin_article_list');
        }

        return $this->render('admin/articleform.html.twig', [ 'articleForm' => $articleForm->createView()]);
    
    }

     /**
      * @Route("admin/update/article/{id}", name="admin_update_article")
      */
      public function adminarticleUpdate(
        $id,
         ArticleRepository $articleRepository,
         Request $request, // class permettant d'utiliser le formulaire de récupérer les information 
         EntityManagerInterface $entityManagerInterface // class permettantd'enregistrer ds la bdd
         ){
             $article = $articleRepository->find($id);

             // Création du formulaire
          $articleForm = $this->createForm(ArticleType::class, $article);

          // Utilisation de handleRequest pour demander au formulaire de traiter les informations
      // rentrées dans le formulaire
      // Utilisation de request pour récupérer les informations rentrées dans le formualire
          $articleForm->handleRequest($request);


          if($articleForm->isSubmitted() && $articleForm->isValid())
          {   
              // persist prépare l'enregistrement ds la bdd analyse le changement à faire
              $entityManagerInterface->persist($article);
              $id = $articleRepository->find($id);

              // flush enregistre dans la bdd
              $entityManagerInterface->flush();

              $this->addFlash(
                'notice',
                'Le article a bien été modifié !'
            );

              return $this->redirectToRoute('admin_article_list');

          }

          return $this->render('admin/articleform.html.twig', ['articleForm'=> $articleForm->createView()]);
    }

    /**
     * @Route("admin/delete/article/{id}", name="admin_delete_article")
     */
    public function adminArticleDelete(
        $id,
        ArticleRepository $articleRepository,
        EntityManagerInterface $entityManagerInterface
        ){

            $article = $articleRepository->find($id);

            //remove supprime le article et flush enregistre ds la bdd
            $entityManagerInterface->remove($article);
            $entityManagerInterface->flush();

            $this->addFlash(
                'notice',
                'Votre article a bien été supprimé'
            );

            return $this->redirectToRoute('admin_article_list');

    }
}


