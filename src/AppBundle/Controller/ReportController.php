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
 * @Route("/report")
 */
class ReportController extends Controller
{
    /**
     * @Route("/list/{id}", name="report_list")
     * @Template()
     */
    public function listAction(Request $request, $id)
    {
        $user = $this->getDoctrine()->getRepository('AppBundle:User')->find($id);
        return array('user' => $user);
    }

}
