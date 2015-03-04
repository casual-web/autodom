<?php
/**
 * Created by PhpStorm.
 * User: olivier
 * Date: 27/02/15
 * Time: 18:29
 */

namespace AppBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use AppBundle\Entity\ImageSite;
use AppBundle\EventListener\FileManagementException;


class ImageFileManager
{

    /**
     * @var string
     */
    private $uploadDirectory;
    /**
     * @var string
     */
    private $kernelRootDir;

    public function __construct($kernelRootDir, $relativeuploadDirectory)
    {
        $this->uploadDirectory = $kernelRootDir . '/' . $relativeuploadDirectory;
        $this->kernelRootDir = $kernelRootDir;
    }

    public function postPersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        if ($entity instanceof ImageSite) {
            $this->upload($entity);
        }
    }

    /**
     * Called on postPersist | postUpdate
     * @param $entity ImageSite
     */
    public function upload(ImageSite $entity)
    {
        if (null === $entity->getFile()) {
            return;
        }

        // Exception will be automatically thrown by move()
        $uploadRootDir = $this->getUploadRootDir($entity);
        $entity->getFile()->move($uploadRootDir, $entity->getPath());

        // check if we have an old image
        if ($entity->hasTemp()) {
            // delete the old image
            unlink($uploadRootDir . '/' . $entity->getTemp());
            // clear the temp image path
            $entity->setTemp(null);
        }
        $entity->setFile(null);
    }

    /**
     * Returns absolute root directory where files will be uploaded
     * @param ImageSite $entity
     * @return string
     */
    public function getUploadRootDir(ImageSite $entity)
    {
        return sprintf('%s/%s', $this->uploadDirectory, $entity->getUploadDir());
    }

    public function postUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        if ($entity instanceof ImageSite) {
            $this->upload($entity);
        }
    }

    public function postRemove(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        if ($entity instanceof ImageSite) {
            $this->removeUpload($entity);
        }
    }

    /**
     * Called on postRemove
     * @param ImageSite $entity
     * @throw FileManagementException
     */
    public function removeUpload(ImageSite $entity)
    {
        $file = $this->getAbsolutePath($entity);
        if (file_exists($file)) {
            unlink($file);
        } else {
            throw new FileManagementException($file, $entity);
        }
    }

    /**
     * Returns absolute path where files will be uploaded
     * @param ImageSite $entity
     * @return string
     */
    public function getAbsolutePath(ImageSite $entity)
    {
        return null === $entity->getPath() ? null : $this->getUploadRootDir($entity) . '/' . $entity->getPath();
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        if ($entity instanceof ImageSite) {
            $this->preUpload($entity);
        }
    }

    /**
     * Called on prePersist | preUpdate
     * @param ImageSite $entity
     */
    public function preUpload(ImageSite $entity)
    {
        if (null !== $entity->getFile()) {
            // generate a unique name
            $filename = sha1(uniqid(mt_rand(), true));
            $entity->setPath($filename . '.' . $entity->getFile()->guessExtension());
        }
    }

    public function preUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        if ($entity instanceof ImageSite) {
            $this->preUpload($entity);
        }
    }




}