<?php

namespace Bundles\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form;


class UserProfileController extends Controller
{
    public function showProfileAction()
    {
        $user = $this->get('security.context')->getToken()->getUser();
        
        return $this->render('BundlesUserBundle:UserProfile:userProfile.html.twig', ['user' => $user]);
    }
    
    
//    public function editProfileAction()
//    {
//        $request = Request::createFromGlobals();
//        $editUserProfile = new User;
////        if (!$request->get('userComment')) {
////            return $this->render('SiteBlogBundle:Blog:setPostComment.html.twig');
////        }
//                
//        //$datetime = new \DateTime('now');
//        
//        $em = $this->get('doctrine')->getManager();
//        $user = $this->get('security.context')->getToken()->getUser();
////        $userId = $user->getID();
////        $userProfile = $em->getRepository('BundlesUserBundle:User') -> findOneBy(['id' => $userId]); 
//        
//        $editUserProfile->setUserName($request->get('userName')); 
//        $editUserProfile->setFirstName($request->get('userFirstName'));
//        $editUserProfile->setLastName($request->get('userLastName'));
//        $editUserProfile->setEmail($request->get('userEmail'));
//        //$editUserProfile->setDatetime($datetime);
//        //$editUserProfile->setBlog($blog);
//              
//        $em->persist($editUserProfile);
//        $em->flush();
//     
//        
//        return $this->render('BundlesUserBundle:UserProfile:editProfile.html.twig', ['user' => $user]);
//    }

    
    
    
    public function profileAction()
    {
        
        $em = $this->getDoctrine()->getEntityManager();

        $user = $this->get('security.context')->getToken()->getUser();
        $entity = $em->getRepository('BundlesUserBundle:User')->find($user->id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        $form = $this->createForm(new ProfileType(), $entity);

        $request = $this->getRequest();

        if ($request->getMethod() === 'POST')
        {
            $form->bindRequest($request);

            if ($form->isValid()) {
                $em->persist($entity);
                $em->flush();

                return $this->redirect($this->generateUrl('profile'));
            }

            $em->refresh($user); // Add this line
        }

        return $this->render('BundlesUserBundle:User:profile.html.twig', array(
            'entity'      => $entity,
            'form'   => $form->createView(),
        ));
    }

    
    
    
}