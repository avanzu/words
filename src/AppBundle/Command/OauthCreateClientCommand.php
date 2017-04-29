<?php

namespace AppBundle\Command;

use OAuth2\OAuth2;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationList;

/**
 * Class OauthCreateClientCommand
 */
class OauthCreateClientCommand extends ContainerAwareCommand
{
    /**
     *
     */
    protected function configure()
    {
        $this
            ->setName('app:oauth:create-client')
            ->setDescription('creates new oauth clients')
            ->addArgument('name', InputArgument::REQUIRED, 'Client name')
            ->addArgument('grantType', InputArgument::REQUIRED,'Grant Type, comma separated. Possible Values: <comment>'. OAuth2::GRANT_TYPE_REGEXP .'</comment>'  )
            ->addArgument('redirectUri', InputArgument::OPTIONAL,'Redirect URI?')
        ;

    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $io          = new SymfonyStyle($input, $output);
        $container   = $this->getContainer();

        $name          = $input->getArgument('name');
        $grantType     = $input->getArgument('grantType');
        $redirectUri   = $input->getArgument('redirectUri');

        $clientManager = $container->get('fos_oauth_server.client_manager.default');
        $client        = $clientManager->createClient();

        $client->setName($name);
        $client->setRedirectUris([$redirectUri]);
        $client->setAllowedGrantTypes(array_filter(array_map('trim', explode(',', $grantType))));

        $this->validateClient($client, $io);

        $clientManager->updateClient($client);

        $io->section(sprintf('The client <info>%s</info> was created', $client->getName()));
        $io->writeln(
            [
                sprintf('public id  : %s', $client->getPublicId()),
                sprintf('secret     : %s', $client->getSecret()),
                sprintf('grant types: %s', implode(', ', $client->getAllowedGrantTypes()))
            ]
        );

    }

    /**
     * @param              $client
     * @param SymfonyStyle $io
     *
     * @return bool
     */
    protected function validateClient($client, SymfonyStyle $io) {
        /** @var ConstraintViolationList $errors */
        $errors     = $this->getContainer()->get('validator')->validate($client);
        $translator = $this->getContainer()->get('translator');
        if( 0 === count($errors) ) {
            return true;
        }

        foreach($errors as $error) {
            $io->error(
                sprintf(
                    '%s: %s',
                    $error->getPropertyPath(),
                    $error->getPlural()
                    ? $translator->trans($error->getMessageTemplate(), $error->getParameters(), 'validators')
                    : $translator->transChoice($error->getMessageTemplate(), $error->getPlural(), $error->getParameters(), 'validators')
                )
            );
        }

        throw new \RuntimeException('Your client configuration is not valid.');
    }

}
