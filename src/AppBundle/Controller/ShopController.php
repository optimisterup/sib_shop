<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Cart;
use AppBundle\Entity\CartProduct;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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

            if ($currentUser==null ||$currentUser->hasCart()!=true){
                $currentCartId = "#";
                $countProductsInCart=0;
            }else{
                $currentCart=$currentUser->getCart();
                $currentCartId=$currentCart->getId();
                $countProductsInCart = $currentCart->getCount();
            }

        return $this->render('default/index.html.twig', [
            'countProductsInCart' => $countProductsInCart,
            'products' => $products,
            'categories' => $allCategories,
            'currentCartId' =>$currentCartId,
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
        if ($currentUser==null ||$currentUser->hasCart()!=true){
            $currentCartId = "#";
            $countProductsInCart=0;
        }else{
            $currentCart=$currentUser->getCart();
            $currentCartId=$currentCart->getId();
            $countProductsInCart = $currentCart->getCount();
        }
        return $this->render('default/index.html.twig', array(
            'countProductsInCart' => $countProductsInCart,
            'products' => $products,
            'categories' => $allCategories,
            'currentCartId' =>$currentCartId,
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
        $currentUserId=$currentUser->getId();
        $addedProduct=$em->getRepository('AppBundle:Product')->find($id);
        if ($currentUser->hasCart()!=true){
            $cart=new Cart();
            $cartProduct = new CartProduct();
            $cartProduct->setProducts($addedProduct);
            $cartProduct->addCart($cart);
            $cartProduct->setUser($currentUser);
        }else{
            $cartProduct=$currentUser->getCart();
            $findProduct=$em->getRepository('AppBundle:CartProduct')
                            ->findOneBy([
                                    'products'=>$id,
                                'user'=>$currentUserId]);
            if ($findProduct!=null){
                $findProduct->addCount();
                $em->persist($findProduct);
            }else{
                $cartProduct->setProducts($addedProduct);
                $cartProduct->setUser($currentUser);
            }
        }
        $em->persist($cartProduct);
        $em->flush();
        return $this->redirectToRoute('homepage', []);
    }

    /**
     * @Route("/my_cart/{id}", name="my_cart")
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function myCart($id)
    {
        $currentUser=$this->getUser();
        $myCart=$currentUser->getCart();
        $myProducts=$myCart->getProducts();
//        dump($myProducts);die;
        $countProductsInCart = $myCart->getCount();
        $currentCartId=$myCart->getId();

        return $this->render('default/cart.html.twig', array(
            'countProductsInCart' => $countProductsInCart,
            'products' => $myProducts,
            'currentCartId' =>$currentCartId,
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ));
    }

    /**
     * @Route("/cart/clear", name="clear cart")
     */
    public function clearCart()
    {
        if (!$this->getUser()){
            return $this->redirectToRoute('fos_user_security_login');
        }
        $currentUser=$this->getUser();
        if ($currentUser->hasCart()) {

            $cart = $this->getUser()->getCart();
            $em = $this->getDoctrine()->getManager();
            $repository = $em->getRepository('AppBundle:CartProduct');
            $ship = $repository->findBy(array('user' => $currentUser));
            foreach ($ship as $one_prod) {
                $em->remove($one_prod);
                $em->flush();
            }
            $cart_repository = $em->getRepository('AppBundle:Cart');
//            $one_cart = $cart_repository->findOneById($cartId);
//            $em->remove($one_cart);
            $em->flush();
        }
        return $this->redirectToRoute('homepage', []);
    }



}
