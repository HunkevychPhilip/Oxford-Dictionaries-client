<?php

namespace App\Entity;

class Entry
{
    private $definitions = [];

    private $pronunciations = [];

    private $examples = [];


    /**
     * @param $definition
     *
     * @return $this
     */
    public function addDefinition($definition)
    {
        if (!in_array($definition, $this->definitions)) {
            $this->definitions[] = $definition;
        }

        return $this;
    }

    /**
     * @param $link
     *
     * @return $this
     */
    public function addPronunciation($link)
    {
        if (!in_array($link, $this->pronunciations)) {
            $this->pronunciations[] = $link;
        }

        return $this;
    }

    /**
     * @param $example
     *
     * @return $this
     */
    public function addExample($example)
    {
        if (!in_array($example, $this->examples)) {
            $this->examples[] = $example;
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getDefinitions(): array
    {
        return $this->definitions;
    }

    /**
     * @return array
     */
    public function getPronunciations(): array
    {
        return $this->pronunciations;
    }

    /**
     * @param array $examples
     */
    public function getExamples(array $examples): void
    {
        $this->examples = $examples;
    }
}
