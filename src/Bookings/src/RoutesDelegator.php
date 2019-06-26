<?php

namespace Bookings;

use Bookings\Handler;
use Psr\Container\ContainerInterface;
use Zend\Expressive\Application;

class RoutesDelegator
{
    /**
     * @param ContainerInterface $container
     * @param string $serviceName Name of the service being created.
     * @param callable $callback Creates and returns the service.
     * @return Application
     */
    public function __invoke(ContainerInterface $container, $serviceName, callable $callback)
    {
        /** @var $app Application */
        $app = $callback();

        $app->post('/booking[/]', Handler\BookingsCreateHandler::class, 'bookings.create');

        $app->get('/booking[/]', Handler\BookingsReadHandler::class, 'bookings.read');

        $app->get('/bookings[/]', Handler\BookingsReadPaginatedHandler::class, 'bookings.paginated.read');

        return $app;
    }
}
