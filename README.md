# AdvancedXPBottles

Add experience vouchers to your pocketmine-mp server!

# Commands 

`/xpbottle <amount/all>` - Add EXP to a bottle for redeemption later on. 

# API

`use wock\AdvancedXPBottle\Item\AdvancedBottle;`\

`AdvancedBottle::createBottle($player, 1000);` *amount can be anything, as well as name, use null to get 'Server' or u can set the players name mt_rand(1, 100) also works for the amount

# Config

```# {SIGNER} = The creator of the bottle.
# {AMOUNT} = The amount of xp on the bottle
Item:
  item: "minecraft:experience_bottle"
  name: "&r&a&lExperience Bottle"
  lore:
    - "&r&7Throw to claim your &6advanced"
    - "&r&7bottle of experience"
    - ""
    - "&r&aValue&r&f: {AMOUNT} XP"
    - "&r&aEnchanter&r&f: {SIGNER}"
command:
  usage:
    error: "&r&l&c[!] &r&cThis command can only be used in-game."
    usage: "&3Usage: /xpbottle <amount/all>"
  reload:
    success: "&6Config reloaded successfully."
  invalid_amount:
    error: "&cInvalid amount. Please enter a positive number or 'all'."
  create:
    success: "&r&aCreated an XP bottle with amount: &f{AMOUNT}"
```
