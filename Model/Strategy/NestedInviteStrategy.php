<?php

namespace YV\InviteBundle\Model\Strategy;

use YV\InviteBundle\Model\NestedInvite;

class NestedInviteStrategy extends InviteStrategy
{    
    public function __construct($entityManager, $freshInstance) 
    {
        parent::__construct($entityManager, $freshInstance);
        
        if(!($this->repository instanceof NestedTreeRepository)) {
            throw new \Exception('Nested invite repository must be an instance of "Gedmo\Tree\Entity\Repository\NestedTreeRepository".');
        }
    }
    
    public function generateInviteWithParent(NestedInvite $parent, array $data, RecipientInterface $recipient = null, $withFlush = true) 
    {
        $data['parent'] = $parent;
        return $this->generateInvite($data, $recipient, true);
    } 
}
