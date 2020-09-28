<?php

namespace App\Tests\Service;

use App\Service\Dictionary;
use App\Service\Client\GuzzleClient;
use App\Service\DictionaryException;
use PHPUnit\Framework\TestCase;

class DictionaryTest extends TestCase
{
    private $fixture;

    /**
     * To pass the tests correctly you must enter valid APP_ID and APP_KEY
     * You can get some after registration on the https://developer.oxforddictionaries.com/
     */
    public function setUp()
    {
        $this->fixture = new Dictionary(new GuzzleClient(
            'https://od-api.oxforddictionaries.com/api/v2/entries/',
            '763efe18',
            '162e8420c914b0a1e4a8d15b879249aa'));

        $this->fixture->setWord('run');
        $this->fixture->setLanguage('en-us');
        $this->fixture->setStrictMatch(false);
    }

    public function tearDown()
    {
        $this->fixture = null;
    }

    /**
     * Checks whether the response is an array and has definition and pronunciation values inside each Entry object
     */
    public function testResponseHasTwoFields()
    {
        $this->fixture->setFields(['pronunciations', 'definitions']);
        $result = $this->fixture->entries();

        $this->assertIsArray($result);
        $this->assertContainsOnlyInstancesOf('App\Entity\Entry', $result);

        foreach($result as $entry) {
            $temp = get_object_vars($entry);
            $this->assertTrue(!empty($temp['pronunciations']));
            $this->assertTrue(!empty($temp['definitions']));

            // we didn't ask the examples, so they should not be here
            $this->assertFalse(!empty($temp['examples']));
        }
    }

    /**
     * Checks whether the response is an array and has only definition values inside each Entry object
     */
    public function testResponseHasOneField()
    {
        $this->fixture->setFields(['definitions']);
        $result = $this->fixture->entries();

        $this->assertIsArray($result);
        $this->assertContainsOnlyInstancesOf('App\Entity\Entry', $result);

        foreach($result as $entry) {
            $temp = get_object_vars($entry);
            $this->assertTrue(!empty($temp['definitions']));

            // we didn't ask the pronunciations and examples, so they should not be here
            $this->assertFalse(!empty($temp['pronunciations']));
            $this->assertFalse(!empty($temp['examples']));
        }
    }

    /**
     * @throws DictionaryException when something is wrong with the HTTP request
     */
    public function testNegative()
    {
        $this->fixture->setWord('there_is_no_match_with_this_string');

        $this->expectException(DictionaryException::class);
        $this->fixture->entries();
    }
}
