<?php

namespace Unoegohh\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Unoegohh\AdminBundle\Form\FoodCategoryForm;
use Unoegohh\AdminBundle\Form\MenuItemForm;
use Unoegohh\AdminBundle\Form\SitePrefForm;
use Symfony\Component\HttpFoundation\Request;
use Unoegohh\AdminBundle\vkapi;
use Unoegohh\EntitiesBundle\Entity\FoodCategory;
use Doctrine\ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Unoegohh\EntitiesBundle\Entity\MenuItem;
use Unoegohh\EntitiesBundle\Entity\Post;
use Unoegohh\SiteBundle\ThumblrClient;

class PostController extends Controller
{
    public function indexAction(Request $request)
    {
        /*
         * @var $em EntityManager
         */
        $em = $this->container->get('doctrine')->getManager();

        $menuRepo = $em->getRepository('UnoegohhEntitiesBundle:Post');

        $menu = $menuRepo->findBy(array(), array('id' => 'DESC'));

        return $this->render('UnoegohhAdminBundle:Post:index.html.twig', array('data'=>$menu));
    }

    public function createAction(Request $request)
    {
        /*
         * @var $em EntityManager
         */
        $em = $this->container->get('doctrine')->getManager();

        $data = array();
        $form = $this->createFormBuilder($data)
            ->add('file')
            ->add('descr','textarea')
            ->add('descr_eng','textarea')
        ->getForm();

        $form->handleRequest($request);


        if($form->isValid()){


            $data = $form->getData();
            $prefRepo = $em->getRepository('UnoegohhEntitiesBundle:SitePref');

            $pref = $prefRepo->findOneBy(array(), array(), 1);
            $params = array("source" => $data['file'], "type" => "photo", 'caption' => $data['descr_eng'] . $pref->getTumblrDelimeter() . $data['descr']);
           // var_dump($params);die;

            $clientClass = new ThumblrClient($pref);
            $client = $clientClass->GetClient();
            $responce = $client->createPost($pref->getTumblrBlogName(), $params );
            $post = $client->getBlogPosts($pref->getTumblrBlogName(), array('id' =>$responce->id ));
            $item = new Post();
            $item->convertFromTumblr($post->posts[0], $pref);

            $api_id = ' id application '; // Insert here id of your application
            $vk_id = '4457036'; // Insert here you vk id
            //$vkClient = new vkapi(4457036, $vk_id);
            $em->persist($item);
            $em->flush();
            $this->get('session')->getFlashBag()->add(
                'notice',
                'Пост добавлен!'
            );
            return $this->redirect($this->generateUrl('unoegohh_admin_posts_edit', array("id" => $item->getId())));
        }
        return $this->render('UnoegohhAdminBundle:Post:create.html.twig', array('form'=>$form->createView()));
    }

    public function editAction(Request $request,Post $id)
    {
        /*
         * @var $em EntityManager
         */
        $em = $this->container->get('doctrine')->getManager();

        $data = array(
            'file' => $id->getPhoto(),
            'descr' => $id->getDescr(),
            'descr_eng' => $id->getDescrEng()
        );
        $form = $this->createFormBuilder($data)
            ->add('file')
            ->add('descr','textarea')
            ->add('descr_eng','textarea')
            ->getForm();

        $form->handleRequest($request);

        if($form->isValid()){$data = $form->getData();
            $prefRepo = $em->getRepository('UnoegohhEntitiesBundle:SitePref');

            $pref = $prefRepo->findOneBy(array(), array(), 1);
            $params = array("type" => "photo", 'caption' => $data['descr_eng'] . $pref->getTumblrDelimeter() . $data['descr']);
            // var_dump($params);die;

            if($id->getPhoto() != $data['file']){
                $params['source'] = $data['file'];
            }

            //var_dump($pref);die;
            $clientClass = new ThumblrClient($pref);
            $client = $clientClass->GetClient();
            $responce = $client->editPost($pref->getTumblrBlogName(),$id->getTId(), $params );
            //var_dump($responce);die;
            $post = $client->getBlogPosts($pref->getTumblrBlogName(), array('id' =>$responce->id ));
            $id->convertFromTumblr($post->posts[0], $pref);
            $em->persist($id);
            $em->flush();
            $this->get('session')->getFlashBag()->add(
                'notice',
                'Пост обновлен!'
            );
            return $this->redirect($this->generateUrl('unoegohh_admin_posts_edit', array("id" => $id->getId())));


        }
        return $this->render('UnoegohhAdminBundle:Post:edit.html.twig', array('form'=>$form->createView()));
    }

    public function removeAction(Request $request, Post $id)
    {

        return $this->render('UnoegohhAdminBundle:Post:remove.html.twig', array('item'=>$id));
    }

    public function removeOkAction(Request $request,Post  $id)
    {
        /*
         * @var $em EntityManager
         */
        $em = $this->container->get('doctrine')->getManager();

        $prefRepo = $em->getRepository('UnoegohhEntitiesBundle:SitePref');

        $pref = $prefRepo->findOneBy(array(), array(), 1);
        $clientClass = new ThumblrClient($pref);
        $client = $clientClass->GetClient();
        $resu = $client->deletePost($pref->getTumblrBlogName(), $id->getTId(),$id->getReblog());
        $em->remove($id);
        $em->flush();
        $this->get('session')->getFlashBag()->add(
            'notice',
            'Пост удален!'
        );
        return $this->redirect($this->generateUrl('unoegohh_admin_posts'));

    }
}
