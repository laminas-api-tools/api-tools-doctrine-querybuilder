<?php

namespace Db\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Exception;

class Artist
{
    protected $id;

    protected $name;

    protected $createdAt;

    protected $album;

    public function __construct()
    {
        $this->album = new ArrayCollection();
    }

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

    public function getAlbum()
    {
        return $this->album;
    }

    /**
     * Add album
     *
     * @param Album $album
     * @return Artist
     * @throws Exception
     */
    public function addAlbum($album)
    {
        if ($album instanceof Album) {
            $this->album[] = $album;
        } elseif ($album instanceof ArrayCollection) {
            foreach ($album as $a) {
                if (! $a instanceof Album) {
                    throw new Exception('Invalid type in addAlbum');
                }
                $this->album->add($a);
            }
        }

        return $this;
    }

    /**
     * Remove album
     *
     * @param Album $album
     * @throws Exception
     */
    public function removeAlbum($album)
    {
        if ($album instanceof Album) {
            $this->album[] = $album;
        } elseif ($album instanceof ArrayCollection) {
            foreach ($album as $a) {
                if (! $a instanceof Album) {
                    throw new Exception('Invalid type remove addAlbum');
                }
                $this->album->removeElement($a);
            }
        }
    }
}
