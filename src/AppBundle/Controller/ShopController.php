<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Cart;
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
        $em = $this->getDoctrine()->getManager();
        $currentUser=$this->getUser();
        $products = $em->getRepository('AppBundle:Product')->findAll();
//        $currentCart=$currentUser->getCart();
        $currentCart=0;
//        $countProductsInCart=count($currentCart->getProducts());
        $countProductsInCart=0;

        return $this->render    ('default/index.html.twig', [
            'countProductsInCart' => $countProductsInCart,
            'products' => $products,
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
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

        if ($currentUser->getCart() ==true) {
            $cart=$currentUser->getCart();
        }else{
            $cart = new Cart;
            $cart->setUser($currentUser);
        }
            $cart->addProduct($addedProduct);
            $em->persist($cart);
            $em->flush();
        return $this->redirectToRoute('homepage', []);
    }


}
