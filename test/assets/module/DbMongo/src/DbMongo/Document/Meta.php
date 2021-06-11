<?php // phpcs:disable

namespace DbMongo\Document;

use DateTime;

class Meta
{
    protected $id;

    public function getId()
    {
        return $this->id;
    }

    protected $name;

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

    protected $createdAt;

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTime $value): void
    {
        $this->createdAt = $value;
    }

    protected $description;

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription(string $value): void
    {
        $this->description = $value;
    }

    /**
     * @return array
     *
     * @psalm-return array{name: mixed, createdAt: mixed, description: mixed}
     */
    public function getArrayCopy(): array
    {
        return [
            'name'        => $this->getName(),
            'createdAt'   => $this->getCreatedAt(),
            'description' => $this->getDescription(),
        ];
    }

    public function exchangeArray($values): void
    {
        $name = $values['name'] ?? '';
        $this->setName((string) $name);
        $this->setCreatedAt($values['createdAt'] ?? null);
    }
}
