<?php

namespace App\Model\Image\Entity\Image;

use App\Model\EntityNotFoundException;
use Doctrine\ORM\EntityManagerInterface;

class ImageRepository
{
    /**
     * @var \Doctrine\ORM\EntityRepository
     */
    private $repo;
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->repo = $em->getRepository(Image::class);
        $this->em = $em;
    }

    public function get($id): Image
    {
        /** @var Image $image */
        if (!$image = $this->repo->find($id)) {
            throw new EntityNotFoundException('Image is not found.');
        }
        return $image;
    }

    public function add(Image $image): void
    {
        $this->em->persist($image);
    }

    public function remove(Image $image): void
    {
        $this->em->remove($image);
    }
}
