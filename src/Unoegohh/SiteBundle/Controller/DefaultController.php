<?php

namespace Unoegohh\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\DateTime;
use Unoegohh\EntitiesBundle\Entity\Post;

class DefaultController extends Controller
{
    public function indexAction($_locale)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository("UnoegohhEntitiesBundle:Post");
        $posts = $repo->findBy(array(), array('date' => 'DESC'),10);
        return $this->render('UnoegohhSiteBundle:Default:index.html.twig', array('posts' => $posts, "_locale" =>$_locale ));
    }
    public function getMoreAction($_locale,$id)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository("UnoegohhEntitiesBundle:Post");
        $posts = $repo->addPosts($id);
        $output = array();
        foreach($posts as $post){
            $output[] = $this->renderView("UnoegohhSiteBundle:Default:postItem.html.twig", array('post' => $post, '_locale' => $_locale));
        }
        return new JsonResponse(array('items' => $output));
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
    public function archiveAction(Request $request, $_locale)
    {

        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository("UnoegohhEntitiesBundle:Post");
        $now =  new \DateTime('now');
        $to = new \DateTime('now');
        $now->modify("-1 month");
        $from = new \DateTime($now->format('y-m' . '-01'));

        $from->setTime(0, 0);
        if($request->query->get('from')){
            $from = new \DateTime($request->query->get('from'));
            $to = new \DateTime($request->query->get('to'));
        }
        /* @var $post Post */
        $posts = $repo->getPostsBetweenDates($from,$to);
        $result = array();
        foreach($posts as $post){
            $item = array();
            $name = $post->getDate()->format("m");
            if(!isset($result[$name])){
                $result[$name] = array();
                $result[$name]['posts'] = array();
                $result[$name]['date'] = $post->getDate();
            }
            $result[$name]['posts'][] =  $post;
            
        }

        return $this->render('UnoegohhSiteBundle:Default:archive.html.twig', array(
            'posts' => $result,
            '_locale' => $_locale
        ));
    }

    public function getMoreArchiveAction($_locale,$id)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository("UnoegohhEntitiesBundle:Post");
        $maxDate = new \DateTime("@$id");

        $minDate =  new \DateTime("@$id");
        $minDate = $minDate->modify('-1 months');
        $minDate->setTime(0, 0);
        $posts = $repo->getPostsBetweenDates($minDate,$maxDate);
        $result = array();
        foreach($posts as $post){
            if(!isset($result['posts'])){
                $result = array();
                $result['posts'] = array();
                $result['date'] = $post->getDate();
            }
            $result['posts'][] =  $post;
        }
        $result = $this->renderView("UnoegohhSiteBundle:Default:archiveMonth.html.twig", array('cat' => $result, '_locale' => $_locale));

        return new JsonResponse(array('result' => $result));
    }

    public function pressAction($_locale)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository("UnoegohhEntitiesBundle:Press");
        return $this->render('UnoegohhSiteBundle:Default:press.html.twig', array('data' => $repo->findAll(), "_locale" =>$_locale ));
    }

    public function contactsAction($_locale)
    {
        return $this->render('UnoegohhSiteBundle:Default:contacts.html.twig', array( "_locale" =>$_locale ));
    }
    public function redirectAction()
    {
        return $this->redirect($this->generateUrl('unoegohh_site_homepage', array('_locale' => 'ru')));
    }
}
