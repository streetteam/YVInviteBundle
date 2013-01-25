<?php

namespace YV\InviteBundle\Model\Strategy;

use Doctrine\Common\Persistence\ObjectManager;

use YV\InviteBundle\Model\NestedInvite;
use YV\InviteBundle\Model\ModelInterface\InviteInterface;

class InviteStrategyContext implements StrategyContextInterface
{
    protected $object;
    
    protected $objectManager;
    
    public function __construct(ObjectManager $objectManager, $modelClass) 
    {
        if(!class_exists($modelClass)) {
            throw new \Exception(sprintf('Class "%s" does not exist.', $modelClass));
        }
        
        $this->object = new $modelClass();
        $this->objectManager = $objectManager;
    }
    
    public function getStrategy()
    {           
        if($this->object instanceof NestedInvite) {
            $strategyClass = 'YV\InviteBundle\Model\Strategy\NestedInviteStrategy';
        }
        elseif($this->object instanceof InviteInterface) {
            $strategyClass = 'YV\InviteBundle\Model\Strategy\InviteStrategy';
        }
        
        if(isset($strategyClass)) {
            return new $strategyClass($this->objectManager, get_class($this->object));
        }
        
        throw new \Exception(sprintf('Class "%s" must be an instance of "YV\InviteBundle\Model\ModelInterface\InviteInterface".'));
    }
}
