<?php

namespace YV\InviteBundle\Model\Manager;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;

use Doctrine\Common\Persistence\ObjectManager;

use YV\InviteBundle\Model\ModelInterface\RecipientInterface;

class RecipientManager implements RecipientManagerInterface
{
   protected $objectManager;
    
    protected $eventDispatcher;
    
    protected $repository;
    
    protected $className;
    
    public function __construct(ObjectManager $objectManager, EventDispatcherInterface $eventDispatcher, $className) 
    {
        $this->objectManager = $objectManager;
        $this->eventDispatcher = $eventDispatcher;
        $this->className = $className;
        $this->repository = $this->objectManager->getRepository($this->className);
    }
    
    public function getClassName()
    {
        return $this->className;
    }
    
    public function getRepository()
    {
        return $this->repository;
    }
    
    public function getObjectManager()
    {
        return $this->objectManager;
    }
    
    public function getEventDispatcher()
    {
        return $this->eventDispatcher;
    }
    
    public function flush()
    {
        $this->objectManager->flush();
    }
    
    public function persist(RecipientInterface $recipient)
    {
        $this->objectManager->persist($recipient);
    }
    
    public function remove(RecipientInterface $recipient)
    {
        $this->objectManager->remove($recipient);
    }    
    
    public function create(array $data = array())
    {
        $recipient = new $this->className();
        $class = $this->objectManager->getClassMetadata($this->className);
        
        foreach ($data as $field => $value) {
            if (isset($class->fieldMappings[$field]) || isset($class->associationMappings[$field])) {
                $class->reflFields[$field]->setValue($recipient, $value);
            }
        }
        
        return $recipient;
    }
    
    public function delete(RecipientInterface $recipient, $withFlush = true)
    {
        $this->remove($recipient);
        
        if($withFlush) {
            $this->flush();
        }
    }    
    
    public function save(RecipientInterface $recipient, $withFlush = true)
    {
        $this->persist($recipient);
        
        if($withFlush) {
            $this->flush();
        }
    } 
    
    public function createByEmailAndName($email, $name = null)
    {
        $data = array(
            'email' => $email,
            'name'  => $name
        );
        
        return $this->create($data);
    }
}
