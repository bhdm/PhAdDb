<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Mediaplan;
use AppBundle\Form\MediaplanType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

/**
 * Class MediaplanController
 * @package AppBundle\Controller
 * @Route("/mediaplan")
 */
class MediaplanController extends Controller
{
    /**
     * @Route("/list", name="mediaplan_list")
     * @Template()
     */
    public function listAction(Request $request)
    {
        $items = $this->getDoctrine()->getRepository('AppBundle:Mediaplan')->findAll();
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $items,
            $request->query->get('page', 1),
            20
        );
        return array('pagination' => $pagination);
    }

    /**
     * @Route("/add", name="mediaplan_add")
     * @Template()
     */
    public function addAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $item = new Mediaplan();
        $form = $this->createForm(MediaplanType::class, $item);
        $form->add('submit', SubmitType::class, ['label' => 'Сохранить', 'attr' => ['class' => 'btn-primary']]);
        $formData = $form->handleRequest($request);

        if ($request->getMethod() === 'POST'){
            if ($formData->isValid()){
                $item = $formData->getData();
                $em->persist($item);
                $em->flush();
                return $this->redirect($this->generateUrl('mediaplan_list'));
            }
        }
        return $this->render('@App/Mediaplan/form.html.twig',
            array(
                'form' => $form->createView()
            )) ;
    }

    /**
     * @Route("/edit/{id}", name="mediaplan_edit")
     * @Template()
     */
    public function editAction(Request $request, $id){
        $em = $this->getDoctrine()->getManager();
        $item = $this->getDoctrine()->getRepository('AppBundle:Mediaplan')->find($id);
        $form = $this->createForm(MediaplanType::class, $item);
        $form->add('submit', SubmitType::class, ['label' => 'Сохранить', 'attr' => ['class' => 'btn-primary']]);
        $formData = $form->handleRequest($request);

        if ($request->getMethod() === 'POST'){
            if ($formData->isValid()){
                $item = $formData->getData();
                $em->persist($item);
                $em->flush();
                return $this->redirect($this->generateUrl('mediaplan_list'));
            }
        }
        return $this->render('@App/Mediaplan/form.html.twig',
            array(
                'form' => $form->createView()
            )) ;
    }

    /**
     * @Route("/remove/{id}", name="mediaplan_remove")
     */
    public function removeAction(Request $request, $id){
        $em = $this->getDoctrine()->getManager();
        $item = $em->getRepository('AppBundle:Mediaplan')->find($id);
        if ($item){
            $em->remove($item);
            $em->flush();
        }
        return $this->redirect($request->headers->get('referer'));
    }

    /**
     * @Route("/print/{id}", name="mediaplan_print")
     */
    public function printAction($id){
        $plan = $this->getDoctrine()->getRepository('AppBundle:Mediaplan')->find($id);

        $phpExcelObject = $this->get('phpexcel')->createPHPExcelObject();

        $phpExcelObject->getProperties()->setCreator("liuggio")
            ->setLastModifiedBy("Giulio De Donato")
            ->setTitle("Office 2005 XLSX Test Document")
            ->setSubject("Office 2005 XLSX Test Document")
            ->setDescription("Test document for Office 2005 XLSX, generated using PHP classes.")
            ->setKeywords("office 2005 openxml php")
            ->setCategory("Test result file");
        $phpExcelObject->setActiveSheetIndex(0)->setCellValue('A2', 'Клиент: '.$plan->getCompany());


        $phpExcelObject->setActiveSheetIndex(0)->setCellValue('A4', 'Издание');
        $phpExcelObject->setActiveSheetIndex(0)->setCellValue('B4', 'ИД');
        $phpExcelObject->setActiveSheetIndex(0)->setCellValue('C4', 'Тираж');
        $phpExcelObject->setActiveSheetIndex(0)->setCellValue('D4', 'Периодичность');
        $phpExcelObject->setActiveSheetIndex(0)->setCellValue('E4', 'Распространение');
        $phpExcelObject->setActiveSheetIndex(0)->setCellValue('F4', 'Формат издания');
        $phpExcelObject->setActiveSheetIndex(0)->setCellValue('G4', 'Статус ВАК*');
        $phpExcelObject->setActiveSheetIndex(0)->setCellValue('H4', 'Формат');
        $phpExcelObject->setActiveSheetIndex(0)->setCellValue('I4', 'I');
        $phpExcelObject->setActiveSheetIndex(0)->setCellValue('J4', 'II');
        $phpExcelObject->setActiveSheetIndex(0)->setCellValue('K4', 'III');
        $phpExcelObject->setActiveSheetIndex(0)->setCellValue('L4', 'IV');
        $phpExcelObject->setActiveSheetIndex(0)->setCellValue('M4', 'V');
        $phpExcelObject->setActiveSheetIndex(0)->setCellValue('N4', 'VI');
        $phpExcelObject->setActiveSheetIndex(0)->setCellValue('O4', 'VII');
        $phpExcelObject->setActiveSheetIndex(0)->setCellValue('P4', 'VIII');
        $phpExcelObject->setActiveSheetIndex(0)->setCellValue('Q4', 'IX');
        $phpExcelObject->setActiveSheetIndex(0)->setCellValue('R4', 'X');
        $phpExcelObject->setActiveSheetIndex(0)->setCellValue('S4', 'XI');
        $phpExcelObject->setActiveSheetIndex(0)->setCellValue('T4', 'XII');
        $phpExcelObject->setActiveSheetIndex(0)->setCellValue('U4', 'Общее кол-во публикаций');
        $phpExcelObject->setActiveSheetIndex(0)->setCellValue('V4', 'Стоимость размещения, без НДС');
        $phpExcelObject->setActiveSheetIndex(0)->setCellValue('W4', 'Общий бюджет, без НДС');
        $phpExcelObject->setActiveSheetIndex(0)->setCellValue('X4', 'Скидка %');
        $phpExcelObject->setActiveSheetIndex(0)->setCellValue('Y4', 'Бюджет после скидки, без  НДС');
        $phpExcelObject->setActiveSheetIndex(0)->setCellValue('Z4', 'НДС 18%');
        $phpExcelObject->setActiveSheetIndex(0)->setCellValue('AA4', 'Стоимость, включая НДС 18%');
        $phpExcelObject->setActiveSheetIndex(0)->setCellValue('AB4', 'Агентская комиссия (5%), без НДС');
        $phpExcelObject->setActiveSheetIndex(0)->setCellValue('AC4', 'Агентская комиссия, включая НДС 18%');
        $phpExcelObject->setActiveSheetIndex(0)->setCellValue('AD4', 'Бюджет после скидки, включая АК, без НДС');

        $phpExcelObject->setActiveSheetIndex(0)->getStyle('A4:AD4')->applyFromArray(
            array(
                'fill' => array(
                    'type' => \PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => 'CCCCCC')
                )
            )
        );
        $phpExcelObject->getActiveSheet()->getStyle('A4:AD4')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $phpExcelObject->getActiveSheet()->getStyle('A4:AD4')->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);

        $phpExcelObject->getActiveSheet()->getRowDimension('4')->setRowHeight(40);

        $phpExcelObject->getActiveSheet()->getColumnDimension('A')->setWidth(15);
        $phpExcelObject->getActiveSheet()->getColumnDimension('B')->setWidth(15);
        $phpExcelObject->getActiveSheet()->getColumnDimension('C')->setWidth(15);
        $phpExcelObject->getActiveSheet()->getColumnDimension('D')->setWidth(15);
        $phpExcelObject->getActiveSheet()->getColumnDimension('E')->setWidth(15);
        $phpExcelObject->getActiveSheet()->getColumnDimension('F')->setWidth(15);
        $phpExcelObject->getActiveSheet()->getColumnDimension('G')->setWidth(15);
        $phpExcelObject->getActiveSheet()->getColumnDimension('H')->setWidth(15);
        $phpExcelObject->getActiveSheet()->getColumnDimension('I')->setWidth(15);
        $phpExcelObject->getActiveSheet()->getColumnDimension('J')->setWidth(15);
        $phpExcelObject->getActiveSheet()->getColumnDimension('K')->setWidth(15);
        $phpExcelObject->getActiveSheet()->getColumnDimension('L')->setWidth(15);
        $phpExcelObject->getActiveSheet()->getColumnDimension('M')->setWidth(15);
        $phpExcelObject->getActiveSheet()->getColumnDimension('N')->setWidth(15);
        $phpExcelObject->getActiveSheet()->getColumnDimension('O')->setWidth(15);
        $phpExcelObject->getActiveSheet()->getColumnDimension('P')->setWidth(15);
        $phpExcelObject->getActiveSheet()->getColumnDimension('Q')->setWidth(15);
        $phpExcelObject->getActiveSheet()->getColumnDimension('R')->setWidth(15);
        $phpExcelObject->getActiveSheet()->getColumnDimension('S')->setWidth(15);
        $phpExcelObject->getActiveSheet()->getColumnDimension('T')->setWidth(15);
        $phpExcelObject->getActiveSheet()->getColumnDimension('U')->setWidth(15);
        $phpExcelObject->getActiveSheet()->getColumnDimension('V')->setWidth(15);
        $phpExcelObject->getActiveSheet()->getColumnDimension('W')->setWidth(15);
        $phpExcelObject->getActiveSheet()->getColumnDimension('X')->setWidth(15);
        $phpExcelObject->getActiveSheet()->getColumnDimension('Y')->setWidth(15);
        $phpExcelObject->getActiveSheet()->getColumnDimension('Z')->setWidth(15);
        $phpExcelObject->getActiveSheet()->getColumnDimension('AA')->setWidth(15);
        $phpExcelObject->getActiveSheet()->getColumnDimension('AB')->setWidth(15);
        $phpExcelObject->getActiveSheet()->getColumnDimension('AC')->setWidth(15);
        $phpExcelObject->getActiveSheet()->getColumnDimension('AD')->setWidth(15);




        $phpExcelObject->getActiveSheet()->setTitle('Simple');
        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $phpExcelObject->setActiveSheetIndex(0);

        // create the writer
        $writer = $this->get('phpexcel')->createWriter($phpExcelObject, 'Excel5');
        // create the response
        $response = $this->get('phpexcel')->createStreamedResponse($writer);
        // adding headers
        $dispositionHeader = $response->headers->makeDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            'stream-file.xls'
        );
        $response->headers->set('Content-Type', 'text/vnd.ms-excel; charset=utf-8');
        $response->headers->set('Pragma', 'public');
        $response->headers->set('Cache-Control', 'maxage=1');
        $response->headers->set('Content-Disposition', $dispositionHeader);

        return $response;
    }
}
