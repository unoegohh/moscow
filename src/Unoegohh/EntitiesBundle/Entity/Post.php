<?php
namespace Unoegohh\EntitiesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="posts")
 */
class Post
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
     * @ORM\Column(type="string")
     */
    protected $photo;

    /**
     * @ORM\Column(type="string")
     */
    protected $tId;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $date;

    /**
     * @ORM\Column(type="string")
     */
    protected $reblog;

    /**
     * @ORM\Column(type="string")
     */
    protected $miniPhoto;

    /**
     * @ORM\Column(type="string")
     */
    protected $bigPhoto;

    /**
     * @ORM\Column(type="string")
     */
    protected $tUrl;

    /**
     * @ORM\Column(type="string", length=10000)
     */
    protected $descr;

    /**
     * @ORM\Column(type="string", length=10000)
     */
    protected $descr_eng;

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
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $photo
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;
    }

    /**
     * @return mixed
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * @param mixed $reblog
     */
    public function setReblog($reblog)
    {
        $this->reblog = $reblog;
    }

    /**
     * @return mixed
     */
    public function getReblog()
    {
        return $this->reblog;
    }

    /**
     * @param mixed $tId
     */
    public function setTId($tId)
    {
        $this->tId = $tId;
    }

    /**
     * @return mixed
     */
    public function getTId()
    {
        return $this->tId;
    }

    /**
     * @param mixed $tUrl
     */
    public function setTUrl($tUrl)
    {
        $this->tUrl = $tUrl;
    }

    /**
     * @return mixed
     */
    public function getTUrl()
    {
        return $this->tUrl;
    }

    /**
     * @param mixed $descr
     */
    public function setDescr($descr)
    {
        $this->descr = $descr;
    }

    /**
     * @return mixed
     */
    public function getDescr()
    {
        return $this->descr;
    }

    /**
     * @param mixed $descr_eng
     */
    public function setDescrEng($descr_eng)
    {
        $this->descr_eng = $descr_eng;
    }

    /**
     * @return mixed
     */
    public function getDescrEng()
    {
        return $this->descr_eng;
    }

    /**
     * @param mixed $miniPhoto
     */
    public function setMiniPhoto($miniPhoto)
    {
        $this->miniPhoto = $miniPhoto;
    }

    /**
     * @return mixed
     */
    public function getMiniPhoto()
    {
        return $this->miniPhoto;
    }

    /**
     * @param mixed $bigPhoto
     */
    public function setBigPhoto($bigPhoto)
    {
        $this->bigPhoto = $bigPhoto;
    }

    /**
     * @return mixed
     */
    public function getBigPhoto()
    {
        return $this->bigPhoto;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }



    public function convertFromTumblr(\StdClass $post , SitePref $pref){

        $this->setName($post->blog_name);
        $this->setPhoto($post->photos[0]->alt_sizes[2]->url);
        $this->setMiniPhoto($post->photos[0]->alt_sizes[5]->url);
        $this->setBigPhoto($post->photos[0]->original_size->url);
        $this->setDate(new \DateTime("@" . $post->timestamp));
        $this->setReblog($post->reblog_key);
        $this->setTId($post->id);
        $this->setTUrl($post->short_url);

        $postDescrs = explode($pref->getTumblrDelimeter(),$post->caption);
        $this->setDescr($postDescrs[1]);
        $this->setDescrEng($postDescrs[0]);

        return true;

    }


}