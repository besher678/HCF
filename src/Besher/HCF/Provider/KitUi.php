<?php


namespace Besher\HCF\Provider;

use Besher\HCF\Main;
use Besher\HCF\Provider\Time;
use muqsit\invmenu\{
	InvMenu, InvMenuHandler};
use pocketmine\item\Item;
use pocketmine\nbt\tag\{
	IntTag ,CompoundTag, ListTag};
use pocketmine\item\enchantment\{
	Enchantment, EnchantmentInstance};
use pocketmine\Player;
use pocketmine\utils\TextFormat as TF;
use pocketmine\inventory\transaction\action\SlotChangeAction;

class KitUi
{
	private $plugin;

	public function __construct(Main $pg)
	{
		$this->plugin = $pg;
	}

	public function sendMenu(Player $player){
		$p = Main::getPlayerManager();
		$bard = Item::get(Item::GOLD_CHESTPLATE);
		$bard->setCustomName(TF::GOLD . "Bard" . TF::GRAY . " Kit");
		$bard->setLore([
			TF::RESET . TF::GRAY . "A set of golden armor for the",
			TF::RESET . TF::GRAY . "players who wish to support their faction!",
			"",
			TF::RESET . TF::YELLOW . "Purchase at: " . TF::RED . "store.alpinenetwork.us",
			"",
			TF::RESET . TF::GRAY . "Cooldown: " . TF::GREEN . "12 Hours",
			TF::RESET . TF::GRAY . "Available In: " . TF::GREEN,
			TF::RESET . TF::BOLD . TF::GRAY . "(" . TF::YELLOW . "!" . TF::GRAY . ")" . TF::RESET . TF::GRAY . "Right click to claim!"]);
		$miner = Item::get(Item::IRON_CHESTPLATE);
		$miner->setCustomName(TF::GRAY . "Miner Kit");
		$miner->setLore([
			TF::RESET . TF::GRAY . "This kit is for all those ",
			TF::RESET . TF::GRAY . "players who mine all those ores!",
			"",
			TF::RESET . TF::YELLOW . "Purchase at: " . TF::RED . "store.alpinehcf.net",
			"",
			TF::RESET . TF::GRAY . "Cooldown: " . TF::GREEN . "12 Hours",
			TF::RESET . TF::GRAY . "Available In: " . TF::GREEN,
			TF::RESET . TF::BOLD . TF::GRAY . "(" . TF::YELLOW . "!" . TF::GRAY . ")" . TF::RESET . TF::GRAY . "Right click to claim!"]);
		$archer = Item::get(Item::LEATHER_CHESTPLATE);
		$archer->setCustomName(TF::GREEN . "Archer" . TF::GRAY . " Kit");
		$archer->setLore([
			TF::RESET . TF::GRAY . "For all those players who can't",
			TF::RESET . TF::GRAY . "do good at melee but good at archery!",
			"",
			TF::RESET . TF::YELLOW . "Purchase at: " . TF::RED . "store.alpinehcf.net",
			"",
			TF::RESET . TF::GRAY . "Cooldown: " . TF::GREEN . "12 Hours",
			TF::RESET . TF::GRAY . "Available In: " . TF::GREEN,
			TF::RESET . TF::BOLD . TF::GRAY . "(" . TF::YELLOW . "!" . TF::GRAY . ")" . TF::RESET . TF::GRAY . "Right click to claim!"]);
		$rogue = Item::get(Item::CHAIN_CHESTPLATE);
		$rogue->setCustomName(TF::GRAY . "Rogue Kit");
		$rogue->setLore([
			TF::RESET . TF::GRAY . "Be prepared to backstab",
			TF::RESET . TF::GRAY . "everyone with your golden swords!",
			"",
			TF::RESET . TF::YELLOW . "Purchase at: " . TF::RED . "store.alpinehcf.net",
			"",
			TF::RESET . TF::GRAY . "Cooldown: " . TF::GREEN . "12 Hours",
			TF::RESET . TF::GRAY . "Available In: " . TF::GREEN,
			TF::RESET . TF::BOLD . TF::GRAY . "(" . TF::YELLOW . "!" . TF::GRAY . ")" . TF::RESET . TF::GRAY . "Right click to claim!"]);
		$diamond = Item::get(Item::DIAMOND_CHESTPLATE);
		$diamond->setCustomName(TF::BLUE . "Diamond" . TF::GRAY . " Kit");
		$diamond->setLore([
			TF::RESET . TF::GRAY . "An enchanted set for",
			TF::RESET . TF::GRAY . "all those action players!",
			"",
			TF::RESET . TF::YELLOW . "Purchase at: " . TF::RED . "store.alpinehcf.net",
			"",
			TF::RESET . TF::GRAY . "Cooldown: " . TF::GREEN . "12 Hours",
			TF::RESET . TF::GRAY . "Available In: " . TF::GREEN,
			TF::RESET . TF::BOLD . TF::GRAY . "(" . TF::YELLOW . "!" . TF::GRAY . ")" . TF::RESET . TF::GRAY . "Right click to claim!"]);
		$master = Item::get(Item::NETHER_STAR);
		$master->setCustomName(TF::DARK_BLUE . "Master" . TF::GRAY . " Kit");
		$master->setLore([
			TF::RESET . TF::GRAY . "An enchanted diamond set that gives special",
			TF::RESET . TF::GRAY . "effects to all those action players!",
			"",
			TF::RESET . TF::YELLOW . "Purchase at: " . TF::RED . "store.sylumhcf.net",
			"",
			TF::RESET . TF::GRAY . "Cooldown: " . TF::GREEN . "12 Hours",
			TF::RESET . TF::GRAY . "Available In: " . TF::GREEN,
			TF::RESET . TF::BOLD . TF::GRAY . "(" . TF::YELLOW . "!" . TF::GRAY . ")" . TF::RESET . TF::GRAY . "Right click to claim!"]);
		$builder = Item::get(Item::GRASS);
		$builder->setCustomName(TF::DARK_GREEN . "Builder" . TF::GRAY . " Kit");
		$builder->setLore([
			TF::RESET . TF::GRAY . "A kit that gives the basic items needed",
			TF::RESET . TF::GRAY . "to start building your base!",
			"",
			TF::RESET . TF::YELLOW . "Purchase at: " . TF::RED . "store.alpinehcf.net",
			"",
			TF::RESET . TF::GRAY . "Cooldown: " . TF::GREEN . "12 Hours",
			TF::RESET . TF::GRAY . "Available In: " . TF::GREEN,
			TF::RESET . TF::BOLD . TF::GRAY . "(" . TF::YELLOW . "!" . TF::GRAY . ")" . TF::RESET . TF::GRAY . "Right click to claim!"]);
		$brewer = Item::get(Item::BREWING_STAND);
		$brewer->setCustomName(TF::DARK_PURPLE . "Brewer" . TF::GRAY . " Kit");
		$brewer->setLore([
			TF::RESET . TF::GRAY . "Run out of brewing materials? Use this kit",
			TF::RESET . TF::GRAY . "to get them all! Great for sotws!",
			"",
			TF::RESET . TF::YELLOW . "Purchase at: " . TF::RED . "store.alpinehcf.net",
			"",
			TF::RESET . TF::GRAY . "Cooldown: " . TF::GREEN . "12 Hours",
			TF::RESET . TF::GRAY . "Available In: " . TF::GREEN,
			TF::RESET . TF::BOLD . TF::GRAY . "(" . TF::YELLOW . "!" . TF::GRAY . ")" . TF::RESET . TF::GRAY . "Right click to claim!"]);
		$starter = Item::get(Item::FISHING_ROD);
		$starter->setCustomName(TF::WHITE . "Starter" . TF::GRAY . " Kit");
		$starter->setLore([
			TF::RESET . TF::GRAY . "A Set useful for SOTW",
			TF::RESET . TF::GRAY . "and when you need food!",
			"",
			TF::RESET . TF::GRAY . "Cooldown: " . TF::GREEN . "4 Hours",
			TF::RESET . TF::GRAY . "Available In: " . TF::GREEN,
			TF::RESET . TF::BOLD . TF::GRAY . "(" . TF::YELLOW . "!" . TF::GRAY . ")" . TF::RESET . TF::GRAY . "Right click to claim!"]);
		$menu = InvMenu::create(InvMenu::TYPE_DOUBLE_CHEST);
		$menu->readonly();
		$menu->setName("§r§l§1Server Kits");
		$inv = $menu->getInventory();
		$inv->setItem(38, $starter);
		$inv->setItem(24, $archer);
		$inv->setItem(33, $miner);
		$inv->setItem(20, $bard);
		$inv->setItem(22, $diamond);
		$inv->setItem(29, $rogue);
		$inv->setItem(31, $brewer);
		$inv->setItem(40, $master);
		$inv->setItem(42, $builder);

		$i = 0;
		while($i < 54){
			if($i != 20 && $i != 22 && $i != 24 && $i != 29 && $i != 31 && $i != 33 && $i != 38 && $i != 40 && $i != 42) {
				$item = Item::get(Item::STAINED_GLASS_PANE, 15);
				$item->setCustomName(" ");
				$inv->setItem($i, $item);
			}
			$i++;
		}
		$p = Main::getPlayerManager();
		$menu->setListener(function (Player $player, Item $itemTakenOut, Item $itemPutIn,  SlotChangeAction $change) use ($p): bool {
			if(!$itemTakenOut->isNull()){
				$inv = $change->getInventory();
				$player->removeWindow($inv);
			}
			if($itemTakenOut->getCustomName() == TF::WHITE . "Starter" . TF::GRAY . " Kit"){
				if(!$player->hasPermission("core.kits.starter")) return false;
				$cooldown = $p->getKitCooldownLeft("Starter", $player);
				if($cooldown <= 0){
					$this->starterKit($player);
					$time = time() + (60 * 60 * 4);
				} else {
					$player->sendMessage("§l§c»» §r§7Your kit is currently on cooldown for: §c" . Time::IntToTime($cooldown));
				}
			}

			if($itemTakenOut->getCustomName() == TF::GREEN . "Archer" . TF::GRAY . " Kit"){
				if(!$player->hasPermission("core.kits.archer")) return false;
				$cooldown = $p->getKitCooldownLeft("Archer", $player);
				if($cooldown <= 0){
					$this->archerKit($player);
					$time = time() + (60 * 60 * 12);
				} else {
					$player->sendMessage("§l§c»» §r§7Your kit is currently on cooldown for: §c" . Time::IntToTime($cooldown));
				}
			}

			if($itemTakenOut->getCustomName() == TF::GRAY . "Miner Kit"){
				if(!$player->hasPermission("core.kits.miner")) return false;
				$cooldown = $p->getKitCooldownLeft("Miner", $player);
				if($cooldown <= 0){
					$this->minerKit($player);
					$time = time() + (60 * 60 * 12);
				} else {
					$player->sendMessage("§l§c»» §r§7Your kit is currently on cooldown for: §c" . Time::IntToTime($cooldown));
				}
			}

			if($itemTakenOut->getCustomName() == TF::GOLD . "Bard" . TF::GRAY . " Kit"){
				if(!$player->hasPermission("core.kits.bard")) return false;
				$cooldown = $p->getKitCooldownLeft("Bard", $player);
				if($cooldown <= 0){
					$this->bardKit($player);
					$time = time() + (60 * 60 * 12);
				} else {
					$player->sendMessage("§l§c»» §r§7Your kit is currently on cooldown for: §c" . Time::IntToTime($cooldown));
				}
			}

			if($itemTakenOut->getCustomName() == TF::GRAY . "Rogue Kit"){
				if(!$player->hasPermission("core.kits.rogue")) return false;
				$cooldown = $p->getKitCooldownLeft("Rogue", $player);
				if($cooldown <= 0){
					$this->rogueKit($player);
					$time = time() + (60 * 60 * 12);
				} else {
					$player->sendMessage("§l§c»» §r§7Your kit is currently on cooldown for: §c" . Time::IntToTime($cooldown));
				}
			}

			if($itemTakenOut->getCustomName() == TF::BLUE . "Diamond" . TF::GRAY . " Kit"){
				if(!$player->hasPermission("core.kits.diamond")) return false;
				$cooldown = $p->getKitCooldownLeft("Diamond", $player);
				if($cooldown <= 0){
					$this->diamondKit($player);
					$time = time() + (60 * 60 * 12);
				} else {
					$player->sendMessage("§l§c»» §r§7Your kit is currently on cooldown for: §c" . Time::IntToTime($cooldown));
				}
			}

			if($itemTakenOut->getCustomName() == TF::DARK_BLUE . "Master" . TF::GRAY . " Kit"){
				if(!$player->hasPermission("core.kits.master")) return false;
				$cooldown = $p->getKitCooldownLeft("Master", $player);
				if($cooldown <= 0){
					$this->masterKit($player);
					$time = time() + (60 * 60 * 12);
				} else {
					$player->sendMessage("§l§c»» §r§7Your kit is currently on cooldown for: §c" . Time::IntToTime($cooldown));
				}
			}

			if($itemTakenOut->getCustomName() == TF::DARK_GREEN . "Builder" . TF::GRAY . " Kit"){
				if(!$player->hasPermission("core.kits.builder")) return false;
				$cooldown = $p->getKitCooldownLeft("Builder", $player);
				if($cooldown <= 0){
					$this->builderKit($player);
					$time = time() + (60 * 60 * 12);
				} else {
					$player->sendMessage("§l§c»» §r§7Your kit is currently on cooldown for: §c" . Time::IntToTime($cooldown));
				}
			}

			if($itemTakenOut->getCustomName() == TF::DARK_PURPLE . "Brewer" . TF::GRAY . " Kit"){
				if(!$player->hasPermission("core.kits.brewer")) return false;
				$cooldown = $p->getKitCooldownLeft("Brewer", $player);
				if($cooldown <= 0){
					$this->brewerKit($player);
					$time = time() + (60 * 60 * 12);
				} else {
					$player->sendMessage("§l§c»» §r§7Your kit is currently on cooldown for: §c" . Time::IntToTime($cooldown));
				}
			}
			return true;
		});
		$menu->send($player);
	}
	/**
	 * @param Player $player
	 */
	public function starterKit(Player $player) {
		$items = [Item::get(Item::BAKED_POTATO, 0, 64), Item::get(Item::NETHER_WART, 0, 8), Item::get(Item::GLOWSTONE_DUST, 0, 8), Item::get(Item::SUGARCANE, 0, 8), Item::get(Item::SPIDER_EYE, 0, 8), Item::get(Item::FERMENTED_SPIDER_EYE, 0, 8), Item::get(Item::GOLDEN_CARROT, 0, 8), Item::get(Item::GLISTERING_MELON, 0, 8), Item::get(Item::GUNPOWDER, 0, 8), Item::get(Item::FISHING_ROD)];
		foreach($items as $item){
			if($player->getInventory()->canAddItem($item)){
				$player->getInventory()->addItem($item);
			} else $player->getLevel()->dropItem($player, $item);
		}
		$player->sendMessage(TF::BOLD . TF::GREEN . "»»" . TF::RESET . TF::GRAY . " You have successfully redeemed Starter Kit");
	}

