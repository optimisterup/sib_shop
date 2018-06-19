<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Cart;
use AppBundle\Entity\CartProduct;
use AppBundle\Entity\Product;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class ShopController extends Controller
{

    /**
     * @Route("/", name="homepage")
     * @Method({"GET","HEAD","POST"})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $allCategories = $this->getDoctrine()->getManager()->getRepository('AppBundle:Category')->findAll();
        $products = $this->getDoctrine()->getRepository('AppBundle:Product');
        $currentUser = $this->getUser();

        if ($currentUser == null || $currentUser->hasCart() != true) {
            $currentCartId = "#";
            $countProductsInCart = 0;
        } else {
            $currentCart = $currentUser->getCart();
            $currentCartId = $currentCart->getId();
            $cartProduct =
                $this->getDoctrine()
                    ->getRepository('AppBundle:CartProduct')
                    ->findOneBy(['carts' => $currentCartId]);
            $countProductsInCart = $cartProduct->getCount();
        }

        $prod = new Product();
        $form_builder = $this->createFormBuilder($prod);
        $form_builder->add('name', TextType::class);
        $form_builder->add('save', SubmitType::class, array('label' => 'find'));
        $form = $form_builder->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $word = $form->getViewData()->getName();
            $products = $this
                ->getDoctrine()
                ->getRepository('AppBundle:Product')
                ->createQueryBuilder('p')
                ->where('p.name LIKE :word')
                ->setParameter('word', "%$word%")
                ->getQuery()
                ->getResult();

            return $this->render('default/find.html.twig', [
                'products' => $products,
                'base_dir' => realpath($this->getParameter('kernel.project_dir')) . DIRECTORY_SEPARATOR,
            ]);
        }

        return $this->render('default/index.html.twig', [
            'form' => $form->createView(),
            'countProductsInCart' => $countProductsInCart,
            'products' => $products,
            'categories' => $allCategories,
            'currentCartId' => $currentCartId,
            'base_dir' => realpath($this->getParameter('kernel.project_dir')) . DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/select/{id}", requirements={"id" = "\d+"})
     * @param $id
     * @Method({"GET","HEAD","POST"})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function selectCategory($id, Request $request)
    {
        $allCategories = $this->getDoctrine()->getRepository('AppBundle:Category')->findAll();
        $selectedCategory = $this
            ->getDoctrine()
            ->getRepository('AppBundle:Category')
            ->find($id);
        $products = $selectedCategory->getProduct();

        $currentUser = $this->getUser();
        if ($currentUser == null || $currentUser->hasCart() != true) {
            $currentCartId = "#";
            $countProductsInCart = 0;
        } else {
            $currentCart = $currentUser->getCart();
            $currentCartId = $currentCart->getId();
            $cartProduct =
                $this->getDoctrine()
                    ->getRepository('AppBundle:CartProduct')
                    ->findOneBy(['carts' => $currentCartId]);
            $countProductsInCart = $cartProduct->getCount();
        }

        $prod = new Product();
        $form_builder = $this->createFormBuilder($prod);
        $form_builder->add('name', TextType::class);
        $form_builder->add('save', SubmitType::class, array('label' => 'find'));
        $form = $form_builder->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $word = $form->getViewData()->getName();
            $products = $this
                ->getDoctrine()
                ->getRepository('AppBundle:Product')
                ->createQueryBuilder('p')
                ->where('p.name LIKE :word')
                ->setParameter('word', "%$word%")
                ->getQuery()
                ->getResult();

            return $this->render('default/find.html.twig', [
                'products' => $products,
                'base_dir' => realpath($this->getParameter('kernel.project_dir')) . DIRECTORY_SEPARATOR,
            ]);
        }

        return $this->render('default/index.html.twig', array(
            'form' => $form->createView(),

            'countProductsInCart' => $countProductsInCart,
            'products' => $products,
            'categories' => $allCategories,
            'currentCartId' => $currentCartId,
            'base_dir' => realpath($this->getParameter('kernel.project_dir')) . DIRECTORY_SEPARATOR,
        ));
    }

    /**
     * @Route("/add_product/{id}", name="add_product")
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function addProduct($id)
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('fos_user_security_login');
        }
        $em = $this->getDoctrine()->getManager();
        $currentUser = $this->getUser();
        $addedProduct = $em->getRepository('AppBundle:Product')->find($id);
        if ($currentUser->hasCart() != true) {
            $cart = new Cart();
            $cart->setUser($currentUser);
            $cartProduct = new CartProduct();
            $cartProduct->setProducts($addedProduct);
            $cartProduct->addCart($cart);
            $em->persist($cartProduct);
        } else {
            $cart = $currentUser->getCart();
            $findCartProduct = $em->getRepository('AppBundle:CartProduct')
                ->findOneBy(['carts' => $cart, 'products' => $addedProduct]);
            if ($findCartProduct != null) {
                $findCartProduct->addCount();
                $em->persist($findCartProduct);
            } else {
                $cartProduct = new CartProduct();
                $cartProduct->setProducts($addedProduct);
                $cartProduct->addCart($cart);
                $em->persist($cartProduct);
            }
        }
        $em->flush();
        return $this->redirectToRoute('homepage', []);
    }

    /**
     * @Route("/my_cart/{id}", name="my_cart")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function myCart()
    {
        $currentUser = $this->getUser();
        $myCart = $currentUser->getCart();
        $em = $this->getDoctrine()->getManager();
        $findCartProduct =
            $em->getRepository('AppBundle:CartProduct')
                ->findBy(['carts' => $myCart]);
        foreach ($findCartProduct as $value) {
            $myProducts[] = $value->getProducts();
            $countProduct[] = $value->getCount();
        }

//        dump($countProduct);die;

        $countProductsInCart=0;
        $countProductsInCart =array_sum($countProduct);
        $currentCartId = $myCart->getId();
        return $this->render('default/cart.html.twig', array(
            'countProductsInCart' => $countProductsInCart,
            'countProduct'=>$countProduct,
            'products' => $myProducts,
            'currentCartId' => $currentCartId,
            'base_dir' => realpath($this->getParameter('kernel.project_dir')) . DIRECTORY_SEPARATOR,
        ));
    }



    /**
     * @Route("/cart/clear", name="clear cart")
     */
    public function clearCart()
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('fos_user_security_login');
        }
        $currentUser = $this->getUser();
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
