<?php

namespace App\Entity;

class SearchQuery
{
    protected $word;
    protected $language;

    /**
     * @return mixed
     */
    public function getWord()
    {
        return $this->word;
    }

    /**
     * @param mixed $word
     */
    public function setWord($word): void
    {
        $this->word = $word;
    }

    /**
     * @return mixed
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * @param mixed $language
     */
    public function setLanguage($language): void
    {
        $this->language = $language;
    }

}
