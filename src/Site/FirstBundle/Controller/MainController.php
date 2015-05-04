<?php

namespace Site\FirstBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Site\FirstBundle\Service\Calculator;
use Symfony\Component\HttpFoundation\Request;
use Site\FirstBundle\Entity;



class MainController extends Controller
{
    public function indexAction()
    {
        return $this->render('SiteFirstBundle:Main:main.html.twig');
    }
    
    public function staticPageAction($slug)
    {
        $em = $this->get('doctrine')->getManager();
        $page = $em->getRepository('SiteFirstBundle:StaticPage') -> findBy(['slug' => $slug]);
        //var_dump($page);
        return $this->render('SiteFirstBundle:StaticPages:staticPage.html.twig', ['page' => $page]);
    }
    
    
    public function calculatorAction()
    {
        $calculator = new Calculator;
        $request = Request::createFromGlobals();
        if (!$request->get('ch1') || !$request->get('oper') || !$request->get('ch2')) {
            return $this->render('SiteFirstBundle:Main:calculator.html.twig', ['calc' => null]);
        }
        $calc = $calculator -> myCalc($request->get('ch1'), $request->get('oper'), $request->get('ch2'));
        return $this->render('SiteFirstBundle:Main:calculator.html.twig', ['calc' => $calc]);
    }
    
    public function contactsAction()
    {
       return $this->render('SiteFirstBundle:Main:contacts.html.twig');
    }

}
