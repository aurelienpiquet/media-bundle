<?php

declare(strict_types=1);

namespace Apb\MediaBundle;

use Apb\MediaBundle\DependencyInjection\MediaBundleExtension;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;

class ApbMediaBundle extends AbstractBundle
{
    public function getPath(): string
    {
        return dirname(__DIR__);
    }

    public function getContainerExtension(): ?Extension
    {
        return new MediaBundleExtension();
    }
}