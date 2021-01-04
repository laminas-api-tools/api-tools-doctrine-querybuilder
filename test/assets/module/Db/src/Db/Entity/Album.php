<?php

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

    public function setName($value)
    {
        $this->name = $value;

        return $this;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTime $value)
    {
        $this->createdAt = $value;

        return $this;
    }

    public function getArtist()
    {
        return $this->artist;
    }

    public function setArtist($value)
    {
        $this->artist = $value;

        return $this;
    }
}
