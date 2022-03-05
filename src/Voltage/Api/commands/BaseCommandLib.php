<?php

namespace Voltage\Api\commands;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\lang\KnownTranslationFactory;
use pocketmine\lang\Translatable;
use pocketmine\network\mcpe\protocol\types\command\CommandParameter;
use pocketmine\permission\PermissionManager;
use pocketmine\player\Player;

abstract class BaseCommandLib extends Command
{
    private array $overPermission = [];
    private array $overloads = [];

    public function __construct(string $name, Translatable|string $description = "", Translatable|string|null $usageMessage = null, array $aliases = [])
    {
        $this->onLoad($name,$description,$usageMessage,$aliases);
        parent::__construct($name, $description, $usageMessage, $aliases);
    }

    final public function execute(CommandSender $sender, string $commandLabel, array $args) : bool
    {
        if(!$this->testPermission($sender)){
            return false;
        }

        if (!$this->onRun($sender,$commandLabel, $args)) {
            $sender->sendMessage($sender->getLanguage()->translate(KnownTranslationFactory::commands_generic_usage($this->getUsage())));
            return false;
        }
        return true;
    }

    abstract public function onRun(CommandSender $sender, string $commandLabel, array $args) : bool;

    abstract public function onLoad(string $name, Translatable|string $description, Translatable|string|null $usageMessage, array $aliases) : void;

    final public function addParameter(CommandParameter $parameter, int $overloadIndex = 0) : void
    {
        $this->overloads[$overloadIndex][] = $parameter;
    }

    final public function setParameter(CommandParameter $parameter, int $parameterIndex, int $overloadIndex = 0) : void
    {
        $this->overloads[$overloadIndex][$parameterIndex] = $parameter;
    }

    final public function setParameters(array $parameters, int $overloadIndex = 0) : void
    {
        $this->overloads[$overloadIndex] = array_values($parameters);
    }

    final public function hasOverloads() : bool
    {
        if($this->overloads === []){
            return false;
        }
        return true;
    }

    final public function getOverloads(Player $player) : array
    {
        $overloads = $this->overloads;
        foreach($this->overPermission as $key => $value){
            if(!isset($overloads[$key])) continue;
            if(!$player->hasPermission($value)){
                unset($overloads[$key]);
            }
        }
        return $overloads;
    }

    final public function setOverloadPermission(int $overloadIndex, string $permission) : void
    {
        foreach(explode(';', $permission) as $perm){
            if(PermissionManager::getInstance()->getPermission($perm) === null){
                throw new \InvalidArgumentException("Cannot use non-existing permission \"$perm\"");
            }
        }
        $this->overPermission[$overloadIndex] = $permission;
    }

    final public function getOverloadPermission(int $overloadIndex) : ?string
    {
        return $this->overPermission[$overloadIndex] ?? null;
    }
}