<?php
namespace Unoegohh\AdminBundle\Service;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Templating\EngineInterface;

class SitePrefService extends \Twig_Extension
{
    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('pref', array($this, 'pref')),
        );
    }

    public function pref()
    {
        $settRepo = $this->em->getRepository("UnoegohhEntitiesBundle:SitePref");

        $pref = $settRepo->findOneBy(array());

        return $pref;
    }

    public function getName()
    {
        return 'pref';
    }
}