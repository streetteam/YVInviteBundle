<?php

namespace YV\InviteBundle\Model\Manager;

interface ManagerInterface
{    
    public function getClassName();
    
    public function getRepository();
    
    public function getObjectManager();
    
    public function getEventDispatcher();   
}
