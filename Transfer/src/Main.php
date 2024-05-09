<?php

declare(strict_types=1);

namespace wax_dev\Transfer;

use pocketmine\plugin\PluginBase;
use wax_dev\Transfer\Transfer\TransferServer;

class Main extends PluginBase{


    public function onEnable () : void
    {
        $this->getServer ()->getCommandMap ()->registerAll ("Transfer", [
            new TransferServer()
        ]);
        $this->getLogger ()->info("plugin activé");
        $this->saveDefaultConfig ();
    }
}
