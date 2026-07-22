<?php

class DocReader
{

    private array $documents = [];


    public function read(string $filePath): string
    {
        if (isset($this->documents[$filePath])) {
            return $this->documents[$filePath];
        }

        if (!file_exists($filePath)) {
            return "";
        }

        $text = file_get_contents($filePath);

        if ($text === false) {
            return "";
        }

        $this->documents[$filePath] = $text;

        return $text;
       
    }

    public function getPage(string $page): string
    {
        $path = "resources/text/" . strtolower($page) . ".txt";
        return $this->read($path);
        
    }
}