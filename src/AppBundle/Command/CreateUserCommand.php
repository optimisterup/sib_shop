<?php

namespace AppBundle\Command;

use AppBundle\Entity\Product;
use AppBundle\Entity\ProductMedia;
use DOMXPath;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

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
        // for site http://mi-shop.kg/
        $url = $input->getArgument('url');

        $dom_doc = new \DOMDocument();
        libxml_use_internal_errors(TRUE);
        $dom_doc->preserveWhiteSpace = false;
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
                    $string = htmlentities($row->firstChild->nodeValue, null, 'utf-8');
                    $content = str_replace(' ', '', str_replace("&nbsp;", "", $string));
                    $content = html_entity_decode($content);
                    $product_price[] = htmlentities($content);
                }
            }
            $dom_row3 = $dom_xpath->query('//img[@class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail wp-post-image"]');

            $em = $this->getContainer()->get('doctrine')->getManager();

            foreach ($dom_row3 as $row) {
                /**
                 * @var $row \DOMElement
                 */
                $link = $row->attributes->getNamedItem('src')->nodeValue;
                $really_link = str_replace('//', 'http://', $link);
                $destdir = 'web/uploads/images/products';
                $img = file_get_contents($really_link);
                file_put_contents($destdir . substr($really_link, strrpos($really_link, '/')), $img);
                $product_media_entity = new ProductMedia();
                $array_split = explode('/', $link);
                $array_sort = array_reverse($array_split);
                $product_media_entity->setImage($array_sort[0]);
                $em->persist($product_media_entity);
                $array_product_media[] = $product_media_entity;
            }
            $em->flush();
        }

        for ($i = 0; $i < count($product_name); $i++) {
            $product = new Product();
            $product->setName($product_name[$i]);
            $product->setPrice($product_price[$i]);
            $product->addMedia($array_product_media[$i]);
            $em->persist($product);
        }

        if ($em->flush()) {
            dump("added products");
        }
    }
}