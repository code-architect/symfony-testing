<?php

namespace AppBundle\Controller;


use AppBundle\Entity\Genus;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class GenusController extends Controller
{

    /**
     * @Route("/genus/new",)
     */
    public function newAction()
    {
        $genus = new Genus();
        $genus->setName("Octopus".rand(1, 100));
        $genus->setSubFamily('Octopodinae');
        $genus->setSpeciesCount(rand(100, 1000));
        //$genus->getFunFact("Octopus can change color with in 3rd of a second!! COOL!!");

        $em = $this->getDoctrine()->getManager();

        $em->persist($genus);           // This one tells doctrine that you want to save this
        $em->flush();                   // this line execute the query

        return new Response("<html><body>Data uploaded</body></html>");
    }


    //------------------------------------------------------------------------------------------------------------------//

    /**
     * List of all Genus Data in the database
     * @Route("/genus")
     */
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();

        $genuses = $em->getRepository('AppBundle:Genus')
            ->findAllPublishedOrderedBySize();

        return $this->render('genus/list.html.twig', [
            'genuses' => $genuses,
        ]);
    }




    //------------------------------------------------------------------------------------------------------------------//


    /**
     * @Route("/genus/{genusName}", name="genus_show")
     */
    public function showAction($genusName)
    {
//        $templeting = $this->container->get('templating');
//        $html = $templeting->render('genus/show.html.twig', [
//            'name'  => $genusName,
//        ]);
//        return new Response($html);
        $notes = ["hello"];



        $em = $this->getDoctrine()->getManager();
        $genus = $em->getRepository('AppBundle:Genus')
            ->findOneBy(['name' => $genusName]);

        //error handling
        if(!$genus)
        {
            throw $this->createNotFoundException('No genus Found DUDE!!! SAD :(');
        }

    /*
        $cache = $this->get('doctrine_cache.providers.my_markdown_cache');
        $key = md5($funFact);

        //checking if the same string have passed cache twice
        if($cache->contains($key))
        {
            $funFact = $cache->fetch($key);
        }else{
            $funFact = $this->container->get('markdown.parser')
                ->transform($funFact);
            $cache->save($key, $funFact);
        }
    */
        //dump($genus); die();

        return $this->render('genus/show.html.twig', [
            'genus' =>  $genus,
            'notes' => $notes,

        ]);
    }


    //------------------------------------------------------------------------------------------------------------------//


    /**
     * This give us a JSON response object for api development
     * @Route("/genus/{genusName}/notes", name="genus_show_notes")
     * @Method("GET")
     */
    public function getNotesAction()
    {
        $notes = [
            ['id' => 1, 'username' => 'AquaPelham', 'avatarUri' => '/images/leanna.jpeg', 'note' => 'Octopus asked me a riddle, outsmarted me', 'date' => 'Dec. 10, 2015'],
            ['id' => 2, 'username' => 'AquaWeaver', 'avatarUri' => '/images/ryan.jpeg', 'note' => 'I counted 8 legs... as they wrapped around me', 'date' => 'Dec. 1, 2015'],
            ['id' => 3, 'username' => 'AquaPelham', 'avatarUri' => '/images/leanna.jpeg', 'note' => 'Inked!', 'date' => 'Aug. 20, 2015'],
        ];

        $data = [
            'notes' =>  $notes,
        ];

        return new JsonResponse($data);
    }
}
