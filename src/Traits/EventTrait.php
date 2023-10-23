<?php

declare(strict_types=1);

namespace Costa\Entity\Traits;

use Costa\Entity\Contracts\EventInterface;

trait EventTrait
{
    /**
     * @var EventInterface[]
     */
    private array $events = [];

    public function addEvent(EventInterface $event): void
    {
        $this->events[] = $event;
    }

    /**
     * @return EventInterface[]
     */
    public function getEvents(): array
    {
        return $this->events;
    }
}