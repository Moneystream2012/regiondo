<?php

declare(strict_types=1);

namespace Bookings\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * https://www.doctrine-project.org/projects/doctrine-orm/en/2.6/reference/basic-mapping.html
 *
 * @ORM\Entity
 * @ORM\Table(name="bookings")
 **/
class Booking
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=50, nullable=false)
     */
    protected $first_name;

    /**
     * @ORM\Column(type="string", length=50, nullable=false)
     */
    protected $last_name;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    protected $company;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     */
    protected $booked_from;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     */
    protected $booked_to;

    /**
     * @return array
     */
    public function getBooking(): array
    {
        return [
            'id' => $this->getId(),
            'first_name' => $this->getFirstName(),
            'last_name' => $this->getLastName(),
            'company' => $this->getCompany(),
            'booked_from' => $this->getBookedFrom()->format('Y-m-d H:i:s'),
            'booked_to' => $this->getBookedTo()->format('Y-m-d H:i:s'),
        ];
    }

    /**
     * @param array $data
     *
     * @return Booking
     * @throws \Exception
     */
    public function setBooking(array $data) : Booking
    {
        if (!($data['booked_from'] instanceof \DateTime)) {
            $data['booked_from'] = new \DateTime($data['booked_from']);
        }
        if (!($data['booked_to'] instanceof \DateTime)) {
            $data['booked_to'] = new \DateTime($data['booked_to']);
        }

        if ($data['booked_from'] > $data['booked_to']) {
            throw new \Exception('Date_from later than date_to');
        }

        $this
            ->setFirstName($data['first_name'])
            ->setLastName($data['last_name'])
            ->setCompany($data['company'])
            ->setBookedFrom($data['booked_from'])
            ->setBookedTo($data['booked_to']);

        return $this;
    }


    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->first_name;
    }

    /**
     * @param string $first_name
     * @return Booking
     */
    public function setFirstName(string $first_name) : Booking
    {
        $this->first_name = $first_name;
        return $this;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->last_name;
    }

    /**
     * @param string $last_name
     * @return Booking
     */
    public function setLastName(string $last_name) : Booking
    {
        $this->last_name = $last_name;
        return $this;
    }

    /**
     * @return string
     */
    public function getCompany(): string
    {
        return $this->company;
    }

    /**
     * @param string|null $company
     * @return Booking
     */
    public function setCompany(?string $company) : Booking
    {
        $this->company = $company;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getBookedFrom(): \DateTime
    {
        return $this->booked_from;
    }

    /**
     * @param \DateTime $booked_from
     * @return Booking
     */
    public function setBookedFrom(\DateTime $booked_from) : Booking
    {
        $this->booked_from = $booked_from;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getBookedTo(): \DateTime
    {
        return $this->booked_to;
    }

    /**
     * @param \DateTime $booked_to
     * @return Booking
     */
    public function setBookedTo(\DateTime $booked_to) : Booking
    {
        $this->booked_to = $booked_to;
        return $this;
    }
}
