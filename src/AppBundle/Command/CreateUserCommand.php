<?php

namespace AppBundle\Command;

use AppBundle\Entity\Media;
use AppBundle\Entity\Product;
use AppBundle\Entity\ProductMedia;
use Doctrine\ORM\EntityManager;
use DOMXPath;
use GuzzleHttp\Client;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DomCrawler\Crawler;

class CreateUserCommand extends ContainerAwareCommand
{

    protected function configure()
    {
        $this
            // the name of the command (the part after "bin/console")
            ->setName('app:shop-parser');
        $this->addArgument('url', InputArgument::REQUIRED, 'give me your url');

    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $url = $input->getArgument('url');
//    http://mi-shop.kg/
//    $client = new Client();
//    try{
//        $res = $client->request('GET', $url);
//        $domDocument = new \DOMDocument('1.0', 'UTF-8');
//        @$domDocument->loadHTML($res->getBody()->getContents());
//        dump($domDocument);die;
//    }catch (\Exception $ex){
//        $output->writeln($ex->getMessage());
//    }
//            $res = $client->request('GET', $url);
        $dom_doc = new \DOMDocument();
        libxml_use_internal_errors(TRUE);
        $html = file_get_contents($url);

        if (!empty($html)) {
            $dom_doc->loadHTML($html);
            libxml_clear_errors();
            $dom_xpath = new DOMXPath($dom_doc);

            $dom_row = $dom_xpath->query('//span[@class="main_carousel_item_title"]');
            if ($dom_row->length > 0) {
                foreach ($dom_row as $row) {
                    $product_name[] = $row->nodeValue;
                }
            }

            $dom_row2 = $dom_xpath->query('//span[@class="woocommerce-Price-amount amount"]');
            if ($dom_row2->length > 0) {
                foreach ($dom_row2 as $row) {
                    $product_price[] = $row->nodeValue;
                }
            }

            $dom_row3 = $dom_xpath->query('//img[@class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail wp-post-image"]');
            foreach ($dom_row3 as $row) {
                /**
                 * @var $row \DOMElement
                 */
                $link= $row->attributes->getNamedItem('src')->nodeValue;
                $realy_link = str_replace('//', 'http://', $link);

//                $pattern='#/\/[a-z0-9]$#';

                $destdir = 'web/uploads/images/products';
                $img=file_get_contents($realy_link);
//                $product_media_entity=new ProductMedia();
//                $product_media_entity->setImageFile($img);
//                dump($product_media_entity);
                file_put_contents($destdir.substr($realy_link, strrpos($realy_link,'/')), $img);
//                $array_product_media[]=$product_media_entity;
//                dump($row->attributes->getNamedItem('src')->nodeValue);
            }
        }

        for($i=0; $i<count($product_name);$i++){
            $product = new Product();
            $product->setName($product_name[$i]);
            $product->setPrice($product_price[$i]);
//            $product->addMedia($array_product_media[$i]);
            $em=$this->getContainer()->get('doctrine');
            $em->persist($product);
            $em->flush();
            echo "добавил продукт";
        }
//        dump($product_media);
//
    }
//    качать
//    upload
//productmedia entity
//
//л
}