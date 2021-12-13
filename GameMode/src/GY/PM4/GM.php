<?php
declare(strict_types=1);

namespace GY\PM4;

use pocketmine\plugin\PluginBase;
use pocketmine\player\{GameMode, Player};
use pocketmine\item\ItemFactory;
use pocketmine\command\{Command, CommandSender};

use skymin\InventoryLib\{InvLibManager, LibInvType, InvLibAction, LIbInventory};

class GM extends PluginBase
{
    public function onEnable() :void {
       InvLibManager::register($this);
    }
    public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool
    {
        if ($sender instanceof Player) {
            if ($command->getName() === "gm") {
            	
            $type = LibInvType::HOPPER();
            $inv = InvLibManager::create($type, $sender->getPosition(), '게임모드 전환기');
            $inv->setListener(function (InvLibAction $action) use ($inv): void {
            	$item = $action->getSourceItem();
                $player = $action->getPlayer();
                $action->setCancelled();
                if($item->getCustomName() === "크리에이티브") {
                    $inv->close($player, function () use($player) : void {
                    $player->setGamemode(GameMode::CREATIVE());
                    });
                }
                if($item->getCustomName() === "서바이벌") {
                    $inv->close($player, function () use($player) : void {
                    $player->setGamemode(GameMode::SURVIVAL());
                    });
                }
                if($item->getCustomName() === "관전자") {
                    $inv->close($player, function () use($player) : void {
                    $player->setGamemode(GameMode::SPECTATOR());
                    });
                }
        });
            $inv->setItem(0, ItemFactory::getInstance()->get(0));
            $inv->setItem(1, ItemFactory::getInstance()->get(2)->setCustomName("크리에이티브"));
            $inv->setItem(2, ItemFactory::getInstance()->get(267)->setCustomName("서바이벌"));
            $inv->setItem(3, ItemFactory::getInstance()->get(381)->setCustomName("관전자"));
            $inv->setItem(4, ItemFactory::getInstance()->get(0));
            $inv->send($sender, function () use ($inv) : void {
            });
          }
        }
        return true;
    }
}