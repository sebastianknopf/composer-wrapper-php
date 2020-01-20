<?php

use Composer\Console\Application;

/*
 * Composer server application class.
 */
class ComposerApplication extends Application
{
    /**
	 * Setter method for composer.
	 *
     * @param $composer \Composer\Composer Composer instance to run within this app
     */
    public function setComposer($composer){
        $this->composer = $composer;
    }

    /**
     * Getter method for composer.
	 *
     * @return \Composer\Composer|null Composer instance running in this app
     */
    public function getComposer()
    {
        return $this->composer;
    }
}