<?php

namespace DoubleThreeDigital\Zippy\Documentation;

class DocumentationHit
{
    protected $title;
    protected $url;

    public function __construct(string $title, string $url)
    {
        $this->title = $title;
        $this->url = $url;
    }

    public function title()
    {
        return $this->title;
    }

    public function url()
    {
        return $this->url;
    }

    public function parent()
    {
        return [
            'title' => null,
            'url' => null,
        ];
    }
}
