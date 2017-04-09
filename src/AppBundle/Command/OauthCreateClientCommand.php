<?php

namespace AppBundle\Command;

use OAuth2\OAuth2;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class OauthCreateClientCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:oauth:create-client')
            ->setDescription('creates new oauth clients')
            ->addArgument('name', InputArgument::REQUIRED, 'Client name')
            ->addArgument('redirectUri', InputArgument::REQUIRED,'Redirect URI?')
            ->addArgument('grantType', InputArgument::REQUIRED,'Grant Type, comma separated. Possible Values: '. OAuth2::GRANT_TYPE_REGEXP  );

            //->addOption('option', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $container   = $this->getContainer();
        $oauthServer = $container->get('fos_oauth_server.server');
        $name        = $input->getArgument('name');
        $redirectUri = $input->getArgument('redirectUri');
        $grantType = $input->getArgument('grantType');

        $clientManager = $container->get('fos_oauth_server.client_manager.default');
        $client = $clientManager->createClient();
        $client->setName($name);
        $client->setRedirectUris([$redirectUri]);
        $client->setAllowedGrantTypes(array_filter(array_map('trim', explode(',', $grantType))));
        $clientManager->updateClient($client);

        $output->writeln(sprintf("<info>The client <comment>%s</comment> was created with <comment>%s</comment> as public id and <comment>%s</comment> as secret</info>",
                                 $client->getName(),
                                 $client->getPublicId(),
                                 $client->getSecret()));
    }

}
