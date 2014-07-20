<?php
namespace Unoegohh\SiteBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Unoegohh\AdminBundle\VK;
use Unoegohh\AdminBundle\VKClient;
use Unoegohh\AdminBundle\VKException;
use Unoegohh\EntitiesBundle\Entity\Contact;
use Unoegohh\EntitiesBundle\Entity\Post;
use Unoegohh\EntitiesBundle\Entity\SitePref;
use Unoegohh\SiteBundle\ThumblrClient;
use Tumblr\API;

class GetVkTokenCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('unoegohh:site:get_vk_token');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $vkontakteApplicationId = '4457592';
        $vkontakteKey ='vVOu9wwkopnv95yUTQ3C';
        $vkontakteUserId='4457036';
        $token = "3444e2ae4d4074a89d";
        /*
         * @var $em EntityManager
         */
        $em = $this->getContainer()->get('doctrine')->getManager();
        $prfRepo = $em->getRepository('UnoegohhEntitiesBundle:SitePref');

        $pref = $prfRepo->findOneBy(array(), array(), 1);
        $vk_config = array(
            'app_id'        => $vkontakteApplicationId,
            'api_secret'    => $vkontakteKey,
            'callback_url'  => 'https://oauth.vk.com/blank.html',
            'api_settings'  => 'offline' // In this example use 'friends'.
            // If you need infinite token use key 'offline'.
        );
        //$client = new VKClient($vkontakteApplicationId, $vkontakteKey,$token);
        try {
            $vk     =new VKClient($vkontakteApplicationId, $vkontakteKey, "d944316de2dd3a7509dab6781d92ca8cb76eec051fa32c635740b97f5c7fa11e0009727a413beecbe37cb");

//            if (!isset($_REQUEST['code'])) {
//                /**
//                 * If you need switch the application in test mode,
//                 * add another parameter "true". Default value "false".
//                 * Ex. $vk->getAuthorizeURL($api_settings, $callback_url, true);
//                 */
//                $authorize_url = $vk->getAuthorizeURL(
//                    $vk_config['api_settings'], $vk_config['callback_url']);
//
//                echo '<a href="' . $authorize_url . '">Sign in with VK</a>';
//            } else {
//                $access_token = $vk->getAccessToken('54129596bd2cf906cd', $vk_config['callback_url']);
//
//                echo 'access token: ' . $access_token['access_token']
//                    . '<br />expires: ' . $access_token['expires_in'] . ' sec.'
//                    . '<br />user id: ' . $access_token['user_id'] . '<br /><br />';

                $user_friends = $vk->api('wall.post', array(
                    'owner_id'  => -$vkontakteApplicationId,
                    'from_group'    => '1',
                    'message'     => 'Привет'
                ));
                var_dump($user_friends);
//
//                foreach ($user_friends['response'] as $key => $value) {
//                    echo $value['first_name'] . ' ' . $value['last_name'] . ' ('
//                        . $value['uid'] . ')<br />';
//                }
//            }
        } catch (VKException $error) {
            echo $error->getMessage();
        }
       // $output->writeln($client->isAuth());
        // http://api.vkontakte.ru/oauth/authorize?client_id=4457592&scope=offline,wall&redirect_uri=http://moscow.localhost/ru&response_type=code
    }
}