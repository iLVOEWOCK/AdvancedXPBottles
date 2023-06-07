<?php

namespace wock\AdvancedXPBottle;

use pocketmine\plugin\PluginBase;
use wock\AdvancedXPBottle\Commands\XPBottleCommand;

class Main extends PluginBase {

    private static ?Main $instance = null;

    public function onEnable(): void
    {
        self::$instance = $this;
        $this->saveDefaultConfig();
        $this->getServer()->getPluginManager()->registerEvents(new EventListener(), $this);
        $this->registerCommands();
    }

    public function registerCommands(){
        $cmd_Map = $this->getServer()->getCommandMap();
        $cmd_Map->registerAll("advancedxpbottles", [
            new XPBottleCommand()
        ]);
    }

    /**
     * @return static
     */
    public static function getInstance() : Main {
        return self::$instance;
    }
}
