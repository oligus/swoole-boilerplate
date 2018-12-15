<?php

namespace SwooleTest\Database\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="SwooleTest\Database\Repositories\CommonRepository")
 * @ORM\Table(name="comments")
 */
class Comment
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
     * @ORM\Column(name="title", type="string", length=100)
     */
    protected $title;

    /**
     * @var string
     * @ORM\Column(name="content", type="string", length=255)
     */
    protected $content;

    /**
     * @var \DateTime
     * @ORM\Column(name="commentDate", type="datetime")
     */
    protected $date;

    /**
     * @var Author
     * @ORM\ManyToOne(targetEntity="Author", cascade={"persist"})
     * @ORM\JoinColumn(name="author_id", referencedColumnName="id")
     */
    protected $author;

    /**
     * @var Post
     * @ORM\ManyToOne(targetEntity="Post", inversedBy="comments")
     * @ORM\JoinColumn(name="post", referencedColumnName="id")
     */
    protected $post;

    /**
     * @param string $title
     * @param string $content
     * @param Author $author
     * @param Post $post
     * @param null $dateTime
     * @return Comment
     */
    public static function create(
        string $title,
        string $content,
        Author $author,
        Post $post,
        $dateTime = null
    ): Comment
    {
        $comment = new self();
        $comment->setTitle($title);
        $comment->setContent($content);
        $comment->setAuthor($author);
        $comment->setPost($post);

        if(!$dateTime instanceof \DateTime) {
            $dateTime = new \DateTime();
        }

        $comment->setDate($dateTime);

        return $comment;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent(string $content)
    {
        $this->content = $content;
    }

    /**
     * @return Author
     */
    public function getAuthor(): Author
    {
        return $this->author;
    }

    /**
     * @param Author $author
     */
    public function setAuthor(Author $author)
    {
        $this->author = $author;
    }

    /**
     * @return \DateTime
     */
    public function getDate(): \DateTime
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     */
    public function setDate(\DateTime $date)
    {
        $this->date = $date;
    }

    /**
     * @return Post
     */
    public function getPost(): Post
    {
        return $this->post;
    }

    /**
     * @param Post $post
     */
    public function setPost(Post $post)
    {
        $this->post = $post;
    }



}