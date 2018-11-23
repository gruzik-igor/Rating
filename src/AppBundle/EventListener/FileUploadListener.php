<?php

namespace AppBundle\EventListener;

use AppBundle\Entity\FileUploadInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploadListener
{

    /**
     *
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function uploadFile(FileUploadInterface $entity, LifecycleEventArgs $args)
    {
        $file = $entity->getPath();

        if ($file instanceof UploadedFile) {
            $fileName = uniqid().'.'.$file->getClientOriginalExtension();

            $file->move('photos', $fileName);

            $entity->setPath($fileName);

        }
    }

}
