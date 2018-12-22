<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Visitor
 *
 * @ORM\Table(name="visitor")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\VisitorRepository")
 */
class Visitor
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
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Length(max="255")
     */
    protected $host;

    /**
     * @ORM\Column(type="integer", length=255, nullable=true)
     * @Assert\Length(max="255")
     */
    protected $pageviews;

    /**
     * @ORM\Column(type="integer", length=255, nullable=false)
     * @Assert\Length(max="255")
     */
    protected $comments;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     *
     */
    protected $visitDate;


    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}
