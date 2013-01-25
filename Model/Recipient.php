<?php

namespace YV\InviteBundle\Model;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

use YV\InviteBundle\Model\ModelInterface\RecipientInterface;

/**
 * 
 * @MappedSuperclass
 */
abstract class Recipient implements RecipientInterface
{
    /**
     * @var integer $id
     *
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * The name of the recipient
     * 
     * @ORM\Column(name="name", type="string", length=100, nullable=true)
     */
    protected $name;

    /**
     * The email of the recipient
     * 
     * @ORM\Column(name="email", type="string", length=100)
     */
    protected $email; 
    
    /**
     * The invite related to this recipient
     *
     * @ORM\ManyToOne(targetEntity="Invite", inversedBy="recipients")
     * @ORM\JoinColumn(name="invite_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    protected $invite;    
    
    /**
     * @var DateTime $createdAt
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime", name="created_at")
     */
    protected $createdAt;     

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
     * Set name
     *
     * @param string $name
     * @return Recipient
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
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
     * Set email
     *
     * @param string $email
     * @return Recipient
     */
    public function setEmail($email)
    {
        $this->email = $email;
    
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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Recipient
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    
        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set invite
     *
     * @param \YV\InviteBundle\Model\ModelInterface\InviteInterface $invite
     * @return Recipient
     */
    public function setInvite(\YV\InviteBundle\Model\ModelInterface\InviteInterface $invite = null)
    {
        $this->invite = $invite;
    
        return $this;
    }

    /**
     * Get invite
     *
     * @return \YV\InviteBundle\Model\Invite 
     */
    public function getInvite()
    {
        return $this->invite;
    }
}