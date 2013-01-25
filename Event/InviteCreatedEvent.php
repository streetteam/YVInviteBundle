<?php
namespace YV\InviteBundle\Event;

use Symfony\Component\EventDispatcher\Event;

use YV\InviteBundle\Model\ModelInterface\InviteInterface;

class InviteCreatedEvent extends Event
{
    protected $invite;

    public function __construct(InviteInterface $invite)
    {
        $this->invite = $invite;
    }

    public function setInvite(InviteInterface $invite)
    {
        $this->invite = $invite;
    }
    
    public function getInvite()
    {
        return $this->invite;
    }
}
