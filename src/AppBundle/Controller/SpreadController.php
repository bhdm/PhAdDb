<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Spread;
use AppBundle\Form\SpreadType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class SpreadController
 * @package AppBundle\Controller
 * @Route("/spread")
 */
class SpreadController extends Controller
{
    /**
     * @Route("/list", name="spread_list")
     * @Template()
     */
    public function listAction(Request $request, $id = null)
    {

            $items = $this->getDoctrine()->getRepository('AppBundle:Spread')->findAll();


        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $items,
            $request->query->get('page', 1),
            20
        );

        return array(
            'pagination' => $pagination,
        );
    }

    /**
     * @Route("/add", name="spread_add")
     * @Template()
     */
    public function addAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $item = new Spread();
        $form = $this->createForm(SpreadType::class, $item);
        $form->add('submit', SubmitType::class, ['label' => 'Сохранить', 'attr' => ['class' => 'btn-primary']]);
        $formData = $form->handleRequest($request);

        if ($request->getMethod() === 'POST'){
            if ($formData->isValid()){
                $item = $formData->getData();
                $em->persist($item);
                $em->flush();
                return $this->redirect($this->generateUrl('spread_list'));
            }
        }
        return $this->render('@App/Spread/form.html.twig',
            array(
                'form' => $form->createView()
            )) ;
    }

    /**
     * @Route("/edit/{id}", name="spread_edit")
     * @Template()
     */
    public function editAction(Request $request, $id){
        $em = $this->getDoctrine()->getManager();
        $item = $this->getDoctrine()->getRepository('AppBundle:Spread')->find($id);
        $form = $this->createForm(SpreadType::class, $item);
        $form->add('submit', SubmitType::class, ['label' => 'Сохранить', 'attr' => ['class' => 'btn-primary']]);
        $formData = $form->handleRequest($request);

        if ($request->getMethod() === 'POST'){
            if ($formData->isValid()){
                $item = $formData->getData();
                $em->persist($item);
                $em->flush();
                return $this->redirect($this->generateUrl('spread_list'));
            }
        }
        return $this->render('@App/Spread/form.html.twig',
            array(
                'form' => $form->createView()
            )) ;
    }

    /**
     * @Route("/remove/{id}", name="spread_remove")
     */
    public function removeAction(Request $request, $id){
        $em = $this->getDoctrine()->getManager();
        $item = $em->getRepository('AppBundle:Spread')->find($id);
        if ($item){
            $em->remove($item);
            $em->flush();
        }
        return $this->redirect($request->headers->get('referer'));
    }
}
