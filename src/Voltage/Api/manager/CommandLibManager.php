<?php

namespace Voltage\Api\manager;

use pocketmine\item\VanillaItems;
use pocketmine\network\mcpe\protocol\AvailableCommandsPacket;
use pocketmine\network\mcpe\protocol\types\command\CommandEnum;
use pocketmine\network\mcpe\protocol\types\command\CommandParameter;
use Voltage\Api\commands\parameters\CommandOverloadManager;
use Voltage\Api\utils\EnumCommand;

final class CommandLibManager
{
    private array $commandData = [];
    private array $itemNames = [];

    public function __construct() {
        $itemNames = array_map('strtolower', array_keys(VanillaItems::getAll()));
        asort($itemNames);
        $this->itemNames = $itemNames;
    }

    public function setOverload(string $name, array $overloads = [], array $overPermission = []) : void {
        $this->commandData[$name] = new CommandOverloadManager($overloads, $overPermission);
    }

    public function removeOverload(string $name) : void {
        unset($this->commandData[$name]);
    }

    public function getOverload(string $name) : ?CommandOverloadManager {
        if ($this->existOverload($name)) {
            return $this->commandData[$name];
        }
        return  null;
    }

    public function existOverload(string $name) : bool {
        return isset($this->commandData[$name]);
    }

    public function create(string $name, string|EnumCommand $enumType, ?array $enumValues = null, bool $optional = false) : CommandParameter
    {
        $result = new CommandParameter();
        $result->paramName = $name;
        $result->flags = 0;
        $result->isOptional = $optional;
        $result->paramType = AvailableCommandsPacket::ARG_FLAG_VALID;
        if($enumType instanceof EnumCommand){
            if(is_null($enumValues)){
                $result->paramType |= $enumType->getParamType();
                return $result;
            }
            $enumType = $enumType->name();
        }
        $result->paramType |= AvailableCommandsPacket::ARG_FLAG_ENUM;
        $result->enum = new CommandEnum($enumType, $enumValues);
        return $result;
    }

    public function EnumItems(bool $optional = false, string $enumType = 'Item') : CommandParameter {
        return $this->create("itemName", $enumType, $this->itemNames, $optional);
    }
}