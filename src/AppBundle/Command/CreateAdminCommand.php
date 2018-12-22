<?php

namespace AppBundle\Command;

use AppBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class CreateAdminCommand extends ContainerAwareCommand
{
    public function configure()
    {
        $this
            ->setName('app:create:admin')
            ->addOption('username',null,InputOption::VALUE_REQUIRED )
            ->addOption('password',null,InputOption::VALUE_REQUIRED)
            ->setDescription('Create admin user');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        /**
         * @var EntityManager $em
         */
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');

        $user = new User();

        $user->setUsername($input->getOption('username'));
        $user->setPlainPassword($input->getOption('password'));
        $user->setRole('ROLE_SUPER_ADMIN');
        $user->setEmail($input->getOption('username'));

        $em->persist($user);
        $em->flush();
    }

}