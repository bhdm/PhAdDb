<?php

namespace AppBundle\Controller;

use AppBundle\Entity\PublishingHouse;
use AppBundle\Form\PublishingHouseType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class FormatController
 * @package AppBundle\Controller
 * @Route("/publishing-house")
 */
class PublishingHouseController extends Controller
{
    /**
     * @Route("/list", name="publishing_house_list")
     * @Template()
     */
    public function listAction(Request $request)
    {
        $items = $this->getDoctrine()->getRepository('AppBundle:PublishingHouse')->findAll();
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $items,
            $request->query->get('page', 1),
            20
        );
        return array('pagination' => $pagination);
    }

    /**
     * @Route("/add", name="publishing_house_add")
     */
    public function addAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $item = new PublishingHouse();
        $form = $this->createForm(PublishingHouseType::class, $item);
        $form->add('submit', SubmitType::class, ['label' => 'Сохранить', 'attr' => ['class' => 'btn-primary']]);
        $formData = $form->handleRequest($request);

        if ($request->getMethod() === 'POST'){
            if ($formData->isValid()){
                $item = $formData->getData();
                $em->persist($item);
                $em->flush();
                return $this->redirect($this->generateUrl('format_list'));
            }
        }
        return $this->render('@App/PublishingHouse/form.html.twig',
            array(
                'form' => $form->createView()
            )) ;
    }

    /**
     * @Route("/edit/{id}", name="publishing_house_edit")
     */
    public function editAction(Request $request, $id){
        $em = $this->getDoctrine()->getManager();
        $item = $this->getDoctrine()->getRepository('AppBundle:PublishingHouse')->find($id);
        $form = $this->createForm(PublishingHouseType::class, $item);
        $form->add('submit', SubmitType::class, ['label' => 'Сохранить', 'attr' => ['class' => 'btn-primary']]);
        $formData = $form->handleRequest($request);

        if ($request->getMethod() === 'POST'){
            if ($formData->isValid()){
                $item = $formData->getData();
                $em->persist($item);
                $em->flush();
                return $this->redirect($this->generateUrl('format_list'));
            }
        }
        return $this->render('@App/PublishingHouse/form.html.twig',
            array(
                'form' => $form->createView()
            )) ;
    }

    /**
     * @Route("/remove/{id}", name="publishing_house_remove")
     */
    public function removeAction(Request $request, $id){
        $em = $this->getDoctrine()->getManager();
        $item = $em->getRepository('AppBundle:PublishingHouse')->find($id);
        if ($item){
            $em->remove($item);
            $em->flush();
        }
        return $this->redirect($request->headers->get('referer'));
    }
}
