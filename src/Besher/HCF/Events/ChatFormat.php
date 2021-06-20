<?php

namespace Besher\HCF\Events;

use Besher\HCF\Main;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\event\player\PlayerCommandPreprocessEvent;
use pocketmine\Player;
use pocketmine\utils\TextFormat as TF;

class ChatFormat implements Listener{


	public function __construct(Main $pg)
	{
	}

	public function onChat(PlayerChatEvent $e){
		$f = Main::getFactionsManager();
		$player = $e->getPlayer();
		if($f->inFaction($player) == true){
			$faction = $f->getPlayerFaction($player);
			$e->setFormat(TF::GOLD."[".TF::RED."$faction".TF::GOLD."] ".TF::WHITE."{$player->getName()}".TF::GRAY.": {$e->getMessage()}");
		}
		$e->setFormat(TF::GOLD."[".TF::RED."*".TF::GOLD."] ".TF::RESET.TF::WHITE."{$player->getName()}".TF::GRAY.": {$e->getMessage()}");
	}
}