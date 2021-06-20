<?php


namespace Besher\HCF\Events\Crate;


use _HumbugBox61bfe547a037\Nette\Neon\Exception;
use Besher\HCF\Main;
use muqsit\invmenu\InvMenu;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\item\enchantment\Enchantment;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\item\Item;
use pocketmine\network\mcpe\protocol\types\Enchant;
use pocketmine\Player;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat as TF;

class CrateEvents implements \pocketmine\event\Listener
{

	public $items = [
	];
	private $plugin;

	public function __construct(Main $pg)
	{
		$this->plugin = $pg;
	}

	public function onBreakCrate(BlockBreakEvent $e)
	{
		$c = Main::getCrateManager();
		foreach ($c->getCrates() as $crate) {
			$pos = $c->getLocation($crate);
			$x = $e->getBlock()->getX();
			$y = $e->getBlock()->getY();
			$z = $e->getBlock()->getZ();
			if ($z == $pos["{$crate}z"] and $x == $pos["{$crate}x"] and $y == $pos["{$crate}y"]) {
				$e->setCancelled();
				$this->viewRewards($e->getPlayer(), $crate);
			}
		}
	}

	public function onInteract(PlayerInteractEvent $e): void
	{
		$c = Main::getCrateManager();
		if ($e->getAction() == PlayerInteractEvent::LEFT_CLICK_BLOCK) {
			foreach ($c->getCrates() as $crate) {
				$pos = $c->getLocation($crate);
				$x = $e->getBlock()->getX();
				$y = $e->getBlock()->getY();
				$z = $e->getBlock()->getZ();
				if ($z == $pos["{$crate}z"] and $x == $pos["{$crate}x"] and $y == $pos["{$crate}y"]) {
					$this->viewRewards($e->getPlayer(), $crate);
					$e->setCancelled();
				}
			}
		}
		if ($e->getAction() == PlayerInteractEvent::RIGHT_CLICK_BLOCK) {
			foreach ($c->getCrates() as $crate) {
				$pos = $c->getLocation($crate);
				$x = $e->getBlock()->getX();
				$y = $e->getBlock()->getY();
				$z = $e->getBlock()->getZ();
				if ($z == $pos["{$crate}z"] and $x == $pos["{$crate}x"] and $y == $pos["{$crate}y"]) {
					$display = $c->getDisplay($crate);
					$e->setCancelled();
					$itemName = str_replace("Crate", "Key", $display);
					if ($e->getItem()->getId() == 131 and $e->getItem()->getCustomName() == TF::RESET . $itemName) {
						$this->scrollRewards($e->getPlayer(), $crate);
						return;
					} else {
						$e->getPlayer()->sendMessage("You don't have a key!");
						return;
					}
				}
			}
		}
	}

	public function viewRewards(Player $player, string $crate)
	{
		$c = Main::getCrateManager();
		$display = $c->getDisplay($crate);
		$menu = InvMenu::create(InvMenu::TYPE_CHEST);
		$menu->readOnly();
		$menu->setName("$display");
		$menu->send($player);
		$inv = $menu->getInventory();
		$array = $this->getRewards($crate);
		$slot = 0;
		foreach ($array['rewards'] as $rewards) {
			$rewards = explode(":", $rewards);
			$id = (int)$rewards[0]; $meta = (int)$rewards[1];
			$amount = (int)$rewards[2]; $name = $rewards[3];if ($name == null) $name = Item::get($id)->getName();
			$chance = $rewards[12] ?? null;if ($chance == 0) $chance = "?";
			$e1 = (int)$rewards[5]; $el1 = (int)$rewards[5]; $e2 = (int)$rewards[5]; $el2 = (int)$rewards[5];
			$e3 = (int)$rewards[5]; $el3 = (int)$rewards[5]; $e4 = (int)$rewards[5]; $el4 = (int)$rewards[5];
			$enc = Enchantment::getEnchantment($e1);
			$ench = new EnchantmentInstance($enc, $el1);
			$item = Item::get($id, $meta, $amount)->setCustomName(TF::RESET . "$name")->setLore([TF::DARK_PURPLE . "$chance%"]);
			$item->addEnchantment($ench);
			$inv->addItem($item);
			$this->items[$id] = $chance;
		}
	}


	public function getRewards(string $crate)
	{
		$this->config = new Config($this->plugin->getDataFolder() . "crate/" . "items.yml", Config::YAML);
		$array = $this->config->get("$crate");
		return $array;
	}

	public function scrollRewards(Player $player, string $crate)
	{
		$lol = [];
		$array = $this->getRewards($crate);
		foreach ($array['rewards'] as $rewards) {
			$rewards = explode(":", $rewards);
			if($rewards[3] == ""){
				$name = Item::get($rewards[0])->getVanillaName();
				$lol["$rewards[0]:$rewards[1]:$rewards[2]:$name"] = $rewards[4];
			} else{
				$lol["$rewards[0]:$rewards[1]:$rewards[2]:$rewards[3]"] = $rewards[4];
			}
		}
		$totalProbability = 0;
		$i = 0;
		foreach ($lol as $item => $probability) {
			$totalProbability += $probability;
		}
		$stopAt = rand(0, $totalProbability);
		$currentProbability = 0;

		foreach ($lol as $item => $probability) {
			$currentProbability += $probability;
			$item = explode(":", $item);
			if ($currentProbability >= $stopAt) {
				$id = (int)$item[0]; $meta = (int)$item[1]; $amount = (int)$item[2]; $name = $item[3];
				$player->getInventory()->addItem(Item::get($id, $meta, $amount)->setCustomName(TF::RESET.$name));
				return true;
			}
		}
	}
}