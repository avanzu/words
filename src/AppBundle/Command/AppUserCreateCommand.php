<?php

namespace AppBundle\Command;

use AppBundle\Manager\UserManager;
use Components\Infrastructure\Response\ErrorResponse;
use Components\Infrastructure\Response\ValidationFailedResponse;
use Components\Interaction\Users\CreateUser\CreateUserRequest;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Validator\ConstraintViolation;

/**
 * Class AppUserCreateCommand
 */
class AppUserCreateCommand extends ContainerAwareCommand
{
    /**
     *
     */
    protected function configure()
    {
        $this
            ->setName('app:user:create')
            ->setDescription('Creates a new user')
            ->addArgument('username', InputArgument::REQUIRED, 'The desired username (must be unique)')
            ->addArgument('email', InputArgument::REQUIRED, "The user's email (must be unique)")
            ->addArgument('password', InputArgument::REQUIRED, "The user's password")
            ->addArgument('roles', InputArgument::OPTIONAL, 'The user roles', 'ROLE_USER')
        ;
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io       = new SymfonyStyle($input, $output);
        $username = $input->getArgument('username');
        $email    = $input->getArgument('email');
        $password = $input->getArgument('password');
        $roles    = array_map('trim', explode(',', $input->getArgument('roles')));


        $request = new CreateUserRequest([
            'username'      => $username,
            'email'         => $email,
            'plainPassword' => $password,
            'roles'         => $roles,
        ]);

        try {
            $response = $this->getContainer()->get('app.command_bus')->execute($request);
            $io->success(sprintf('A new User [%s] was created.', $response->getResource()));
            return 0;
        }
        catch(ValidationFailedResponse $reason){
            $io->error(sprintf('[%d] The user could not be saved due to validation errors.', $reason->getCode()));
            foreach($reason->getViolationMessages() as $property => $messages) {
                $io->section($property);
                array_map(function($message) use ($io){ $io->writeln($message); }, $messages);
            }
        }
        catch(ErrorResponse $reason) {
            $io->error(sprintf('[%d] %s.', $reason->getCode(), $reason->getResponseText()));
        }

        return -1;
    }


}
