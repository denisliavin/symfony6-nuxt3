<?php

declare(strict_types=1);

namespace App\Event\Listener\Product;

use App\Model\Product\Entity\Product\Event\ProductImageRemoved;
use App\Service\Uploader\FileUploader;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ProductImageRemoveSubscriber implements EventSubscriberInterface
{
    private $uploader;

    public function __construct(FileUploader $uploader)
    {
        $this->uploader = $uploader;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            ProductImageRemoved::class => 'onProductImageRemoved',
        ];
    }

    public function onProductImageRemoved(ProductImageRemoved $event): void
    {
        $this->uploader->remove($event->info->getPath(), $event->info->getName());
    }
}
