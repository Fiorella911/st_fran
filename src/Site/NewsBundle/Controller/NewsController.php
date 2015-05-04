<?php

namespace Site\NewsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Knp\Bundle\PaginatorBundle;

class NewsController extends Controller
{
    public function indexAction()
    {
        $em = $this->get('doctrine')->getManager();
        $news = $em->getRepository('SiteNewsBundle:News') -> findBy([], ['id'=>'DESC']);
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate( $news,
                                            $this->get('request') ->query->get('page', 1)/*page number*/,
                                            4/*limit per page*/);
        return $this->render('SiteNewsBundle:News:news.html.twig', ['news' => $pagination]);
    }
    
    public function getCategoryAction()
    {
        $em = $this->get('doctrine')->getManager();
        $category = $em->getRepository('SiteNewsBundle:Categories') -> findAll();
        return $this->render('SiteNewsBundle:News:categoryMenu.html.twig', ['category' => $category]);
    }
   

    public function articleAction($slug)
    {
        $em = $this->get('doctrine')->getManager();
        $article = $em->getRepository('SiteNewsBundle:News') -> findOneBy(['slug' => $slug]);
        //var_dump($article);
        if (is_null($article) || empty($article)) {
            throw $this->createNotFoundException('Запрашиваемая страница перемещена или удалена!');
        } else {
            return $this->render('SiteNewsBundle:News:article.html.twig', ['article' => $article]); 
        }
    }
    
    public function threeLastNewsAction()
    {
        $em = $this->get('doctrine')->getManager();
        $threeLastNews = $em->getRepository('SiteNewsBundle:News')->findBy([], ['id'=>'DESC'], 3);
        
        return $this->render('SiteNewsBundle:News:threeLastNews.html.twig', ['threeLastNews'=>$threeLastNews]);
    } 
        
    
    public function categoryAction($slug)
    {
        $em = $this->get('doctrine')->getManager();
        $category = $em->getRepository('SiteNewsBundle:Categories') -> findOneBy(['slug' => $slug]);
                
        //print_r($category);
        if (is_null($category) || empty($category)) {
            throw $this->createNotFoundException('Запрашиваемая страница перемещена или удалена!');
        } else {
            return $this->render('SiteNewsBundle:News:newsByCategories.html.twig', ['category' => $category]); 
        }
    }
    
    
    public function tagAction($slug)
    {
        $em = $this->get('doctrine')->getManager();
        $tag = $em->getRepository('SiteNewsBundle:Tags') -> findOneBy(['tag' => $slug]);
                
        //print_r($category);
        if (is_null($tag) || empty($tag)) {
            throw $this->createNotFoundException('Запрашиваемая страница перемещена или удалена!');
        } else {
            return $this->render('SiteNewsBundle:News:newsByTags.html.twig', ['tag' => $tag]); 
        }
    }
    
    public function getTagAction()
    {
        $em = $this->get('doctrine')->getManager();
        $tag = $em->getRepository('SiteNewsBundle:Tags') -> findAll();
        return $this->render('SiteNewsBundle:News:tagsMenu.html.twig', ['tag' => $tag]);
    }
    
}
