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

        /*
         * @var $em EntityManager
         */
        $em = $this->getContainer()->get('doctrine')->getManager();
        $prfRepo = $em->getRepository('UnoegohhEntitiesBundle:SitePref');

        $pref = $prfRepo->findOneBy(array(), array(), 1);
        $clientClass = new ThumblrClient($pref);
        $client = $clientClass->GetClient();

        $end = false;
        $offset = 0;
        while($end == false){

            $posts = $client->getBlogPosts($pref->getTumblrBlogName(), $options = array('offset' => $offset));


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

                    $postDescrs = explode($pref->getTumblrDelimeter(),$post->caption);
                    $item->setDescr($postDescrs[1]);
                    $item->setDescrEng($postDescrs[0]);
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
            if(count($posts) != 20){
                $end = true;
            }
            $offset += 20;
            $em->flush();
        }

    }
}