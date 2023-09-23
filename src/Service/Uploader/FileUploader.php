<?php

declare(strict_types=1);

namespace App\Service\Uploader;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Path;


class FileUploader
{
    private $storage;

    public function __construct(Filesystem $storage)
    {
        $this->storage = $storage;
    }

    public function remove(string $path, string $name): void
    {
        $path = Path::normalize(sys_get_temp_dir() . '/public/uploads/' . $path . '/' . $name);
        $this->storage->remove($path);

        //$this->storage->remove('uploads/' . $path . '/' . $name);
    }
}
