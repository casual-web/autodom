<?php
/**
 * Created by PhpStorm.
 * User: olivier
 * Date: 27/02/15
 * Time: 14:54
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * ImageSite
 *
 * @ORM\Table()
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class ImageSite
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    public $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    public $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    public $path;
    /**
     * @ORM\Column(type="integer", name="carousel_order")
     */
    public $carouselOrder;
    /**
     * @ORM\Column(type="string", length=255)
     */
    public $location;
    /**
     * @ORM\Column(name="damage_type", type="string", length=255)
     */
    public $damageType;
    /**
     * @ORM\Column(name="vehicle_element", type="string", length=255)
     */
    public $vehicleElement;
    /**
     * @Assert\File(maxSize="6000000")
     */
    private $file;
    /**
     * @var string
     *
     * @ORM\Column(name="business_service_ref", type="string")
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\BusinessService")
     * @ORM\JoinColumn(name="business_service_ref", referencedColumnName="ref")
     */
    private $businessServiceRef;

    /**
     * Get businessServiceRef
     *
     * @return string
     */
    public function getBusinessServiceRef()
    {
        return $this->businessServiceRef;
    }

    /**
     * Set businessServiceRef
     *
     * @param string $businessServiceRef
     * @return ImageSite
     */
    public function setBusinessServiceRef($businessServiceRef)
    {
        $this->businessServiceRef = $businessServiceRef;

        return $this;
    }

    public function getWebPath()
    {
        return null === $this->path ? null : $this->getUploadDir() . '/' . $this->path;
    }

    protected function getUploadDir()
    {
        // on se débarrasse de « __DIR__ » afin de ne pas avoir de problème lorsqu'on affiche
        // le document/image dans la vue.
        return 'uploads/documents';
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if (null !== $this->getFile()) {
            // do whatever you want to generate a unique name
            $filename = sha1(uniqid(mt_rand(), true));
            $this->path = $filename . '.' . $this->getFile()->guessExtension();
        }
    }

    /**
     * Get file.
     *
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Sets file.
     *
     * @param UploadedFile $file
     * @return ImageSite
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
        return $this;
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        if (null === $this->getFile()) {
            return;
        }

        // if there is an error when moving the file, an exception will
        // be automatically thrown by move(). This will properly prevent
        // the entity from being persisted to the database on error
        $this->getFile()->move($this->getUploadRootDir(), $this->path);

        // check if we have an old image
        if (isset($this->temp)) {
            // delete the old image
            unlink($this->getUploadRootDir() . '/' . $this->temp);
            // clear the temp image path
            $this->temp = null;
        }
        $this->file = null;
    }

    protected function getUploadRootDir()
    {
        // le chemin absolu du répertoire où les documents uploadés doivent être sauvegardés
        return __DIR__ . '/../../../../web/' . $this->getUploadDir();
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        $file = $this->getAbsolutePath();
        if ($file) {
            unlink($file);
        }
    }

    public function getAbsolutePath()
    {
        return null === $this->path ? null : $this->getUploadRootDir() . '/' . $this->path;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return ImageSite
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get path
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set path
     *
     * @param string $path
     * @return ImageSite
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Set order
     *
     * @param integer $order
     * @return ImageSite
     */
    public function setOrder($order)
    {
        $this->order = $order;

        return $this;
    }

    /**
     * Get order
     *
     * @return integer
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Get location
     *
     * @return string
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Set location
     *
     * @param string $location
     * @return ImageSite
     */
    public function setLocation($location)
    {
        $this->location = $location;

        return $this;
    }

    /**
     * Get damageType
     *
     * @return string
     */
    public function getDamageType()
    {
        return $this->damageType;
    }

    /**
     * Set damageType
     *
     * @param string $damageType
     * @return ImageSite
     */
    public function setDamageType($damageType)
    {
        $this->damageType = $damageType;

        return $this;
    }

    /**
     * Get carouselOrder
     *
     * @return integer
     */
    public function getCarouselOrder()
    {
        return $this->carouselOrder;
    }

    /**
     * Set carouselOrder
     *
     * @param integer $carouselOrder
     * @return ImageSite
     */
    public function setCarouselOrder($carouselOrder)
    {
        $this->carouselOrder = $carouselOrder;

        return $this;
    }

    /**
     * Get vehicleElement
     *
     * @return string
     */
    public function getVehicleElement()
    {
        return $this->vehicleElement;
    }

    /**
     * Set vehicleElement
     *
     * @param string $vehicleElement
     * @return ImageSite
     */
    public function setVehicleElement($vehicleElement)
    {
        $this->vehicleElement = $vehicleElement;

        return $this;
    }
}
