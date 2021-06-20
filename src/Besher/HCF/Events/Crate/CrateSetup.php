<?php


namespace Besher\HCF\Events\Crate;


use Besher\HCF\Main;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\utils\Config;

class CrateSetup implements \pocketmine\event\Listener
{

	private $plugin;
	private $crate;

	public function __construct(Main $pg)
	{
		$this->plugin = $pg;
	}

	public function crateSetup(PlayerChatEvent $e) : void
	{
		$c = Main::getCrateManager();
		$name = $e->getPlayer()->getName();
		if(array_key_exists($e->getPlayer()->getName(), $this->plugin->crateSetup)){
			if(in_array($e->getPlayer()->getName(), $this->plugin->display)){
				$display = $e->getMessage();
				$cratename = $this->plugin->crateSetup[$e->getPlayer()->getName()];
				$c->addDisplay($cratename, $display);
				$e->setCancelled();
				$e->getPlayer()->sendMessage("DONE!!!");
				unset($this->plugin->display[$name]);
				$this->plugin->hologram[$name] = $cratename;
				return;
			}
			if(array_key_exists($e->getPlayer()->getName(), $this->plugin->hologram)){
				$hologram = $e->getMessage();
				$cratename = $this->plugin->crateSetup[$e->getPlayer()->getName()];
				$c->addHologram($cratename, $hologram);
				$e->setCancelled();
				$e->getPlayer()->sendMessage("DONE!!!");
				unset($this->plugin->hologram[$name]);
				$this->plugin->breakCrate[$e->getPlayer()->getName()] = $cratename;
				return;
			}
		}
	}

	public function breakCrate(BlockBreakEvent $e)
	{
		$c = Main::getCrateManager();
		if(array_key_exists($e->getPlayer()->getName(), $this->plugin->breakCrate))
		{
			$cratename = $this->plugin->breakCrate[$e->getPlayer()->getName()];
			$e->setCancelled();
			$x = $e->getBlock()->getFloorX();
			$y = $e->getBlock()->getFloorY();
			$z = $e->getBlock()->getFloorZ();
			$c->addX($cratename, $x);
			$c->addY($cratename, $y);
			$c->addZ($cratename, $z);
			unset($this->plugin->breakCrate[$e->getPlayer()->getName()]);
			$e->getPlayer()->sendMessage("block set at X:$x\nY: $y\nZ:$z");
		}
	}
}