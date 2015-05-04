<?php

namespace Site\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Knp\Bundle\PaginatorBundle;
use Site\BlogBundle\Entity\Comments;
use Site\BlogBundle\Entity\Blog;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use \Datetime;
use \DateTimeZone;
use Doctrine\DBAL\Types;
use Bundles\UserBundle\Entity;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;



class BlogController extends Controller
{
    
    
    public function indexAction($slug)
    {
        $em = $this->get('doctrine')->getManager();
        $blogPost = $em->getRepository('SiteBlogBundle:Blog') -> findAll();
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate( $blogPost,
                                            $this->get('request') ->query->get('page', 1)/*page number*/,
                                            4/*limit per page*/);
      
        //$pag = $pagination->getPaginationData();
        //print_r($pag);
        if ($slug !== 'blog2') {
            return $this->render('SiteBlogBundle:Blog:blog.html.twig', ['blogPost' => $pagination, 'blogPagination' => $pagination]);
        } 
        return $this->render('SiteBlogBundle:Blog:blog2.html.twig', ['blogPost' => $pagination, 'blogPagination' => $pagination]);
        
    }
    
    
    public function singlePostAction($slug)
    {      
        $em = $this->get('doctrine')->getManager();
        $singlePost = $em->getRepository('SiteBlogBundle:Blog')->findOneBy(['slug' => $slug]);
                         
        return $this->render('SiteBlogBundle:Blog:singlePost.html.twig', ['singlePost' => $singlePost]);
     
    }

        
    public function postCommentAction($slug)
    {      
        $em = $this->get('doctrine')->getManager();

        $postComments = $em->getRepository('SiteBlogBundle:Blog')->findOneBy(['slug' => $slug]);
        $userBlogId = $postComments->getId();
        //var_dump($userBlogId);
        $comments = $em->getRepository('SiteBlogBundle:Comments')->findBy(['blog' => $userBlogId]);
           
        return $this->render('SiteBlogBundle:Blog:postComment.html.twig', ['comments' => $comments]);
     
    }
    
    public function userAction($slug)
    {
        $em = $this->get('doctrine')->getManager();
        $user = $em->getRepository('BundlesUserBundle:User') -> findOneBy(['id' => $slug]);
        
        return $this->render('SiteBlogBundle:User:user.html.twig', ['user' => $user]);
    }
        
    public function userAllPostsAction($slug)
    {
        $em = $this->get('doctrine')->getManager();
        $userPosts = $em->getRepository('SiteBlogBundle:Blog') -> findBy(['user' => $slug]);
                
        return $this->render('SiteBlogBundle:User:userAllPosts2.html.twig', ['userPosts' => $userPosts]);
    }
    
    
    public function popularPostsAction()
    {
        $em = $this->get('doctrine')->getManager();
        $popularPosts = $em->getRepository('SiteBlogBundle:Blog')->findBy([], ['id'=>'DESC'], 3);
        
        return $this->render('SiteBlogBundle:Blog:popularPosts.html.twig', ['popularPosts'=>$popularPosts]);
    } 
    
    public function recentCommentsAction()
    {
        $em = $this->get('doctrine')->getManager();
        $recentComments = $em->getRepository('SiteBlogBundle:Comments')->findBy([], ['id'=>'DESC'], 3);
        
        return $this->render('SiteBlogBundle:Blog:recentComments.html.twig', ['recentComments'=>$recentComments]);
    } 
    
    public function setPostCommentAction($blog)
    {   
        $request = Request::createFromGlobals();
        $comment = new Comments;
        if (!$request->get('userComment')) {
            return $this->render('SiteBlogBundle:Blog:setPostComment.html.twig');
        }
             
        $datetime = new \DateTime('now');
        
        $em = $this->get('doctrine')->getManager();
        $userName = $this->get('security.context')->getToken()->getUser();
        $blog = $em->getRepository('SiteBlogBundle:Blog') -> findOneBy(['id' => $blog]); 
        
        $comment->setUser($userName); 
        $comment->setComment($request->get('userComment'));
        $comment->setDatetime($datetime);
        $comment->setBlog($blog);
              
        $em->persist($comment);
        $em->flush();
        
        return $this->render('SiteBlogBundle:Blog:setPostComment.html.twig');
    }
    
    
    public function setPostAction()
    {   
        $request = Request::createFromGlobals();
        $post = new Blog;
        if (!$request->get('title') || !$request->get('content') || $request->get('slug')) {
            return $this->render('SiteBlogBundle:Blog:setPost.html.twig');
        }
     
        
        $datetime = new \Datetime('now');
        
        $em = $this->get('doctrine')->getManager();
        $userId = $this->get('security.context')->getToken()->getUser()->getId(); 
        $slug = $request->get('slug');
        
        $post->setTitle($request->get('title')); 
        $post->setContent($request->get('content'));
        $post->setDate($datetime);
        $post->setSlug($request->get('slug'));
        $post->setUser($userId);
              
        $em->persist($post);
        $em->flush();
        
        //return $this->render('SiteBlogBundle:Blog:singlePost.html.twig');
        return $this->redirectToRoute('site_blog_singlePost', ['slug' => $slug]);
    }

}