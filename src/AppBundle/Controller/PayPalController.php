<?php
namespace AppBundle\Controller;

use AppBundle\Entity\TransactionOrder;
use AppBundle\PayPal\PayPal;
use AppBundle\PayPal\PayPalHttpsConnection;
use GuzzleHttp\Client;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/pay")
 */
class PayPalController extends Controller
{
    /**
     * @Route("/", name="get_token_paypal")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getTokenAction(Request $request)
    {
        $requestParams = array(
            'RETURNURL' => "http://d6f67d51.ngrok.io/pay/success",
            'CANCELURL' => 'http://d6f67d51.ngrok.io/pay/cancelled'
        );

        $currentUser = $this->getUser();
        $myCart = $currentUser->getCart();
        $em = $this->getDoctrine()->getManager();
        $findCartProduct =
            $em->getRepository('AppBundle:CartProduct')
                ->findBy(['carts' => $myCart]);
        foreach ($findCartProduct as $value) {
            $product = $value->getProducts();
            $names[]=$product->getName();
            $descriptions[]=$product->getDescription();
            $prices=$product->getPrice();
            $myProducts[] = $product;
            $countProduct[] = $value->getCount();
            $sumByProducts[]= $product->getPrice()*$value->getCount();
        }
        $totalSumCart=array_sum($sumByProducts);
        $countProductsInCart =array_sum($countProduct);
        $totalSumShipping=$countProductsInCart*$totalSumCart;
//            for ($i=0; $i<count($myProducts);$i++){
//            $orderParams[] = array(
//                //total price
//                "PAYMENTREQUEST_.$i._AMT" => $sumByProducts[$i],
//                //shipping price
//                "PAYMENTREQUEST_.$i._SHIPPINGAMT" => "4",
//                "PAYMENTREQUEST_.$i._CURRENCYCODE" => "USD",
//                //price without taxes
//                "PAYMENTREQUEST_.$i._ITEMAMT" => $sumByProducts[$i]-4
//            );
//                $orderParams[] = ["PAYMENTREQUEST_.$i._ITEMAMT" =>"3000"];
//        }

        $orderParams = array(
////            total price
            'PAYMENTREQUEST_0_AMT' => $totalSumCart+$totalSumShipping,
////            shipping price
            'PAYMENTREQUEST_0_SHIPPINGAMT' => $totalSumShipping,
            'PAYMENTREQUEST_0_CURRENCYCODE' => 'USD',
////            price without taxes
            'PAYMENTREQUEST_0_ITEMAMT' => $totalSumCart
        );
//
        $total=0;
        for ($i=0; $i<count($myProducts);$i++) {
            $item[] = [
                "L_PAYMENTREQUEST_0_NAME{$i}" => $names[$i],
                "L_PAYMENTREQUEST_0_DESC{$i}" => $descriptions[$i],
                "L_PAYMENTREQUEST_0_AMT{$i}" => $prices[$i],
                "L_PAYMENTREQUEST_0_QTY{$i}" => $countProduct[$i]];
        }

//        dump($orderParams);die;
//        $item = array(
//            'L_PAYMENTREQUEST_0_NAME0' => 'iPhone',
//            'L_PAYMENTREQUEST_0_DESC0' => 'White iPhone, 16GB',
//            'L_PAYMENTREQUEST_0_AMT0' => '496',
//            'L_PAYMENTREQUEST_0_QTY0' => '1'
//        );

        $paypal = new PayPal();
        $response = $paypal -> request('SetExpressCheckout',$requestParams + $orderParams + $item);
//dump($myProducts[0]);die;
//dump($totalSumCart,$total );die;
        if(is_array($response) && $response['ACK'] == 'Success') {
            $token = $response['TOKEN'];
            header( 'Location: https://www.sandbox.paypal.com/webscr?cmd=_express-checkout&useraction=commit&token=' . urlencode($token) );
            dump($token);die;
        }
        return $this->redirectToRoute('cancel_pay', []);
    }

    /**
     * @Route("/success", name="paid")
     * @Method({"GET","HEAD","POST"})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function successPaid(Request $request)
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('fos_user_security_login');
        }
        if( isset($_GET['token']) && !empty($_GET['token']) ) {
            $paypal = new Paypal();
            $checkoutDetails = $paypal -> request('GetExpressCheckoutDetails', array('TOKEN' => $_GET['token']));

            $response = $paypal -> request('DoExpressCheckoutPayment',$checkoutDetails);
            if( $response['ACK'] == 'Success' || $response['ACK'] == 'SuccessWithWarning') {
                $transactionId = $response['PAYMENTINFO_0_TRANSACTIONID'];
                $em=$this->getDoctrine()->getManager();
                $transaction=new TransactionOrder();
                $transaction->setPaypalId($transactionId)
                    ->setDetail($checkoutDetails['COUNTRYCODE']."/".$checkoutDetails['SHIPTOSTREET']."/".
                                       $checkoutDetails['SHIPTOSTATE']."/".$checkoutDetails['SHIPTOZIP'])
                    ->setStatus("paid");
                $em->persist($transaction);
                $em->flush();
            }
        }
        return $this->render('default/success.html.twig', []);
    }

    /**
     * @Route("/cancelled", name="cancel_pay")
     */
    public function cancelledPaid()
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('fos_user_security_login');
        }
        return $this->render('default/cancelled.html.twig', []);
    }
}