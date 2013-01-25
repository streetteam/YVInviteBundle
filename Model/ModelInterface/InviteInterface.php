<?php

namespace YV\InviteBundle\Model\ModelInterface;

interface InviteInterface
{
    /**
     * Set code
     *
     * @param string $code
     * @return InviteInterface
     */
    public function setCode($code);

    /**
     * Get code
     *
     * @return string 
     */
    public function getCode();

    /**
     * Get recipientsLimit
     *
     * @return integer 
     */
    public function getRecipientsLimit();

    /**
     * Set recipientsLimit
     *
     * @param string $recipientsLimit
     * @return InviteInterface
     */
    public function setRecipientsLimit($recipientsLimit);   
    
    /**
     * Set senderName
     *
     * @param string $senderName
     * @return InviteInterface
     */
    public function setSenderName($senderName);

    /**
     * Get senderName
     *
     * @return \YV\InviteBundle\Model\Sender 
     */
    public function getSenderName();

    /**
     * Add recipients
     *
     * @param \YV\InviteBundle\Model\ModelInterface\RecipientInterface $recipients
     * @return InviteInterface
     */
    public function addRecipient(\YV\InviteBundle\Model\ModelInterface\RecipientInterface $recipients);

    /**
     * Remove recipients
     *
     * @param \YV\InviteBundle\Model\ModelInterface\RecipientInterface $recipients
     */
    public function removeRecipient(\YV\InviteBundle\Model\ModelInterface\RecipientInterface $recipients);

    /**
     * Get recipients
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRecipients();

    /**
     * Set expiresAt
     *
     * @param \DateTime $expiresAt
     * @return InviteInterface
     */
    public function setExpiresAt($expiresAt);

    /**
     * Get expiresAt
     *
     * @return \DateTime 
     */
    public function getExpiresAt();      
    
    /**
     * Get numberOfAcceptedRecipients
     *
     * @return integer
     */    
    public function getNumberOfAcceptedRecipients();
    
    /**
     * Get numberOfInvitesRemaining
     *
     * @return integer
     */     
    public function getNumberOfInvitesRemaining();
    
    /**
     * Get active
     *
     * @return boolean
     */      
    public function isActive();
    
    /**
     * Get recipients
     *
     * @return boolean
     */     
    public function hasRecipients();
}