	/**
	 * @param Player $player
	 */
	public function brewerKit(Player $player) {
		$items = [Item::get(Item::NETHER_WART, 0, 64), Item::get(Item::GLOWSTONE_DUST, 0, 128), Item::get(Item::GOLDEN_CARROT, 0, 64), Item::get(Item::CARROT, 0, 64), Item::get(Item::SPIDER_EYE, 0, 64), Item::get(Item::FERMENTED_SPIDER_EYE, 0, 64), Item::get(Item::SUGAR, 0, 64), Item::get(Item::GLISTERING_MELON, 0, 64), Item::get(Item::GUNPOWDER, 0, 64), Item::get(Item::REDSTONE_DUST, 0, 64), Item::get(Item::MAGMA_CREAM, 0, 64), Item::get(Item::HOPPER, 0, 32), Item::get(Item::GLASS, 0, 256)];
		foreach($items as $item){
			if($player->getInventory()->canAddItem($item)){
				$player->getInventory()->addItem($item);
			} else $player->getLevel()->dropItem($player, $item);
		}
		$player->sendMessage(TF::BOLD . TF::GREEN . "»»" . TF::RESET . TF::GRAY . " You have successfully redeemed Brewer Kit");
	}

	/**
	 * @param Player $player
	 */
	public function builderKit(Player $player) {
		$items = [Item::get(Item::GRASS, 0, 256), Item::get(Item::GLASS, 0, 512), Item::get(Item::LOG, 0, 512), Item::get(Item::STONE, 0, 512)];
		foreach($items as $item){
			if($player->getInventory()->canAddItem($item)){
				$player->getInventory()->addItem($item);
			} else $player->getLevel()->dropItem($player, $item);
		}
		$player->sendMessage(TF::BOLD . TF::GREEN . "»»" . TF::RESET . TF::GRAY . " You have successfully redeemed Builder Kit");
	}

