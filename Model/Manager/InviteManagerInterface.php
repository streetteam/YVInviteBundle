<?php

namespace YV\InviteBundle\Model\Manager;

use YV\InviteBundle\Model\ModelInterface\InviteInterface;
use YV\InviteBundle\Model\ModelInterface\RecipientInterface;

interface InviteManagerInterface extends ManagerInterface
{        
    public function flush();
    
    public function persist(InviteInterface $invite);
    
    public function remove(InviteInterface $invite);    
    
    public function create($withCode);
    
    public function delete(InviteInterface $invite, $withFlush);    
    
    public function save(InviteInterface $invite, $withFlush); 
    
    public function generateInvite(array $data, RecipientInterface $recipient = null, $withFlush = true);      
}
