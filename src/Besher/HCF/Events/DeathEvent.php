<?php


namespace Besher\HCF\Events;


use Besher\HCF\Main;
use pocketmine\block\SnowLayer;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\item\Item;
use pocketmine\network\mcpe\protocol\types\inventory\stackrequest\LabTableCombineStackRequestAction;
use pocketmine\Player;

class DeathEvent implements \pocketmine\event\Listener
{

	private $plugin;

	public function __construct(Main $pg)
	{
		$this->plugin = $pg;
	}

	public function playerDeathEvent(PlayerDeathEvent $e)
	{
		$this->Backup($e->getPlayer(), $e->getDrops());
	}

	public function Backup(Player $player, array $contents)
	{
		$p = Main::getPlayerManager();
		$items = [];
		foreach ($contents as $slot => $item) {
			$items[$slot] = [$item->getId(), $item->getDamage(), $item->getCount()];
		}
		$p->inventory[$player->getName()] = $items;
		var_dump($p->inventory);
	}

}