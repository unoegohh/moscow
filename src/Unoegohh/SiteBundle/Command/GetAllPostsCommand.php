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

class GetAllPostsCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('unoegohh:site:all_posts')
            ->setDescription('gets all posts fro tumblr');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $clientClass = new ThumblrClient();
        $client = $clientClass->GetClient();

        $posts = $client->getBlogPosts('unoegohh', $options = null);

        /*
         * @var $em EntityManager
         */
        $em = $this->getContainer()->get('doctrine')->getManager();

        $prefRepo = $em->getRepository('UnoegohhEntitiesBundle:Post');
        foreach($posts->posts as $post){
            try{
                $item = new Post();
                $item->setName($post->blog_name);
                $item->setPhoto($post->photos[0]->alt_sizes[2]->url);
                $item->setMiniPhoto($post->photos[0]->alt_sizes[5]->url);
                $item->setDate(new \DateTime("@" . $post->timestamp));
                $item->setReblog($post->reblog_key);
                $item->setBigPhoto($post->photos[0]->original_size->url);
                $item->setTId($post->id);
                $item->setTUrl($post->short_url);

                $postDescrs = explode("#humasofmoscow#",$post->caption);
                $item->setDescr($postDescrs[0]);
                $item->setDescrEng($postDescrs[1]);
                $postItem = $prefRepo->findOneBy(array('tId' => $post->id));
                if(!$postItem){
                    $output->writeln('Added item with id ' . $item->getTId());

                    $em->persist($item);
                }
            }
            catch(\Exception $e){
                $output->writeln('Problems with  ' . $item->getTId());

            }

        }
        $em->flush();

    }
}