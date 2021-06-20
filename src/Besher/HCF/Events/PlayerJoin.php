<?php


namespace Besher\HCF\Events;

use Besher\HCF\Main;
use pocketmine\event\entity\EntityMotionEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\event\server\DataPacketReceiveEvent;
use pocketmine\level\particle\FloatingTextParticle;
use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\LoginPacket;
use pocketmine\utils\TextFormat as TF;

class PlayerJoin implements Listener
{

	public $plugin;

	public function __construct(Main $pg)
	{
		$this->plugin = $pg;
	}

	private $playerDevices; // Usage: $playerDevices['Steve']['DeviceNumber'] OR $playerDevices['Alex']['DeviceName']

	private function getDeviceNameByNumber(int $id) {
		static $deviceNames = array(1 => 'Android', 'iOS', 'Mac', 'FireOS', 'GearVR', 'HoloLens', 'Win10', 'Windows', 'Dedicated', 'tvOS', 'PS4', 'Switch', 'Xbox'); // Hope the list is all right
		return $deviceNames[$id] ?? 'unknown';
	}

	public function onJoin(PlayerJoinEvent $e){
		$player = $e->getPlayer();
		$pex = Main::getPexManager();
		$c = Main::getCrateManager();
		$c->loadFloatingText();
		$name = $player->getName();
		$rank = $pex->getPlayerRank($name);
		$p = Main::getPlayerManager();
		$f = Main::getFactionsManager();
		$eco = Main::getEcoManager();
		$e->setJoinMessage(TF::RED."[".$rank."] $name Joined the server");
		if($f->inFaction($player)){
		$faction = $f->getPlayerFaction($player);
		$dtr = $f->getDtr($faction);
			$player->setDisplayName(TF::GOLD."[".TF::RED."$faction".TF::GOLD."] ".TF::RED."$dtr DTR" ."\n".TF::RESET."$name");
		}
		if(!$player->hasPlayedBefore()){
			$p->firstJoin($player);
			$eco->joinMoney($player);
		}
	}

	public function EntityMove(EntityMotionEvent $e){
		$e->setCancelled();
	}

	public function quit(PlayerQuitEvent $e){
	}

	public function dieEvent(PlayerDeathEvent $e){
		$f = Main::getFactionsManager();
		$player = $e->getPlayer();
		$name = $player->getName();
		$p = Main::getPlayerManager();
		$p->deathBan($player);
		if($f->inFaction($player)){
			$faction = $f->getPlayerFaction($player);
			$dtr = $f->getDtr($faction);
			$player->setDisplayName(TF::GOLD."[".TF::RED."$faction".TF::GOLD."] ".TF::RED."$dtr DTR" ."\n".TF::RESET."$name");
		}
	}

	public function DataPacketReceive(DataPacketReceiveEvent $event) {
		$packet = $event->getPacket();
		$p = Main::getPlayerManager();
		if($packet instanceof LoginPacket) {
			$device = $this->getDeviceNameByNumber($packet->clientData['DeviceOS']);
			echo $packet->username;
			$p->setDevice($packet->username, $device);
		}
	}
}