<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Company;
use AppBundle\Form\CompanyType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class CompanyController
 * @package AppBundle\Controller
 * @Route("/company")
 */
class CompanyController extends Controller
{
    /**
     * @Route("/list", name="company_list")
     * @Template()
     */
    public function listAction(Request $request)
    {
        $items = $this->getDoctrine()->getRepository('AppBundle:Company')->findAll();
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $items,
            $request->query->get('page', 1),
            20
        );
        return array('pagination' => $pagination);
    }

    /**
     * @Route("/add", name="company_add")
     * @Template()
     */
    public function addAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $item = new Company();
        $form = $this->createForm(CompanyType::class, $item);
        $form->add('submit', SubmitType::class, ['label' => 'Сохранить', 'attr' => ['class' => 'btn-primary']]);
        $formData = $form->handleRequest($request);

        if ($request->getMethod() === 'POST'){
            if ($formData->isValid()){
                $item = $formData->getData();
                $item->setUser($this->getUser());
                $em->persist($item);
                $em->flush();
                $this->get('app.email')->send($this->getUser(),'создал', 'компанию '.$item->getTitle());
                return $this->redirect($this->generateUrl('company_list'));
            }
        }
        return $this->render('@App/Company/form.html.twig',
            array(
                'form' => $form->createView()
            )) ;
    }

    /**
     * @Route("/edit/{id}", name="company_edit")
     * @Template()
     */
    public function editAction(Request $request, $id){
        $em = $this->getDoctrine()->getManager();
        $item = $this->getDoctrine()->getRepository('AppBundle:Company')->find($id);
        $form = $this->createForm(CompanyType::class, $item);
        $form->add('submit', SubmitType::class, ['label' => 'Сохранить', 'attr' => ['class' => 'btn-primary']]);
        $formData = $form->handleRequest($request);

        if ($request->getMethod() === 'POST'){
            if ($formData->isValid()){
                $item = $formData->getData();
                $item->setUpdated(new \DateTime());
                $em->persist($item);
                $em->flush();
                $this->get('app.email')->send($this->getUser(),'изменил', 'компанию '.$item->getTitle());
                return $this->redirect($this->generateUrl('company_list'));
            }
        }
        return $this->render('@App/Company/form.html.twig',
            array(
                'form' => $form->createView()
            )) ;
    }

    /**
     * @Route("/remove/{id}", name="company_remove")
     */
    public function removeAction(Request $request, $id){
        $em = $this->getDoctrine()->getManager();
        $item = $this->getDoctrine()->getRepository('AppBundle:Company')->findOneById($id);
        if ($item){
            $this->get('app.email')->send($this->getUser(),'удалил', 'компанию '.$item);
            $em->remove($item);
            $em->flush();
        }
        return $this->redirect($request->headers->get('referer'));
    }
}
