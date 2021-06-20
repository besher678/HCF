<?php

namespace Besher\HCF\Events;

use Besher\HCF\Main;
use pocketmine\block\Air;
use pocketmine\event\block\SignChangeEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\math\Vector3;
use pocketmine\Player;
use pocketmine\tile\Sign;
use pocketmine\utils\TextFormat as TF;

class Elevator implements Listener{

	public $plugin;

	public function __construct(Main $pg)
	{
		$this->plugin = $pg;
	}

	public function sign(SignChangeEvent $event){
		$player = $event->getPlayer();
		$block = $event->getBlock();
		if($event->getLine(0) != "[Elevator]") return;
		if(strtolower($event->getLine(1)) == "up" || strtolower($event->getLine(1)) == "down"){
			$event->setLine(0, TF::GREEN .
				"[Elevator]" . TF::RESET);
			$line = strtolower($event->getLine(1));
			$event->setLine(1, $line);
		}
	}

	/**
	 * @param PlayerInteractEvent $event
	 */
	public function onTap(PlayerInteractEvent $event){
		$player = $event->getPlayer();
		$block = $event->getBlock();
		$loc = new Vector3($block->getX(), $block->getY(), $block->getZ());
		$tile = $player->getLevel()->getTile($loc);
		if($tile instanceof Sign){
			if($player->isSneaking()) return;
			$line = $tile->getText();
			if($line[0] == TF::GREEN . "[Elevator]" . TF::RESET){
				if(strtolower($line[1]) == "up"){
					$this->sendTo($player, strtolower($line[1]), $loc);
				}
				if(strtolower($line[1]) == "down"){
					$this->sendTo($player, strtolower($line[1]), $loc);
				}
			}
		}
	}
	/**
	 * @param Player $player
	 * @param string $dir
	 * @param Vector3 $loc
	 */
	public function sendTo(Player $player, $dir, Vector3 $loc){
		$lvl = $player->getLevel();
		$up = $this->getClosestUp($lvl, $loc, $player);
		$low = $this->getClosestDown($lvl, $loc, $player);

		if($dir == "up"){
			$player->teleport(new Vector3($loc->getX(), $up, $loc->getZ()));
		}
		if($dir == "down"){
			$low--;
			$player->teleport(new Vector3($loc->getX(), $low, $loc->getZ()));
		}
	}

	public function getClosestUp($lvl, Vector3 $loc, Player $player){
		for($i = $loc->getY() + 1 + 1; $i < 128; $i++){
			$block = $lvl->getBlock(new Vector3($loc->getX(), $i, $loc->getZ()));
			if($block instanceof Air){
				return $i;
			}
		}
		return $i;
	}
	public function getClosestDown($lvl, Vector3 $loc, Player $player){
		for($i = $loc->getY() - 1; $i > 0; $i--){
			$block = $lvl->getBlock(new Vector3($loc->getX(), $i, $loc->getZ()));
			if($block instanceof Air){
				return $i;
			}
		}
		return $i;
	}
}