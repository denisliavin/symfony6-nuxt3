<?php

declare(strict_types=1);

namespace App\Service\Uploader;

use Symfony\Component\Filesystem\Filesystem;

class FileUploader
{
    private $storage;

    public function __construct(Filesystem $storage)
    {
        $this->storage = $storage;
    }

    public function remove(string $path, string $name): void
    {
        $this->storage->remove('public/uploads/' . $path . '/' . $name);
    }
}
