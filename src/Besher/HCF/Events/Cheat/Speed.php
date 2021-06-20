<?php


namespace Besher\HCF\Events\Cheat;


use Besher\HCF\Main;
use http\Client\Curl\User;
use pocketmine\entity\Effect;
use pocketmine\event\Event;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\event\server\DataPacketReceiveEvent;
use pocketmine\network\mcpe\protocol\DataPacket;
use pocketmine\network\mcpe\protocol\InventoryTransactionPacket;
use pocketmine\network\mcpe\protocol\LevelSoundEventPacket;
use pocketmine\network\mcpe\protocol\PlayerAuthInputPacket;
use pocketmine\network\mcpe\protocol\types\inventory\UseItemOnEntityTransactionData;
use pocketmine\Player;
use pocketmine\utils\TextFormat as TF;
use raklib\protocol\Packet;

class Speed implements \pocketmine\event\Listener
{
	private $vl;
	private $plugin;

	private $groundY = 1 / 64.;

	public function __construct(Main $pg)
	{
		$this->plugin = $pg;
	}

	public function NoFall(PlayerMoveEvent $e)
	{
		
	}




	public function flagCheats(Player $player)
	{
		$this->vl[$player->getName()]++;
		$this->plugin->getServer()->getLogger()->alert(TF::GRAY . "(" . TF::YELLOW .TF::BOLD. "!". TF::RESET. TF::GRAY . ")" . TF::BOLD . TF::DARK_RED . " ALERT: " . TF::RESET . TF::GRAY . $player->getName(). " might be bhopping vl({$this->vl[$player->getName()]})");
		foreach ($this->plugin->getServer()->getOnlinePlayers() as $players){
			if($players->hasPermission("alerts.hcf")){
				$players->sendMessage(TF::GRAY . "(" . TF::YELLOW .TF::BOLD. "!". TF::RESET. TF::GRAY . ")" . TF::BOLD . TF::DARK_RED . " ALERT: " . TF::RESET . TF::GRAY . $player->getName(). " might be bhopping vl({$this->vl[$player->getName()]})");
			}
		}
	}

}