	/**
	 * @param Player $player
	 */
	public function archerKit(Player $player){
		$inv = $player->getInventory();
		$protection = Enchantment::getEnchantment(Enchantment::PROTECTION);
		$sharpness = Enchantment::getEnchantment(Enchantment::SHARPNESS);
		$infinity = Enchantment::getEnchantment(Enchantment::INFINITY);
		$power = Enchantment::getEnchantment(Enchantment::POWER);
		$punch = Enchantment::getEnchantment(Enchantment::PUNCH);
		$flame = Enchantment::getEnchantment(Enchantment::FLAME);
		$unbreaking = Enchantment::getEnchantment(Enchantment::UNBREAKING);
		$falling = Enchantment::getEnchantment(Enchantment::FEATHER_FALLING);

		$helmet = Item::get(Item::LEATHER_HELMET);
		$helmet->addEnchantment(new EnchantmentInstance($protection, 2));
		$helmet->addEnchantment(new EnchantmentInstance($unbreaking, 3));
		$helmet->setCustomName("" . "§r§l§7[§aArcher§7]§r §7Helmet");
		$chestplate = Item::get(Item::LEATHER_CHESTPLATE);
		$chestplate->addEnchantment(new EnchantmentInstance($protection, 2));
		$chestplate->addEnchantment(new EnchantmentInstance($unbreaking, 3));
		$chestplate->setCustomName("" . "§r§l§7[§aArcher§7]§r §7Chestplate");
		$leggings = Item::get(Item::LEATHER_LEGGINGS);
		$leggings->addEnchantment(new EnchantmentInstance($protection, 2));
		$leggings->addEnchantment(new EnchantmentInstance($unbreaking, 3));
		$leggings->setCustomName("" . "§r§l§7[§aArcher§7]§r §7Leggings");
		$boots = Item::get(Item::LEATHER_BOOTS);
		$boots->addEnchantment(new EnchantmentInstance($protection, 2));
		$boots->addEnchantment(new EnchantmentInstance($falling, 4));
		$boots->addEnchantment(new EnchantmentInstance($unbreaking, 3));
		$boots->setCustomName("" . "§r§l§7[§aArcher§7]§r §7Boots");
		$pearl = Item::get(Item::ENDER_PEARL, 0, 16);
		$sword = Item::get(Item::DIAMOND_SWORD);
		$sword->addEnchantment(new EnchantmentInstance($sharpness, 2));
		$sword->addEnchantment(new EnchantmentInstance($unbreaking, 3));
		$sword->setCustomName("" . "§r§l§7[§aArcher§7]§r §7Sword");
		$bow = Item::get(Item::BOW);
		$bow->addEnchantment(new EnchantmentInstance($unbreaking, 3));
		$bow->addEnchantment(new EnchantmentInstance($power, 5));
		$bow->addEnchantment(new EnchantmentInstance($punch, 2));
		$bow->addEnchantment(new EnchantmentInstance($infinity, 1));
		$bow->addEnchantment(new EnchantmentInstance($flame, 1));
		$bow->setCustomName("" . "§r§l§7[§aArcher§7]§r §7Bow");
		$arrow = Item::get(Item::ARROW, 0, 64);
		$sugar = Item::get(Item::SUGAR, 0, 64);
		$wings = Item::get(Item::FEATHER, 0, 64);
		$pot = Item::get(Item::BAKED_POTATO, 0, 64);
		$items = array($sword, $pearl, $helmet, $chestplate, $leggings, $boots, $bow, $arrow, $sugar, $wings, $pot);
		foreach($items as $item){
			if($player->getInventory()->canAddItem($item)){
				$player->getInventory()->addItem($item);
			} else $player->getLevel()->dropItem($player, $item);
		}
		for($i = 0; $i < 26; $i++){
			$healing = Item::get(Item::SPLASH_POTION, 22, 1);
			if($inv->canAddItem($healing)){
				$inv->addItem($healing);
			} else $player->getLevel()->dropItem($player, $healing);
		}
		$player->sendMessage(TF::BOLD . TF::GREEN . "»»" . TF::RESET . TF::GRAY . " You have successfully redeemed Archer Kit");
	}

