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
        if (is_null($currentUser->getCart())){
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
        if (is_null($currentUser->getCart())){
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
//        $em = $this->getDoctrine()->getManager();
//        $currentUser=$this->getUser();
//        $addedProduct=$em->getRepository('AppBundle:Product')->find($id);
//
//        if ($currentUser->getCartProduct()!=null) {
//            $cartProduct=$currentUser->getCartProduct();
//                $productsInCart=$cartProduct->getProduct();
//                for($i=0; $i<count($productsInCart); $i++){
//                    if($productsInCart[$i]->getId()==$id){
//                        dump($productsInCart[0]) ;die;
//                        break;
//                    }
//                }
//        }else{
//            $cartProduct = new CartProduct();
//            $cartProduct->setUser($currentUser);
//        }
////
//            foreach ($productsInCart as $value){
//                if ($value->getId()==$id){
//                    $productsInCart->addCount();
//                    break;
//                }
//            }
////
////        $cartProductRepository=$em->getRepository('AppBundle:CartProduct');
////        $cartProductRepository->findBy(['product'=>$id]);
////        dump($cartProductRepository);die;
////        if (){
////            $cartProduct->addCount();
////        }else{
////            $cartProduct->addProduct($addedProduct);
////        }
//
//
//        $em->persist($cartProduct);
//        $em->flush();
////        dump($cartProduct);die;
        $em = $this->getDoctrine()->getManager();
        $currentUser=$this->getUser();
        $addedProduct=$em->getRepository('AppBundle:Product')->find($id);
        if ($currentUser->getCart()!=null) {
            $cart=$currentUser->getCart();
            $cartProduct=$em->getRepository('AppBundle:Cart')->find($cart);
            $cartProduct->setProducts($addedProduct);
            $productInCart=$em->getRepository('AppBundle:CartProduct')->findOneBy(['product'=>$id, 'user'=>$currentUser]);
            $productInCart->addCount();
        }else{
            $cartProduct = new CartProduct();
            $cartProduct->setProducts($addedProduct);
        }
//        $cartProduct->setProducts($addedProduct);
        $cartProduct->addCart($cart);
//dump($cartProduct);die;
        $em->persist($cartProduct);
//        $em->persist($productInCart);
//        dump(gettype($addedProduct));die;
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
        $myCart=$this->getDoctrine()->getRepository('AppBundle:CartProduct')->find($id);
        $myProducts=$myCart->getProducts();
        $countProductsInCart = $myCart->getCount();
        $currentCartId=$myCart->getId();

        return $this->render('default/cart.html.twig', array(
            'countProductsInCart' => $countProductsInCart,
            'products' => $myProducts,
            'currentCartId' =>$currentCartId,
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ));
    }

}
