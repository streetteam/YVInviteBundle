<?php

namespace YV\InviteBundle\Model\Strategy;

use YV\InviteBundle\Model\ModelInterface\InviteInterface;
use YV\InviteBundle\Model\ModelInterface\RecipientInterface;

interface InviteStrategyInterface
{    
    public function getClassName();
    
    public function getRepository();
    
    public function getObjectManager();
    
    public function generateInvite(array $data, RecipientInterface $recipient = null, $withFlush = true);   
    
    public function generateCode($length);
}

