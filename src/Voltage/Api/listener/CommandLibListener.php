<?php

namespace Voltage\Api\listener;


use pocketmine\event\Listener;
use pocketmine\event\server\DataPacketSendEvent;
use pocketmine\network\mcpe\protocol\AvailableCommandsPacket;
use pocketmine\Server;
use pocketmine\utils\SingletonTrait;
use Voltage\Api\CommandLibApi;
use Voltage\Api\commands\BaseCommandLib;

class CommandLibListener implements Listener
{
    use SingletonTrait;

    /** @var CommandLibApi */
    private static CommandLibApi $pg;

    /**
     * @param CommandLibApi $pg
     */
    public function __construct(CommandLibApi $pg)
    {
        self::$pg = $pg;
        $pg->getServer()->getPluginManager()->registerEvents($this,$pg);
    }

    /** @return CommandLibApi */
    public function getPlugin() : CommandLibApi
    {
        return self::$pg;
    }

    public function onDataSendPacket(DataPacketSendEvent $event) : void
    {
        foreach ($event->getTargets() as $target){
            $player = $target->getPlayer();
            foreach($event->getPackets() as $packet){
                if($packet instanceof AvailableCommandsPacket) {
                    foreach($packet->commandData as $name => $commandData){
                        $cmd = Server::getInstance()->getCommandMap()->getCommand($name);
                        if($cmd instanceof BaseCommandLib && $cmd->hasOverloads()){
                            $commandData->overloads = $cmd->getOverloads($player);
                        }
                    }
                }
            }
        }
    }
}