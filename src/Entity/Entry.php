<?php

namespace App\Entity;

class Entry
{
    public $definitions = [];

    public $pronunciations = [];

    public $examples = [];


    /**
     * @param $definition
     *
     * @return $this
     */
    public function addDefinition($definition)
    {
        if (!in_array($definition, $this->definitions)) {
            $this->definitions = $definition;
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
            $this->pronunciations = $link;
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
            $this->examples = $example;
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
     * @return array
     */
    public function getExamples(): array
    {
        return $this->examples;
    }
}
