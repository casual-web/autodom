<?php

namespace AppBundle\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;

/**
 * QuotationRequest
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\QuotationRequestRepository")
 */
class QuotationRequest
{
    /**
     *
     * @ORM\OneToMany(targetEntity="QuotationRequestServiceRelation", mappedBy="quotation_request", cascade={"remove", "persist"})
     *
     */
    protected $quotationRequestServiceRelation;
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @var string
     *
     * @ORM\Column(name="vehicle_model", type="string", length=255)
     */
    private $vehicleModel;
    /**
     * @var string
     *
     * @ORM\Column(name="problem_description", type="text")
     */
    private $problemDescription;
    /**
     * @var boolean
     *
     * @ORM\Column(name="has_shelter", type="boolean")
     */
    private $hasShelter = false;
    /**
     * @var string
     *
     * @ORM\Column(name="first_name", type="string", length=255)
     */
    private $first_name;
    /**
     * @var string
     *
     * @ORM\Column(name="last_name", type="string", length=255)
     */
    private $last_name;
    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;
    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=255)
     */
    private $phone;
    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=512)
     */
    private $address;
    /**
     * @var integer
     *
     * @ORM\Column(name="contact_origin", type="string", columnDefinition="ENUM('autre', 'recherche sur internet', 'lien depuis un autre site', 'pages jaunes', 'bouche à oreilles', 'cartes de visite, flyers')")
     *
     */
    private $contactOrigin = "autre";
    /**
     * @var datetime $created
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $created;
    /**
     * @var integer
     *
     * @ORM\Column(name="status", type="integer")
     *
     */
    private $status = "0";

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->quotationRequestServiceRelation = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set vehicleModel
     *
     * @param string $vehicleModel
     * @return QuotationRequest
     */
    public function setVehicleModel($vehicleModel)
    {
        $this->vehicleModel = $vehicleModel;

        return $this;
    }

    /**
     * Get problemDescription
     *
     * @return string
     */
    public function getProblemDescription()
    {
        return $this->problemDescription;
    }

    /**
     * Set problemDescription
     *
     * @param string $problemDescription
     * @return QuotationRequest
     */
    public function setProblemDescription($problemDescription)
    {
        $this->problemDescription = $problemDescription;

        return $this;
    }

    /**
     * Get hasShelter
     *
     * @return boolean
     */
    public function getHasShelter()
    {
        return $this->hasShelter;
    }

    /**
     * Set hasShelter
     *
     * @param boolean $hasShelter
     * @return QuotationRequest
     */
    public function setHasShelter($hasShelter)
    {
        $this->hasShelter = $hasShelter;

        return $this;
    }

    /**
     * Get first_name
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * Set first_name
     *
     * @param string $first_name
     * @return QuotationRequest
     */
    public function setFirstName($first_name)
    {
        $this->first_name = $first_name;

        return $this;
    }

    /**
     * Get last_name
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * Set last_name
     *
     * @param string $last_name
     * @return QuotationRequest
     */
    public function setLastName($last_name)
    {
        $this->last_name = $last_name;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return QuotationRequest
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set phone
     *
     * @param string $phone
     * @return QuotationRequest
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set address
     *
     * @param string $address
     * @return QuotationRequest
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get contactOrigin
     *
     * @return integer
     */
    public function getContactOrigin()
    {
        return $this->contactOrigin;
    }

    /**
     * Set contactOrigin
     *
     * @param integer $contactOrigin
     * @return QuotationRequest
     */
    public function setContactOrigin($contactOrigin)
    {
        $this->contactOrigin = $contactOrigin;

        return $this;
    }

    /**
     * Get created
     *
     * @return string
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set created
     *
     * @param string $created
     * @return QuotationRequest
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return QuotationRequest
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Add quotation request service relation
     *
     * @param \AppBundle\Entity\QuotationRequestServiceRelation $quotationRequestServiceRelation
     * @return QuotationRequest
     */
    public function addQuotationRequestServiceRelation(\AppBundle\Entity\QuotationRequestServiceRelation $quotationRequestServiceRelation)
    {
        $this->quotationRequestServiceRelation[] = $quotationRequestServiceRelation;

        return $this;
    }

    /**
     * Remove quotation request service relation
     *
     * @param \AppBundle\Entity\QuotationRequestServiceRelation $quotationRequestServiceRelation
     */
    public function removeQuotationRequestServiceRelation(\AppBundle\Entity\QuotationRequestServiceRelation $quotationRequestServiceRelation)
    {
        $this->quotationRequestServiceRelation->removeElement($quotationRequestServiceRelation);
    }

    /**
     * Get quotation request service relation
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getQuotationRequestServiceRelation()
    {
        return $this->quotationRequestServiceRelation;
    }
}
