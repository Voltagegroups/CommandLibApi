<?php

namespace Voltage\Api;

use pocketmine\item\VanillaItems;
use pocketmine\network\mcpe\protocol\AvailableCommandsPacket;
use pocketmine\plugin\PluginBase;
use Voltage\Api\commands\BaseCommandLib;
use Voltage\Api\listener\CommandLibListener;
use Voltage\Api\manager\CommandLibManager;
use pocketmine\command\CommandSender;
use Voltage\Api\utils\EnumCommand;

class CommandLibApi extends PluginBase
{
    private static CommandLibManager $manager;

    /**
     * @return CommandLibManager
     */
    public static function getManager() : CommandLibManager {
        return self::$manager;
    }

    public function onLoad(): void
    {
        self::$manager = new CommandLibManager();
    }

    public function onEnable(): void
    {
        new CommandLibListener($this);
        $this->loadVanillaCommand();
    }

    private function loadVanillaCommand() {
        self::getManager()->setOverload("ban",
            [
                [
                    self::getManager()->create("name", EnumCommand::TARGET(),null, false),
                    self::getManager()->create("reason", EnumCommand::MESSAGE(),null, true)
                ]
            ]
        );
        self::getManager()->setOverload("ban-ip",
            [
                [
                    self::getManager()->create("name", EnumCommand::TARGET(),null, false),
                    self::getManager()->create("reason", EnumCommand::MESSAGE(),null, true)
                ]
            ]
        );
        self::getManager()->setOverload("banlist",
            [
                [
                    self::getManager()->create("option", EnumCommand::STRING(),["players","ips"], true)
                ]
            ]
        );
        self::getManager()->setOverload("clear",
            [
                [
                    self::getManager()->create("player", EnumCommand::TARGET(),null, true),
                    self::getManager()->EnumItems(true),
                    self::getManager()->create("data", EnumCommand::INT(),null, true),
                    self::getManager()->create("maxCount", EnumCommand::INT(),null, true)
                ]
            ]
        );
        self::getManager()->setOverload("deop",
            [
                [
                    self::getManager()->create("player", EnumCommand::TARGET(),null, false)
                ]
            ]
        );
        self::getManager()->setOverload("difficulty",
            [
                [
                    self::getManager()->create("difficulty", EnumCommand::STRING(),["easy","normal","hard","peaceful"], false)
                ],
                [
                    self::getManager()->create("difficulty", EnumCommand::STRING(),["e","n","h","p"], false)
                ]
            ]
        );
        self::getManager()->setOverload("dumpmemory",
            [
                [
                    self::getManager()->create("data", EnumCommand::MESSAGE(), null, false)
                ]
            ]
        );

        self::getManager()->setOverload("op",
            [
                [
                    self::getManager()->create("player", EnumCommand::TARGET(),null, false)
                ]
            ]
        );

        self::getManager()->setOverload("kick",
            [
                [
                    self::getManager()->create("name", EnumCommand::TARGET(),null, false),
                    self::getManager()->create("reason", EnumCommand::MESSAGE(),null, true)
                ]
            ]
        );
        self::getManager()->setOverload("defaultgamemode",
            [
                [
                    self::getManager()->create("gameMode", EnumCommand::STRING(),["survival", "creative", "adventure", "spectator"], false),
                    self::getManager()->create("player", EnumCommand::TARGET(),null, true)
                ],
                [
                    self::getManager()->create("gameMode", EnumCommand::INT(),[0,1,2,3], false),
                    self::getManager()->create("player", EnumCommand::TARGET(),null, true)
                ],
                [
                    self::getManager()->create("gameMode", EnumCommand::STRING(),["s","c","a","s"], false),
                    self::getManager()->create("player", EnumCommand::TARGET(),null, true)
                ]
            ]
        );
        self::getManager()->setOverload("gamemode",
            [
                [
                    self::getManager()->create("gameMode", EnumCommand::STRING(),["survival", "creative", "adventure", "spectator"], false),
                    self::getManager()->create("player", EnumCommand::TARGET(),null, true)
                ],
                [
                    self::getManager()->create("gameMode", EnumCommand::INT(),[0,1,2,3], false),
                    self::getManager()->create("player", EnumCommand::TARGET(),null, true)
                ],
                [
                    self::getManager()->create("gameMode", EnumCommand::STRING(),["s","c","a","s"], false),
                    self::getManager()->create("player", EnumCommand::TARGET(),null, true)
                ]
            ]
        );
    }
}