<?php

namespace Unoegohh\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Unoegohh\AdminBundle\Form\FoodCategoryForm;
use Unoegohh\AdminBundle\Form\PressForm;
use Unoegohh\AdminBundle\Form\SitePrefForm;
use Symfony\Component\HttpFoundation\Request;
use Unoegohh\AdminBundle\Form\StaticPageForm;
use Unoegohh\EntitiesBundle\Entity\FoodCategory;
use Doctrine\ORM;
use Unoegohh\EntitiesBundle\Entity\Press;
use Unoegohh\EntitiesBundle\Entity\StaticPage;

class PressController extends Controller
{
    public function indexAction(Request $request)
    {
        /*
         * @var $em EntityManager
         */
        $em = $this->container->get('doctrine')->getManager();

        $pressRepo = $em->getRepository('UnoegohhEntitiesBundle:Press');

        $data = $pressRepo->findAll();

        return $this->render('UnoegohhAdminBundle:Press:index.html.twig', array('data'=>$data));
    }

    public function createAction(Request $request)
    {
        /*
         * @var $em EntityManager
         */
        $em = $this->container->get('doctrine')->getManager();

        $page = new Press();

        $form = $this->createForm(new PressForm(), $page);

        $form->handleRequest($request);

        if($form->isValid()){
            $page = $form->getData();
            $em->persist($page);
            $em->flush();
            $this->get('session')->getFlashBag()->add(
                'notice',
                'Запись добавлена!'
            );
            return $this->redirect($this->generateUrl('unoegohh_admin_press_edit', array("id" => $page->getId())));
        }
        return $this->render('UnoegohhAdminBundle:Press:create.html.twig', array('form'=>$form->createView()));
    }

    public function editAction(Request $request, Press $id)
    {
        /*
         * @var $em EntityManager
         */
        $em = $this->container->get('doctrine')->getManager();

        if(!$id){
            throw new Exception("3апись не найдена");
        }

        $form = $this->createForm(new PressForm(), $id);

        $form->handleRequest($request);

        if($form->isValid()){
            $id = $form->getData();
            $em->persist($id);
            $em->flush();
            $this->get('session')->getFlashBag()->add(
                'notice',
                'Запись обновлена!'
            );
            return $this->redirect($this->generateUrl('unoegohh_admin_press_edit', array("id" => $id->getId())));

        }
        return $this->render('UnoegohhAdminBundle:Press:edit.html.twig', array('form'=>$form->createView()));
    }

    public function removeAction(Request $request, Press  $id)
    {
        return $this->render('UnoegohhAdminBundle:Press:remove.html.twig', array('page'=>$id));
    }

    public function removeOkAction(Request $request, Press $id)
    {
        /*
         * @var $em EntityManager
         */
        $em = $this->container->get('doctrine')->getManager();
        $em->remove($id);
        $em->flush();
        $this->get('session')->getFlashBag()->add(
            'notice',
            'Запись удалена!'
        );
        return $this->redirect($this->generateUrl('unoegohh_admin_press'));

    }

}
