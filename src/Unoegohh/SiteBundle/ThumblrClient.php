<?php

namespace Unoegohh\SiteBundle;
use Tumblr\API;

 class ThumblrClient
{
    public function __construct(){
        $client = new API\Client('ONPKUuYNo7QYUle7A1mfMDEhfk5HIXFGsb069DefRPGAs4Apem', 'OOp9g0SPzseek2ZkCo5SkR7370qCcttEhgA0JOUjkqdHp0ferd', 'kFeMm5WDiDy9goWskC4kfBfhYioOf7To5aqhwZnp02p7sxe8cF', '0CY0wB004uL62jxNQWk7nudHVkVlLd9ELrC1Fn8XDtU6VtKF3C');

        $this->client = $client;
    }
    public $client;

    public function GetClient(){
        return $this->client;
    }
}
