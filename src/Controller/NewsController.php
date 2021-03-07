<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class NewsController extends AbstractController
{
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }
    
    /**
     * This function is used to fetch the Business News (using REST API) and display it in tabular format
     * @return : HTML
     */
    public function display()
    {        
        try {
            //REST Call to news Api
            $response = $this->client->request('GET', 'http://newsapi.org/v2/top-headlines', [
                'headers' => [
                    'Accept' => 'application/json'
                ],
                'query' => [
                    'country' => 'us',
                    'category' => 'business',
                    'apiKey' => '44ffe07a0aac4b58a4976a6e030e37e4'
                ]
            ]);
            $content = $response->toArray();
           
            return $this->render('news/index.html.twig', [
                'articles' => $content['articles']
            ]);
        } catch (Exception $e) {
            return json_encode(['message' => $e->getMessage(), 'code' => $e->getCode()]);
        }
    }
}