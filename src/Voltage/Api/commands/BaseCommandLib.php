<?php

namespace Voltage\Api\commands;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\lang\KnownTranslationFactory;
use pocketmine\lang\Translatable;
use Voltage\Api\commands\parameters\CommandOverloadManager;

abstract class BaseCommandLib extends Command
{
    private CommandOverloadManager $overloadManager;

    public function __construct(string $name, Translatable|string $description = "", Translatable|string|null $usageMessage = null, array $aliases = [], array $overloads = [], array $overPermission = [])
    {
        $this->overloadManager = new CommandOverloadManager($overloads, $overPermission);
        $this->onLoad($name,$description,$usageMessage,$aliases);
        parent::__construct($name, $description, $usageMessage, $aliases);
    }

    final public function getOverload() : CommandOverloadManager {
        return $this->overloadManager;
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
}