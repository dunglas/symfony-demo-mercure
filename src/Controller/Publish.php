<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Mercure\Update;

class Publish
{
    public function __invoke(MessageBusInterface $bus)
    {
        $bus->dispatch(new Update(
            'https://demo.mercure.rocks/demo/books/1.jsonld',
            'Hello from Symfony'
        ));

        return new Response('dispatched!', 200, ['Content-Type' => 'text/plain']);
    }
}
