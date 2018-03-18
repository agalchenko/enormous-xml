<?php

namespace Classes;

use SimpleXMLElement;

class Parser
{
    /**
     * @var string
     */
    private $file;

    /**
     * @var bool
     */
    private $isValid;

    /**
     * @var SimpleXMLElement
     */
    private $fileObject;

    /**
     * @var array
     */
    private $fileData = [];

    /**
     * @param string $file
     */
    public function __construct(string $file)
    {
        $this->file = $file;
    }

    /**
     * Handle an input file.
     */
    public function handle()
    {
        $this->readFile();
        $this->validate();

        if ($this->isValid) {
            $this->parse();
        }
    }

    /**
     * @return bool
     */
    public function isValid(): bool
    {
        return $this->isValid;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->fileData;
    }

    /**
     * @throws \Exception
     */
    private function readFile()
    {
        if (!file_exists($this->file)) {
            throw new \Exception(sprintf('File "%s" doesn\'t exist. Please check and try again.', $this->file));
        }

        // TODO: to think how implement parsing for huge xml

        libxml_use_internal_errors(true);

        $this->fileObject = simplexml_load_file($this->file);
    }

    /**
     * Validate input XML file structure.
     */
    private function validate()
    {
        $this->isValid = true;

        if (count(libxml_get_errors()) > 0) {
            libxml_clear_errors();

            $this->isValid = false;
        }
    }

    /**
     * Transform xml file data to array.
     */
    private function parse()
    {
        $fileData = json_decode(json_encode($this->fileObject), true);

        $this->fileData = $fileData['user'];
    }
}
