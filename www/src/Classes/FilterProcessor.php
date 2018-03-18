<?php

namespace Classes;

class FilterProcessor
{
    /**
     * @var array
     */
    private $fileData;

    /**
     * @param array $fileData
     */
    public function __construct(array $fileData)
    {
        $this->fileData = $fileData;
    }

    /**
     * @param int $from
     * @param int $to
     *
     * @return array
     */
    public function filterByAge(int $from, int $to): array
    {
        $data = array_filter($this->fileData, function ($element) use ($from, $to) {
            return isset($element['age'])
                && $element['age'] >= $from
                && $element['age'] <= $to;
        });

        return $data;
    }
}
