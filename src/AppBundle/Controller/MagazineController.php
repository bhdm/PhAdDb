<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Magazine;
use AppBundle\Form\MagazineType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class MagazineController
 * @package AppBundle\Controller
 * @Route("/magazine")
 */
class MagazineController extends Controller
{
    /**
     * @Route("/list", name="magazine_list")
     * @Template()
     */
    public function listAction(Request $request)
    {
        if ($request->query->get('search')){
            $items = $this->getDoctrine()->getRepository('AppBundle:Magazine')->search($request->query->get('search'));
        }else{
            $items = $this->getDoctrine()->getRepository('AppBundle:Magazine')->findAll();
        }
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $items,
            $request->query->get('page', 1),
            20
        );
        return array('pagination' => $pagination);
    }

    /**
     * @Route("/add", name="magazine_add")
     * @Template()
     */
    public function addAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $item = new Magazine();
        $form = $this->createForm(MagazineType::class, $item);
        $form->add('submit', SubmitType::class, ['label' => 'Сохранить', 'attr' => ['class' => 'btn-primary']]);
        $formData = $form->handleRequest($request);

        if ($request->getMethod() === 'POST'){
            if ($formData->isValid()){
                $item = $formData->getData();
                $em->persist($item);
                $em->flush();
                return $this->redirect($this->generateUrl('magazine_list'));
            }
        }
        return $this->render('@App/Magazine/form.html.twig',
            array(
                'form' => $form->createView()
            )) ;
    }

    /**
     * @Route("/edit/{id}", name="magazine_edit")
     * @Template()
     */
    public function editAction(Request $request, $id){
        $em = $this->getDoctrine()->getManager();
        $item = $this->getDoctrine()->getRepository('AppBundle:Magazine')->find($id);
        $form = $this->createForm(MagazineType::class, $item);
        $form->add('submit', SubmitType::class, ['label' => 'Сохранить', 'attr' => ['class' => 'btn-primary']]);
        $formData = $form->handleRequest($request);

        if ($request->getMethod() === 'POST'){
            if ($formData->isValid()){
                $item = $formData->getData();
                $em->persist($item);
                $em->flush();
                return $this->redirect($this->generateUrl('magazine_list'));
            }
        }
        return $this->render('@App/Magazine/form.html.twig',
            array(
                'form' => $form->createView()
            )) ;
    }

    /**
     * @Route("/remove/{id}", name="magazine_remove")
     */
    public function removeAction(Request $request, $id){
        $em = $this->getDoctrine()->getManager();
        $item = $em->getRepository('AppBundle:Magazine')->find($id);
        if ($item){
            $em->remove($item);
            $em->flush();
        }
        return $this->redirect($request->headers->get('referer'));
    }

    /**
     * @Route("/api/spread/all", name="api_get_spread", options={"expose" = true})
     */
    public function getSpreadAction(Request $request){
        $title = $request->query->get('title');
        $spreads = $this->getDoctrine()->getRepository('AppBundle:Spread')->findForAutocomplete($title);
        $us = [];
        foreach ($spreads as $spread) {
            $us[] = $spread['title'];
        }
        return new JsonResponse($us);
    }
}