	/**
	 * @param Player $player
	 */
	public function minerKit(Player $player){
		$inv = $player->getInventory();
		$efficiency = Enchantment::getEnchantment(Enchantment::EFFICIENCY);
		$protection = Enchantment::getEnchantment(Enchantment::PROTECTION);
		$sharpness = Enchantment::getEnchantment(Enchantment::SHARPNESS);
		$fortune = Enchantment::getEnchantment(Enchantment::FORTUNE);
		$silktouch = Enchantment::getEnchantment(Enchantment::SILK_TOUCH);
		$unbreaking = Enchantment::getEnchantment(Enchantment::UNBREAKING);
		$falling = Enchantment::getEnchantment(Enchantment::FEATHER_FALLING);

		$helmet = Item::get(Item::IRON_HELMET);
		$helmet->addEnchantment(new EnchantmentInstance($protection, 2));
		$helmet->addEnchantment(new EnchantmentInstance($unbreaking, 3));
		$helmet->setCustomName("" . "§r§l§7[§8Miner§7]§r §7Helmet");
		$chestplate = Item::get(Item::IRON_CHESTPLATE);
		$chestplate->addEnchantment(new EnchantmentInstance($protection, 2));
		$chestplate->addEnchantment(new EnchantmentInstance($unbreaking, 3));
		$chestplate->setCustomName("" . "§r§l§7[§8Miner§7]§r §7Chestplate");
		$leggings = Item::get(Item::IRON_LEGGINGS);
		$leggings->addEnchantment(new EnchantmentInstance($protection, 2));
		$leggings->addEnchantment(new EnchantmentInstance($unbreaking, 3));
		$leggings->setCustomName("" . "§r§l§7[§8Miner§7]§r §7Leggings");
		$boots = Item::get(Item::IRON_BOOTS);
		$boots->addEnchantment(new EnchantmentInstance($protection, 2));
		$boots->addEnchantment(new EnchantmentInstance($falling, 4));
		$boots->addEnchantment(new EnchantmentInstance($unbreaking, 3));
		$boots->setCustomName("" . "§r§l§7[§8Miner§7]§r §7Boots");
		$effaxe = Item::get(Item::DIAMOND_AXE);
		$effaxe->addEnchantment(new EnchantmentInstance($unbreaking, 3));
		$effaxe->addEnchantment(new EnchantmentInstance($efficiency, 5));
		$effshovel = Item::get(Item::DIAMOND_SHOVEL);
		$effshovel->addEnchantment(new EnchantmentInstance($unbreaking, 3));
		$effshovel->addEnchantment(new EnchantmentInstance($efficiency, 5));
		$effshovel->setCustomName("§r§l" . "§7[§aMiner§7]§r §7[Efficiency] Shovel");
		$effpickaxe = Item::get(Item::DIAMOND_PICKAXE);
		$effpickaxe->addEnchantment(new EnchantmentInstance($unbreaking, 3));
		$effpickaxe->addEnchantment(new EnchantmentInstance($fortune, 3));
		$effpickaxe->addEnchantment(new EnchantmentInstance($efficiency, 5));
		$effpickaxe->setCustomName("§r§l" . "§7[§aMiner§7]§r §7[Efficiency] Pickaxe");
		$silkpickaxe = Item::get(Item::DIAMOND_PICKAXE);
		$silkpickaxe->addEnchantment(new EnchantmentInstance($silktouch, 1));
		$silkpickaxe->addEnchantment(new EnchantmentInstance($unbreaking, 3));
		$silkpickaxe->addEnchantment(new EnchantmentInstance($efficiency, 4));
		$silkpickaxe->setCustomName("§r§l" . "§7[§aMiner§7]§r §7[SilkTouch] Pickaxe");
		$table = Item::get(Item::CRAFTING_TABLE, 0, 64);
		$anvil = Item::get(Item::ANVIL, 0, 2);
		$pot = Item::get(Item::BAKED_POTATO, 0, 64);
		$items = array($helmet, $chestplate, $leggings, $boots, $effpickaxe, $silkpickaxe, $effshovel, $effaxe, $table, $anvil, $pot);
		foreach($items as $item){
			if($player->getInventory()->canAddItem($item)){
				$player->getInventory()->addItem($item);
			} else $player->getLevel()->dropItem($player, $item);
		}
		$player->sendMessage(TF::BOLD . TF::GREEN . "»»" . TF::RESET . TF::GRAY . " You have successfully redeemed Miner Kit");
	}

