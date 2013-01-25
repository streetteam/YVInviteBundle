<?php

namespace YV\InviteBundle\Model;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * An invitation, which may be used by one or more users
 * 
 * @Gedmo\Tree(type="nested")
 * @MappedSuperclass
 */
abstract class NestedInvite extends Invite
{
    /**
     * @Gedmo\TreeLeft
     * @ORM\Column(name="left", type="integer")
     */
    protected $left;

    /**
     * @Gedmo\TreeLevel
     * @ORM\Column(name="level", type="integer")
     */
    protected $level;

    /**
     * @Gedmo\TreeRight
     * @ORM\Column(name="right", type="integer")
     */
    protected $right;

    /**
     * @Gedmo\TreeRoot
     * @ORM\Column(name="root", type="integer", nullable=true)
     */
    protected $root;

    /**
     * @Gedmo\TreeParent
     * @ORM\ManyToOne(targetEntity="Invite", inversedBy="children")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $parent;

    /**
     * @ORM\OneToMany(targetEntity="Invite", mappedBy="parent")
     * @ORM\OrderBy({"left" = "ASC"})
     */
    protected $children;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        
        $this->children = new \Doctrine\Common\Collections\ArrayCollection();
        $this->inviteRecipients = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Set left
     *
     * @param integer $left
     * @return NestedInvite
     */
    public function setLeft($left)
    {
        $this->left = $left;
    
        return $this;
    }

    /**
     * Get left
     *
     * @return integer 
     */
    public function getLeft()
    {
        return $this->left;
    }

    /**
     * Set level
     *
     * @param integer $level
     * @return NestedInvite
     */
    public function setLevel($level)
    {
        $this->level = $level;
    
        return $this;
    }

    /**
     * Get level
     *
     * @return integer 
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Set right
     *
     * @param integer $right
     * @return NestedInvite
     */
    public function setRight($right)
    {
        $this->right = $right;
    
        return $this;
    }

    /**
     * Get right
     *
     * @return integer 
     */
    public function getRight()
    {
        return $this->right;
    }

    /**
     * Set root
     *
     * @param integer $root
     * @return NestedInvite
     */
    public function setRoot($root)
    {
        $this->root = $root;
    
        return $this;
    }

    /**
     * Get root
     *
     * @return integer 
     */
    public function getRoot()
    {
        return $this->root;
    }
    
    /**
     * Set parent
     *
     * @param NestedInvite $parent
     * @return NestedInvite
     */    
    public function setParent(NestedInvite $parent = null)
    {
        $this->parent = $parent; 
        
        return $this;
    }

    /**
     * Get parent
     *
     * @return NestedInvite 
     */    
    public function getParent()
    {
        return $this->parent;   
    }    
}