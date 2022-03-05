<p align="center">
  <img src="http://image.noelshack.com/fichiers/2021/39/5/1633118741-logo-no-background.png" alt="Voltage logo" height="180" />
</p>

<h1 align="center">Voltage-Groups</h1>
<a href="https://discord.gg/ntF6gH6NNm"><img src="https://img.shields.io/discord/814507789656784898?label=discord&color=7289DA&logo=discord" alt="Discord" /></a>
<br/>
----------------------
<br/>

## Info
> Note: The `main` branch may be in an unstable or even broken state during development.
<br/>

Versions they are available [here](https://github.com/Voltagegroups/CommandLibApi/releases)
<br/>
Branch stable for [PM4](https://github.com/Voltagegroups/CommandLibApi/tree/pm4)


## Api
A very basic example can be seen here: [CommandVanilla](https://github.com/Voltagegroups/CommandVanilla)

Implement the command
```PHP
class Exemple extends BaseCommandLib
{
    public function onLoad(string $name, string|\pocketmine\lang\Translatable $description, string|null|\pocketmine\lang\Translatable $usageMessage, array $aliases): void
    {
        $this->addParameter(CommandLibApi::create('player', EnumCommand::TARGET(), null, true));
    }

    public function onRun(CommandSender $sender, string $commandLabel, array $args): bool
    {
        return false;
    }
}
```

## Contents

- [Features](./FEATURES.md)
- [License](./LICENSE)

## Usages

* [PocketMine-MP](https://github.com/pmmp/PocketMine-MP)

## Community

Active channels:

- Twitter: [@voltagegroups](https://twitter.com/VoltageGroups?t=wSiFVaX5GiHx8Z-LmSC7iQ&s=09)
- Discord: [ntF6gH6NNm](https://discord.gg/ntF6gH6NNm)
- © Voltage-Groups
<div align="center">
  <img src="http://image.noelshack.com/fichiers/2021/39/5/1633118741-logo-no-background.png" height="50" width="50" align="left"></img>
</div>
<br/><br/>

## © Voltage-Groups

Voltage-Groups are not affiliated with Mojang. All brands and trademarks belong to their respective owners. Voltage-Groups is not a Mojang-approved software, nor is it associated with Mojang.
