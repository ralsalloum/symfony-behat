<?php

namespace App\Controller;

//use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Client;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AnnouncementsController extends AbstractController
{

    /**
     * @Route("/")
     */
    public function home()
    {
        return $this->json(['res'=>true]);
    }
    /**
     * @Route("/announcements", name="announcements")
     */
    public function index()
    {
        $announcements = [
            [
                'id' => 1,
                'description' => 'Announcement description 1',
            ],
            [
                'id' => 2,
                'description' => 'Announcement description 2',
            ]
        ];

        $response = new Response();
        //$client = new Client(['base_uri'=>'http://localhost:8080/']);
        //$request = $client->request('GET', '/');
        ///$response = $client->send($request);
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->setContent(json_encode($announcements));

        return $response;
    }
}
