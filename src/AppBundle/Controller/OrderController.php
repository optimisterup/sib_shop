<?php
namespace AppBundle\Controller;
use AppBundle\Entity\PayPal;
use GuzzleHttp\Client;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
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
            $client=new PayPal();
            $result=$client->connect();
//            dump($result);
        return $this->render('@App/Orders/paypal.html.twig', [
            'result' => $result
        ]);
    }
}