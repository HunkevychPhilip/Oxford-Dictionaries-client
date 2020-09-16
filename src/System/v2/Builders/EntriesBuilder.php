<?php

namespace App\System\v2\Builders;

use App\System\v2\Entity\Entry;

class EntriesBuilder
{
    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * @return array
     */
    public function build() : array
    {
        $entries = [];
        foreach ($this->data->results as $item) {
            $entries[] = $this->buildEntry($item);
        }

        return $entries;
    }

    /**
     * @param $response
     *
     * @return Entry
     */
    private function buildEntry($response)
    {
        $entry = new Entry();

        foreach ($response->lexicalEntries as $lexicalEntry) {
            foreach ($lexicalEntry->entries as $coreInfo) {

                foreach ($coreInfo->senses as $sense) {
                    foreach ($sense->definitions as $definition) {
                        $entry->addDefinition($definition);
                    }
                }

                foreach ($coreInfo->pronunciations as $pronunciation) {
                    $entry->addPronunciation($pronunciation);
                }
            }
        }

        return $entry;
    }
}
