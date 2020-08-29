<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Component\HttpClient\HttpClient;

//use GuzzleHttp\Exception\GuzzleException;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context
{

    protected $response;
    private $client;
    private $uri;
    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
        //$this->client = $client;
        $this->uri = 'http://localhost:8000';
    }

    /**
     * @Given I am an unauthenticated user
     * @throws GuzzleException
     */
    public function iAmAnUnauthenticatedUser()
    {
        $client = new GuzzleHttp\Client();

        $response = $client->request("GET", $this->uri);

        $resCod = $response->getStatusCode();

        if($resCod != 200)
        {
            throw new Exception();
        }

        return true;

    }

    /**
     * @When I request a list of announcements from :arg1
     */
    public function iRequestAListOfAnnouncementsFrom($arg1)
    {
        $client = new GuzzleHttp\Client(['base_uri'=>$arg1]);

        $this->response = $client->get('/announcements');

        $responseCode = $this->response->getStatusCode();

        if($responseCode !== 200)
        {
            throw new Exception('Expected a 200. But received '.$responseCode);
        }

        return true;
    }

    /**
     * @Then The results should include an announcement with ID :arg1
     */
    public function theResultsShouldIncludeAnAnnouncementWithId($arg1)
    {
        $announcements = json_decode($this->response->getBody()->getContents(), true);

        if($announcements[0] == $arg1)
                return true;

        throw new Exception('Expected to find announcement'.$arg1."' but didn't");
    }

}
