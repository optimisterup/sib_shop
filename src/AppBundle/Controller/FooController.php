<?php
namespace  AppBundle\Controller;
use JMS\Payment\CoreBundle\Form\ChoosePaymentMethodType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class FooController extends Controller{




}
//$config = [
//    'paypal_express_checkout' => [
//        'return_url' => 'https://example.com/return-url',
//        'cancel_url' => 'https://example.com/cancel-url',
//        'useraction' => 'commit',
//    ],
//];
//
//$form = $this->createForm(ChoosePaymentMethodType::class, null, [
//    'amount'          => 10.00,
//    'currency'        => 'EUR',
//    'predefined_data' => $config,
//]);