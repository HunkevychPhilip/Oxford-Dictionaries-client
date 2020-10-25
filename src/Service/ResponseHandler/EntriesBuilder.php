<?php

namespace App\Service\ResponseHandler;

use App\Entity\Entry;

class EntriesBuilder
{
    private $data = [];

    public function __construct(array $response)
    {
        $this->data = $response;
    }

    /**
     * @return array
     */
    public function build(): array
    {
        $entries = [];
        $core = $this->data['results'] ? $this->data['results'] : ['Error' => '"Results" array is not found'];

        if (in_array('Error', $core)) {
            return $core;
        } else {

            $lexCategoryFlag = '';
            $dialectFlag = '';
            foreach ($core as $results) {
                $entry = new Entry();

                $entry->setLanguage($results['language'] ?? null);
                foreach ($results['lexicalEntries'] as $lexEntry) {
                    if (!empty($lexEntry['lexicalCategory'])) {
                        foreach ($lexEntry['lexicalCategory'] as $key => $lexCategory) {
                            if ($key === 'id') {
                                $lexCategoryFlag = $lexCategory;
                            }
                        }
                    }
                    if (!empty(($lexEntry['entries']))) {
                        foreach ($lexEntry['entries'] as $lexEntries) {
                            if (!empty($lexEntries['senses'])) {
                                foreach ($lexEntries['senses'] as $senses) {
                                    if (!empty($senses['definitions'])) {
                                        foreach ($senses['definitions'] as $definition) {
                                            $entry->setDefinition($definition, $lexCategoryFlag);
//                                            $exampleKeyFlag = count($this->gatheredData['definitions'][$lexCategoryFlag]) + 1;
                                            if (!empty($senses['examples'])) {
                                                    foreach ($senses['examples'] as $examples) {
                                                        foreach ($examples as $key => $example) {
                                                            if ($key === 'text') {
                                                                $entry->setExample($example);
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                            if (!empty($lexEntries['pronunciations'])) {
                                foreach ($lexEntries['pronunciations'] as $pronunciation) {
//                                    if (!empty($pronunciation['dialects'])) {
//                                        $dialectFlag = $pronunciation['dialects'][0];
//                                    }
                                    if (!empty($pronunciation['audioFile'])) {
                                        $entry->setPronunciation($pronunciation['audioFile']);
                                    }
                                }
                            }
                        }
                }
                $entries[] = $entry;
            }
        }
        return $entries;
    }
}
