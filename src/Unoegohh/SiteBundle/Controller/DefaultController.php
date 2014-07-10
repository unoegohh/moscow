<?php

namespace Unoegohh\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;

class DefaultController extends Controller
{
    public function indexAction($_locale)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository("UnoegohhEntitiesBundle:Post");
        $posts = $repo->findBy(array(), array('date' => 'DESC'));
        return $this->render('UnoegohhSiteBundle:Default:index.html.twig', array('posts' => $posts, "_locale" =>$_locale ));
    }
    public function menuAction($_locale)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository("UnoegohhEntitiesBundle:MenuItem");
        $posts = $repo->findBy(array(), array('orderNum' => 'ASC'));
        return $this->render('UnoegohhSiteBundle:Default:menu.html.twig', array('data' => $posts, "_locale" =>$_locale ));
    }
    public function aboutAction($_locale)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository("UnoegohhEntitiesBundle:StaticPage");
        $page = $repo->findOneBy(array('url' => 'about'));
        if(!$page){
            throw new Exception("Cтраница не найдена");
        }
        return $this->render('UnoegohhSiteBundle:Default:about.html.twig', array('page' => $page, "_locale" =>$_locale ));
    }
    public function pressAction($_locale)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository("UnoegohhEntitiesBundle:Press");
        return $this->render('UnoegohhSiteBundle:Default:press.html.twig', array('data' => $repo->findAll(), "_locale" =>$_locale ));
    }
    public function redirectAction()
    {
        return $this->redirect($this->generateUrl('unoegohh_site_homepage', array('_locale' => 'ru')));
    }
}
