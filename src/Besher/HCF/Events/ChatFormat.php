<?php

namespace Besher\HCF\Events;

use Besher\HCF\Main;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\event\player\PlayerCommandPreprocessEvent;
use pocketmine\network\mcpe\protocol\TransferPacket;
use pocketmine\Player;
use pocketmine\utils\TextFormat as TF;

class ChatFormat implements Listener{

	private $plugin;

	public function __construct(Main $pg)
	{
		$this->plugin = $pg;
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

	public function inFactionChat(PlayerChatEvent $e)
	{
		$player = $e->getPlayer();
		$name = $player->getName();
		if(in_array($name, $this->plugin->factionChat))
		{
			$e->setCancelled();
			$e->setFormat(TF::GREEN."Faction Chat".TF::GRAY.">>".TF::WHITE."{$e->getMessage()}");
			$f = Main::getFactionsManager();
			$faction = $f->getPlayerFaction($player);
			$members = $f->getFactionMemebers($faction);
			if($members == null)
			{
			return;
			} else
			foreach ($members as $players){
				if($players == true){
					$players = $this->plugin->getServer()->getPlayer($players);
					$players->sendMessage(TF::GREEN."Faction ".TF::GRAY. $name.": ".TF::WHITE."{$e->getMessage()}");;
				}
			}
		}
	}
}