<?php
namespace AppBundle\Controller;

use AppBundle\PayPal\PayPal;
use AppBundle\PayPal\PayPalHttpsConnection;
use GuzzleHttp\Client;
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
        // Параметры нашего запроса
        $requestParams = array(
            'RETURNURL' => 'http://localhost:2020/pay/success',
            'CANCELURL' => 'http://localhost:2020/pay/cancel_pay    '
        );

        $orderParams = array(
            //total price
            'PAYMENTREQUEST_0_AMT' => '500',
            //shipping price
            'PAYMENTREQUEST_0_SHIPPINGAMT' => '4',
            'PAYMENTREQUEST_0_CURRENCYCODE' => 'USD',
            //price without taxes
            'PAYMENTREQUEST_0_ITEMAMT' => '496'
        );

        $item = array(
            'L_PAYMENTREQUEST_0_NAME0' => 'iPhone',
            'L_PAYMENTREQUEST_0_DESC0' => 'White iPhone, 16GB',
            'L_PAYMENTREQUEST_0_AMT0' => '496',
            'L_PAYMENTREQUEST_0_QTY0' => '1'
        );

        $paypal = new PayPal();
        $response = $paypal -> request('SetExpressCheckout',$requestParams + $orderParams + $item);

        if(is_array($response) && $response['ACK'] == 'Success') {
            $token = $response['TOKEN'];
            header( 'Location: https://www.paypal.com/webscr?cmd=_express-checkout&token=' . urlencode($token) );
            dump($token);die;
        }

        return $this->redirectToRoute('paid', []);
    }


    /**
     * @Route("/success", name="paid")
     */
    public function successPaid()
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('fos_user_security_login');
        }
//        $currentUser = $this->getUser();
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
//        $currentUser = $this->getUser();
        return $this->render('default/cancelled.html.twig', []);
    }
}