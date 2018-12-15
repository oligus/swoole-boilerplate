<?php

namespace SwooleTest\Database\Entities;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="SwooleTest\Database\Repositories\CommonRepository")
 * @ORM\Table(name="authors")
 */
class Author
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(name="name", type="string", length=100)
     */
    protected $name;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="Post", mappedBy="author", cascade={"persist", "remove"}))
     */
    protected $posts;

    /**
     * @param string $name
     * @return Author
     */
    public static function create(string $name): Author
    {
        $author = new self();
        $author->setName($name);
        return $author;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

}