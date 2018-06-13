<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Cart;
use AppBundle\Entity\CartProduct;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ShopController extends Controller
{

    /**
     * @Route("/", name="homepage")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {

        $allCategories = $this->getDoctrine()->getManager()->getRepository('AppBundle:Category')->findAll();
        $products = $this->getDoctrine()->getRepository('AppBundle:Product');

        $currentUser = $this->getUser();
        $currentCart = $currentUser->getCartProduct();
        $countProductsInCart = $currentCart->getCount();

        return $this->render('default/index.html.twig', [
            'countProductsInCart' => $countProductsInCart,
            'products' => $products,
            'categories' => $allCategories,
            'base_dir' => realpath($this->getParameter('kernel.project_dir')) . DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/select/{id}", requirements={"id" = "\d+"})
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function selectCategory($id){

        $allCategories = $this->getDoctrine()->getRepository('AppBundle:Category')->findAll();
        $selectedCategory = $this
            ->getDoctrine()
            ->getRepository('AppBundle:Category')
            ->find($id);
        $products=$selectedCategory->getProduct();

        $currentUser = $this->getUser();
        $currentCart = $currentUser->getCartProduct();
        $countProductsInCart = $currentCart->getCount();
        return $this->render('default/index.html.twig', array(
            'countProductsInCart' => $countProductsInCart,
            'products' => $products,
            'categories' => $allCategories,
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ));
    }

    /**
     * @Route("/add_product/{id}", name="add_product")
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function addProduct($id)
    {
        if (!$this->getUser()){
            return $this->redirectToRoute('fos_user_security_login');
        }

        $em = $this->getDoctrine()->getManager();
        $currentUser=$this->getUser();
        $addedProduct=$em->getRepository('AppBundle:Product')->find($id);

        if ($currentUser->getCartProduct()!=null) {
            $cartProduct=$currentUser->getCartProduct();
        }else{
            $cartProduct = new CartProduct();
            $cartProduct->setUser($currentUser);
        }
        if ($em->getRepository('AppBundle:Product')->find($id)){
            $cartProduct->addCount();
        }else{
            $cartProduct->addProduct($addedProduct);
        }
        $em->persist($cartProduct);
        $em->flush();
//        dump($cartProduct);die;

        return $this->redirectToRoute('homepage', []);
    }


//    /**
//     * @Route("/my_cart/{id}", name="my_cart")
//     * @param $id
//     * @return \Symfony\Component\HttpFoundation\RedirectResponse
//     */
//    public function myCart($id)
//    {
//
//        return $this->redirectToRoute('homepage', []);
//    }

}
