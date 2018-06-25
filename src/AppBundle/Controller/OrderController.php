<?php
namespace AppBundle\Controller;
use AppBundle\Entity\PayPal;
use AppBundle\PayPal\PayPalHttpsConnection;
use GuzzleHttp\Client;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/orders")
 */
class OrderController extends Controller
{
    /**
     * @Route("/new", name="orders_new")
     */
    public function newAction()
    {
            $client=new PayPalHttpsConnection();
            $headers=$client->connect();
            dump($headers);die;
        return $this->render('@App/Orders/paypal.html.twig', [
            'headers' => $headers
        ]);
    }
}