<?php


namespace Besher\HCF\Commands;

use pocketmine\item\Item;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat as TF;
use Besher\HCF\Main;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;

class Crate extends Command
{

	private $plugin;
	private $crate;
	private $block;

	private const CRATES = TF::GOLD."Crates ".TF::RESET;

	public function __construct(Main $pg)
	{
		parent::__construct("crate", "Crates command", "/Crate <string>");
		$this->setPermission("crate.hcf");
		$this->setPermissionMessage(self::CRATES.TF::RED."No permission");
		$this->plugin = $pg;
	}

	public function execute(CommandSender $sender, string $commandLabel, array $args) : void
	{
		$c = Main::getCrateManager();
		if(!$sender instanceof Player){
			$sender->sendMessage($this->getPermissionMessage());
			return;
		}
		if(!$this->testPermission($sender)){
			$sender->sendMessage($this->getPermissionMessage());
			return;
		}
		if(!isset($args[0])){
			$sender->sendMessage(self::CRATES."/crate help");
			return;
		}
		$array = strtolower($args[0]);
		if($array == "help"){
			$sender->sendMessage(self::CRATES."§a/crate create <cratename> <displayname> §6- Creates a crate\n§a/crate reload §6- §rReloads the plugin.\n§a/crate give <player> <cratename> <amount> §6- §rGives a player a crate.\n§a/crate giveall <cratename> <amount> §6- §rGives all players a crate.\n§a/crate givekey <player> <cratename> <amount> §6- §rGives a player a crate key.\n§a/crate giveallkey <cratename> <amount> §6- §rGive all players a crate key.\n§a/crate set <cratename> §6- §rSet a block as a crate.\n§a/crate remove §6- §rRemove a block as crate.\n§a/crate list §6- §rList all current crates.\n§a/crate info <cratename> §6- §rGet info on a crate.");
			return;
		}
		if($array == "reload"){
			$this->config = new Config($this->plugin->getDataFolder() . "crate/" . "items.yml", Config::YAML);
			$sender->sendMessage(self::CRATES.TF::GRAY."Reloading...");
			$c->loadFloatingText();
			$this->config->reload();
			$sender->sendMessage(self::CRATES.TF::GREEN."Reload complete.");
			return;
		}
		if($array == "create")
		{
			if(!isset($args[1])){
				$sender->sendMessage("§a/crate create <cratename>.");
				return;
			}
			if($c->crateExists($args[1]) == true){
				$sender->sendMessage(self::CRATES.TF::RED."That crate already exists");
				return;
			}
			unset($this->plugin->crateSetup[$sender->getName()]);
			unset($this->plugin->display[$sender->getName()]);
			unset($this->plugin->hologram[$sender->getName()]);
			$this->config = new Config($this->plugin->getDataFolder() . "crate/" . "items.yml", Config::YAML);
			$this->config->set("$args[1]", ["rewards" => ['Hello', 'Bye', 'Lol']]);
			$this->config->save();
			$c->createCrate($args[1]);
			$sender->sendMessage(self::CRATES."Crate $args[1] created\nYou have started Crate setup:\n1. Type crate display name\n2. Hologram text\nBreak block");
			$this->plugin->crateSetup[$sender->getName()] = $args[1];
			$this->plugin->display[$sender->getName()] = $sender->getName();
			return;
		}
		if($array == "edit")
		{
			if(!isset($args[1])){
				$sender->sendMessage("§a/crate create <cratename>");
				return;
			}
			if($c->crateExists($args[1]) == false){
				$sender->sendMessage(self::CRATES.TF::RED."That crate doesn't exists");
				return;
			}
			unset($this->plugin->crateSetup[$sender->getName()]);
			unset($this->plugin->display[$sender->getName()]);
			unset($this->plugin->hologram[$sender->getName()]);
			$this->plugin->crateSetup[$sender->getName()] = $args[1];
			$this->plugin->display[$sender->getName()] = $sender->getName();
			$sender->sendMessage(self::CRATES."You are now editing\nYou have started Crate setup:\n1. Type crate display name\n2. Hologram text\nBreak block");
		}
		if($array == "givekey")
		{
			if(!isset($args[1]) or !isset($args[2])){
				$sender->sendMessage("§a/crate givekey <cratename> <player>");
				return;
			}
			if($c->crateExists($args[1]) == false){
				$sender->sendMessage(self::CRATES.TF::RED."That crate doesn't exists");
				return;
			}
			$player = $this->plugin->getServer()->getPlayer($args[2]);
			$crate = $args[1];
			if($player == null)
			{
				$sender->sendMessage("That player is not online");
				return;
			}
			$display = $c->getDisplay($crate);
			$itemName = str_replace("Crate", "Key", $display);
			$player->getInventory()->addItem(Item::get(Item::TRIPWIRE_HOOK)->setCustomName(TF::RESET."$itemName"));
			$player->sendMessage("You have received x1 $display Key");
			$sender->sendMessage("Give {$player->getName()} $display Key");
			return;
		}
	}
}