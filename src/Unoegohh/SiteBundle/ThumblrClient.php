<?php

namespace Unoegohh\SiteBundle;
use Tumblr\API;
use Unoegohh\EntitiesBundle\Entity\SitePref;

class ThumblrClient
{
    public function __construct(SitePref $pref){
        $client = new API\Client($pref->getTumblrToken(),$pref->getTumblrSecret(), $pref->getTumblrAToken(), $pref->getTumblrASecret());

        $this->client = $client;
    }
    public $client;

    public function GetClient(){
        return $this->client;
    }
}
