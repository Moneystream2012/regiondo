<?php

declare(strict_types=1);

namespace Bookings\Handler;

use Doctrine\ORM\EntityManager;
use Psr\Container\ContainerInterface;

/**
 * Class BookingsReadHandlerFactory
 * @package Bookings\Handler
 */
class BookingsCreateHandlerFactory
{
    /**
     * @param ContainerInterface $container
     * @return BookingsCreateHandler
     */
    public function __invoke(ContainerInterface $container) : BookingsCreateHandler
    {
        $entityManager = $container->get(EntityManager::class);

        return new BookingsCreateHandler($entityManager);
    }
}
