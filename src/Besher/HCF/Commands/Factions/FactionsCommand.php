<?php

namespace Besher\HCF\Commands\Factions;

use Besher\HCF\Main;
use pocketmine\block\Block;
use pocketmine\block\BlockIds;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\utils\CommandException;
use pocketmine\item\Item;
use pocketmine\math\Vector3;
use pocketmine\Player;
use pocketmine\utils\TextFormat as TF;

class FactionsCommand extends Command{

	public $plugin;

	public $stepOne = [];


	const FACTION = TF::DARK_GRAY."[".TF::RED.TF::BOLD."Faction".TF::RESET.TF::DARK_GRAY."] ".TF::GRAY;

	public function __construct(Main $pg)
	{
		parent::__construct("faction", "Factions command", "", ["t", "f", "team", "teams", "factions"]);
		$this->plugin = $pg;
	}

	public function execute(CommandSender $sender, string $commandLabel, array $args)
	{
		$fac = Main::getFactionsManager();
		$lol = strtolower($args[0]);
		if ($sender instanceof Player) {
			if (!isset($args[0])) {
				$sender->sendMessage(TF::GRAY . "/t help to get list of commands");
				return true;
			}
			if($lol == "help"){
				$sender->sendMessage(TF::AQUA."-".TF::GRAY."-------------------------------------".TF::AQUA."Faction Help".TF::GRAY." (Page 1/4)\n".TF::AQUA."/t join -".TF::GRAY." Accept a join request from another faction.\n".TF::AQUA."/f chat - ".TF::GRAY."Toggle team chat.\n".TF::AQUA."/f claim - ".TF::GRAY."Claim land in the Wilderness.");

			}
			if($lol == "join"){
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
			if($lol == "chat") {
				if (!isset($args[1])) {
					$sender->sendMessage(self::FACTION. " /f help for list of commands");
					return true;
				}
				if (!$fac->inFaction($sender)) {
					$sender->sendMessage(self::FACTION . " You are not in a " . TF::YELLOW . "Faction");
					return true;
				}
				$name = $sender->getName();
				$text = strtolower($args[1]);
					if(in_array($name, $this->plugin->factionChat)){
						unset($this->plugin->factionChat[$name]);
						$sender->sendMessage(self::FACTION.TF::GREEN. " joined public chat");
						return true;
					}
					$this->plugin->factionChat[$name] = $name;
					$sender->sendMessage(self::FACTION.TF::GREEN. " joined faction chat");
					return true;
				}
			if($lol == "claim"){

			}
			if($lol == "claimfor")
			{
				if(!isset($args[1])){
					$sender->sendMessage(self::FACTION.TF::RED."/f claimfor <faction>");
					return true;
				}
				$sender->sendMessage(self::FACTION."You are now claiming for $args[1]!");
				$name = $sender->getName();
				$fac->claimFor($args[1], $name);
				$name = $sender->getName();
				$claim = Item::get(Item::WOODEN_HOE)->setCustomName(TF::RESET.TF::RED."Claim Wand")->setLore([TF::RESET.TF::GRAY."Left or Right click a block to set the\n".TF::GREEN."first".TF::GRAY." and".TF::GREEN." second ".TF::GRAY."position of your claim\n\nShift and right click the air or a block to\n".TF::GREEN."purchase ".TF::GRAY."your current claim selection\n\nRight click the air to ".TF::GREEN."clear\n".TF::GRAY."your current claim selection"]);
				$sender->getInventory()->addItem($claim);
				return true;
			}
			if($lol == "create"){
				if(!isset($args[1])){
					$sender->sendMessage(self::FACTION.TF::GRAY." /f create <faction_name>");
					return true;
				}
				if($fac->inFaction($sender)){
					$sender->sendMessage(self::FACTION. TF::RED." You are already in a faction!");
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
			if($args[0] == "sethome"){
				if(!$fac->inFaction($sender)){
					$sender->sendMessage(self::FACTION. TF::RED." You are not in a faction!");
					return true;
				}
				$faction = $fac->getPlayerFaction($sender);
				$leader = $fac->getLeader($faction);
				$coLeader = $fac->getCoLeader($faction);
				$officer = $fac->getOfficer($faction);
				if($sender->getName() != $leader or $sender->getName() != $coLeader or $sender->getName() != $officer){
					$sender->sendMessage("You don't have permission to set faction HQ");
					return true;
				}
				if($fac->inClaim($sender->getPosition()) == $faction)
				{
					$x = round($sender->getX());
					$y = round($sender->getY());
					$z = round($sender->getZ());
					$sender->sendMessage(self::FACTION. TF::GRAY."You faction home has been set to".TF::AQUA.  "$x, $y, $z ");
					$fac->setHQ($faction, $x, $y, $z);
				} else{
					$sender->sendMessage(self::FACTION. TF::RED." You must be in your claim to set Faction HQ");
					return true;
				}
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