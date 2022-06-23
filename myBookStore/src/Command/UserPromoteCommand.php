<?php

namespace App\Command;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class UserPromoteCommand extends Command
{
    protected static $defaultName = 'user:promote';
    protected static $defaultDescription = 'Add a short description for your command';

    private $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $email = $input->getArgument('email');
        $role = $input->getArgument('role');

        // Get EntityManager

        // A. Access repositories
        $repo = $this->em->getRepository(User::class);

        // B. Get the user at $email
        $user = $repo->findOneBy([
            'email' => $email
        ]);

        if (!$user) {
            $io->error(sprintf("No user found with the email %s", $email));
            return Command::FAILURE;
        }

        // Add the new role to the list
        $user->addRole($role);

        // Persits the user
        $this->em->persist($user);
        $this->em->flush();
        $io->success(sprintf('The user %s as the new role %s', $email, $role));
        return Command::SUCCESS;
    }
}
