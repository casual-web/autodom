<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use AppBundle\EmailImporter\EmailImporter;

class EmailImportCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('autodom:EmailImport')
            ->setDescription('import html email')
            ->addArgument('directory', InputArgument::REQUIRED, 'Give me a directory where I can find .html files');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $directory = $input->getArgument('directory');
        $output->writeln('start loading files...');
        $emailImporter = new EmailImporter($directory);
        $output->writeln(sprintf('start loading %s entities...', $emailImporter->getNbFiles()));
        $entities = $emailImporter->loadEntities();
        $output->writeln(sprintf('start persisitng %s entities...', $emailImporter->getNbFiles()));
        $errors = $emailImporter->getErrorLog();
        if (count($errors)) {
            foreach ($errors as $err) {
                $output->writeln($err);
            }
        }
        $em = $this->getContainer()->get('doctrine.orm.quotation_request_manager');
        foreach ($entities as $entity) {
            $em->persistAndFlush($entity);
        }
    }
}