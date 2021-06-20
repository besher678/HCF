<?php

namespace Besher\HCF\Events\Items;

use Besher\HCF\Main;
use pocketmine\entity\projectile\Snowball;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\entity\ProjectileHitEntityEvent;
use pocketmine\Player;

class SwitcherSnowBall implements \pocketmine\event\Listener
{
	public $plugin;

	public function __construct(Main $pg)
	{
		$this->plugin = $pg;
	}

	public function throwSnowBall(EntityDamageEvent $e){
		if($e instanceof EntityDamageByEntityEvent === false) return;
		if($e->getCause() === EntityDamageEvent::CAUSE_PROJECTILE){
			$projectile = $e->getDamager();
			$player = $e->getEntity();
			$damager = $e->getDamager();
			if($player instanceof Player AND $projectile instanceof Player){
				if($projectile instanceof Snowball){
					$pos = $player->getPosition();
					$damager->teleport($pos);
					$pos = $damager->getPosition();
					$player->teleport($pos);
			}
			}
		}
	}

}