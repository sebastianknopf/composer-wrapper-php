<?php

require_once 'ComposerApplication.php';
require_once 'ComposerOutput.php';

use Composer\Console\Application;
use Composer\Factory;
use Composer\IO\NullIO;
use Composer\Repository\PlatformRepository;
use Composer\Repository\RepositoryInterface;
use Composer\Repository\RepositoryManager;
use Symfony\Component\Console\Input\ArrayInput;

/*
 * PHP wrapper class for composer application.
 */
class Composer
{
    public static $configFile = null;
    public static $configFilePath = null;

    private static $composer;
    private static $app;
    private static $_instance;

    /**
	 * Gets an instance of the composer wrapper.
	 *
     * @param string $configFile The path to composer file
     * @param string|null $configFilePath The path to the directory where composer should do it's work
     * @return Composer
     */
    public static function getInstance($configFile, $configFilePath = null)
    {
        if ($configFilePath == null) {
			$configFilePath = dirname($configFile);
		}
		
		putenv('COMPOSER='.$configFile);
        self::$configFile = $configFile;
        self::$configFilePath = $configFilePath;

        chdir(self::$configFilePath);

        if (self::$_instance === null)
        {
            self::$_instance = new self();
        }
		
        return self::$_instance;
    }

    /**
	 * Returns the current instance of the composer worker.
	 *
     * @return \Composer\Composer The actual composer worker
     */
    public static function getComposer()
	{
        if(!self::$composer){
            $factory = new Factory();
            self::$composer = $factory->createComposer(new NullIO(), self::$configFile, false, self::$configFilePath);
        }
		
        return self::$composer;
    }
	
    /**
	 * Returns the current instance of composer server application.
	 *
     * @return ComposerApplication The composer server application
     */
    public static function getApplication()
	{
        if(empty(self::$app)){
            $app = new ComposerApplication();
            $app->setComposer(self::getComposer());
            $app->setAutoExit(false);
            self::$app = $app;
        }
		
        return self::$app;
    }
	
	/*
	 * Common install method.
	 *
	 * @param array $options Command line options 
	 */
	public function install($options = [])
	{
		$this->executeCommand('install', $options);
	}
	
	/*
	 * Common require method.
	 *
	 * @param string $packageName The package name to require
	 * @param array $options Command line options
	 */
	public function require($packageName, $options = [])
	{
		$this->executeCommand('require', [$packageName] + $options);
	}
	
	/*
	 * Common update method. If a package name is set, only the desired package
	 * will be updated.
	 *
	 * @param string $packageName The package name to update
	 * @param array $options Command line options 
	 */
	public function update($packageName = null, $options = [])
	{
		if ($packageName == null) {
			$this->executeCommand('update', [$packageName] + $options);
		} else {
			$this->executeCommand('update', $options);
		}
	}
	
	/*
	 * Common remove method.
	 *
	 * @param string $packageName The package name to remove 
	 * @param array $options Command line options 
	 */
	public function remove($packageName, $options = [])
	{
		$this->executeCommand('remove', $options);
	}

	/*
	 * Common dump autoload method.
	 *
	 * @param array $options Command line options
	 */
	public function dumpAutoload($options = [])
    {
        $this->executeCommand('dump-autoload', $options);
    }
	
	/*
	 * Common list method.
	 */
	public function list() 
	{
		$this->executeCommand('list', []);
	}
	
	/*
	 * Common about method.
	 */
	public function about()
	{
		$this->executeCommand('about', []);
	}

    /**
	 * Executes a composer command.
	 *
     * @param string $command The command to run
     * @param array $params Several parameters and options
     */
    public function executeCommand($command = '', $params = [])
	{
        if(empty($command)){
            $command = 'list';
        }

        $input = new ArrayInput(['command' => $command] + $params);
        $output = new ComposerOutput();

        try {
            $app = self::getApplication();
            $app->run($input, $output);
        }catch (\Exception $e){
            $output->write($e->getMessage());
        }
    }
}