<?php
namespace Unoegohh\EntitiesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="site_pref")
 */
class SitePref
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $active;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $facebookUrl;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $tumblrToken;
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $tumblrBlogName;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $tumblrSecret;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $tumblrAToken;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $tumblrASecret;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $vkLink;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $facebookLink;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $tumblrLink;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $twitterLink;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $instaLink;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $tumblrDelimeter;

    /**
     * @param mixed $active
     */
    public function setActive($active)
    {
        $this->active = $active;
    }

    /**
     * @return mixed
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * @param mixed $facebookLink
     */
    public function setFacebookLink($facebookLink)
    {
        $this->facebookLink = $facebookLink;
    }

    /**
     * @return mixed
     */
    public function getFacebookLink()
    {
        return $this->facebookLink;
    }

    /**
     * @param mixed $facebookUrl
     */
    public function setFacebookUrl($facebookUrl)
    {
        $this->facebookUrl = $facebookUrl;
    }

    /**
     * @return mixed
     */
    public function getFacebookUrl()
    {
        return $this->facebookUrl;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $instaLink
     */
    public function setInstaLink($instaLink)
    {
        $this->instaLink = $instaLink;
    }

    /**
     * @return mixed
     */
    public function getInstaLink()
    {
        return $this->instaLink;
    }

    /**
     * @param mixed $tumblrASecret
     */
    public function setTumblrASecret($tumblrASecret)
    {
        $this->tumblrASecret = $tumblrASecret;
    }

    /**
     * @return mixed
     */
    public function getTumblrASecret()
    {
        return $this->tumblrASecret;
    }

    /**
     * @param mixed $tumblrAToken
     */
    public function setTumblrAToken($tumblrAToken)
    {
        $this->tumblrAToken = $tumblrAToken;
    }

    /**
     * @return mixed
     */
    public function getTumblrAToken()
    {
        return $this->tumblrAToken;
    }

    /**
     * @param mixed $tumblrDelimeter
     */
    public function setTumblrDelimeter($tumblrDelimeter)
    {
        $this->tumblrDelimeter = $tumblrDelimeter;
    }

    /**
     * @return mixed
     */
    public function getTumblrDelimeter()
    {
        return $this->tumblrDelimeter;
    }

    /**
     * @param mixed $tumblrSecret
     */
    public function setTumblrSecret($tumblrSecret)
    {
        $this->tumblrSecret = $tumblrSecret;
    }

    /**
     * @return mixed
     */
    public function getTumblrSecret()
    {
        return $this->tumblrSecret;
    }

    /**
     * @param mixed $tumblrToken
     */
    public function setTumblrToken($tumblrToken)
    {
        $this->tumblrToken = $tumblrToken;
    }

    /**
     * @return mixed
     */
    public function getTumblrToken()
    {
        return $this->tumblrToken;
    }

    /**
     * @param mixed $twitterLink
     */
    public function setTwitterLink($twitterLink)
    {
        $this->twitterLink = $twitterLink;
    }

    /**
     * @return mixed
     */
    public function getTwitterLink()
    {
        return $this->twitterLink;
    }

    /**
     * @param mixed $vkLink
     */
    public function setVkLink($vkLink)
    {
        $this->vkLink = $vkLink;
    }

    /**
     * @return mixed
     */
    public function getVkLink()
    {
        return $this->vkLink;
    }

    /**
     * @param mixed $tumblrLink
     */
    public function setTumblrLink($tumblrLink)
    {
        $this->tumblrLink = $tumblrLink;
    }

    /**
     * @return mixed
     */
    public function getTumblrLink()
    {
        return $this->tumblrLink;
    }

    /**
     * @param mixed $tumblrBlogName
     */
    public function setTumblrBlogName($tumblrBlogName)
    {
        $this->tumblrBlogName = $tumblrBlogName;
    }

    /**
     * @return mixed
     */
    public function getTumblrBlogName()
    {
        return $this->tumblrBlogName;
    }



}