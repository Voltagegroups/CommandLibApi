<?php


namespace Voltage\Api\utils;

use pocketmine\network\mcpe\protocol\AvailableCommandsPacket;
use pocketmine\utils\EnumTrait;

/**
 * @method static self INT()
 * @method static self FLOAT()
 * @method static self VALUE()
 * @method static self WILDCARDINT()
 * @method static self OPERATOR()
 * @method static self TARGET()
 * @method static self WILDCARDTARGET()
 * @method static self FILEPATH()
 * @method static self STRING()
 * @method static self POSITION()
 * @method static self MESSAGE()
 * @method static self RAWTEXT()
 * @method static self JSON()
 * @method static self COMMAND()
 * @method static self ENUM()
 * @method static self POSTFIX()
 */

final class EnumCommand{
    use EnumTrait{
        __construct as Enum__construct;
    }

    protected static function setup() : void
    {
        self::registerAll(
            new self('int', AvailableCommandsPacket::ARG_TYPE_INT),
            new self('float', AvailableCommandsPacket::ARG_TYPE_FLOAT),
            new self('value', AvailableCommandsPacket::ARG_TYPE_VALUE),
            new self('wildcardint', AvailableCommandsPacket::ARG_TYPE_WILDCARD_INT),
            new self('operator', AvailableCommandsPacket::ARG_TYPE_OPERATOR),
            new self('target', AvailableCommandsPacket::ARG_TYPE_TARGET),
            new self('wildcardtarget', AvailableCommandsPacket::ARG_TYPE_WILDCARD_TARGET),
            new self('filepath', AvailableCommandsPacket::ARG_TYPE_FILEPATH),
            new self('string', AvailableCommandsPacket::ARG_TYPE_STRING),
            new self('position', AvailableCommandsPacket::ARG_TYPE_POSITION),
            new self('message',  AvailableCommandsPacket::ARG_TYPE_MESSAGE),
            new self('rawtext', AvailableCommandsPacket::ARG_TYPE_RAWTEXT),
            new self('json', AvailableCommandsPacket::ARG_TYPE_JSON),
            new self('command', AvailableCommandsPacket::ARG_TYPE_COMMAND),
            new self('enum', AvailableCommandsPacket::ARG_FLAG_ENUM),
            new self('postfix', AvailableCommandsPacket::ARG_FLAG_POSTFIX)
        );
    }

    private function __construct(string $name, private int $paramType){
        $this->Enum__construct($name);
    }

    public function getParamType() : int{
        return $this->paramType;
    }
}