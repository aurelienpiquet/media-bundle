<?php

namespace Apb\MediaBundle\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\MappedSuperclass;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;
use Symfony\Component\Serializer\Attribute\Groups;
use Doctrine\ORM\Mapping as ORM;

#[MappedSuperclass]
final class Media
{
    #[ORM\Id]
    #[ORM\Column(type: Types::GUID)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    #[Groups(['apb_media', 'apb_media_list'])]
    private ?string $id = null;

    #[ORM\Column(type: Types::STRING, length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::STRING, length: 255)]
    #[Groups(['apb_media', 'apb_media_list'])]
    private ?string $originalName = null;

    #[ORM\Column(type: Types::STRING, length: 255)]
    #[Groups(['apb_media', 'apb_media_list'])]
    private ?string $extension = null;

    #[ORM\Column(type: Types::STRING, length: 255)]
    #[Groups(['apb_media', 'apb_media_list'])]
    private ?string $type = null;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(?string $id): Media
    {
        $this->id = $id;
        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): Media
    {
        $this->name = $name;
        return $this;
    }

    public function getOriginalName(): ?string
    {
        return $this->originalName;
    }

    public function setOriginalName(?string $originalName): Media
    {
        $this->originalName = $originalName;
        return $this;
    }

    public function getExtension(): ?string
    {
        return $this->extension;
    }

    public function setExtension(?string $extension): Media
    {
        $this->extension = $extension;
        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): Media
    {
        $this->type = $type;

        return $this;
    }
}