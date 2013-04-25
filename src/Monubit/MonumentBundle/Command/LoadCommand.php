<?php

namespace Monubit\MonumentBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class LoadCommand extends ContainerAwareCommand
{
	protected function configure()
	{
		$this
		->setName('monument:load')
		->setDescription('Loads monuments from an xml file')
		->addArgument(
				'file',
				InputArgument::REQUIRED,
				'Which file do you want to load?'
		)
		;
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		// Grab the file
		$file = $input->getArgument('file');
		
		// Load xml from file
		
		
		// Create entity and store into the database (if it does not yet exist)
		$output->writeln('Loading from file "' . $file . '"');
		
		$em = $this->getContainer()->get('doctrine')->getManager();
		
		// create monument object (new Monument())
		// use setters to set information
		// store object in database ($em->persist($monumentObject); )
		// flush the entity manager so it gets stored in the database ($em->flush(); )
		
		// Notify user of progress
		$output->writeln($text);
	}
}
