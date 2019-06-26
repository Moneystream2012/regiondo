<?php

declare(strict_types=1);

namespace Bookings\Handler;

use Doctrine\ORM\EntityManager;
use Psr\Container\ContainerInterface;

/**
 * Class BookingsReadHandlerFactory
 * @package Bookings\Handler
 */
class BookingsReadHandlerFactory
{
    /**
     * @param ContainerInterface $container
     * @return BookingsReadHandler
     */
    public function __invoke(ContainerInterface $container) : BookingsReadHandler
    {
        $entityManager = $container->get(EntityManager::class);

        return new BookingsReadHandler($entityManager);
    }
}
