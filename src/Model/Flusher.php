<?php

declare(strict_types=1);

namespace App\Model;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class Flusher
{
    private $em;
    private $dispatcher;
    private $eventDispatcher;

    public function __construct(
        EntityManagerInterface $em,
        EventDispatcher $dispatcher,
        EventDispatcherInterface $eventDispatcher
    )
    {
        $this->em = $em;
        $this->dispatcher = $dispatcher;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function flush(AggregateRoot ...$roots): void
    {
        $this->em->flush();

        foreach ($roots as $root) {
            $this->dispatcher->dispatch($root->releaseEvents());
//            $events = $root->releaseEvents();
//            foreach ($events as $event) {
//                $this->eventDispatcher->dispatch($event);
//            }
        }
    }
}
