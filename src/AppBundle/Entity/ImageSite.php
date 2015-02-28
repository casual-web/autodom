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
 * @ORM\Table(name="image_site")
 * @ORM\Entity
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
     * @ORM\Column(type="string", length=255, name="vehicle_model")
     * @Assert\NotBlank
     */
    public $vehicleModel;
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
    private $temp;

    public function __construct()
    {
        $this->temp = null;
    }
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

    public function getUploadDir()
    {
        return 'uploads/' . $this->businessServiceRef;
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
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
        // check if we have an old image path
        if (isset($this->path)) {
            // store the old name to delete after the update
            $this->temp = $this->path;
            $this->path = null;
        } else {
            $this->path = 'initial';
        }
    }

    public function hasTemp()
    {
        return isset($this->temp);
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
     * Get vehicleModel
     *
     * @return string
     */
    public function getVehicleModel()
    {
        return $this->vehicleModel;
    }

    /**
     * Set $vehicleModel
     *
     * @param string $vehicleModel
     * @return ImageSite
     */
    public function setVehicleModel($vehicleModel)
    {
        $this->vehicleModel = $vehicleModel;

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

}
