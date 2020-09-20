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
        $entry = new Entry();


        foreach ($this->response->results as $resultObject) {
            foreach ($resultObject->lexicalEntries as $lexicalEntryObject) {
                foreach ($lexicalEntryObject->entries as $entryObject) {

                    foreach ($entryObject->senses as $senseObject) {
                        foreach ($senseObject->definitions as $definitionProperty) {
                            $entry->addDefinition($definitionProperty);
                        }
                    }

                    if (property_exists($entryObject, 'pronunciations')) {
                        foreach ($entryObject->pronunciations as $pronunciationObject) {
                            if (property_exists($pronunciationObject, 'audioFile')) {
                                $entry->addPronunciation($pronunciationObject->audioFile);
                            }
                        }
                    }
                }
            }
        }

        $entries[] = $entry;

        return $entries;
    }
}
