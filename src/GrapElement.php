<?php

namespace App;

use App\GrapRequestInterface;

class GrapElement
{

    /**
     * File to grap
     *
     * @var string
     */
    private $file;

     
    private $source;

    private $grapRequest;

    private $typeElement;

    private $messages = [];

    private $elementsFound;

    public function __construct(
        $file,
        $pattern,
        GrapRequestInterface $grapRequest,
        $typeElement = FILTER_VALIDATE_URL) {
        $this->file = $file;
        $this->grapRequest = $grapRequest;
        $this->pattern = $pattern;
        $this->typeElement = $typeElement;
        $this->init();
    }

    public function findElement($start = 50, $end = 20)
    {
        preg_match_all($this->pattern, $this->source, $this->result);

        $this->filterResult();
        $this->sliceElement($start, $end);
        return $this->execute();

    }

    /**
     * Filter result by type Element (filter_var const)
     * (Email, url...)
     *
     * @return void
     */
    private function filterResult()
    {
        $this->result = array_filter($this->result[1], function ($element) {
            return filter_var($element, $this->typeElement) ? $element : null;
        });
    }

    public function init()
    {
        $this->loadFile();

        $this->findElement();
    }

    public function loadFile()
    {
        $this->source = @file_get_contents($this->file);
    }

    private function sliceElement($start, $end)
    {
        $this->elementsFound = array_slice($this->result, $start, $end);
    }

    public function execute()
    {

        foreach ($this->elementsFound as $element) {
            $this->messages[] = $this->grapRequest->init($element)->execute()->getMessage();
        }

        return $this;
    }

    public function getMessages()
    {
        return $this->messages;
    }
}
