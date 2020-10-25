<?php

namespace App\Entity;

class Entry
{
    protected $definitions = [];
    protected $pronunciations = [];
    protected $examples = [];
    protected $languages = [];

    /**
     * @param string $language
     */
    public function setLanguage(string $lang): void
    {
        if (!in_array($lang ,$this->languages)) {
            $this->languages[] = $lang;
        }
    }

    /**
     * @param string $definition
     */
    public function setDefinition(string $definition, string $flag): void
    {
        if (!in_array($definition, $this->definitions)) {
            $this->definitions[$flag][] = $definition;
        }
    }

    /**
     * @param $link
     */
    public function setPronunciation($link): void
    {
        if (!in_array($link, $this->pronunciations)) {
            $this->pronunciations[] = $link;
        }
    }

    /**
     * @param $example
     */
    public function setExample($example): void
    {
        $this->examples[] = $example;
    }

    /**
     * @return array
     */
    public function getDefinition(): array
    {
        return $this->definitions;
    }

    /**
     * @return array
     */
    public function getPronunciation(): array
    {
        return $this->pronunciations;
    }

    /**
     * @return array
     */
    public function getExample(): array
    {
        return $this->examples;
    }

    /**
     * @return mixed
     */
    public function getLanguage(): string
    {
        return $this->langToString($this->language);
    }

    /**
     * @param string $lang
     * @return string
     */
    public function langToString(string $lang): string
    {
        $flag = $this->language;
        $result = '';
        if ($flag === 'en-us') {
            $result = 'American English';
        } elseif ($flag === 'en-gb') {
            $result = 'British English';
        }

        return $result;
    }
}
