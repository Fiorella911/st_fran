<?php

namespace Bundles\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
//use FOS\UserBundle\Entity\User as BaseUser;
use Sonata\UserBundle\Entity\BaseUser as BaseUser;
/**
 * User
 */
class User extends BaseUser
{
     
    /**
     * @var integer
     */
    protected $id;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
    }
    


    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $blog;

//    /**
//     * @var \Doctrine\Common\Collections\Collection
//     */
//    private $groups;


    /**
     * Add blog
     *
     * @param \Site\BlogBundle\Entity\Blog $blog
     * @return User
     */
    public function addBlog(\Site\BlogBundle\Entity\Blog $blog)
    {
        $this->blog[] = $blog;

        return $this;
    }

    /**
     * Remove blog
     *
     * @param \Site\BlogBundle\Entity\Blog $blog
     */
    public function removeBlog(\Site\BlogBundle\Entity\Blog $blog)
    {
        $this->blog->removeElement($blog);
    }

    /**
     * Get blog
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getBlog()
    {
        return $this->blog;
    }

//    /**
//     * Add groups
//     *
//     * @param \Bundles\UserBundle\Entity\Role $groups
//     * @return User
//     */
//    public function addGroup(\Bundles\UserBundle\Entity\Role $groups)
//    {
//        $this->groups[] = $groups;
//
//        return $this;
//    }

//    /**
//     * Remove groups
//     *
//     * @param \Bundles\UserBundle\Entity\Role $groups
//     */
//    public function removeGroup(\Bundles\UserBundle\Entity\Role $groups)
//    {
//        $this->groups->removeElement($groups);
//    }
//
//    /**
//     * Get groups
//     *
//     * @return \Doctrine\Common\Collections\Collection 
//     */
//    public function getGroups()
//    {
//        return $this->groups;
//    }
}
