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

class RemoveAllPostsCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('unoegohh:site:remove_all_posts')
            ->setDescription('gets all posts fro tumblr');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        /*
         * @var $em EntityManager
         */
        $em = $this->getContainer()->get('doctrine')->getManager();
        $prfRepo = $em->getRepository('UnoegohhEntitiesBundle:SitePref');

        $pref = $prfRepo->findOneBy(array(), array(), 1);
        $clientClass = new ThumblrClient($pref);
        $client = $clientClass->GetClient();

        $posts = $client->getBlogPosts($pref->getTumblrBlogName(), $options = null);


        $prefRepo = $em->getRepository('UnoegohhEntitiesBundle:Post');
        $posts = $prefRepo->findAll();
        foreach($posts as $val){
            $em->remove($val);
        }
        $em->flush();

    }
}