	/**
	 * @param Player $player
	 */
	public function bardKit(Player $player){
		$inv = $player->getInventory();
		$protection = Enchantment::getEnchantment(Enchantment::PROTECTION);
		$sharpness = Enchantment::getEnchantment(Enchantment::SHARPNESS);
		$unbreaking = Enchantment::getEnchantment(Enchantment::UNBREAKING);
		$falling = Enchantment::getEnchantment(Enchantment::FEATHER_FALLING);

		$helmet = Item::get(Item::GOLD_HELMET);
		$helmet->addEnchantment(new EnchantmentInstance($protection, 2));
		$helmet->addEnchantment(new EnchantmentInstance($unbreaking, 3));
		$helmet->setCustomName("" . "§r§l§7[" . TF::GOLD . "Bard§7]§r §7Helmet");
		$chestplate = Item::get(Item::GOLD_CHESTPLATE);
		$chestplate->addEnchantment(new EnchantmentInstance($protection, 2));
		$chestplate->addEnchantment(new EnchantmentInstance($unbreaking, 3));
		$chestplate->setCustomName("" . "§r§l§7[" . TF::GOLD . "Bard§7]§r §7Chestplate");
		$leggings = Item::get(Item::GOLD_LEGGINGS);
		$leggings->addEnchantment(new EnchantmentInstance($protection, 2));
		$leggings->addEnchantment(new EnchantmentInstance($unbreaking, 3));
		$leggings->setCustomName("" . "§r§l§7[" . TF::GOLD . "Bard§7]§r §7Leggings");
		$boots = Item::get(Item::GOLD_BOOTS);
		$boots->addEnchantment(new EnchantmentInstance($protection, 2));
		$boots->addEnchantment(new EnchantmentInstance($falling, 4));
		$boots->addEnchantment(new EnchantmentInstance($unbreaking, 3));
		$boots->setCustomName("" . "§r§l§7[" . TF::GOLD . "Bard§7]§r §7Boots");
		$pearl = Item::get(Item::ENDER_PEARL, 0, 16);
		$sword = Item::get(Item::DIAMOND_SWORD);
		$sword->addEnchantment(new EnchantmentInstance($sharpness, 2));
		$sword->addEnchantment(new EnchantmentInstance($unbreaking, 3));
		$sword->setCustomName("" . "§r§l§7[" . TF::GOLD . "Bard§7]§r §7Sword");
		$sugar = Item::get(Item::SUGAR, 0, 64);
		$powder = Item::get(Item::BLAZE_POWDER, 0, 64);
		$iron = Item::get(Item::IRON_INGOT, 0, 64);
		$tear = Item::get(Item::GHAST_TEAR, 0, 16);
		$cream = Item::get(Item::MAGMA_CREAM, 0, 64);
		$wings = Item::get(Item::FEATHER, 0, 64);
		$pot = Item::get(Item::BAKED_POTATO, 0, 64);
		$spider = Item::get(Item::SPIDER_EYE, 0, 64);
		$wheat = Item::get(Item::WHEAT, 0, 64);
		$items = array($sword, $pearl, $helmet, $chestplate, $leggings, $boots, $sugar, $wings, $pot, $powder, $iron, $tear, $cream, $spider, $wheat, $sugar);
		foreach($items as $item){
			if($player->getInventory()->canAddItem($item)){
				$player->getInventory()->addItem($item);
			} else $player->getLevel()->dropItem($player, $item);
		}
		for($i = 0; $i < 22; $i++){
			$healing = Item::get(Item::SPLASH_POTION, 22, 1);
			if($inv->canAddItem($healing)){
				$inv->addItem($healing);
			} else $player->getLevel()->dropItem($player, $healing);
		}
		$player->sendMessage(TF::BOLD . TF::GREEN . "»»" . TF::RESET . TF::GRAY . " You have successfully redeemed Bard Kit");
	}

