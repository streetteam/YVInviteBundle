<?php

namespace YV\InviteBundle\Model\Manager;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;

use YV\InviteBundle\Model\ModelInterface\InviteInterface;
use YV\InviteBundle\Model\ModelInterface\RecipientInterface;
use YV\InviteBundle\Model\Strategy\StrategyContextInterface;
use YV\InviteBundle\Model\Strategy\InviteStrategyInterface;
use YV\InviteBundle\Event\InviteCreatedEvent;
use YV\InviteBundle\YVInviteEvents;

class InviteManager implements InviteManagerInterface
{
    protected $eventDispatcher;
    
    protected $strategy;
    
    public function __construct(EventDispatcherInterface $eventDispatcher, StrategyContextInterface $inviteStrategyContext) 
    {
        $this->eventDispatcher = $eventDispatcher;
        $this->strategy = $inviteStrategyContext->getStrategy();
        
        if(!($this->strategy instanceof InviteStrategyInterface)) {
            throw new \Exception('The strategy must be an instance of "YV\InviteBundle\Model\Strategy\InviteStrategyInterface".');
        }
    }
    
    public function getClassName()
    {
        return $this->strategy->getClassName();
    }
    
    public function getRepository()
    {
        return $this->strategy->getRepository();
    }
    
    public function getObjectManager()
    {
        return $this->strategy->getObjectManager();
    }
    
    public function getEventDispatcher()
    {
        return $this->eventDispatcher;
    }
    
    public function flush()
    {
        $this->getObjectManager()->flush();
    }
    
    public function persist(InviteInterface $invite)
    {
        $this->getObjectManager()->persist($invite);
    }
    
    public function remove(InviteInterface $invite)
    {
        $this->getObjectManager()->remove($invite);
    }    
    
    public function create($withCode = true)
    {
        $className = $this->getClassName();
        $invite = new $className();
        
        if($withCode) {
            $code = $this->strategy->generateCode();
            $invite->setCode($code);
        }
        
        return $invite;
    }
    
    public function delete(InviteInterface $invite, $withFlush = true)
    {
        $this->remove($invite);
        
        if($withFlush) {
            $this->flush();
        }
    }    
    
    public function save(InviteInterface $invite, $withFlush = true)
    {
        $this->persist($invite);
        
        if($withFlush) {
            $this->flush();
        }
    } 
    
    public function generateInvite(array $data = array(), RecipientInterface $recipient = null, $withFlush = true)
    {
        $invite = $this->strategy->generateInvite($data, $recipient, $withFlush);
        
        $inviteCreatedEvent = new InviteCreatedEvent($invite);
        $this->eventDispatcher->dispatch(YVInviteEvents::INVITE_CREATED, $inviteCreatedEvent);
        
        return $invite;
    }  
}
