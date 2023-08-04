<?php
/**
 * Inyección de Dependencias PHP style.
 *
 * @package    	MimoticBootstrap
 * @subpackage 	mimotic/load_deps
 * @author     	Mimotic <hello@mimotic.com>
 * @version 	0.1.2
 */
class MimoticBootstrap{

    /**
     * @var array
     */
    private $dependencies;

    /**
     * @var string
     */
    private $pluginUrl;

    public function __construct($dependencies) {
        $this->dependencies = $dependencies;
        $this->setPluginUrl();
    }

    public function setPluginUrl(){
        $this->pluginUrl = dirname( dirname(__FILE__));
    }

    /**
     * recorre array
     * @param  array $deps mount list of deps to set
     * @return void
     */
    public function start(){
        foreach ($this->dependencies as $filePath) {
            $this->setDeps($filePath);
        }
    }

    /**
     * set deps requieres
     * @param string $dir
     * @return  void
     */
    private function setDeps($filePath){
        if (file_exists($this->pluginUrl . "/$filePath.php")) {
            require_once  $this->pluginUrl . "/$filePath.php";
        }
    }

    //...
}