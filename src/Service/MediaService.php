<?php

declare(strict_types=1);

namespace Apb\MediaBundle\Service;

use Apb\MediaBundle\Entity\Media;
use Apb\MediaBundle\Repository\MediaRepository;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\String\Slugger\SluggerInterface;

readonly class MediaService
{
    public function __construct(
        private SluggerInterface $slugger,
        private Filesystem       $filesystem,
        private ParameterBagInterface $bag,
        private MediaRepository $mediaRepository,
        private string $defaultDirectory,
    ) {
    }

    public function read(Media $media, ?string $path = null): ?string
    {
        $fileSystem = new Filesystem();

        if (!$fileSystem->exists($path ?? $this->defaultDirectory . $media->getName())) {
            throw new NotFoundHttpException('File doesnt exist.');
        }

        return $path . $media->getName();
    }

    public function write(File $file, ?string $path = null, ?string $type = null): Media
    {
        $originalFilename = pathinfo($file->getBasename(), PATHINFO_FILENAME);

        $safeFilename = $this->slugger->slug($originalFilename);

        $extension = $this->getExtension($file);

        $newFilename = $safeFilename . '-' . uniqid('') . '.' . $extension;

        $media = (new Media())
            ->setName($newFilename)
            ->setExtension($extension)
            ->setOriginalName($originalFilename . '.' . $extension)
            ->setType($type)
        ;

        $this->mediaRepository->save($media, true);

        $file->move($path ?? $this->defaultDirectory, $newFilename);

        return $media;
    }

    public function delete(Media $media, ?string $path = null): void
    {
        try {
            $this->filesystem->remove($this->read($media, $path ?? $this->defaultDirectory));
        } catch (NotFoundHttpException) {
        }

        $this->mediaRepository->remove($media, true);
    }

    private function getExtension(File $file): string
    {
        $extension = $file->getExtension();

        $this->validate($file->getMimeType());

        return $extension;
    }

    private function validate(string $mimetype): void
    {
        $allowedMineTypes = $this->bag->get('media_bundle.configuration')['allowed_mine_types'];

        if (in_array('*', $allowedMineTypes) || count($allowedMineTypes) === 0) {
            return;
        }

        if (!in_array($mimetype, $allowedMineTypes)) {
            throw new BadRequestException('Mime type is not supported. Check apb/media-bundle configuration.');
        }
    }
}
