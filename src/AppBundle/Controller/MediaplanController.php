<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Mediaplan;
use AppBundle\Form\MediaplanType;
use Doctrine\Common\Collections\ArrayCollection;
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
        $params = array(
            'house' => $request->query->get('house'),
            'magazine' => $request->query->get('magazine'),
            'year' => $request->query->get('year'),
            'company' => $request->query->get('company'),
            'format' => $request->query->get('format'),
        );
        $items = $this->getDoctrine()->getRepository('AppBundle:Mediaplan')->filter($params);
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $items,
            $request->query->get('page', 1),
            20

        );
        $houses = $this->getDoctrine()->getRepository('AppBundle:PublishingHouse')->findBy([],['title' => 'ASC']);
        $magazines = $this->getDoctrine()->getRepository('AppBundle:Magazine')->findBy([],['title' => 'ASC']);
        $companies = $this->getDoctrine()->getRepository('AppBundle:Company')->findBy([],['title' => 'ASC']);
        $formats = $this->getDoctrine()->getRepository('AppBundle:Format')->findBy([],['title' => 'ASC']);
        return array(
            'pagination' => $pagination,
            'magazines'=> $magazines,
            'houses'=> $houses,
            'companies'=> $companies,
            'formats'=> $formats,
            'params'=> $params,
        );
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
        $form->add('show', SubmitType::class, ['label' => 'Просмотр', 'attr' => ['class' => 'btn-success', 'target' => '_blank']]);
        $formData = $form->handleRequest($request);

        if ($request->getMethod() === 'POST'){
            if ($formData->isValid()){
                if ($form->get('submit')->isClicked()) {
                    $item = $formData->getData();
                    $item->setUser($this->getUser());
                    $em->persist($item);
                    $em->flush();
                    $lastM = $this->getDoctrine()->getRepository('AppBundle:Mediaplan')->findOneBy([],['id' => 'DESC']);
                    foreach ( $item->getGoods() as $g ) {
                        $g->setMediaplan($lastM);
                    }
                    $em->flush();
                    $this->get('app.email')->send($this->getUser(),'создал', 'медиаплан '.$item);
                    return $this->redirectToRoute('mediaplan_list');
                }elseif ($form->get('show')->isClicked()){
                    $item = $formData->getData();
                    return $this->render('@App/Mediaplan/show.html.twig',['item' => $item]);
                }
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

        $originalGoods = new ArrayCollection();
        foreach ($item->getGoods() as $good) {
            $originalGoods->add($good);
        }

        $form = $this->createForm(MediaplanType::class, $item);
        $form->add('submit', SubmitType::class, ['label' => 'Сохранить', 'attr' => ['class' => 'btn-primary']]);
        $form->add('show', SubmitType::class, ['label' => 'Просмотр', 'attr' => ['class' => 'btn-success', 'target' => '_blank']]);
        $formData = $form->handleRequest($request);

        if ($request->getMethod() === 'POST'){
            if ($formData->isValid()){
                $item = $formData->getData();
                $item->setUpdated(new \DateTime());

                foreach ($originalGoods as $good) {
                    if (false === $item->getGoods()->contains($good)) {
                        $good->setMediaplan(null);
                        $em->remove($good);
                    }
                }
                if ($form->get('submit')->isClicked()) {
                    $em->flush();
                    $em->flush($item);
                    foreach ( $item->getGoods() as $g) {
                        $g->setMediaplan($item);
                        $em->flush($g);
                    }
                    $em->flush();
                    $em->refresh($item);
                    $this->get('app.email')->send($this->getUser(),'изменил', 'медиаплан '.$item);
                    return $this->redirect($this->generateUrl('mediaplan_list'));
                }else{
                    return $this->render('@App/Mediaplan/show.html.twig',['item' => $item]);
                }
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
            $this->get('app.email')->send($this->getUser(),'удалил', 'медиаплан '.$item);
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
            ->setLastModifiedBy("")
            ->setTitle("Медиаплан")
            ->setSubject("")
            ->setDescription("")
            ->setKeywords("")
            ->setCategory("");

        // add logo medimform
        $objDrawing = new \PHPExcel_Worksheet_Drawing();    //create object for Worksheet drawing
        $objDrawing->setName('');
        $objDrawing->setDescription('');
        $signature = $this->get('kernel')->getRootDir() . '/../web/bundles/app/images/logo.gif';    //Path to signature .jpg file
        $objDrawing->setPath($signature);
        $objDrawing->setOffsetX(25);                       //setOffsetX works properly
        $objDrawing->setOffsetY(10);                       //setOffsetY works properly
        $objDrawing->setCoordinates('A1');          //set image to cell
        $objDrawing->setWidth(150);                 //set width, height
        $objDrawing->setHeight(38);

        $objDrawing->setWorksheet($phpExcelObject->getActiveSheet());


        $phpExcelObject->setActiveSheetIndex(0)->setCellValue('A2', 'Клиент: '.$plan->getCompany());
//        $phpExcelObject->setActiveSheetIndex(0)->setCellValue('A3', 'Договор: '.$plan->getContractNumber());



        $phpExcelObject->getActiveSheet()->mergeCells('A3:A4');
        $phpExcelObject->getActiveSheet()->mergeCells('B3:B4');
        $phpExcelObject->getActiveSheet()->mergeCells('C3:C4');
        $phpExcelObject->getActiveSheet()->mergeCells('D3:D4');
        $phpExcelObject->getActiveSheet()->mergeCells('E3:E4');
        $phpExcelObject->getActiveSheet()->mergeCells('F3:F4');
        $phpExcelObject->getActiveSheet()->mergeCells('G3:G4');
        $phpExcelObject->getActiveSheet()->mergeCells('H3:H4');

        $phpExcelObject->getActiveSheet()->mergeCells('I3:T3');

        $phpExcelObject->getActiveSheet()->mergeCells('U3:U4');
        $phpExcelObject->getActiveSheet()->mergeCells('V3:V4');
        $phpExcelObject->getActiveSheet()->mergeCells('W3:W4');
        $phpExcelObject->getActiveSheet()->mergeCells('X3:X4');
        $phpExcelObject->getActiveSheet()->mergeCells('Y3:Y4');
        $phpExcelObject->getActiveSheet()->mergeCells('Z3:Z4');
        $phpExcelObject->getActiveSheet()->mergeCells('AA3:AA4');
        $phpExcelObject->getActiveSheet()->mergeCells('AB3:AB4');
        $phpExcelObject->getActiveSheet()->mergeCells('AC3:AC4');
        $phpExcelObject->getActiveSheet()->mergeCells('AD3:AD4');


        $phpExcelObject->setActiveSheetIndex(0)->setCellValue('A3', 'Издание');
        $phpExcelObject->setActiveSheetIndex(0)->setCellValue('B3', 'ИД');
        $phpExcelObject->setActiveSheetIndex(0)->setCellValue('C3', 'Тираж');
        $phpExcelObject->setActiveSheetIndex(0)->setCellValue('D3', 'Периодичность');
        $phpExcelObject->setActiveSheetIndex(0)->setCellValue('E3', 'Распространение');
        $phpExcelObject->setActiveSheetIndex(0)->setCellValue('F3', 'Формат издания');
        $phpExcelObject->setActiveSheetIndex(0)->setCellValue('G3', 'Статус ВАК*');
        $phpExcelObject->setActiveSheetIndex(0)->setCellValue('H3', 'Формат');
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
        $phpExcelObject->setActiveSheetIndex(0)->setCellValue('U3', 'Общее кол-во публикаций');
        $phpExcelObject->setActiveSheetIndex(0)->setCellValue('V3', 'Стоимость размещения, без НДС');
        $phpExcelObject->setActiveSheetIndex(0)->setCellValue('W3', 'Общий бюджет, без НДС');
        $phpExcelObject->setActiveSheetIndex(0)->setCellValue('X3', 'Скидка %');
        $phpExcelObject->setActiveSheetIndex(0)->setCellValue('Y3', 'Бюджет после скидки, без  НДС');
        $phpExcelObject->setActiveSheetIndex(0)->setCellValue('Z3', 'НДС 18%');
        $phpExcelObject->setActiveSheetIndex(0)->setCellValue('AA3', 'Стоимость, включая НДС 18%');
        $phpExcelObject->setActiveSheetIndex(0)->setCellValue('AB3', 'Агентская комиссия (5%), без НДС');
        $phpExcelObject->setActiveSheetIndex(0)->setCellValue('AC3', 'Агентская комиссия, включая НДС 18%');
        $phpExcelObject->setActiveSheetIndex(0)->setCellValue('AD3', 'Бюджет после скидки, включая АК, без НДС');

//        $phpExcelObject->setActiveSheetIndex(0)->setCellValue('AE4', 'Общий бюджет, без НДС');
//        $phpExcelObject->setActiveSheetIndex(0)->setCellValue('AF4', 'Скидка, %');
//        $phpExcelObject->setActiveSheetIndex(0)->setCellValue('AG4', 'Бюджет после скидки, без  НДС');
//        $phpExcelObject->setActiveSheetIndex(0)->setCellValue('AH4', 'OMI');

        $phpExcelObject->setActiveSheetIndex(0)->freezePane('B1');

        $phpExcelObject->setActiveSheetIndex(0)->getStyle('A3:AD4')->applyFromArray(
            array(
                'fill' => array(
                    'type' => \PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => 'CCCCCC')
                )
            )
        );
//        $phpExcelObject->setActiveSheetIndex(0)->getStyle('AE4:AH4')->applyFromArray(
//            array(
//                'fill' => array(
//                    'type' => \PHPExcel_Style_Fill::FILL_SOLID,
//                    'color' => array('rgb' => 'FFCCCC')
//                )
//            )
//        );
//
        $phpExcelObject->setActiveSheetIndex(0)->getStyle('A3:AD4')->applyFromArray(
            array(
                'borders' => array(
                    'allborders' => array(
                        'style' => \PHPExcel_Style_Border::BORDER_THIN
                    )
                )
            )
        );
        $phpExcelObject->setActiveSheetIndex(0)->getStyle('A1:A2')->applyFromArray(
            array(
                'borders' => array(
                    'allborders' => array(
                        'style' => \PHPExcel_Style_Border::BORDER_THIN
                    )
                )
            )
        );

        $centerstyle = array(
            'alignment' => array(
                'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            )
        );

        $rightstyle = array(
            'alignment' => array(
                'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
            )
        );

        $phpExcelObject->getActiveSheet()->getStyle("I3:T4")->applyFromArray($centerstyle);
        $phpExcelObject->getActiveSheet()->getStyle("F")->applyFromArray($centerstyle);
        $phpExcelObject->getActiveSheet()->getStyle("G")->applyFromArray($centerstyle);
        $phpExcelObject->getActiveSheet()->getStyle("H")->applyFromArray($centerstyle);
        $phpExcelObject->getActiveSheet()->getStyle("U")->applyFromArray($centerstyle);

        $phpExcelObject->getActiveSheet()->getStyle("A3:AH3")->getFont()->setBold(true);
        $phpExcelObject->getActiveSheet()->getStyle("AC6:AD6")->getFont()->setBold(true);
        $phpExcelObject->getActiveSheet()->getStyle("A2:A3")->getFont()->setBold(true);


        $phpExcelObject->getActiveSheet()->getStyle('A4:AH4')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $phpExcelObject->getActiveSheet()->getStyle('A4:AH4')->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);

        $phpExcelObject->getActiveSheet()->getRowDimension('1')->setRowHeight(40);
        $phpExcelObject->getActiveSheet()->getRowDimension('2')->setRowHeight(40);
        $phpExcelObject->getActiveSheet()->getRowDimension('3')->setRowHeight(40);
        $phpExcelObject->getActiveSheet()->getRowDimension('4')->setRowHeight(40);
        $phpExcelObject->getActiveSheet()->getRowDimension('5')->setRowHeight(40);
        $phpExcelObject->getActiveSheet()->getRowDimension('6')->setRowHeight(40);

        $phpExcelObject->getActiveSheet()->getColumnDimension('A')->setWidth(25);
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

        $phpExcelObject->getActiveSheet()->getColumnDimension('AE')->setWidth(20);
        $phpExcelObject->getActiveSheet()->getColumnDimension('AF')->setWidth(15);
        $phpExcelObject->getActiveSheet()->getColumnDimension('AG')->setWidth(20);
        $phpExcelObject->getActiveSheet()->getColumnDimension('AH')->setWidth(15);


//      Получаем список Изданий в данном медиаплане
        $mediaplanGoods = $this->getDoctrine()->getRepository('AppBundle:Good')->findGoods($id);

        $row = 5;
        foreach ($mediaplanGoods as $good){
            $magazine = $good->getPrice()->getMagazine();
            $phpExcelObject->setActiveSheetIndex(0)->setCellValue('I3', $plan->getYear());
            $phpExcelObject->setActiveSheetIndex(0)->setCellValue('A'.$row, $magazine->getHouse());
            $phpExcelObject->setActiveSheetIndex(0)->setCellValue('B'.$row, '');
            $phpExcelObject->setActiveSheetIndex(0)->setCellValue('C'.$row, $magazine->getCirculation());
            $phpExcelObject->setActiveSheetIndex(0)->setCellValue('D'.$row, $magazine->getPeriodicity());
            if (is_array($magazine->getSpread())){
                $phpExcelObject->setActiveSheetIndex(0)->setCellValue('E'.$row, implode(', ', $magazine->getSpread()));
            }
            $phpExcelObject->setActiveSheetIndex(0)->setCellValue('F'.$row, $magazine->getFormat());
            $phpExcelObject->setActiveSheetIndex(0)->setCellValue('G'.$row, ($magazine->getBak() == true? 'Да' : 'Нет'));

//          Получаем в0се модули на данный месяц на данный журнал
            $modules = $this->getDoctrine()->getRepository('AppBundle:Good')->findByMonth($id, $good->getPrice());
            $phpExcelObject->setActiveSheetIndex(0)->setCellValue('H'.$row, $good->getPrice()->getFormat());
            $modulesCount = 0;
            foreach ($modules as $key => $months){
                $title = '';
                $price = '';
                foreach ( $months as $module ) {
                    $modulesCount ++;
                    $title .= $module->getTitle()."\r\n";
                    $price += $module->getPrice()->getPrice();
                }
                $phpExcelObject->setActiveSheetIndex(0)->setCellValue($this->convertMonthToCell($key).$row, $title);
            }

            $phpExcelObject->getActiveSheet()->getStyle('V'.$row)->getNumberFormat()->setFormatCode(\PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);
            $phpExcelObject->getActiveSheet()->getStyle('W'.$row)->getNumberFormat()->setFormatCode(\PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);
            $phpExcelObject->getActiveSheet()->getStyle('Y'.$row)->getNumberFormat()->setFormatCode(\PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);
            $phpExcelObject->getActiveSheet()->getStyle('AA'.$row)->getNumberFormat()->setFormatCode(\PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);
            $phpExcelObject->getActiveSheet()->getStyle('AB'.$row)->getNumberFormat()->setFormatCode(\PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);
            $phpExcelObject->getActiveSheet()->getStyle('AC'.$row)->getNumberFormat()->setFormatCode(\PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);
            $phpExcelObject->getActiveSheet()->getStyle('AD'.$row)->getNumberFormat()->setFormatCode(\PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);
            $phpExcelObject->getActiveSheet()->getStyle('Z'.$row)->getNumberFormat()->setFormatCode(\PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00);
            $phpExcelObject->getActiveSheet()->getStyle('X'.$row)->getNumberFormat()->setFormatCode(\PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00);

            $phpExcelObject->setActiveSheetIndex(0)->getStyle('A'.$row.':AD'.$row)->applyFromArray(
                array(
                    'borders' => array(
                        'allborders' => array(
                            'style' => \PHPExcel_Style_Border::BORDER_THIN
                        )
                    )
                )
            );

            $phpExcelObject->setActiveSheetIndex(0)->setCellValue('U'.$row, $modulesCount);
            $phpExcelObject->setActiveSheetIndex(0)->setCellValue('V'.$row, '='.$price.'/1.18');
            $phpExcelObject->setActiveSheetIndex(0)->setCellValue('W'.$row, '=U'.$row.'*V'.$row);
            $phpExcelObject->setActiveSheetIndex(0)->setCellValue('X'.$row, ($plan->getSale()/100));
            $phpExcelObject->setActiveSheetIndex(0)->setCellValue('Y'.$row, '=W'.$row.'*(1-X'.$row.')');
            $phpExcelObject->setActiveSheetIndex(0)->setCellValue('Z'.$row, '0.18');
            $phpExcelObject->setActiveSheetIndex(0)->setCellValue('AA'.$row, '=Y'.$row.'+(Y'.$row.'*Z'.$row.')');
            $phpExcelObject->setActiveSheetIndex(0)->setCellValue('AB'.$row, '=Y'.$row.'*'.($plan->getCommission()/100));
            $phpExcelObject->setActiveSheetIndex(0)->setCellValue('AC'.$row, '=AB'.$row.'*1.18');
            $phpExcelObject->setActiveSheetIndex(0)->setCellValue('AD'.$row, '=AA'.$row.'+AC'.$row);
            $row ++;
        }

            $phpExcelObject->getActiveSheet()->mergeCells('B'.$row.':AC'.$row);
            $phpExcelObject->setActiveSheetIndex(0)->setCellValue('B'.$row, 'Общий бюджет:');
            $phpExcelObject->getActiveSheet()->getStyle('B'.$row)->applyFromArray($rightstyle);
            $phpExcelObject->setActiveSheetIndex(0)->setCellValue('AD'.$row, '=SUM(AD5:AD'.($row-1).')');
            $phpExcelObject->getActiveSheet()->getStyle('AD'.$row)->getNumberFormat()->setFormatCode(\PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);
            $phpExcelObject->getActiveSheet()->getStyle('A'.$row.':AD'.$row)->getFont()->setBold(true);



        $dateNow = new \DateTime();
        $filename = $plan->getCompany()->getTitle() . ' ' . $dateNow->format('d.m.Y');
        $filename = $this->slugify($filename);
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
            null,
            $filename.'.xls'
        );
        $response->headers->set('Content-Type', 'text/vnd.ms-excel; charset=utf-8');
        $response->headers->set('Pragma', 'public');
        $response->headers->set('Cache-Control', 'maxage=1');
        $response->headers->set('Content-Disposition', $dispositionHeader);

        return $response;
    }

    public function convertMonthToCell($month){
        switch ($month){
            case 1:  return 'I'; break;
            case 2:  return 'J'; break;
            case 3:  return 'K'; break;
            case 4:  return 'L'; break;
            case 5:  return 'M'; break;
            case 6:  return 'N'; break;
            case 7:  return 'O'; break;
            case 8:  return 'P'; break;
            case 9:  return 'Q'; break;
            case 10: return 'R'; break;
            case 11: return 'S'; break;
            case 12: return 'T'; break;
        }
    }

    public function slugify($text)
    {
        // replace non letter or digits by -
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        // trim
        $text = trim($text, '-');

        // remove duplicate -
        $text = preg_replace('~-+~', '-', $text);

        // lowercase
        $text = strtolower($text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }
}
