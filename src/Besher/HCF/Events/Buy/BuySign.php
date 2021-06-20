<?php


namespace Besher\HCF\Events\Buy;

use Besher\HCF\Main;
use pocketmine\event\block\SignChangeEvent;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\item\Item;
use pocketmine\math\Vector3;
use pocketmine\tile\Sign;
use pocketmine\utils\TextFormat as TF;

class BuySign implements \pocketmine\event\Listener
{
	public $interactDelay = [];

	public function __construct(Main $pg)
	{
	}

	public function CreateBuySign(SignChangeEvent $e){
		if($e->getLine(0) == "[Buy]") {
			if ($e->getLine(1) == "Melon") {
				$e->setLine(0, TF::GREEN .
					"[Buy]" . TF::RESET);
				$e->setLine(1, TF::BLACK . "Glistering Melon");
				$e->setLine(2, TF::BLACK . "16");
				$e->setLine(3, TF::BLACK . "$500");
			}
			if ($e->getLine(1) == "Nether Wart") {
				$e->setLine(0, TF::GREEN .
					"[Buy]" . TF::RESET);
				$e->setLine(1, TF::BLACK . "Nether Wart");
				$e->setLine(2, TF::BLACK . "16");
				$e->setLine(3, TF::BLACK . "$500");

			}
			if ($e->getLine(1) == "Blaze Rod") {
				$e->setLine(0, TF::GREEN .
					"[Buy]" . TF::RESET);
				$e->setLine(1, TF::BLACK . "Blaze Rod");
				$e->setLine(2, TF::BLACK . "16");
				$e->setLine(3, TF::BLACK . "$500");
			}
			if ($e->getLine(1) == "Exp") {
				$e->setLine(0, TF::GREEN .
					"[Buy]" . TF::RESET);
				$e->setLine(1, TF::BLACK . "Nether Wart");
				$e->setLine(2, TF::BLACK . "64");
				$e->setLine(3, TF::BLACK . "$5000");
			}
			if ($e->getLine(1) == "Melon Seeds") {
				$e->setLine(0, TF::GREEN .
					"[Buy]" . TF::RESET);
				$e->setLine(1, TF::BLACK . "Melon Seeds");
				$e->setLine(2, TF::BLACK . "16");
				$e->setLine(3, TF::BLACK . "$500");

			}
			if ($e->getLine(1) == "Carrot") {
				$e->setLine(0, TF::GREEN .
					"[Buy]" . TF::RESET);
				$e->setLine(1, TF::BLACK . "Carrot");
				$e->setLine(2, TF::BLACK . "16");
				$e->setLine(3, TF::BLACK . "$500");
			}
			if ($e->getLine(1) == "Sugar Cane") {
				$e->setLine(0, TF::GREEN .
					"[Buy]" . TF::RESET);
				$e->setLine(1, TF::BLACK . "Sugar Cane");
				$e->setLine(2, TF::BLACK . "16");
				$e->setLine(3, TF::BLACK . "$500");
			}
			if ($e->getLine(1) == "Potato") {
				$e->setLine(0, TF::GREEN .
					"[Buy]" . TF::RESET);
				$e->setLine(1, TF::BLACK . "Potato");
				$e->setLine(2, TF::BLACK . "16");
				$e->setLine(3, TF::BLACK . "$500");
			}
			if ($e->getLine(1) == "Slime Ball") {
				$e->setLine(0, TF::GREEN .
					"[Buy]" . TF::RESET);
				$e->setLine(1, TF::BLACK . "Slime Ball");
				$e->setLine(2, TF::BLACK . "16");
				$e->setLine(3, TF::BLACK . "$500");
			}
			if ($e->getLine(1) == "Feather") {
				$e->setLine(0, TF::GREEN .
					"[Buy]" . TF::RESET);
				$e->setLine(1, TF::BLACK . "Feather");
				$e->setLine(2, TF::BLACK . "16");
				$e->setLine(3, TF::BLACK . "$500");
			}
			if ($e->getLine(1) == "EndPortalFrame") {
				$e->setLine(0, TF::GREEN .
					"[Buy]" . TF::RESET);
				$e->setLine(1, TF::BLACK . "EndPortalFrame");
				$e->setLine(2, TF::BLACK . "1");
				$e->setLine(3, TF::BLACK . "$5000");
			}
			if ($e->getLine(1) == "Cow Egg") {
				$e->setLine(0, TF::GREEN .
					"[Buy]" . TF::RESET);
				$e->setLine(1, TF::BLACK . "Cow Egg");
				$e->setLine(2, TF::BLACK . "2");
				$e->setLine(3, TF::BLACK . "$1000");
			}
			if ($e->getLine(1) == "Skele Spawner") {
				$e->setLine(0, TF::GREEN .
					"[Buy]" . TF::RESET);
				$e->setLine(1, TF::BLACK . "Skele Spawner");
				$e->setLine(2, TF::BLACK . "1");
				$e->setLine(3, TF::BLACK . "$30000");
			}
			if ($e->getLine(1) == "Zombie Spawner") {
				$e->setLine(0, TF::GREEN .
					"[Buy]" . TF::RESET);
				$e->setLine(1, TF::BLACK . "Zombie Spawner");
				$e->setLine(2, TF::BLACK . "1");
				$e->setLine(3, TF::BLACK . "$30000");

			}
			if ($e->getLine(1) == "Crowbar") {
				$e->setLine(0, TF::GREEN .
					"[Buy]" . TF::RESET);
				$e->setLine(1, TF::BLACK . "Crowbar");
				$e->setLine(2, TF::BLACK . "1");
				$e->setLine(3, TF::BLACK . "$25000");

			}
			if ($e->getLine(1) == "Cave Spawner") {
				$e->setLine(0, TF::GREEN .
					"[Buy]" . TF::RESET);
				$e->setLine(1, TF::BLACK . "Cave Spawner");
				$e->setLine(2, TF::BLACK . "1");
				$e->setLine(3, TF::BLACK . "$30000");
			}
			if ($e->getLine(1) == "Spider Spawner") {
				$e->setLine(0, TF::GREEN .
					"[Buy]" . TF::RESET);
				$e->setLine(1, TF::BLACK . "Spider Spawner");
				$e->setLine(2, TF::BLACK . "1");
				$e->setLine(3, TF::BLACK . "$30000");

			}
			if ($e->getLine(1) == "Ink Sack") {
				$e->setLine(0, TF::GREEN .
					"[Buy]" . TF::RESET);
				$e->setLine(1, TF::BLACK . "Ink Sak");
				$e->setLine(2, TF::BLACK . "16");
				$e->setLine(3, TF::BLACK . "$1000");

			}
			if ($e->getLine(1) == "Beacon") {
				$e->setLine(0, TF::GREEN .
					"[Buy]" . TF::RESET);
				$e->setLine(1, TF::BLACK . "Beacon");
				$e->setLine(2, TF::BLACK . "1");
				$e->setLine(3, TF::BLACK . "$25000");
			}
			if ($e->getLine(1) == "Ghast Tear") {
				$e->setLine(0, TF::GREEN .
					"[Buy]" . TF::RESET);
				$e->setLine(1, TF::BLACK . "Ghast Tear");
				$e->setLine(2, TF::BLACK . "16");
				$e->setLine(3, TF::BLACK . "$1000");
			}
		}
		if($e->getLine(0) == "[Sell]") {
			if ($e->getLine(1) == "Ghast Tear") {
				$e->setLine(0, TF::GREEN .
					"[Buy]" . TF::RESET);
				$e->setLine(1, TF::BLACK . "Ghast Tear");
				$e->setLine(2, TF::BLACK . "16");
				$e->setLine(3, TF::BLACK . "$1000");
			}
		}

	}