	/**
	 * @param Player $player
	 */
	public function diamondKit(Player $player){
		$inv = $player->getInventory();
		$protection = Enchantment::getEnchantment(Enchantment::PROTECTION);
		$sharpness = Enchantment::getEnchantment(Enchantment::SHARPNESS);
		$unbreaking = Enchantment::getEnchantment(Enchantment::UNBREAKING);
		$falling = Enchantment::getEnchantment(Enchantment::FEATHER_FALLING);

		$helmet = Item::get(Item::DIAMOND_HELMET);
		$helmet->addEnchantment(new EnchantmentInstance($protection, 2));
		$helmet->addEnchantment(new EnchantmentInstance($unbreaking, 3));
		$helmet->setCustomName("" . "§r§l§7[" . TF::BLUE . "Diamond§7]§r §7Helmet");
		$chestplate = Item::get(Item::DIAMOND_CHESTPLATE);
		$chestplate->addEnchantment(new EnchantmentInstance($protection, 2));
		$chestplate->addEnchantment(new EnchantmentInstance($unbreaking, 3));
		$chestplate->setCustomName("" . "§r§l§7[" . TF::BLUE . "Diamond§7]§r §7Chestplate");
		$leggings = Item::get(Item::DIAMOND_LEGGINGS);
		$leggings->addEnchantment(new EnchantmentInstance($protection, 2));
		$leggings->addEnchantment(new EnchantmentInstance($unbreaking, 3));
		$leggings->setCustomName("" . "§r§l§7[" . TF::BLUE . "Diamond§7]§r §7Leggings");
		$boots = Item::get(Item::DIAMOND_BOOTS);
		$boots->addEnchantment(new EnchantmentInstance($protection, 2));
		$boots->addEnchantment(new EnchantmentInstance($falling, 4));
		$boots->addEnchantment(new EnchantmentInstance($unbreaking, 3));
		$boots->setCustomName("" . "§r§l§7[" . TF::BLUE . "Diamond§7]§r §7Boots");
		$pearl = Item::get(Item::ENDER_PEARL, 0, 16);
		$sword = Item::get(Item::DIAMOND_SWORD);
		$sword->addEnchantment(new EnchantmentInstance($sharpness, 2));
		$sword->addEnchantment(new EnchantmentInstance($unbreaking, 3));
		$sword->setCustomName("" . "§r§l§7[" . TF::BLUE . "Diamond§7]§r §7Sword");
		$invis = Item::get(Item::POTION, 8, 1);
		$fire = Item::get(Item::POTION, 13, 1);
		$speed = Item::get(Item::POTION, 16, 6);
		$pot = Item::get(Item::BAKED_POTATO, 0, 64);
		$items = array($sword, $pearl, $helmet, $chestplate, $leggings, $boots, $invis, $fire, $speed, $pot);
		foreach($items as $item){
			if($player->getInventory()->canAddItem($item)){
				$player->getInventory()->addItem($item);
			} else $player->getLevel()->dropItem($player, $item);
		}
		for($i = 0; $i < 24; $i++){
			$healing = Item::get(Item::SPLASH_POTION, 22, 1);
			if($inv->canAddItem($healing)){
				$inv->addItem($healing);
			} else $player->getLevel()->dropItem($player, $healing);
		}
		$player->sendMessage(TF::BOLD . TF::GREEN . "»»" . TF::RESET . TF::GRAY . " You have successfully redeemed Diamond Kit");
	}

