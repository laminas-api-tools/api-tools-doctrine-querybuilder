<?php // phpcs:disable

namespace Db\Entity;

use DateTime;

class Album
{
    protected $id;

    protected $name;

    protected $createdAt;

    protected $artist;

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    /**
     * @return static
     */
    public function setName(string $value): self
    {
        $this->name = $value;

        return $this;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @return static
     */
    public function setCreatedAt(DateTime $value): self
    {
        $this->createdAt = $value;

        return $this;
    }

    public function getArtist()
    {
        return $this->artist;
    }

    /**
     * @return static
     */
    public function setArtist(Artist $value): self
    {
        $this->artist = $value;

        return $this;
    }
}
