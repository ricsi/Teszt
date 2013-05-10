<?php

namespace Bundles\FrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller {

    /**
     * @Route("/", name="frontend")
     * @Template()
     * @Method("GET")
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BundlesAdminBundle:Setting')->find(1);

        if (!$entity) {
            throw $this->createNotFoundException('Something Went wrong.');
        }

        return $this->render('::layout_index.html.twig', array(
                    'setting' => $entity,
                    'main' => 1));
    }

    /**
     * @Route("/termek/{slug}", name="termek")
     * @Template()
     * @Method("GET")
     */
    public function showAction($slug) {

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BundlesAdminBundle:Setting')->find(1);

        if (!$entity) {
            throw $this->createNotFoundException('Something Went wrong.');
        }


        $entityke = $em->getRepository('BundlesAdminBundle:Product');
        $termek = $entityke->findOneByNameSlug($slug);
        if ($termek)
            $termek->setView($termek->getView() + 1);
        else
            throw $this->createNotFoundException('Nem létezik ilyen termék.');

        $em->flush();

        return $this->render('::layout_index.html.twig', array('setting' => $entity,
                    'termek' => $termek));
    }

    /**
     * @Route("/kategoria/{slug}", name="category")
     * @Template()
     * @Method("GET")
     */
    public function showCategoryAction($slug) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BundlesAdminBundle:Setting')->find(1);

        if (!$entity) {
            throw $this->createNotFoundException('Something Went wrong.');
        }

        $items = null;
        $catName = null;
        $catID = $em->getRepository('BundlesAdminBundle:Category')->findOneBySlug($slug);
        if ($catID) {
            $catName = $catID->getName();
            $catLvl = $catID->getLvl();
            if ($catLvl == 1) {
                $catID = $em->getRepository('BundlesAdminBundle:Category')->findOneByParent($catID->getId());
            }
            $catID = $catID->getID();
            $items = $em->getRepository('BundlesAdminBundle:Product')->findByCategory($catID);
        }

        if ($slug == "osszes") {

            $items = $em->getRepository('BundlesAdminBundle:Product')->findAll();
        }

        return $this->render('::layout_index.html.twig', array('setting' => $entity,
                    'items' => $items,
                    'catname' => $catName
        ));
    }

    /**
     * @Route("/menu/{slug}", name="menu")
     * @Template()
     * @Method("GET")
     */
    public function menuAction($slug) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BundlesAdminBundle:Setting')->find(1);

        if (!$entity) {
            throw $this->createNotFoundException('Something Went wrong.');
        }

        $menu = $em->getRepository('BundlesAdminBundle:Menu')->findByTitleSlug($slug);

        if (!$menu) {
            throw $this->createNotFoundException('Ilyen menü nem létezik.');
        }


        return $this->render('::layout_index.html.twig', array(
                    'setting' => $entity,
            'menu' => $menu
        ));
    }

    /**
     * @Route("/stuff_getmenu", name="stuff_getmenu")
     * @Template("::stuff/menu.html.twig")
     * @param array $menus
     */
    public function getMenuAction() {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('BundlesAdminBundle:Menu');
        $root = $entities->findOneByTitleSlug('gyoker-elem');
        $menus = null;

        if ($root) {
            $menus = $entities->childrenHierarchy($root, false, array());
        }
        return array('menus' => $menus);
    }

    /**
     * @Route("/stuff_getlatest", name="stuff_getlatest")
     * @Template("::stuff/latest.html.twig")
     * @param array $menus
     */
    public function getLatestAction() {
        $repository = $this->getDoctrine()
                ->getRepository('BundlesAdminBundle:Product');

        $query = $repository->createQueryBuilder('p')
                ->orderBy('p.id', 'DESC')->setMaxResults(6)
                ->getQuery();

        $latest = $query->getResult();

        return array('latest' => $latest);
    }

    /**
     * @Route("/stuff_menu2", name="stuff_menu2")
     * @Template("::stuff/getcategory2.html.twig")
     * @param array $menus
     */
    public function getCategoryAction() {
        $em = $this->getDoctrine();
        $entities = $em->getRepository('BundlesAdminBundle:Category');
        $root = $entities->findOneBySlug('gyoker-elem');
        $menus = null;

        if ($root) {
            $menus = $entities->childrenHierarchy($root, false, array());
        }

        return array('category' => $menus);
    }

    /**
     * @Route("/stuff_menu3", name="stuff_menu3")
     * @Template("::stuff/getcategory.html.twig")
     * @param array $menus
     */
    public function getCategory2Action() {
        $em = $this->getDoctrine();
        $entities = $em->getRepository('BundlesAdminBundle:Category');
        $root = $entities->findOneBySlug('gyoker-elem');
        $menus = null;

        if ($root) {
            $menus = $entities->childrenHierarchy($root, false, array());
        }


        return array('category' => $menus);
    }

    /**
     * @Route("/stuff_topproduct", name="stuff_topproduct")
     * @Template("::stuff/toptermek.html.twig")
     * @param array $menus
     */
    public function getTopTermekAction() {
        $repository = $this->getDoctrine()->getRepository('BundlesAdminBundle:Product');

        $query = $repository->createQueryBuilder('p')
                ->orderBy('p.view', 'DESC')->setMaxResults(3)
                ->getQuery();

        $topTermek = $query->getResult();
        return array('topTermek' => $topTermek);
    }

    /**
     * @Route("/stuff_topproduct2", name="stuff_topproduct2")
     * @Template("::stuff/toptermek.html.twig")
     * @param array $menus
     */
    public function getTopTermek2Action() {
        $repository = $this->getDoctrine()->getRepository('BundlesAdminBundle:Product');

        $query = $repository->createQueryBuilder('p')
                ->orderBy('p.id', 'DESC')->setMaxResults(3)
                ->getQuery();

        $topTermek = $query->getResult();

        return array('topTermek' => $topTermek);
    }

    /**
     * @Route("/stuff_maintop", name="stuff_maintop")
     * @Template("::stuff/maintop.html.twig")
     * @param array $menus
     */
    public function getMainTopAction() {
        $repository = $this->getDoctrine()->getRepository('BundlesAdminBundle:Product');

        $query = $repository->createQueryBuilder('p')
                ->orderBy('p.view', 'DESC')->setMaxResults(1)
                ->getQuery();

        try {
            $topTermek = $query->getSingleResult();
        } catch (\Doctrine\Orm\NoResultException $e) {
            $topTermek = null;
        }
        return array('topTermek' => $topTermek);
    }

}

