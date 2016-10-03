<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Format;
use AppBundle\Form\FormatType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class FormatController
 * @package AppBundle\Controller
 * @Route("/format")
 */
class FormatController extends Controller
{
    /**
     * @Route("/list", name="format_list")
     * @Template()
     */
    public function listAction(Request $request)
    {
        $items = $this->getDoctrine()->getRepository('AppBundle:Format')->findAll();
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $items,
            $request->query->get('page', 1),
            20
        );
        return array('pagination' => $pagination);
    }

    /**
     * @Route("/add", name="format_add")
     * @Template()
     */
    public function addAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $item = new Format();
        $form = $this->createForm(FormatType::class, $item);
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
        return $this->render('@App/Format/form.html.twig',
            array(
                'form' => $form->createView()
            )) ;
    }

    /**
     * @Route("/edit/{id}", name="format_edit")
     * @Template()
     */
    public function editAction(Request $request, $id){
        $em = $this->getDoctrine()->getManager();
        $item = $this->getDoctrine()->getRepository('AppBundle:Format')->find($id);
        $form = $this->createForm(FormatType::class, $item);
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
        return $this->render('@App/Format/form.html.twig',
            array(
                'form' => $form->createView()
            )) ;
    }

    /**
     * @Route("/remove/{id}", name="format_remove")
     */
    public function removeAction(Request $request, $id){
        $em = $this->getDoctrine()->getManager();
        $item = $em->getRepository('AppBundle:Format')->find($id);
        if ($item){
            $em->remove($item);
            $em->flush();
        }
        return $this->redirect($request->headers->get('referer'));
    }
}
