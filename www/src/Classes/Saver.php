<?php

namespace Classes;

use SimpleXMLElement;
use DOMDocument;

class Saver
{
    const RESULT_FILENAME = 'files/result/users-%s-%s.xml';

    /**
     * @var array
     */
    private $data;

    /**
     * @var string
     */
    private $resultFile;

    /**
     * @param int $ageFrom
     * @param int $ageTo
     */
    public function setFileName(int $ageFrom, int $ageTo)
    {
        $this->resultFile = sprintf(self::RESULT_FILENAME, $ageFrom, $ageTo);
    }

    /**
     * @return string
     */
    public function getFileName(): string
    {
        return $this->resultFile;
    }

    /**
     * @param array $data
     */
    public function setData(array $data)
    {
        $this->data = $data;
    }

    /**
     * @param bool $formatted
     */
    public function save(bool $formatted = false)
    {
        /**
         * @param $data array
         * @param $xml SimpleXMLElement
         */
        function arrayToXml($data, &$xml)
        {
            foreach ($data as $key => $value) {
                if (is_array($value)) {
                    $node = $xml->addChild("user");
                    arrayToXml($value, $node);
                } else {
                    $xml->addChild("$key", $value);
                }
            }
        }

        $xml = new SimpleXMLElement('<users/>');
        arrayToXml($this->data, $xml);

        if ($formatted) {
            $this->formatAndSave($xml->asXML());
        } else {
            $xml->saveXML($this->resultFile);
        }
    }

    /**
     * @param string $xml
     */
    private function formatAndSave(string $xml)
    {
        $dom = new DOMDocument();
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = true;
        $dom->loadXML($xml);

        $dom->save($this->resultFile);
    }
}
