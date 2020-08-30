<?php

use Behat\Behat\Context\Context;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context
{
    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
    }

    /**
     * @Given I am an unauthenticated user
     */
    public function iAmAnUnauthenticatedUser()
    {
        $mock = new MockHttpClient(new MockResponse());

        $response = $mock->request('GET', 'http://localhost');
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
        $mock = new MockHttpClient(new MockResponse());

        $response = $mock->request('GET', $arg1.'/announcements');

        $responseCode = $response->getStatusCode();

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
        $body = [
            [
                'id' => 1,
                'description' => 'Announcement description 1',
            ],
            [
                'id' => 2,
                'description' => 'Announcement description 2',
            ]
        ];

        $responses = [
            new MockResponse($body)
        ];

        $mock = new MockHttpClient(new MockResponse(json_encode($body)));

        $response = $mock->request('GET', 'http://localhost:8000/announcements');

        $data = json_decode($response->getContent(), true);

        if($data[0]['id']==1)
        {
            return true;
        }

        throw new Exception('Expected to find announcement'.$arg1."' but didn't");
    }

}
