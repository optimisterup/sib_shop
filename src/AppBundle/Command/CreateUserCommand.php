<?php
namespace AppBundle\Command;

use GuzzleHttp\Client;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Command\Command;
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
    $this->addArgument('url',InputArgument::REQUIRED, 'give me your url');

}

protected function execute(InputInterface $input, OutputInterface $output)
{
    $url=$input->getArgument('url');

    $client = new Client();
    try{
        $res = $client->request('GET', $url);
        $domDocument = new \DOMDocument('1.0', 'UTF-8');
        @$domDocument->loadHTML($res->getBody()->getContents());
        dump($domDocument);die;
    }catch (\Exception $ex){
        $output->writeln($ex->getMessage());
    }

}
}