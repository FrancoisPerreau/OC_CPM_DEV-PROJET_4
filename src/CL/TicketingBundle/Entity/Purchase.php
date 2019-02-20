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
     * @ORM\Column(name="createdAt", type="datetime")
     * @Assert\NotBlank
     */
    private $createdAt;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float")
     */
    private $price;

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

<<<<<<< HEAD
        // On lie l'annonce à la candidature
        $ticket->setPurchase($this);

=======
>>>>>>> 0678e8ce8b46f943faf0cbaeb9f7a866b0827cfc
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
