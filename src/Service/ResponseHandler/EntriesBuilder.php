<?php

namespace App\Service\ResponseHandler;

use App\Entity\Entry;

class EntriesBuilder
{
    private $response;

    public function __construct($data)
    {
        $this->response = $data;
//        dd($this->response);

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

                    if (property_exists($entryObject, 'pronunciations')) {
                        foreach ($entryObject->pronunciations as $pronunciationObject) {
                            if (property_exists($pronunciationObject, 'audioFile')) {
                                $entry->addPronunciation($pronunciationObject->audioFile);
                            }
                        }
                    }

                    if (property_exists($entryObject, 'senses')) {
                        foreach ($entryObject->senses as $senseObject) {

                            if (property_exists($senseObject, 'definitions')) {
                                foreach ($senseObject->definitions as $definitionProperty) {
                                    $entry->addDefinition($definitionProperty);
                                }
                            }

                            if (property_exists($senseObject, 'examples')) {
                                foreach ($senseObject->examples as $exampleObject) {
                                    $entry->addExample($exampleObject->text);
                                }
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
