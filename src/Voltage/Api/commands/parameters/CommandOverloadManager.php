<?php

namespace Voltage\Api\commands\parameters;

use pocketmine\network\mcpe\protocol\types\command\CommandParameter;
use pocketmine\permission\PermissionManager;
use pocketmine\player\Player;

class CommandOverloadManager
{
    private array $overloads;
    private array $overPermission;

    public function __construct(array $overloads = [], array $overPermission = []) {
        $this->overloads = $overloads;
        $this->overPermission = $overPermission;
    }

    public function addParameter(CommandParameter $parameter, int $overloadIndex = 0) : void
    {
        $this->overloads[$overloadIndex][] = $parameter;
    }

    public function setParameter(CommandParameter $parameter, int $parameterIndex, int $overloadIndex = 0) : void
    {
        $this->overloads[$overloadIndex][$parameterIndex] = $parameter;
    }

    public function setParameters(array $parameters, int $overloadIndex = 0) : void
    {
        $this->overloads[$overloadIndex] = array_values($parameters);
    }

    public function hasOverloads() : bool
    {
        if($this->overloads === []){
            return false;
        }
        return true;
    }

    public function getOverloads(Player $player) : array
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

    public function setOverloadPermission(int $overloadIndex, string $permission) : void
    {
        foreach(explode(';', $permission) as $perm){
            if(PermissionManager::getInstance()->getPermission($perm) === null){
                throw new \InvalidArgumentException("Cannot use non-existing permission \"$perm\"");
            }
        }
        $this->overPermission[$overloadIndex] = $permission;
    }

    public function getOverloadPermission(int $overloadIndex) : ?string
    {
        return $this->overPermission[$overloadIndex] ?? null;
    }

    public function setOverloads(array $parameters) : void {
        $this->overloads = $parameters;
    }
}