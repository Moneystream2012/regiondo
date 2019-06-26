<?php

declare(strict_types=1);

namespace Bookings\Resource;

use Bookings\Entity\Booking;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query;

class BookingResource
{
    /** @var EntityManager */
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
     * @param string $bookedFrom
     * @param string $bookedTo
     *
     * @return array
     */
    public function getBookingsInPeriod(string $bookedFrom, string $bookedTo) : array
    {
        $qb = $this->entityManager
            ->getRepository(Booking::class)
            ->createQueryBuilder('b');

        $bookedFrom = $this->entityManager->getConnection()->quote($bookedFrom);
        $bookedTo   = $this->entityManager->getConnection()->quote($bookedTo);

        $bookings = $qb
            ->andWhere(
                $qb->expr()->between('b.booked_from', $bookedFrom, $bookedTo)
            )
            ->orWhere(
                $qb->expr()->between('b.booked_to', $bookedFrom, $bookedTo)
            )
            ->orderBy('b.booked_from','ASC')
            ->getQuery()
            ->getResult(Query::HYDRATE_ARRAY);

        return array_map(
            function($booking) {
                $this->castAsString($booking['booked_from']);
                $this->castAsString($booking['booked_to']);
                return $booking;
            },
            $bookings
        );
    }

    /**
     * @param mixed $dateObj
     */
    private function castAsString(&$dateObj) : void
    {
        if ($dateObj instanceof \DateTime) {
            $dateObj = $dateObj->format("c");
        }
    }
}
