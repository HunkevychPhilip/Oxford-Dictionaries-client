<?php

namespace App\Entity;

class Entry
{
    private $definitions = [];

    private $pronunciations = [];

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
}
