<?php

namespace App\EventListener;

use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use App\Entity\User;

class JWTCreatedListener
{

    private User $user;

    /**
     * @param JWTCreatedEvent $event
     *
     * @return void
     */
    public function onJWTCreated(JWTCreatedEvent $event)
    {
        $this->user = $event->getUser();

        // merge with existing event data
        $payload = array_merge(
            $event->getData(),
            [
                'id' => $this->user->getId(),
                'username' => $this->user->getUsername(),
                'email' => $this->user->getEmail()
            ]
        );

        $event->setData($payload);
    }
}

