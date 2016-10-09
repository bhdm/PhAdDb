<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Price;
use AppBundle\Form\PriceType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class PriceController
 * @package AppBundle\Controller
 * @Route("/price")
 */
class PriceController extends Controller
{
    /**
     * @Route("/list/{id}", name="price_list", defaults={"id" = null})
     * @Template()
     */
    public function listAction(Request $request, $id = null)
    {
        if ($id == null){
            $items = $this->getDoctrine()->getRepository('AppBundle:Price')->findAll();
            $magazine = null;
        }else{
            $magazine = $this->getDoctrine()->getRepository('AppBundle:Magazine')->find($id);
            $items = $this->getDoctrine()->getRepository('AppBundle:Price')->findBy(['magazine' => $magazine]);
        }

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $items,
            $request->query->get('page', 1),
            20
        );
        return array('pagination' => $pagination, 'magazine' => $magazine);
    }

    /**
     * @Route("/add", name="price_add")
     * @Template()
     */
    public function addAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $item = new Price();
        $form = $this->createForm(PriceType::class, $item);
        $form->add('submit', SubmitType::class, ['label' => 'Сохранить', 'attr' => ['class' => 'btn-primary']]);
        $formData = $form->handleRequest($request);

        if ($request->getMethod() === 'POST'){
            if ($formData->isValid()){
                $item = $formData->getData();
                $em->persist($item);
                $em->flush();
                return $this->redirect($this->generateUrl('price_list'));
            }
        }
        return $this->render('@App/Price/form.html.twig',
            array(
                'form' => $form->createView()
            )) ;
    }

    /**
     * @Route("/edit/{id}", name="price_edit")
     * @Template()
     */
    public function editAction(Request $request, $id){
        $em = $this->getDoctrine()->getManager();
        $item = $this->getDoctrine()->getRepository('AppBundle:Price')->find($id);
        $form = $this->createForm(PriceType::class, $item);
        $form->add('submit', SubmitType::class, ['label' => 'Сохранить', 'attr' => ['class' => 'btn-primary']]);
        $formData = $form->handleRequest($request);

        if ($request->getMethod() === 'POST'){
            if ($formData->isValid()){
                $item = $formData->getData();
                $em->persist($item);
                $em->flush();
                return $this->redirect($this->generateUrl('price_list'));
            }
        }
        return $this->render('@App/Price/form.html.twig',
            array(
                'form' => $form->createView()
            )) ;
    }

    /**
     * @Route("/remove/{id}", name="price_remove")
     */
    public function removeAction(Request $request, $id){
        $em = $this->getDoctrine()->getManager();
        $item = $em->getRepository('AppBundle:Price')->find($id);
        if ($item){
            $em->remove($item);
            $em->flush();
        }
        return $this->redirect($request->headers->get('referer'));
    }
}
