<?php

namespace YV\InviteBundle\Model\Manager;

use YV\InviteBundle\Model\ModelInterface\RecipientInterface;

interface RecipientManagerInterface extends ManagerInterface
{        
    public function flush();
    
    public function persist(RecipientInterface $recipient);
    
    public function remove(RecipientInterface $recipient);    
    
    public function create(array $data);
    
    public function delete(RecipientInterface $recipient, $withFlush);    
    
    public function save(RecipientInterface $recipient, $withFlush); 
    
    public function createByEmailAndName($email, $name);
}
