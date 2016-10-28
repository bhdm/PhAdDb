<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\Type\RegistrationFormType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class UserController
 * @package AppBundle\Controller
 * @Route("/user")
 */
class UserController extends Controller
{
    /**
     * @Route("/list", name="user_list")
     * @Template()
     */
    public function listAction(Request $request)
    {
        $role = $request->query->get('role');
        $text = $request->query->get('s-text');
        $items = $this->getDoctrine()->getRepository('AppBundle:User')->filter($role, $text);
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $items,
            $request->query->get('page', 1),
            20
        );
        return array('pagination' => $pagination);
    }

    /**
     * @Route("/add", name="user_add")
     * @Template()
     */
    public function addAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $item = new User();
        $form = $this->createForm(RegistrationFormType::class, $item);
        $form->add('submit', SubmitType::class, ['label' => 'Сохранить', 'attr' => ['class' => 'btn-primary']]);
        $formData = $form->handleRequest($request);

        if ($request->getMethod() === 'POST'){
            if ($formData->isValid()){
                $item = $formData->getData();
                $item->setUsername($item->getEmail());

                $password = $this->get('security.password_encoder')->encodePassword($item, $item->getPassword());
                $item->setPassword($password);

                if ($request->request->get('admin') == 1){
                    $item->setRoles(array('ROLE_USER','ROLE_ADMIN'));
                }else{
                    $item->setRoles(array('ROLE_USER'));
                }

                $em->persist($item);
                $em->flush();
                return $this->redirect($this->generateUrl('user_list'));
            }
        }
        return $this->render('@App/User/form.html.twig',
            array(
                'form' => $form->createView(),
                'isadmin' => null
            )) ;
    }

    /**
     * @Route("/edit/{id}", name="user_edit")
     * @Template()
     */
    public function editAction(Request $request, $id){
        $em = $this->getDoctrine()->getManager();
        $item = $this->getDoctrine()->getRepository('AppBundle:User')->find($id);
        $form = $this->createForm(RegistrationFormType::class, $item);
        $form->add('submit', SubmitType::class, ['label' => 'Сохранить', 'attr' => ['class' => 'btn-primary']]);
        $formData = $form->handleRequest($request);

        if ($request->getMethod() === 'POST'){
            if ($formData->isValid()){
                $item = $formData->getData();
                if ($request->request->get('admin') == 1){
                    $item->setRoles(['ROLE_USER','ROLE_ADMIN']);
                }else{
                    $item->setRoles(['ROLE_USER']);
                }
                $em->persist($item);
                $em->flush();
                return $this->redirect($this->generateUrl('user_list'));
            }
        }
        return $this->render('@App/User/form.html.twig',
            array(
                'form' => $form->createView(),
                'isadmin' => $item->isAdmin()
            )) ;
    }

    /**
     * @Route("/remove/{id}", name="user_remove")
     */
    public function removeAction(Request $request, $id){
        $em = $this->getDoctrine()->getManager();
        $item = $em->getRepository('AppBundle:User')->find($id);
        if ($item){
            $em->remove($item);
            $em->flush();
        }
        return $this->redirect($request->headers->get('referer'));
    }
}
