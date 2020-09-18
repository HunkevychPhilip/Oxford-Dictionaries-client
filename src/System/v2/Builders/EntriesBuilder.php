<?php

namespace App\System\v2\Builders;

use App\System\v2\Entity\Entry;
use http\Exception\InvalidArgumentException;

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
        try {
            foreach ($this->data->results as $result) {
                $entries[] = $this->buildEntry($result);
            }
        } catch (\InvalidArgumentException $e) {
            $error = $e->getMessage();
            header("Location: /?error=$error");
            die();
        }

        return $entries;
    }

    /**
     * @param $result
     * @return Entry
     */
    private function buildEntry($result)
    {
        $entry = new Entry();

        foreach ($result->lexicalEntries as $lexicalEntry) {
            foreach ($lexicalEntry->entries as $coreInfo) {

                if (isset($coreInfo->senses)) {
                    foreach ($coreInfo->senses as $sense) {
                        foreach ($sense->definitions as $definition) {
                            $entry->addDefinition($definition);
                        }
                    }
                }

                if (isset($coreInfo->pronunciations)) {
                    foreach ($coreInfo->pronunciations as $pronunciation) {
                        $entry->addPronunciation($pronunciation);
                    }
                }
            }
        }

        return $entry;
    }
}
