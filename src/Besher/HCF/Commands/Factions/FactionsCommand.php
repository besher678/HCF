<?php

namespace Besher\HCF\Commands\Factions;

use Besher\HCF\Main;
use pocketmine\block\Block;
use pocketmine\block\BlockIds;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\utils\CommandException;
use pocketmine\item\Item;
use pocketmine\Player;
use pocketmine\utils\TextFormat as TF;

class FactionsCommand extends Command{

	public $plugin;

	public $stepOne = [];

	const FACTION = TF::DARK_GRAY."[".TF::RED.TF::BOLD."Faction".TF::RESET.TF::DARK_GRAY."] ".TF::GRAY;

	public function __construct(Main $pg)
	{
		parent::__construct("faction", "Factions command", "", ["t", "f", "team", "teams", "factions"]);
		$this->setPermission("faction.hcf");
		$this->plugin = $pg;
	}

	public function execute(CommandSender $sender, string $commandLabel, array $args)
	{
		$fac = Main::getFactionsManager();
		if ($sender instanceof Player) {
			if (!isset($args[0])) {
				$sender->sendMessage(TF::GRAY . "/t help to get list of commands");
				return true;
			}
			if($args[0] == "help"){
				$sender->sendMessage(TF::AQUA."-".TF::GRAY."-------------------------------------".TF::AQUA."Faction Help".TF::GRAY." (Page 1/4)\n".TF::AQUA."/t join -".TF::GRAY." Accept a join request from another faction.\n".TF::AQUA."/f chat - ".TF::GRAY."Toggle team chat.\n".TF::AQUA."/f claim - ".TF::GRAY."Claim land in the Wilderness.");

			}
			if($args[0] == "join"){
				if(!isset($args[1])){
					$sender->sendMessage(self::FACTION." Usage:".TF::YELLOW."/".TF::GRAY."f join".TF::YELLOW."<".TF::GRAY."faction".TF::YELLOW.">");
					return true;
				}
				if($fac->inFaction($sender)){
					$sender->sendMessage(self::FACTION." You are already in a ".TF::YELLOW."Faction");
					return true;
				}
				$faction = $args[1];
				if(!$fac->factionExists($faction)){
					$sender->sendMessage(self::FACTION." Faction with the name $faction doesn't exist");
					return true;
				}
				if(!$fac->isInvited($sender, $faction)){
					$sender->sendMessage(self::FACTION." You are not invited to that faction.");
					return true;
				}
				$fac->joinFaction($sender, $faction);


			}
			if($args[0] == "chat") {
				if (!isset($args[1])) {
					if (!$fac->inFaction($sender)) {
						$sender->sendMessage(self::FACTION . " You are not in a " . TF::YELLOW . "Faction");
						return true;
					}
					if (in_array($sender->getName(),  $this->plugin->inChat())){
						$this->plugin->setPublic($sender);
						$sender->sendMessage(self::FACTION . " Chat type changed to " . TF::YELLOW . "Public");
						return true;
					}
						$this->plugin->setFactionChat($sender);
						$sender->sendMessage(self::FACTION . " Chat type changed to " . TF::YELLOW . "Faction");
						return true;
					}
					if ($args[1] == "p") {
						$sender->sendMessage(self::FACTION . " Chat type changed to " . TF::YELLOW . "Public");
						return true;
					}
					if ($args[1] == "f") {
						$sender->sendMessage(self::FACTION . " Chat type changed to " . TF::YELLOW . "Faction");
						return true;
					}
			}
			if($args[0] == "claim"){

			}
			if($args[0] == "claimfor")
			{
				if(!isset($args[1])){
					$sender->sendMessage(self::FACTION.TF::RED."/f claimfor <faction>");
					return true;
				}
				$sender->sendMessage(self::FACTION."You are now claiming for $args[1]!");
				$name = $sender->getName();
				$fac->claimFor($args[1], $name);
				$name = $sender->getName();
				unset($this->stepOne[$name]);
				$this->stepOne[$name] = $args[1];
				$claim = Item::get(Item::WOODEN_HOE)->setCustomName(TF::RESET.TF::GOLD."Claiming Wand")->setLore([TF::RESET.TF::YELLOW."Right Click block to set claim area\nShift click air to confirm\nClick air to cancel"]);
				$sender->getInventory()->addItem($claim);
				return true;
			}
			if($args[0] == "create"){
				if(!isset($args[1])){
					$sender->sendMessage("args1");
					return true;
				}
				if($fac->factionExists($args[1])){
					$sender->sendMessage("EXISTS");
					return true;
				}
				$fac->createFaction($sender, $args[1]);
				$sender->sendMessage("created");
				return true;

			}
			if($args[0] == "disband"){

			}
			if($args[0] == "home"){

			}
			if($args[0] == "map"){
			}

		}
	}

	public function sendBlock(Player $player, $x, $y, $z, $id){
		$block = Block::get($id);
		$block->x = (int) $x;
		$block->y = (int) $y;
		$block->z = (int) $z;
		$block->level = $player->getLevel();
		$player->level->sendBlocks([$player],[$block]);
	}

	public function claimTower(Player $player, int $x, int $y, int $z)
	{
		$i = $y;
		for($i = $y; $i < $y +50; $i++){
			$this->sendBlock($player, $x, $i, $z, $this->glassAndEmerald());
		}
	}

	public function glassAndEmerald(): int
	{
		switch (mt_rand(1, 3)) {
			case 1:
			case 2:
				return BlockIds::GLASS;
				break;
			case 3:
				return BlockIds::EMERALD_BLOCK;
				break;
		}
		return BlockIds::GLASS;
	}

	public function alphanum($string)
	{
		if (function_exists('ctype_alnum')) {
			$return = ctype_alnum($string);
		} else {
			$return = preg_match('/^[a-z0-9]+$/i', $string) > 0;
		}
		return $return;
	}
}