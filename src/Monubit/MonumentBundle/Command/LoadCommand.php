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
		->setDescription('Loads monuments from multiple xml files')
		->addArgument(
				'folder',
				InputArgument::REQUIRED,
				'Which folder do you want to load from?'
		)
		;
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		// Grab the folder argument
		$folder = $input->getArgument('folder');
		
		// Load files
		$output->writeln('Loading from folder "' . $folder . '"');
		
		
		// Create entity and store into the database (if it does not yet exist)
		
		
		$em = $this->getContainer()->get('doctrine')->getManager();
		
		// create monument object (new Monument())
		// create location object (new Location())
		// use setters to set information
		// store object in database ($em->persist($monumentObject); )
		// flush the entity manager so it gets stored in the database ($em->flush(); )
		
		// Notify user of progress
		$output->writeln($text);
	}
}
