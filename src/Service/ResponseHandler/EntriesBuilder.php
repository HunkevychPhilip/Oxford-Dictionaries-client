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
    public function build(): array
    {
        $entries = [];
        $pronunciationsFlags = [];

        foreach ($this->response->results as $resultObject) {
            foreach ($resultObject->lexicalEntries as $lexicalEntryObject) {
                foreach ($lexicalEntryObject->entries as $entryObject) {

                    $definitions = [];
                    $examples = [];
                    $pronunciations = [];

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

                    if (!empty($definitions)) {
                        $entry->addDefinition($definitions);
                    }

                    if (!empty($examples)) {
                        $entry->addExample($examples);
                    }

                    if (!empty($pronunciations)) {
                        $entry->addPronunciation($pronunciations);
                    }

                    $entries[] = $entry;
                }
            }
        }

        return $entries;
    }
}
