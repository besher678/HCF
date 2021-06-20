<?php


namespace Besher\HCF\Events\Cheat;


use Besher\HCF\Main;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerMoveEvent;

class FlyCheats implements Listener
{

	private $plugin;

	public function __construct(Main $pg)
	{
		$this->plugin = $pg;
	}

	public function onMoveEvent(PlayerMoveEvent $e)
	{
		if($e->getPlayer()->getAllowFlight() != true)
		{
			if($e->getPlayer()->isFlying())
			{
				$distanceX = $e->getFrom()->getX() - $e->getTo()->getX();
				$distanceY = $e->getFrom()->getY() - $e->getTo()->getY();
				$distanceZ = $e->getFrom()->getZ() - $e->getTo()->getZ();

				if($distanceX < 0){
					$distanceX = abs($distanceX);
				}

				if($distanceY < 0){
					$distanceY = abs($distanceY);
				}

				if($distanceZ < 0){
					$distanceZ = abs($distanceZ);
				}

				if($e->getPlayer()->isSprinting())
				{
					if($distanceX > 1.3 || $distanceY > 1.3 || $distanceZ > 1.3){
						$this->plugin->getServer()->broadcastMessage("{$e->getPlayer()->getName()} is hacking");
						$e->setCancelled();
					}

				} else {
					if($distanceX > 0.6 || $distanceY > 0.6 || $distanceZ > 0.6){
						$this->plugin->getServer()->broadcastMessage("{$e->getPlayer()->getName()} is hacking");
						$e->setCancelled();
					}
				}
			}
		}
	}

}