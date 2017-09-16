<?php

namespace AppBundle\Command;

use AppBundle\Manager\UserManager;
use Components\Infrastructure\ErrorCommandResponse;
use Components\Infrastructure\ValidationFailedResponse;
use Components\Interaction\Resource\CreateResource\CreateResourceRequest;
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
        }
        catch(ValidationFailedResponse $reason){
            $io->error(sprintf('[%d] The user could not be saved due to validation errors.', $reason->getCode()));
            foreach($reason->getViolationMessages() as $property => $messages) {
                $io->section($property);
                array_map(function($message) use ($io){ $io->writeln($message); }, $messages);
            }
        }
        catch(ErrorCommandResponse $reason) {
            $io->error(sprintf('[%d] %s.', $reason->getCode(), $reason->getResponseText()));
        }



        /*
        $manager  = $this->getUserManager();
        $user     = $manager
            ->createNew(
                [
                    'username'      => $username,
                    'email'         => $email,
                    'plainPassword' => $password,
                    'roles'         => $roles,
                ]
            );

        if (false == $this->validate($user, $manager, $io)) {
            return -1;
        }

        try {
            $manager->save([$user]);

        } catch (\Exception $e) {
            $io->error($e->getMessage());

            return -1;
        }

        */

        // $io->success(sprintf("A new user [%s] was created.", $user->getUsername()));
    }

    /**
     * @return \AppBundle\Manager\UserManager|object
     */
    protected function getUserManager()
    {
        return $this->getContainer()->get('app.manager.user');
    }

    /**
     * @param                   $user
     * @param UserManager       $manager
     * @param      SymfonyStyle $io
     *
     * @return bool
     */
    protected function validate($user, UserManager $manager, $io)
    {
        $violations = $manager->validate($user, ['Default', 'registration']);

        if (count($violations) === 0) {
            return true;
        }

        $errors = [];

        /** @var ConstraintViolation $violation */
        foreach ($violations as $violation) {
            $errors[] = ($this->trans($violation->getMessageTemplate(), $violation->getParameters(), 'validation'));
        }

        $io->error($errors);

        return false;
    }

    /**
     * @param        $token
     * @param array  $args
     * @param string $catalog
     *
     * @return string
     */
    protected function trans($token, $args = [], $catalog = 'messages')
    {
        return $this->getContainer()->get('translator')->trans($token, $args, $catalog);
    }

}