	/**
	 * @param Player $player
	 */
	public function rogueKit(Player $player){
		$inv = $player->getInventory();
		$protection = Enchantment::getEnchantment(Enchantment::PROTECTION);
		$sharpness = Enchantment::getEnchantment(Enchantment::SHARPNESS);
		$unbreaking = Enchantment::getEnchantment(Enchantment::UNBREAKING);
		$falling = Enchantment::getEnchantment(Enchantment::FEATHER_FALLING);

		$helmet = Item::get(Item::CHAIN_HELMET);
		$helmet->addEnchantment(new EnchantmentInstance($protection, 2));
		$helmet->addEnchantment(new EnchantmentInstance($unbreaking, 3));
		$helmet->setCustomName("" . "§r§l§7[" . TF::GRAY . "Rogue§7]§r §7Helmet");
		$chestplate = Item::get(Item::CHAIN_CHESTPLATE);
		$chestplate->addEnchantment(new EnchantmentInstance($protection, 2));
		$chestplate->addEnchantment(new EnchantmentInstance($unbreaking, 3));
		$chestplate->setCustomName("" . "§r§l§7[" . TF::GRAY . "Rogue§7]§r §7Chestplate");
		$leggings = Item::get(Item::CHAIN_LEGGINGS);
		$leggings->addEnchantment(new EnchantmentInstance($protection, 2));
		$leggings->addEnchantment(new EnchantmentInstance($unbreaking, 3));
		$leggings->setCustomName("" . "§r§l§7[" . TF::GRAY . "Rogue§7]§r §7Leggings");
		$boots = Item::get(Item::CHAIN_BOOTS);
		$boots->addEnchantment(new EnchantmentInstance($protection, 2));
		$boots->addEnchantment(new EnchantmentInstance($falling, 4));
		$boots->addEnchantment(new EnchantmentInstance($unbreaking, 3));
		$boots->setCustomName("" . "§r§l§7[" . TF::GRAY . "Rogue§7]§r §7Boots");
		$pearl = Item::get(Item::ENDER_PEARL, 0, 16);
		$sword = Item::get(Item::DIAMOND_SWORD);
		$sword->addEnchantment(new EnchantmentInstance($sharpness, 2));
		$sword->addEnchantment(new EnchantmentInstance($unbreaking, 3));
		$sword->setCustomName("" . "§r§l§7[" . TF::GRAY . "Rogue§7]§r §7Sword");
		$feather = Item::get(Item::FEATHER, 0, 64);
		$sugar = Item::get(Item::SUGAR, 0, 64);
		$pot = Item::get(Item::BAKED_POTATO, 0, 64);
		$swords = Item::get(Item::GOLD_SWORD, 0, 11);
		$items = array($sword, $pearl, $helmet, $chestplate, $leggings, $boots, $feather, $sugar, $pot, $swords);
		foreach($items as $item){
			if($player->getInventory()->canAddItem($item)){
				$player->getInventory()->addItem($item);
			} else $player->getLevel()->dropItem($player, $item);
		}
		for($i = 0; $i < 16; $i++){
			$healing = Item::get(Item::SPLASH_POTION, 22, 1);
			if($inv->canAddItem($healing)){
				$inv->addItem($healing);
			} else $player->getLevel()->dropItem($player, $healing);
		}
		$player->sendMessage(TF::BOLD . TF::GREEN . "»»" . TF::RESET . TF::GRAY . " You have successfully redeemed Rogue Kit");
	}

