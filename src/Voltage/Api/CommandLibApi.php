<?php

namespace Voltage\Api;

use JetBrains\PhpStorm\Pure;
use pocketmine\network\mcpe\protocol\AvailableCommandsPacket;
use pocketmine\network\mcpe\protocol\types\command\CommandEnum;
use pocketmine\network\mcpe\protocol\types\command\CommandParameter;
use pocketmine\plugin\PluginBase;
use Voltage\Api\listener\CommandLibListener;
use Voltage\Api\types\EnumCommand;

class CommandLibApi extends PluginBase
{
    public function onEnable(): void
    {
        new CommandLibListener($this);
    }

    #[Pure] public static function create(string $name, string|EnumCommand $enumType, ?array $enumValues = null, bool $optional = false) : CommandParameter
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
        $result->enum = new CommandEnum($enumType, $enumValues) ;
        return $result;
    }
}