<?php

namespace Classes;

use splitbrain\phpcli\CLI;

use splitbrain\phpcli\Options;

class App extends CLI
{
    const COMMAND_PARSE = 'parse';
    const ARGUMENT_FILE = 'file';
    const ARGUMENT_AGE_FROM = 'ageFrom';
    const ARGUMENT_AGE_TO = 'ageTo';

    /**
     * {@inheritdoc}
     */
    protected function setup(Options $options)
    {
        $options->registerCommand(self::COMMAND_PARSE, 'Parse file command');

        $options->registerArgument(self::ARGUMENT_FILE, 'Path to the source file', true, self::COMMAND_PARSE);
        $options->registerArgument(self::ARGUMENT_AGE_FROM, 'Min Age for filtering', true, self::COMMAND_PARSE);
        $options->registerArgument(self::ARGUMENT_AGE_TO, 'Max Age for filtering', true, self::COMMAND_PARSE);

        $options->registerOption('formatted', 'Output result should be formatted', 'f');
    }

    /**
     * {@inheritdoc}
     */
    protected function main(Options $options)
    {
        switch ($options->getCmd()) {
            case self::COMMAND_PARSE:
                $this->filterUsers($options);
                break;
            default:
                $this->error('No known command was called, we show the src help instead:');
                echo $options->help();
                exit;
        }
    }

    /**
     * @param Options $options
     */
    private function filterUsers(Options $options)
    {
        $arguments = $options->getArgs();
        $formattedOutput = $options->getOpt('formatted');

        $parser = new Parser($arguments[0]);

        $parser->handle();

        if (!$parser->isValid()) {
            $this->error('Wrong file structure!');

            return;
        }

        $data = $parser->getData();

        $filterData = new FilterProcessor($data);
        $result = $filterData->filterByAge($arguments[1], $arguments[2]);

        $saver = new Saver();
        $saver->setData($result);
        $saver->setFileName($arguments[1], $arguments[2]);
        $saver->save($formattedOutput);

        $this->success(sprintf('Data has been filtered and saved to the file "%s"', $saver->getFileName()));
    }
}
