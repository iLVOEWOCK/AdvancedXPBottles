<?php

namespace wock\AdvancedXPBottle\Item;

use pocketmine\item\Item;
use pocketmine\item\StringToItemParser;
use pocketmine\player\Player;
use pocketmine\utils\Config;
use wock\AdvancedXPBottle\Main;

class AdvancedBottle
{

    public static function createBottle(?Player $player = null, ?float $amount = null, int $count = 1, bool $subtract = false): ?Item
    {
        $signer = "Server";
        $randomAmount = rand(1, 500000);
        if ($player !== null) {
            $signer = $player->getName();
        }
        if ($amount !== null) {
            $randomAmount = $amount;
        }

        $cfg = new Config(Main::getInstance()->getDataFolder() . "config.yml", Config::YAML);
        $itemData = $cfg->get("Item", []);

        $item = StringToItemParser::getInstance()->parse($itemData["item"]);
        $item->setCount($amount);

        $name = $itemData["name"];
        $name = str_replace("&", "§", $name); // Replace & with color code symbol
        $item->setCustomName($name);

        $lore = $itemData["lore"];
        $lore = str_replace(["{SIGNER}", "{AMOUNT}"], [$signer, number_format($randomAmount)], $lore);
        $lore = str_replace("&", "§", $lore); // Replace & with color code symbol
        $item->setLore($lore);

        $item->getNamedTag()->setInt("xpbottle", $randomAmount);
        $tag = $item->getNamedTag()->getInt("xpbottle");
        $item->setCount($count);

        if ($subtract) $player->getXpManager()->subtractXp($amount);
        return $item;
    }

    public function getMessage(string $messageKey, array $placeholders = []): string
    {
        $config = new Config(Main::getInstance()->getDataFolder() . "config.yml", Config::YAML);
        $message = $config->get($messageKey, "");
        $message = str_replace(array_keys($placeholders), array_values($placeholders), $message);
        return str_replace("&", "§", $message);
    }
}
