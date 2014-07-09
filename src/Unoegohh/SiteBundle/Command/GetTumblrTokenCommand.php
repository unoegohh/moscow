<?php
namespace Unoegohh\SiteBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Unoegohh\EntitiesBundle\Entity\Contact;
use Unoegohh\EntitiesBundle\Entity\Post;
use Unoegohh\EntitiesBundle\Entity\SitePref;
use Unoegohh\SiteBundle\ThumblrClient;
use Tumblr\API;

class GetTumblrTokenCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('unoegohh:site:initTumblr')
            ->setDescription('gets all posts fro tumblr');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        /*
         * @var $em EntityManager
         */
        $em = $this->getContainer()->get('doctrine')->getManager();
        /*
         * @var $pref SitePref
         */
        $pref = $em->getRepository("UnoegohhEntitiesBundle:SitePref")->findOneBy(array());
        $consumerKey = $pref->getTumblrToken();
        $consumerSecret = $pref->getTumblrSecret();
        // some variables that will be pretttty useful
        $client = new API\Client($consumerKey, $consumerSecret);
        $requestHandler = $client->getRequestHandler();
        $requestHandler->setBaseUrl('https://www.tumblr.com/');

// start the old gal up
        $resp = $requestHandler->request('POST', 'oauth/request_token', array());

// get the oauth_token
        $out = $result = $resp->body;
        $data = array();
        parse_str($out, $data);


// tell the user where to go
        echo 'https://www.tumblr.com/oauth/authorize?oauth_token=' . $data['oauth_token'];
        $client->setToken($data['oauth_token'], $data['oauth_token_secret']);

// get the verifier
        echo "\noauth_verifier: ";
        $handle = fopen('php://stdin', 'r');
        $line = fgets($handle);

// exchange the verifier for the keys
        $verifier = trim($line);
        $resp = $requestHandler->request('POST', 'oauth/access_token', array('oauth_verifier' => $verifier));
        $out = $result = $resp->body;
        $data = array();
        parse_str($out, $data);

// and print out our new keys
        $token = $data['oauth_token'];
        $secret = $data['oauth_token_secret'];
        $pref->setTumblrAToken($data['oauth_token']);
        $pref->setTumblrASecret($data['oauth_token_secret']);
        $em->persist($pref);
        $em->flush();
        echo "\ntoken: " . $token . "\nsecret: " . $secret;

// and prove we're in the money
        $client = new API\Client($consumerKey, $consumerSecret, $token, $secret);
        $info = $client->getUserInfo();
        echo "\ncongrats " . $info->user->name . "!\n";
    }
}