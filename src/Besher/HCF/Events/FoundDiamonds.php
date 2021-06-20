<?php

namespace Besher\HCF\Events;

use Besher\HCF\Main;
use pocketmine\block\BlockIds;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\Listener;
use pocketmine\math\Vector3;
use pocketmine\Player;
use pocketmine\utils\TextFormat;

class FoundDiamonds implements Listener{

	private $blocks = [];
	private $plugin;

	public  function __construct(Main $pg)
	{
		$this->plugin = $pg;
	}

	public function onBreak(BlockBreakEvent $event){
		$player = $event->getPlayer();
		$block = $event->getBlock();
		if($player instanceof Player){
			if($block->getId() == BlockIds::DIAMOND_ORE){
				if($event->isCancelled()){
					return;
				}
				if (!isset($this->blocks[$this->vector3AsString($block->asVector3())])) {
					$count = 0;
					for($x = $block->getX() - 4; $x <= $block->getX() +4; $x++){
						for($z = $block->getZ() - 4; $z <= $block->getZ() +4; $z++){
							for($y = $block->getY() - 4; $y <= $block->getY() +4; $y++){
								if ($player->getLevel()->getBlockIdAt($x,$y,$z) == BlockIds::DIAMOND_ORE){
									if (!isset($this->blocks[$this->vector3AsString($block->asVector3())])) {
										++$count;
										$this->blocks[$this->vector3AsString(new Vector3($x, $y, $z))] = true;
									}
								} // besher hello bro
							}
						}
					}
					$server = $this->plugin->getServer();
					$server->broadcastMessage("" . TextFormat::GREEN . TextFormat::BOLD . "»» " . TextFormat::RESET . TextFormat::GRAY . $player->getName() . " Found " . $count . " Diamonds!");
				}
			}
		}
	}
	/**
	 * @param Vector3 $vector3
	 * @return string
	 */
	public function vector3AsString(Vector3 $vector3): string {
		return $vector3->getX() . ":" . $vector3->getY() . ":" . $vector3->getZ();
	}
}