<?php

namespace YV\InviteBundle\Model\Strategy;

use Gedmo\Tree\Entity\Repository\NestedTreeRepository;

use YV\InviteBundle\Model\NestedInvite;
use YV\InviteBundle\Model\ModelInterface\RecipientInterface;

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
        return $this->generateInvite($data, $recipient, $withFlush);
    } 
}
