<?php

namespace App\Service\ResponseHandler;

use App\Entity\Entry;

class EntriesBuilder
{
    private $response;

    public function __construct($data)
    {
        $this->response = $data;
    }

    /**
     * @return array
     */
    public function build() : array
    {
        $entries = [];

        foreach ($this->response->results as $resultObject) {
            foreach ($resultObject->lexicalEntries as $lexicalEntryObject) {
                foreach ($lexicalEntryObject->entries as $entryObject) {

                    $definitions = [];
                    $pronunciations = [];
                    $examples = [];

                    if (property_exists($entryObject, 'pronunciations')) {
                        foreach ($entryObject->pronunciations as $pronunciationObject) {
                            if (property_exists($pronunciationObject, 'audioFile')) {
                                $pronunciations[] = $pronunciationObject->audioFile;
                            }
                        }
                    }

                    if (property_exists($entryObject, 'senses')) {
                        foreach ($entryObject->senses as $senseObject) {

                            if (property_exists($senseObject, 'definitions')) {
                                foreach ($senseObject->definitions as $definitionProperty) {
                                    $definitions[] = $definitionProperty;
                                }
                            }

                            if (property_exists($senseObject, 'examples')) {
                                foreach ($senseObject->examples as $exampleObject) {
                                    $examples[] = $exampleObject->text;
                                }
                            }

                        }
                    }
                    $entry = new Entry();

                    if (count($definitions) > 0) {
                        $entry->addDefinition($definitions);
                    }

                    if (count($pronunciations) > 0) {
                        $entry->addPronunciation($pronunciations);
                    }

                    if (count($examples) > 0) {
                        $entry->addExample($examples);
                    }

                    $entries[] = $entry;
                }
            }
        }

        return $entries;
    }
}
