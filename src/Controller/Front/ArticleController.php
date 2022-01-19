<?php

namespace App\Controller\Front;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{

    
    public function listArticle(ArticleRepository $articleRepository)
    {
        $articles = $articleRepository->findAll();

        return $this->render("front/articles.html.twig", ['articles' => $articles]);
    }

    
    public function showArticle($id, ArticleRepository $articleRepository)
    {
        $article = $articleRepository->find($id);

        return $this->render("front/article.html.twig", ['article' => $article]);
    }

    /**
     * @Route("search", name="front_search")
     */
    public function frontSearch(Request $request, ArticleRepository $articleRepository)
    {

        // Récupérer les données rentrées dans le formulaire
        $term = $request->query->get('term');
        // query correspond à l'outil qui permet de récupérer les données d'un formulaire en get
        // Pour un formulaire en get on utilise query
        // Pour un formulaire en post on utilise request

        $articles = $articleRepository->searchByTerm($term);

        if($term){
            
        return $this->render('front/search.html.twig', ['articles' => $articles, 'term' => $term]);
    }
}
}