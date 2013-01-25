<?php

namespace YV\InviteBundle\Model;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

use YV\InviteBundle\Model\ModelInterface\InviteInterface;

/**
 * An invitation, which may be used by one or more users
 * 
 * @ORM\MappedSuperclass
 */
abstract class Invite implements InviteInterface
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
     * The randomly generated invite "code" which unique identifies 
     * 
     * @ORM\Column(name="code", type="string", length=20)
     */
    protected $code;
    
    /**
     * The maximum number of available recipients
     * 
     * @ORM\Column(name="recipients_limit", type="integer", nullable=true)
     */
    protected $recipientsLimit = 1;    
    
    /**
     * The sender name related to this invite
     * 
     * @ORM\Column(name="sender_name", type="string", length=255)
     */
    protected $senderName;
    
    /**
     * All recipients that this invite was sent to
     *
     * @ORM\OneToMany(targetEntity="Recipient", mappedBy="invite")
     */
    protected $recipients;    
    
    /**
     * @var DateTime $expiresAt
     * 
     * @ORM\Column(type="datetime", name="expires_at", nullable=true)
     */
    protected $expiresAt;    
    
    /**
     * @var DateTime $updatedAt
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime", name="updated_at", nullable=true)
     */
    protected $updatedAt;      
    
    /**
     * @var DateTime $createdAt
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime", name="created_at")
     */
    protected $createdAt;   
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->recipients = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set code
     *
     * @param string $code
     * @return Invite
     */
    public function setCode($code)
    {
        $this->code = $code;
    
        return $this;
    }

    /**
     * Get recipientsLimit
     *
     * @return integer 
     */
    public function getRecipientsLimit()
    {
        return $this->recipientsLimit;
    }

    /**
     * Set recipientsLimit
     *
     * @param string $recipientsLimit
     * @return Invite
     */
    public function setRecipientsLimit($recipientsLimit)
    {
        $this->recipientsLimit = $recipientsLimit;
    
        return $this;
    }

    /**
     * Get code
     *
     * @return string 
     */
    public function getCode()
    {
        return $this->code;
    }    
    
    /**
     * Set expiresAt
     *
     * @param \DateTime $expiresAt
     * @return Invite
     */
    public function setExpiresAt($expiresAt)
    {
        $this->expiresAt = $expiresAt;
    
        return $this;
    }

    /**
     * Get expiresAt
     *
     * @return \DateTime 
     */
    public function getExpiresAt()
    {
        return $this->expiresAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Invite
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    
        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Invite
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
     * Set senderName
     *
     * @param string $senderName
     * @return Invite
     */
    public function setSenderName($senderName)
    {
        $this->senderName = $senderName;
    
        return $this;
    }

    /**
     * Get senderName
     *
     * @return string 
     */
    public function getSenderName()
    {
        return $this->senderName;
    }

    /**
     * Add recipients
     *
     * @param \YV\InviteBundle\Model\ModelInterface\RecipientInterface $recipients
     * @return Invite
     */
    public function addRecipient(\YV\InviteBundle\Model\ModelInterface\RecipientInterface $recipients)
    {
        $this->recipients[] = $recipients;
    
        return $this;
    }

    /**
     * Remove recipients
     *
     * @param \YV\InviteBundle\Model\ModelInterface\RecipientInterface $recipients
     */
    public function removeRecipient(\YV\InviteBundle\Model\ModelInterface\RecipientInterface $recipients)
    {
        $this->recipients->removeElement($recipients);
    }

    /**
     * Get recipients
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRecipients()
    {
        return $this->recipients;
    }
    
    /**
     * Get active
     *
     * @return boolean
     */      
    public function isActive()
    {
        return $this->getRecipientsLimit() > $this->getNumberOfAcceptedRecipients() && 
              ($this->getExpiresAt() === null || ($this->getExpiresAt() instanceof \DateTime && time() <= $this->getExpiresAt()->getTimestamp()));
    }
    
    public function getNumberOfInvitesRemaining()
    {
        return $this->getRecipientsLimit() - $this->getNumberOfAcceptedRecipients();
    }    
    
    public function hasRecipients() 
    {
        return $this->recipients->count() > 0;
    }
}