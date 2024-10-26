<?php

namespace App\Command;

use App\Document\User;
use App\Security\PasswordUpdaterInterface;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:create-database')]
class CreateDatabaseCommand extends Command
{
    private DocumentManager $documentManager;
    private PasswordUpdaterInterface $passwordUpdater;

    public function __construct(DocumentManager $documentManager, PasswordUpdaterInterface $passwordUpdater)
    {
        parent::__construct();
        $this->documentManager = $documentManager;
        $this->passwordUpdater = $passwordUpdater;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $user = new User('Karim', 'karim@example.com', [User::ROLE_USER]);
        $user->setPassword($this->passwordUpdater->encodePassword($user, 'pass123'));
        $this->documentManager->persist($user);

        $this->documentManager->flush();

        $output->writeln('Database and collections created with sample data.');

        return Command::SUCCESS;
    }
}
