<?php


namespace Besher\HCF\Commands\Player;


use Besher\HCF\Main;
use pocketmine\command\CommandSender;
use pocketmine\command\utils\CommandException;
use pocketmine\math\Vector3;
use pocketmine\Player;

class Spawn extends \pocketmine\command\Command
{

	private $plugin;

	public const SYSTEM = "§8[§cSystem§8] §7";

	public function __construct(Main $pg)
	{
		parent::__construct("spawn", "Teleports you or other player to spawn", "/spawn <player>");
		$this->setPermission("spawn.hcf");
		$this->plugin = $pg;
	}

	/**
     * @inheritDoc
     */
    public function execute(CommandSender $sender, string $commandLabel, array $args) : void
    {
       if(!$sender instanceof Player){
	   	$sender->sendMessage(self::SYSTEM. "Not player");
	   	   return;
	   }
       if(!$this->testPermission($sender)){
		   $sender->sendMessage(self::SYSTEM. "§4No permission");
		   return;
	   }
       if(!isset($args[0])){
			$sender->teleport($this->plugin->getServer()->getDefaultLevel()->getSafeSpawn());
		    $sender->sendMessage(self::SYSTEM. "Teleporting you to spawn...");
		    return;
	   }
       $player = $this->plugin->getServer()->getPlayer($args[0]);
       if($player == null){
		   $sender->sendMessage(self::SYSTEM. "That player doesn't exist");
		   return;
	   }
		$player->teleport($this->plugin->getServer()->getDefaultLevel()->getSafeSpawn());
		$sender->sendMessage(self::SYSTEM. "Teleporting {$player->getName()} to spawn...");
		$player->sendMessage(self::SYSTEM. "You have been teleported to spawn");
		return;
    }
}