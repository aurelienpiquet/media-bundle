<?php

namespace Apb\MediaBundle\Entity;

/**
 * Represents the interface that all medias must implement
 *
 * @author Aurelien Piquet <apiquet@feelity.fr>
 */
Interface MediaInterface
{
    /**
     * Identifies the owner of the media
     *
     * @return string
     */
    public function getOwnerIdentifier(): string;
}