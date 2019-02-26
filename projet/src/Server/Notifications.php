<?php
/**
 * Created by PhpStorm.
 * User: Ludovic
 * Date: 21-Feb-19
 * Time: 20:20
 */

namespace App\Server;



use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;


//http://socketo.me/docs/push modifier tt ceci
class Notifications implements MessageComponentInterface
{
    protected $clients;

    public function __construct()
    {
        $this->clients = new \SplObjectStorage();
    }

    public function onOpen(ConnectionInterface $conn)
    {
        $this->clients->attach($conn);
        $conn->send('New connection: Hello');
    }

    public function onClose(ConnectionInterface $conn)
    {
        $this->clients->detach($conn);
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        $conn->close();
    }
    public function onMessage(ConnectionInterface $from, $msg)
    {
        foreach ($this->clients as $client) {
            if ($from !== $client) {
                $client->send($msg);
            }
        }
    }
}