<?php

namespace YV\InviteBundle\Event;

use Symfony\Component\EventDispatcher\Event;

use YV\InviteBundle\Model\ModelInterface\InviteInterface;
use YV\InviteBundle\Model\ModelInterface\InvitableUserInterface;

class InviteAcceptedEvent extends Event
{
    protected $invite;

    protected $user;
    
    public function __construct(InviteInterface $invite, InvitableUserInterface $user)
    {
        $this->invite = $invite;
        $this->user = $user;
    }

    public function setInvite(InviteInterface $invite)
    {
        $this->invite = $invite;
    }
    
    public function getInvite()
    {
        return $this->invite;
    } 
    
    public function setUser(InvitableUserInterface $user)
    {
        $this->user = $user;
    }
    
    public function getUser()
    {
        return $this->user;
    }    
}
