<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Magazine;
use AppBundle\Entity\Spread;
use AppBundle\Form\MagazineType;
use Doctrine\Common\Collections\ArrayCollection;
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
        $nosologies = $this->getDoctrine()->getRepository('AppBundle:Nosology')->findBy([],['title' => 'ASC']);
        $activeNosology = $request->query->get('nosology');

        if ($request->query->get('search') || $activeNosology){
            $items = $this->getDoctrine()->getRepository('AppBundle:Magazine')->search($request->query->get('search'), $activeNosology);
        }else{
            $items = $this->getDoctrine()->getRepository('AppBundle:Magazine')->findAll();
        }
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $items,
            $request->query->get('page', 1),
            20
        );

        return array('pagination' => $pagination, 'nosologies' => $nosologies, 'activeNosology'=> $activeNosology);
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
                $em->flush($item);
                $em->refresh($item);
                $spreads = $request->request->get('spread');
                if ($spreads == null){
                    $spreads = array();
                }
                foreach ($spreads as $s){
                    $spread = $this->getDoctrine()->getRepository('AppBundle:Spread')->findOneByTitle($s);
                    if ($spread == null){
                        $spread = new Spread();
                        $spread->setTitle($s);
                        $em->persist($spread);
                        $em->flush($spread);
                        $em->refresh($spread);

                    }
                    $item->addSpread($spread);
                }
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
                $spreads = $request->request->get('spread');
                if ($spreads == null){
                    $spreads = array();
                }
                foreach ($item->getSpread() as $s){
                    $item->removeSpread($s);
                }
                $em->flush();
                foreach ($spreads as $s){
                    $spread = $this->getDoctrine()->getRepository('AppBundle:Spread')->findOneByTitle($s);
                    if ($spread == null){
                        $spread = new Spread();
                        $spread->setTitle($s);
                        $em->persist($spread);
                        $em->flush($spread);
                        $em->refresh($spread);
                    }
                    $item->getSpread()->add($spread);
                }
                $em->flush($item);
                $em->refresh($item);
                return $this->redirect($this->generateUrl('magazine_list'));
            }
        }
        return $this->render('@App/Magazine/form.html.twig',
            array(
                'form' => $form->createView(),
                'spreads' => $item->getSpread()
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
