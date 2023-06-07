<?php

namespace wock\AdvancedXPBottle\Commands;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use wock\AdvancedXPBottle\Item\AdvancedBottle;
use wock\AdvancedXPBottle\Main;

class XPBottleCommand extends Command
{

    public function __construct(){
        parent::__construct("xpbottle", "Create an exprience bottle", "/xpbottle <amount/all>", ["xpb"]);
        $this->setPermission("AdvancedXPBottles.command");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args): bool
    {
        if (!$sender instanceof Player) {
            $message = Main::getInstance()->getConfig()->getNested("command.usage.error", "This command can only be used in-game.");
            $message = str_replace("&", "§", $message);
            $sender->sendMessage($message);
            return false;
        }

        if (empty($args[0])) {
            $message = Main::getInstance()->getConfig()->getNested("command.usage.usage", "Usage: /xpbottle <amount/all>");
            $message = str_replace("&", "§", $message);
            $sender->sendMessage($message);
            return true;
        }

        $subCommand = strtolower(array_shift($args));

        switch ($subCommand) {
            case "reload":
                Main::getInstance()->reloadConfig();
                $message = Main::getInstance()->getConfig()->getNested("command.reload.success", "Config reloaded successfully.");
                $message = str_replace("&", "§", $message);
                $sender->sendMessage($message);
                return true;
            default:
                $amount = $subCommand;
                if ($amount === "all") {
                    $amount = $sender->getXpManager()->getCurrentTotalXp();
                }
                if ($amount <= 0) {
                    $message = Main::getInstance()->getConfig()->getNested("command.invalid_amount.error", "Invalid amount. Please enter a positive number or 'all'.");
                    $message = str_replace("&", "§", $message);
                    $sender->sendMessage($message);
                    return true;
                }
                $item = AdvancedBottle::createBottle($sender, $amount);
                $sender->getInventory()->addItem($item);
                $sender->getXpManager()->subtractXp($amount);
                $message = Main::getInstance()->getConfig()->getNested("command.create.success", "Created an XP bottle with amount: " . number_format($amount));
                $message = str_replace("{AMOUNT}", number_format($amount), $message);
                $message = str_replace("&", "§", $message);
                $sender->sendMessage($message);
                return true;
        }
    }
}
