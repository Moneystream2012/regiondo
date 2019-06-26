<?php

declare(strict_types=1);

namespace Bookings\Handler;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Psr\Container\ContainerInterface;
use Zend\Expressive\Helper\ServerUrlHelper;

/**
 * Class BookingsReadHandlerFactory
 * @package Bookings\Handler
 */
class BookingsReadPaginatedHandlerFactory
{
    /**
     * @param ContainerInterface $container
     * @return BookingsReadPaginatedHandler
     */
    public function __invoke(ContainerInterface $container) : BookingsReadPaginatedHandler
    {
        $entityManager = $container->get(EntityManager::class);

        $query = $entityManager->getRepository('Bookings\Entity\Booking')
            ->createQueryBuilder('c')
            ->getQuery();

        $paginator  = new Paginator($query);

        $urlHelper = $container->get(ServerUrlHelper::class);

        return new BookingsReadPaginatedHandler($paginator, $container->get('config')['page_size'], $urlHelper);
    }
}
