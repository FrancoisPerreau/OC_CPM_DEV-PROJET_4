<?php
// src/CL/TicketingBundle/Entity/Purchase.php

namespace CL\TicketingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Purchase
 *
 * @ORM\Table(name="PURCHASE")
 * @ORM\Entity(repositoryClass="CL\TicketingBundle\Repository\PurchaseRepository")
 */
class Purchase
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     * @Assert\NotBlank
     */
    private $createdAt;

    /**
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=255, unique=true)
     */
    private $code;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     *
     */
    private $email;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="visit_date", type="datetime")
     */
    private $visitDate;

    /**
     * @var bool
     *
     * @ORM\Column(name="visit_type", type="boolean")
     */
    private $visitType;

    /**
     * @ORM\Column(name="ticket_nb", type="integer")
     */
     private $ticketNb;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float")
     */
    private $price;

    /**
     * @ORM\OneToMany(targetEntity="CL\TicketingBundle\Entity\Ticket", mappedBy="visit", cascade={"persist"})
     * @Assert\Valid()
     */
    private $tickets;


    // **********************************
    // CONSTRUCTEUR
    // **********************************
    public function __construct()
    {
        $this->tickets = new ArrayCollection();
        $this->createdAt = new \DateTime('now');
    }


    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set createdAt.
     *
     * @param \DateTime $createdAt
     *
     * @return Purchase
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt.
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set code.
     *
     * @param string $code
     *
     * @return Purchase
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code.
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set email.
     *
     * @param string $email
     *
     * @return Purchase
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email.
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set visitDate.
     *
     * @param \DateTime $visitDate
     *
     * @return Purchase
     */
    public function setVisitDate($visitDate)
    {
        $this->visitDate = $visitDate;

        return $this;
    }

    /**
     * Get visitDate.
     *
     * @return \DateTime
     */
    public function getVisitDate()
    {
        return $this->visitDate;
    }

    /**
     * Set visitType.
     *
     * @param bool $visitType
     *
     * @return Purchase
     */
    public function setVisitType($visitType)
    {
        $this->visitType = $visitType;

        return $this;
    }

    /**
     * Get visitType.
     *
     * @return bool
     */
    public function getVisitType()
    {
        return $this->visitType;
    }

    /**
     * Set ticketNb.
     *
     * @param int $ticketNb
     *
     * @return Purchase
     */
    public function setTicketNb($ticketNb)
    {
        $this->ticketNb = $ticketNb;

        return $this;
    }

    /**
     * Get ticketNb.
     *
     * @return int
     */
    public function getTicketNb()
    {
        return $this->ticketNb;
    }

    /**
     * Set price.
     *
     * @param float $price
     *
     * @return Purchase
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price.
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }


    /**
     * Get tickets
     */
    public function getTickets()
    {
        return $this->tickets;
    }

    /**
     * Add ticket.
     *
     * @param \CL\TicketingBundle\Entity\Ticket $ticket
     *
     * @return Purchase
     */
    public function addTicket(\CL\TicketingBundle\Entity\Ticket $ticket)
    {
        $this->tickets[] = $ticket;

        // On lie l'annonce à la candidature
        $ticket->setPurchase($this);

        return $this;
    }

    /**
     * Remove ticket.
     *
     * @param \CL\TicketingBundle\Entity\Ticket $ticket
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeTicket(\CL\TicketingBundle\Entity\Ticket $ticket)
    {
        return $this->tickets->removeElement($ticket);
    }

}
