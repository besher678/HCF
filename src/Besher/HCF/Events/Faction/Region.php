<?php

namespace Besher\HCF\Events\Faction;

use Besher\HCF\Main;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\math\Vector3;
use pocketmine\Player;
use pocketmine\utils\TextFormat;
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
		$name = $e->getPlayer()->getName();
		$player = $e->getPlayer();
		$vec = $e->getPlayer()->getPosition();

		if($this->getRegion($name) == "region") {

			if(Main::getFactionsManager()->inSpawnClaim($vec)) {

				$this->setRegion($name, "Spawn");

			}elseif(Main::getFactionsManager()->inClaim($player)) {

				$region = Main::getFactionsManager()->inClaim($vec);

				$this->setRegion($name, $region);

			}else {

				$this->setRegion($name, "Wilderness");

			}

		}

		if($this->getRegion($name) != $this->getCurrentRegion($vec)) {

			if($this->getCurrentRegion($vec) == "Spawn") {

				$player->sendMessage(TF::YELLOW."§r§eNow Leaving§r§7: ".TextFormat::RED.$this->getRegion($name).TextFormat::YELLOW." (".TextFormat::GRAY."Deathban".TextFormat::YELLOW.")");

				$player->sendMessage(TextFormat::YELLOW."§r§eNow Entering§r§7:".TextFormat::RED." Spawn ".TextFormat::YELLOW."(".TextFormat::GREEN."Non-Deathban".TextFormat::YELLOW.")");

			}else {

				if($this->getRegion($name) == "Spawn") {

					$player->sendMessage(TextFormat::YELLOW."§eNow Leaving§7:".TextFormat::GRAY." §cSpawn ".TextFormat::YELLOW."(".TextFormat::GREEN."Non-Deathban".TextFormat::YELLOW.")");

					$player->sendMessage(TextFormat::YELLOW."§eNow Entering§7: ".TextFormat::RED.$this->getCurrentRegion($vec).TextFormat::YELLOW." (".TextFormat::GRAY."Deathban".TextFormat::YELLOW.")");
				}else {
					$player->sendMessage(TextFormat::YELLOW."Now Leaving§7: ".TextFormat::RED.$this->getRegion($name).TextFormat::YELLOW." (".TextFormat::GRAY."Deathban".TextFormat::YELLOW.")");

					$player->sendMessage(TextFormat::YELLOW."Now Entering§7: ".TextFormat::RED.$this->getCurrentRegion($vec).TextFormat::YELLOW." (".TextFormat::GRAY."Deathban".TextFormat::YELLOW.")");

				}

			}

			$this->setRegion($name, $this->getCurrentRegion($vec));

		}
	}

	public function getCurrentRegion(Vector3 $vector3) : string {
		if(Main::getFactionsManager()->inSpawnClaim($vector3)) {
			return "Spawn";
		}elseif(Main::getFactionsManager()->inClaim($vector3)) {
			return Main::getFactionsManager()->inClaim($vector3);
		}else {
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