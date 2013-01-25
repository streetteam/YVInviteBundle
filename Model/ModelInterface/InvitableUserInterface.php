<?php

namespace YV\InviteBundle\Model\ModelInterface;

interface InvitableUserInterface
{
    public function getInvite();
    
    public function setInvite(InviteInterface $invite);
}

