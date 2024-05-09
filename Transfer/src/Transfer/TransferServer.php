<?php

declare(strict_types=1);

namespace wax_dev\Transfer\Transfer;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\lang\Translatable;
use pocketmine\player\Player;
use pocketmine\Server;
use wax_dev\Transfer\forms\elements\Button;
use wax_dev\Transfer\forms\MenuForm;

class TransferServer extends Command {

    public function __construct() {
        parent::__construct("server", "Permet de rejoindre un serveur", "/server", ["ssrv"]);
        $this->setPermission("server.cmd");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) {
        if ($sender instanceof Player) {
            $this->sendFormServer($sender);
            return true;
        }
        return false;
    }

    private function sendFormServer(Player $player): void {
        $serverList = [
            new Button("Choisir un serveur")
        ];

        $form = new MenuForm("Server", "Liste des serveurs", $serverList, function (Player $player, Button $button): void {
            $this->connectToServer($player);
        });
        $player->sendForm($form);
    }

    private function connectToServer(Player $player): void {
        $options = [
            "Minage" => ["ip" => "mcbe.server.eu", "port" => 19132],
            "Faction" => ["ip" => "mcpe.server.fr", "port" => 19133]
        ];

        $form = new MenuForm("Choisir un serveur", "Liste des serveurs", array_map(function ($serverName) {
            return new Button($serverName);
        }, array_keys($options)), function (Player $player, Button $button) use ($options): void {
            $serverName = $button->getText();
            if (isset($options[$serverName])) {
                $this->connectToServerIPPort($player, $options[$serverName]["ip"], $options[$serverName]["port"]);
            }
        });

        $player->sendForm($form);
    }

    private function connectToServerIPPort(Player $player, string $ip, int $port): void {
        $player->transfer($ip, $port);
    }
}
