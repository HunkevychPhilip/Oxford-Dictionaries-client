<?php

namespace App\Entity;

class Entry
{
    public $definitions = [];

    public $pronunciations = [];

    public $examples = [];


    /**
     * @param $definition
     */
    public function addDefinition($definition): void
    {
        if (!in_array($definition, $this->definitions)) {
            $this->definitions = $definition;
        }
    }

    /**
     * @param $link
     */
    public function addPronunciation($link): void
    {
        if (!in_array($link, $this->pronunciations)) {
            $this->pronunciations = $link;
        }
    }

    /**
     * @param $example
     */
    public function addExample($example): void
    {
        if (!in_array($example, $this->examples)) {
            $this->examples = $example;
        }
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
