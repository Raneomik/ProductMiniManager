<?php

namespace App\Command;

use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ExportProductsCsvCommand extends ContainerAwareCommand
{
    protected static $defaultName = 'export:products:csv';

    protected function configure() : void
    {
        $this
            ->setDescription('Product export to a csv file')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output) : void
    {
        $output->writeln('initializing export...');

        $fileSystem = $this->getContainer()->get('filesystem');
        $registry   = $this->getContainer()->get('doctrine');
        $serializer = $this->getContainer()->get('serializer');

        $productRepository =  $registry->getRepository(Product::class);
        $fileName          = $this->getContainer()->getParameter('csv.file.export');

        $products    = $productRepository->findAll();
        $progressBar = new ProgressBar($output, count($products));
        $progressBar->start();
        $progressBar->setFormat(' %current%/%max% [%bar%] %percent:3s%% %elapsed:6s%/%estimated:-6s% - %message:5s%');

        $data = [];
        foreach($products as $product) {
            $productName = $product->getName();

            $data[] = [
                'id' => $product->getId(),
                'name' => $productName,
                'price' =>  $product->getPrice(),
                'description' => $product->getDescription(),
            ];

            $progressBar->setMessage("processing '${productName}'");
            $progressBar->advance();
        }

        $csvData = $serializer->encode($data, 'csv');
        $fileSystem->dumpFile($fileName, $csvData);
        $output->writeln('');
        $output->writeln('Done !');

        $progressBar->finish();
    }
}
