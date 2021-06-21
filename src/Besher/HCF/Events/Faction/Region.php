<?php

namespace Besher\HCF\Events\Faction;

use Besher\HCF\Main;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\math\Vector3;
use pocketmine\Player;
use pocketmine\utils\TextFormat as TF;

class Region implements \pocketmine\event\Listener
{

	public $region = [];

	public $plugin;

	public function __construct(Main $pg)
	{
		$this->plugin = $pg;
	}

	public function enterRegion(PlayerMoveEvent $e) : void
	{
		$f = Main::getFactionsManager();
		$name = $e->getPlayer()->getName();
		$player = $e->getPlayer();
		$vec = $e->getPlayer()->getPosition();
		if($this->getRegion($name) == "null"){
			if($f->inSpawnClaim($vec,)){
				$this->setRegion($name,"Spawn");
			} elseif($f->inClaim($vec)){
				$this->setRegion($name, $f->inClaim($vec));
			} if($f->inClaim($vec) == null) {
				$this->setRegion($name, "Wilderness");
			}
		}
		if($this->getRegion($name) != $this->getCurrentRegion($vec)){
			if($this->getCurrentRegion($vec) == "Spawn"){
				$player->sendMessage("§cNow Leaving §7" . $this->getRegion($name) . " §7(§cDeathban§7) \n§aNow Entering §7Spawn (§aNon-Deathban§7)");
			} else {
				if($this->getRegion($name) == "Spawn"){
					$player->sendMessage("§cNow Leaving §7Spawn (§aNon-Deathban§7) \n§cNow Entering §7" . $this->getCurrentRegion($vec) . " §7(§cDeathban§7)");
				} else {
					$player->sendMessage("§cNow Leaving §7" . $this->getRegion($name) . " §7(§cDeathban§7) \n§cNow Entering §7" . $this->getCurrentRegion($vec) . " §7(§cDeathban§7)");
				}
			}
			$player->sendMessage("§cNow Leaving §7" . $this->getRegion($name) . " §7(§cDeathban§7) \n§cNow Entering §7" . $this->getCurrentRegion($vec) . " §7(§cDeathban§7)");
			$region = $this->getCurrentRegion($vec);
			$this->setRegion($name, $region);
		}
	}

	public function getCurrentRegion(Vector3 $vector3): string
	{
		$f = Main::getFactionsManager();
		if ($f->inSpawnClaim($vector3)) {
			return "Spawn";
		}elseif ($f->inClaim($vector3)) {
			return $f->inClaim($vector3);
		} if($f->inClaim($vector3) == null){
			return "Wilderness";
		}
	}

	public function getRegion(string $name)
	{
		return $this->region[$name] ?? null;
	}

	/**
	 * @param string $region
	 */
	public function setRegion(string $name, string $region)
	{
		$this->region[$name] = $region;
	}
}