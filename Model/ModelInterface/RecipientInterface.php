<?php

namespace YV\InviteBundle\Model\ModelInterface;

interface RecipientInterface
{
    /**
     * Set name
     *
     * @param string $name
     * @return RecipientInterface
     */
    public function setName($name);

    /**
     * Get name
     *
     * @return string 
     */
    public function getName();

    /**
     * Set email
     *
     * @param string $email
     * @return RecipientInterface
     */
    public function setEmail($email);

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail();

    /**
     * Set invite
     *
     * @param \YV\InviteBundle\Model\ModelInterface\InviteInterface $invite
     * @return RecipientInterface
     */
    public function setInvite(\YV\InviteBundle\Model\ModelInterface\InviteInterface $invite = null);

    /**
     * Get invite
     *
     * @return \YV\InviteBundle\Model\ModelInterface\InviteInterface
     */
    public function getInvite();
}

