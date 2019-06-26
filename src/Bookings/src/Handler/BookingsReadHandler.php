<?php

declare(strict_types=1);

namespace Bookings\Handler;

use Bookings\Resource\BookingResource;
use Doctrine\ORM\EntityManager;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\JsonResponse;

/**
 * Class BookingsReadHandler
 * @package Bookings\Handler
 */
class BookingsReadHandler implements RequestHandlerInterface
{
    protected $entityManager;

    /**
     * BookingsReadHandler constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        $query = $request->getQueryParams();

        if (empty($bookedFrom = $query['booked_from']) || empty($bookedTo = $query['booked_to'])) {
            return new JsonResponse(['description' => 'Invalid input'], 405);
        }

        $bookings = (new BookingResource($this->entityManager))
            ->getBookingsInPeriod($bookedFrom, $bookedTo);

        return new JsonResponse($bookings);
    }
}
