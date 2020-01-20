<?php

use Symfony\Component\Console\Formatter\OutputFormatter;
use Symfony\Component\Console\Output\Output;

/**
 * ComposerOutput class to print messages from composer in realtime.
 */
class ComposerOutput extends Output
{
    /**
     * Writes a message to the output and delivers to the client immediately.
     *
     * @param string $message A message to write to the output
     * @param bool $newline Whether to add a newline or not
     */
    protected function doWrite($message, $newline)
    {
        if(strripos($message, \Composer\Composer::BRANCH_ALIAS_VERSION) === false){
			echo $message;
		
			if ($newline) {
				echo PHP_EOL;
			}
		
			ob_flush();
			flush();
        }
    }
}