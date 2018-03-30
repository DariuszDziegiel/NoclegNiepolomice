<?php

namespace AppBundle\Controller;

use AdminBundle\Entity\CmsStaticPage;
use ReservationBundle\Form\ReservationFormType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{

    /**
     * @Route("/{_locale}", name="homepage", defaults={"_locale": "pl"})
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine();
        $cmsStaticPages = $em->getRepository('AdminBundle:CmsStaticPage')
            ->getAll();
        
        return $this->render('@App/Default/index.html.twig', [
           'cmsStaticPages'  => $cmsStaticPages,
           'reservationForm' => $this->createForm(ReservationFormType::class)->createView()
       ]);
    }

    /**
     * @Route("/service/under_construction", name="under_construction")
     */
    public function underConstructionAction()
    {
        return $this->render('@App/Default/under_construction.html.twig');
    }

    /**
     * Main menu render
     * @return Response
     */
    public function menuCategoryAction($cmsCategoryCode)
    {
        $em = $this->getDoctrine()
            ->getManager();

        //cmsCategory
        $cmsCategory = $em->getRepository('AdminBundle:CmsCategory')
            ->findOneBy(['code' => $cmsCategoryCode]);
        
        //get pages by cmsCategory
        $cmsPages = $em->getRepository('AdminBundle:CmsPage')
            ->getPagesByCategory($cmsCategory);
        
        return $this->render('@App/Default/menu_category.html.twig', [
            'cmsCategory' => $cmsCategory,
            'cmsPages'    => $cmsPages
        ]);
    }

}