	public function onTap(PlayerInteractEvent $event){
		$player = $event->getPlayer();
		$eco = Main::getEcoManager();
		$money = $eco->getMoney($player);
		$block = $event->getBlock();
		$loc = new Vector3($block->getX(), $block->getY(), $block->getZ());
		$tile = $player->getLevel()->getTile($loc);
		if($tile instanceof Sign){
			if($player->isSneaking()) return;
			$line = $tile->getText();
			if(!isset($this->interactDelay[$player->getName()])) {
				$this->interactDelay[$player->getName()] = time() + 1;
				if ($line[0] == TF::GREEN . "[Buy]" . TF::RESET) {
					if ($line[1] == TF::BLACK . "Ghast Tear") {
						$item = Item::get(Item::GHAST_TEAR, 0, 16);
						$inv = $player->getInventory();
						if ($inv->canAddItem($item)) {
							if ($money > 1000) {
								$inv->addItem($item);
								$eco->reduceMoney($player, 1000);
							} else {
								$player->sendMessage(TF::RED . "Insufficent funds ");
							}
						} else {
							$player->sendMessage("No place in the inventory");
						}
					}
					if ($line[1] == TF::BLACK . "Glistering Melon") {
						$item = Item::get(Item::GLISTERING_MELON, 0, 16);
						$inv = $player->getInventory();
						if ($inv->canAddItem($item)) {
							if ($money > 500) {
								$inv->addItem($item);
								$eco->reduceMoney($player, 500);
							} else {
								$player->sendMessage(TF::RED . "Insufficent funds ");
							}
						} else {
							$player->sendMessage("No place in the inventory");
						}
					}
					if ($line[1] == TF::BLACK . "Nether Wart") {
						$item = Item::get(Item::NETHER_WART, 0, 16);
						$inv = $player->getInventory();
						if ($inv->canAddItem($item)) {
							if ($money > 500) {
								$eco->reduceMoney($player, 500);
								$inv->addItem($item);
							} else {
								$player->sendMessage(TF::RED . "Insufficent funds ");
							}
						} else {
							$player->sendMessage("No place in the inventory");
						}
					}
					if ($line[1] == TF::BLACK . "Blaze Rod") {
						$item = Item::get(Item::BLAZE_ROD, 0, 16);
						$inv = $player->getInventory();
						if ($inv->canAddItem($item)) {
							if ($money > 500) {
								$eco->reduceMoney($player, 500);
								$inv->addItem($item);
							} else {
								$player->sendMessage(TF::RED . "Insufficent funds ");
							}
						} else {
							$player->sendMessage("No place in the inventory");
						}
					}
					if ($line[1] == TF::BLACK . "Exp") {
						$item = Item::get(Item::EXPERIENCE_BOTTLE, 0, 64);
						$inv = $player->getInventory();
						if ($inv->canAddItem($item)) {
							if ($money > 5000) {
								$eco->reduceMoney($player, 5000);
								$inv->addItem($item);
							} else {
								$player->sendMessage(TF::RED . "Insufficent funds ");
							}
						} else {
							$player->sendMessage("No place in the inventory");
						}
					}
					if ($line[1] == TF::BLACK . "Melon Seeds") {
						$item = Item::get(Item::MELON_SEEDS, 0, 16);
						$inv = $player->getInventory();
						if ($inv->canAddItem($item)) {
							if ($money > 500) {
								$eco->reduceMoney($player, 500);
								$inv->addItem($item);
							} else {
								$player->sendMessage(TF::RED . "Insufficent funds ");
							}
						} else {
							$player->sendMessage("No place in the inventory");
						}
					}
					if ($line[1] == TF::BLACK . "Carrot") {
						$item = Item::get(Item::CARROT, 0, 16);
						$inv = $player->getInventory();
						if ($inv->canAddItem($item)) {
							if ($money > 500) {
								$eco->reduceMoney($player, 500);
								$inv->addItem($item);
							} else {
								$player->sendMessage(TF::RED . "Insufficent funds ");
							}
						} else {
							$player->sendMessage("No place in the inventory");
						}
					}
					if ($line[1] == TF::BLACK . "Sugar Cane") {
						$item = Item::get(Item::SUGARCANE, 0, 16);
						$inv = $player->getInventory();
						if ($inv->canAddItem($item)) {
							if ($money > 500) {
								$eco->reduceMoney($player, 500);
								$inv->addItem($item);
							} else {
								$player->sendMessage(TF::RED . "Insufficent funds ");
							}
						} else {

							$player->sendMessage("No place in the inventory");
						}
					}
					if ($line[1] == TF::BLACK . "Potato") {
						$item = Item::get(Item::POTATO, 0, 16);
						$inv = $player->getInventory();
						if ($inv->canAddItem($item)) {
							if ($money > 500) {
								$eco->reduceMoney($player, 500);
								$inv->addItem($item);
							} else {
								$player->sendMessage(TF::RED . "Insufficent funds ");
							}
						} else {
							$player->sendMessage("No place in the inventory");
						}
					}
					if ($line[1] == TF::BLACK . "Slime Ball") {
						$item = Item::get(Item::SLIME_BALL, 0, 16);
						$inv = $player->getInventory();
						if ($inv->canAddItem($item)) {
							if ($money > 500) {
								$eco->reduceMoney($player, 500);
								$inv->addItem($item);
							} else {
								$player->sendMessage(TF::RED . "Insufficent funds ");
							}
						} else {
							$player->sendMessage("No place in the inventory");
						}
					}
					if ($line[1] == TF::BLACK . "Feather") {
						$item = Item::get(Item::FEATHER, 0, 16);
						$inv = $player->getInventory();
						if ($inv->canAddItem($item)) {
							if ($money > 500) {
								$eco->reduceMoney($player, 500);
								$inv->addItem($item);
							} else {
								$player->sendMessage(TF::RED . "Insufficent funds ");
							}
						} else {
							$player->sendMessage("No place in the inventory");
						}
					}
					if ($line[1] == TF::BLACK . "EndPortalFrame") {
						$item = Item::get(Item::END_PORTAL_FRAME, 0, 1);
						$inv = $player->getInventory();
						if ($inv->canAddItem($item)) {
							if ($money > 5000) {
								$eco->reduceMoney($player, 5000);
								$inv->addItem($item);
							} else {
								$player->sendMessage(TF::RED . "Insufficent funds ");
							}
						} else {
							$player->sendMessage("No place in the inventory");
						}
					}
					if ($line[1] == TF::BLACK . "Cow Egg") {
						$item = Item::get(Item::SPAWN_EGG, 11, 2);
						$inv = $player->getInventory();
						if ($inv->canAddItem($item)) {
							if ($money > 1000) {
								$eco->reduceMoney($player, 1000);
								$inv->addItem($item);
							} else {
								$player->sendMessage(TF::RED . "Insufficent funds ");
							}
						} else {
							$player->sendMessage("No place in the inventory");
						}
					}
					if ($line[1] == TF::BLACK . "Skele Spawner") {
						$item = Item::get(Item::MOB_SPAWNER, 0, 1);
						$inv = $player->getInventory();
						if ($inv->canAddItem($item)) {
							if ($money > 30000) {
								$eco->reduceMoney($player, 30000);
								$inv->addItem($item);
							} else {
								$player->sendMessage(TF::RED . "Insufficent funds ");
							}
						} else {
							$player->sendMessage("No place in the inventory");
						}
					}
					if ($line[1] == TF::BLACK . "Zombie Spawner") {
						$item = Item::get(Item::MOB_SPAWNER, 0, 1);
						$inv = $player->getInventory();
						if ($inv->canAddItem($item)) {
							if ($money > 30000) {
								$eco->reduceMoney($player, 30000);
								$inv->addItem($item);
							} else {
								$player->sendMessage(TF::RED . "Insufficent funds");
							}
						} else {
							$player->sendMessage("No place in the inventory");
						}
					}
					if ($line[1] == TF::BLACK . "Crowbar") {
						$item = Item::get(Item::DIAMOND_HOE, 0, 1);
						$inv = $player->getInventory();
						if ($inv->canAddItem($item)) {
							if ($money > 25000) {
								$eco->reduceMoney($player, 25000);
								$inv->addItem($item);
							} else {
								$player->sendMessage(TF::RED . "Insufficent funds ");
							}
						} else {
							$player->sendMessage("No place in the inventory");
						}
					}
					if ($line[1] == TF::BLACK . "Cave Spawner") {
						$item = Item::get(Item::MOB_SPAWNER, 0, 1);
						$inv = $player->getInventory();
						if ($inv->canAddItem($item)) {
							if ($money > 30000) {
								$eco->reduceMoney($player, 30000);
								$inv->addItem($item);
							} else {
								$player->sendMessage(TF::RED . "Insufficent funds ");
							}
						} else {
							$player->sendMessage("No place in the inventory");
						}
					}
					if ($line[1] == TF::BLACK . "Spider Spawner") {
						$item = Item::get(Item::MOB_SPAWNER, 0, 1);
						$inv = $player->getInventory();
						if ($inv->canAddItem($item)) {
							if ($money > 30000) {
								$eco->reduceMoney($player, 30000);
								$inv->addItem($item);
							} else {
								$player->sendMessage(TF::RED . "Insufficent funds ");
							}
						} else {
							$player->sendMessage("No place in the inventory");
						}
					}
					if ($line[1] == TF::BLACK . "Ink Sack") {
						$item = Item::get(351, 0, 16);
						$inv = $player->getInventory();
						if ($inv->canAddItem($item)) {
							if ($money > 1000) {
								$eco->reduceMoney($player, 1000);
								$inv->addItem($item);
							} else {
								$player->sendMessage(TF::RED . "Insufficent funds ");
							}
						} else {
							$player->sendMessage("No place in the inventory");
						}
					}
					if ($line[1] == TF::BLACK . "Beacon") {
						$item = Item::get(Item::BEACON, 0, 1);
						$inv = $player->getInventory();
						if ($inv->canAddItem($item)) {
							if ($money > 25000) {
								$eco->reduceMoney($player, 25000);
								$inv->addItem($item);
							} else {
								$player->sendMessage(TF::RED . "Insufficent funds ");
							}
						} else {
							$player->sendMessage("No place in the inventory");
						}
					}
				}
			}else{
				if(time() >= $this->interactDelay[$player->getName()]);
					unset($this->interactDelay[$player->getName()]);
			}
		}
	}

}