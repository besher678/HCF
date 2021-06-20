<?php

declare(strict_types=1);

namespace Besher\HCF\Events\Cheat;

use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\Listener;
use Besher\HCF\Main;
use pocketmine\Player;
use pocketmine\utils\TextFormat as TF;

class ReachCheats implements Listener{

	private $plugin;

	public function __construct(Main $pg)
	{
		$this->plugin = $pg;
	}

	public function reachHacks(EntityDamageEvent $e){
		$entity = $e->getEntity();
		if($e->getCause() == EntityDamageEvent::CAUSE_PROJECTILE) return;
		if($e instanceof EntityDamageByEntityEvent and $entity instanceof Player){
			$damager = $e->getDamager();
			if($damager instanceof Player){
				$reach = $entity->distance($damager);
				$max = 4;
				if($reach > $max) {
					$this->plugin->getServer()->getLogger()->alert(TF::GRAY . "[" . TF::YELLOW . "!" . TF::GRAY . "]" . TF::BOLD . TF::DARK_RED . " ALERT: " . TF::RESET . TF::GRAY . $damager->getName() . " got " . floor($reach) . "block reach!");
					foreach(Main::getInstance()->getServer()->getOnlinePlayers() as $player){
						if($player->hasPermission("alerts.hardcore")){
							$player->sendMessage(TF::GRAY . "[" . TF::YELLOW . "!" . TF::GRAY . "]" . TF::BOLD . TF::DARK_RED . " ALERT: " . TF::RESET . TF::GRAY . $damager->getName() . " got " . floor($reach) . " block reach!");
						}
					}
				}
			}
		}
	}
}