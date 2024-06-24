<?php

declare(strict_types=1);

namespace Apb\MediaBundle\Manager;

use Apb\MediaBundle\Entity\Media;
use Apb\MediaBundle\Repository\MediaRepository;
use Apb\MediaBundle\Service\MediaService;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

readonly class MediaManager
{
    public function __construct(
        private MediaService $mediaService,
        private MediaRepository $mediaRepository,
    )
    {}

    public function create(mixed $file, ?string $type = null): Media
    {
        return $this->mediaService->write($file, $type);
    }

    public function delete(Media $media, ?string $path = null): void
    {
        $this->mediaService->delete($media, $path);
    }

    public function read(string $id, ?string $path = null): ?string
    {
        $media = $this->fetch($id);

        return $this->mediaService->read($media, $path);
    }

    public function fetch(string $id): Media
    {
        $media = $this->mediaRepository->fetch($id);

        if (!$media) {
            throw new NotFoundHttpException('Media does not exist');
        }

        return $media;
    }
}