	/**
	 * @param Player $player
	 */
	public function masterKit(Player $player){
		$inv = $player->getInventory();
		$protection = Enchantment::getEnchantment(Enchantment::PROTECTION);
		$sharpness = Enchantment::getEnchantment(Enchantment::SHARPNESS);
		$unbreaking = Enchantment::getEnchantment(Enchantment::UNBREAKING);
		$falling = Enchantment::getEnchantment(Enchantment::FEATHER_FALLING);

		$helmet = Item::get(Item::DIAMOND_HELMET);
		$helmet->addEnchantment(new EnchantmentInstance($protection, 2));
		$helmet->addEnchantment(new EnchantmentInstance($unbreaking, 3));
		$helmet->setCustomName("" . "§r§l§7[" . TF::DARK_BLUE . "Master§7]§r §7Helmet");
		$nametag = $helmet->getNamedTag();
		$nametag->setInt("master", 1);
		$helmet->setNamedTag($nametag);
		$chestplate = Item::get(Item::DIAMOND_CHESTPLATE);
		$chestplate->addEnchantment(new EnchantmentInstance($protection, 2));
		$chestplate->addEnchantment(new EnchantmentInstance($unbreaking, 3));
		$chestplate->setCustomName("" . "§r§l§7[" . TF::DARK_BLUE . "Master§7]§r §7Chestplate");
		$chesttag = $chestplate->getNamedTag();
		$chesttag->setInt("master", 2);
		$chestplate->setNamedTag($chesttag);
		$leggings = Item::get(Item::DIAMOND_LEGGINGS);
		$leggings->addEnchantment(new EnchantmentInstance($protection, 2));
		$leggings->addEnchantment(new EnchantmentInstance($unbreaking, 3));
		$leggings->setCustomName("" . "§r§l§7[" . TF::DARK_BLUE . "Master§7]§r §7Leggings");
		$legtag = $leggings->getNamedTag();
		$legtag->setInt("master", 3);
		$leggings->setNamedTag($legtag);
		$boots = Item::get(Item::DIAMOND_BOOTS);
		$boots->addEnchantment(new EnchantmentInstance($protection, 2));
		$boots->addEnchantment(new EnchantmentInstance($falling, 4));
		$boots->addEnchantment(new EnchantmentInstance($unbreaking, 3));
		$boots->setCustomName("" . "§r§l§7[" . TF::DARK_BLUE . "Master§7]§r §7Boots");
		$boottag = $boots->getNamedTag();
		$boottag->setInt("master", 4);
		$boots->setNamedTag($boottag);
		$pearl = Item::get(Item::ENDER_PEARL, 0, 16);
		$sword = Item::get(Item::DIAMOND_SWORD);
		$sword->addEnchantment(new EnchantmentInstance($sharpness, 2));
		$sword->addEnchantment(new EnchantmentInstance($unbreaking, 3));
		$sword->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::FIRE_ASPECT), 1));
		$sword->setCustomName("" . "§r§l§7[" . TF::DARK_BLUE . "Master§7]§r §7Sword");
		$invis = Item::get(Item::POTION, 8, 1);
		$fire = Item::get(Item::POTION, 13, 1);
		$speed = Item::get(Item::POTION, 16, 2);
		$pot = Item::get(Item::BAKED_POTATO, 0, 64);
		$items = array($sword, $pearl, $helmet, $chestplate, $leggings, $boots, $invis, $fire, $speed, $pot);
		foreach($items as $item){
			if($player->getInventory()->canAddItem($item)){
				$player->getInventory()->addItem($item);
			} else $player->getLevel()->dropItem($player, $item);
		}
		for($i = 0; $i < 25; $i++){
			$healing = Item::get(Item::SPLASH_POTION, 22, 1);
			if($inv->canAddItem($healing)){
				$inv->addItem($healing);
			} else $player->getLevel()->dropItem($player, $healing);
		}
		$player->sendMessage(TF::BOLD . TF::GREEN . "»»" . TF::RESET . TF::GRAY . " You have successfully redeemed Master Kit");
	}

}