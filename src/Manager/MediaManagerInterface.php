<?php

declare(strict_types=1);

namespace Apb\MediaBundle\Manager;

use Apb\MediaBundle\Entity\Media;
use Apb\MediaBundle\Repository\MediaRepository;
use Apb\MediaBundle\Service\MediaService;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * MediaManagerInterface must be implemented in order to create/delete/read medias and files
 *
 * @author Aurelien Piquet <apiquet@feelity.fr>
 */
Interface MediaManagerInterface
{
    /**
     * Uploads a file on the server and create the associated media
     */
    public function create(File $file, ?string $type = null): Media;

    /**
     * Deletes a file on the server and the associated media
     */
    public function delete(Media $media, ?string $path = null): void;

    /**
     * Returns a file from the server
     */
    public function read(string $id, ?string $path = null): ?string;

    /**
     * Fetch a media
     */
    public function fetch(string $id): Media;
}
