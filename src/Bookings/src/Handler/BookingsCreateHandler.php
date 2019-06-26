<?php

declare(strict_types=1);

namespace Bookings\Handler;

use Bookings\Resource\BookingResource;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\EntityManager;
use Bookings\Entity\Booking;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\JsonResponse;

/**
 * Class BookingsCreateHandler
 *
 * @package Bookings\Handler
 */
class BookingsCreateHandler implements RequestHandlerInterface
{
    /** @var EntityManager */
    protected $entityManager;

    /**
     * BookingsCreateHandler constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(
        EntityManager $entityManager
    ) {
        $this->entityManager = $entityManager;
    }

    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     * @throws \Exception
     */
    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        $bookings = $request->getParsedBody();
        if (empty($bookings)) {
            return new JsonResponse(['description' => 'Invalid input'], 405);
        }

        try {
            foreach ((array)$bookings as $data) {
                $bookings = (new BookingResource($this->entityManager))
                    ->getBookingsInPeriod($data['booked_from'], $data['booked_to']);

                if ($bookings) {
                    return new JsonResponse(['description' => 'Booking not possible, room is not available'], 202);
                }

                $data['company'] = $data['company'] ?? null;

                $booking = (new Booking())
                    ->setBooking($data);

                $this->entityManager->persist($booking);
            }

            $this->entityManager->flush();

        } catch (ORMException $e) {
            return new JsonResponse(['description' => 'not_created'], 500);

        } catch (\Throwable $e) {
            return new JsonResponse(['description' => 'Invalid input'], 405);
        }

        return new JsonResponse(['description' => 'Successful operation'], 200);
    }
}
