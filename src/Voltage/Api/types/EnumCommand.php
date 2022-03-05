<?php


namespace Voltage\Api\types;

use pocketmine\network\mcpe\protocol\AvailableCommandsPacket;
use pocketmine\utils\EnumTrait;

final class EnumCommand{

    /**
     * @method static self INT()
     * @method static self FLOAT()
     * @method static self STRING()
     * @method static self TARGET()
     * @method static self POSITION()
     * @method static self MESSAGE()
     * @method static self JSON()
     * @method static self FILE()
     * @method static self POSTFIX()
     */

    use EnumTrait{
        __construct as Enum__construct;
    }

    protected static function setup() : void
    {
        self::registerAll(
            new self('int', AvailableCommandsPacket::ARG_TYPE_INT),
            new self('float', AvailableCommandsPacket::ARG_TYPE_FLOAT),
            new self('string', AvailableCommandsPacket::ARG_TYPE_STRING),
            new self('position', AvailableCommandsPacket::ARG_TYPE_POSITION),
            new self('target', AvailableCommandsPacket::ARG_TYPE_TARGET),
            new self('message',  AvailableCommandsPacket::ARG_TYPE_MESSAGE),
            new self('json', AvailableCommandsPacket::ARG_TYPE_JSON),
            new self('file', AvailableCommandsPacket::ARG_TYPE_FILEPATH),
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