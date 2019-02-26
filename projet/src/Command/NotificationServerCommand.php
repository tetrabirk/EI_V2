<?php
/**
 * Created by PhpStorm.
 * User: Ludovic
 * Date: 21-Feb-19
 * Time: 20:28
 */

namespace App\Command;


use App\Server\Notifications;
use Ratchet\Server\IoServer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class NotificationServerCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('wd-log:app:notif-server')
            ->setDescription('Start notification server');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $server = IoServer::factory(
            new Notifications(),
            8080,
            '127.0.0.1'
        );
        $server->run();
    }
}