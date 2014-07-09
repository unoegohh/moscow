<?php

namespace Unoegohh\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($_locale)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository("UnoegohhEntitiesBundle:Post");
        $posts = $repo->findBy(array(), array('id' => 'DESC'));
        return $this->render('UnoegohhSiteBundle:Default:index.html.twig', array('posts' => $posts, "_locale" =>$_locale ));
    }
    public function redirectAction()
    {
        return $this->redirect($this->generateUrl('unoegohh_site_homepage', array('_locale' => 'ru')));
    }
}
