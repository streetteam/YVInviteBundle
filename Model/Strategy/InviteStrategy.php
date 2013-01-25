<?php

namespace YV\InviteBundle\Model\Strategy;

use Doctrine\Common\Persistence\ObjectManager;

use YV\InviteBundle\Model\ModelInterface\RecipientInterface;

class InviteStrategy implements InviteStrategyInterface
{
    protected $className;
    
    protected $objectManager;
    
    protected $repository;
    
    public function __construct(ObjectManager $objectManager, $className) 
    {
        $this->objectManager = $objectManager;
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
    
    public function generateInvite(array $data, RecipientInterface $recipient = null, $withFlush = true) 
    {
        $invite = new $this->className();
        $class = $this->objectManager->getClassMetadata($this->className);
        
        $data = array_merge(array('code' => $this->generateCode()), $data);
        
        foreach ($data as $field => $value) {
            if (isset($class->fieldMappings[$field]) || isset($class->associationMappings[$field])) {
                $class->reflFields[$field]->setValue($invite, $value);
            }
        }
        
        if($recipient !== null) {
            $invite->addRecipient($recipient);
            $recipient->setInvite($invite);
            
            $this->objectManager->persist($recipient);
        }
         
        $this->objectManager->persist($invite);
        
        if($withFlush) {
            $this->objectManager->flush();
        }
        
        return $invite;
    }
    
    public function generateCode($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $code = '';
        
        for ($max = strlen($characters) - 1, $i = 0; $i < $length; ++$i) {
            $code .= $characters[mt_rand(0, $max)];
        }
        
        return $code;
    }    
}
