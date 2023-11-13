<?php

namespace Hashbangcode\Composerexample;

class Page implements PageInterface {

    protected $title;

    protected $body;

    public function setTitle($title) {
        $this->title = $title;
        return $this;
    }

    public function getTitle():string {
        return $this->title;
    }

    /**
     * @return mixed
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param mixed $body
     * @return Page
     */
    public function setBody($body)
    {
        $this->body = $body;
        return $this;
    }


}
