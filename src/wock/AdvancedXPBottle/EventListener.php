<?php

namespace wock\AdvancedXPBottle;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerItemUseEvent;
use pocketmine\math\Vector3;
use pocketmine\world\sound\XpLevelUpSound;

class EventListener implements Listener{

    public function onUse(PlayerItemUseEvent $event) {
        $player = $event->getPlayer();
        $item = $event->getItem();
        $nbt = $item->getNamedTag();
        if ($nbt->getInt("xpbottle", 0) !== 0) {
            $event->cancel();
            $value = $nbt->getInt("xpbottle");
            $formatted = number_format($value, 1);
            $position = new Vector3(0, 64, 0);
            $level = $player->getWorld();
            $level->addSound($position, new XpLevelUpSound(10));
            $hand = $player->getInventory()->getItemInHand();
            $player->getXpManager()->addXp($value);
            $player->sendMessage("§r§a§l+ §r§a$formatted xp");
            $hand->setCount($hand->getCount() - 1);
            $player->getInventory()->setItemInHand($hand);
        }
    }
}