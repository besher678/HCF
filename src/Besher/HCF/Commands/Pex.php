<?php


namespace Besher\HCF\Commands;


use Besher\HCF\Main;
use pocketmine\command\CommandSender;
use pocketmine\command\utils\CommandException;
use pocketmine\Player;
use pocketmine\utils\TextFormat as TF;

class Pex extends \pocketmine\command\Command
{

	private const PEX = TF::GRAY."[".TF::RED."Pex".TF::GRAY."] ".TF::RESET;

	private $plugin;

	public function __construct(Main $pg)
	{
		$this->plugin = $pg;
		parent::__construct("pex", "Add permissions/group to a player", "/pex help");;
	}

	/**
     * @inheritDoc
     */
    public function execute(CommandSender $sender, string $commandLabel, array $args) :void
    {
    	$pex = Main::getPexManager();
        if(!$sender->isOp() AND !$sender instanceof Player){
        	$sender->sendMessage(TF::RED."No permission");
        	return ;
		}
        if(!isset($args[0])){
        	$sender->sendMessage("/pex help");
        	return;
		}
        if(!isset($args[1])){
			$sender->sendMessage("/pex help");
			return;
		}
        switch ($args[0]){
			case "create":
					if (!isset($args[1])) {
						$sender->sendMessage(TF::RED . "/pex create group (name)");
						return ;
					}
					if (!isset($args[2])) {
						$sender->sendMessage(TF::RED . "/pex create group (name)");
						return ;
					}
					$group = $args[2];
					if($pex->groupExists($group)){
						$sender->sendMessage(TF::RED." That group already exists");
						return;
					}
					$pex->createGroup($group);
					$sender->sendMessage(self::PEX . TF::GREEN . "$group Group created!");
					return;
					break;

			case "add":
				if (!isset($args[1])) {
					$sender->sendMessage(TF::RED . "/pex add perms (group) (perms)");
					return ;
				}
				if (!isset($args[2])) {
					$sender->sendMessage(TF::RED . "/pex add perms (group) (perms)");
					return ;
				}
				if (!isset($args[3])) {
					$sender->sendMessage(TF::RED . "/pex add perms (group) (perms)");
					return ;
				}
				if($args[1] == "perms"){
					$group = $args[2];
					$perms = $args[3];
					if($pex->groupExists($group) == false){
						$sender->sendMessage(self::PEX.TF::RED."That group doesn't exist!");
						return ;
					}
					$pex->addPermissionToGroup($group, $perms);
					$sender->sendMessage(self::PEX.TF::GREEN."Added permission $perms to group");
					$this->plugin->getServer()->getLogger()->alert("{$sender->getName()} Added permission $perms to group $group");
					return ;
				}
				if($args[1] == "player"){
					$player = $this->plugin->getServer()->getPlayer($args[2]);
					if($pex->groupExists($args[3])){
						if($player == null){
							$pex->addPlayerToGroup($args[2], $args[3]);
							$this->plugin->getServer()->getLogger()->alert("{$sender->getName()} Added player $args[2] to group $args[3]");
							return;
						}
						$pName = $player->getName();
						$pex->addPlayerToGroup($pName, $args[3]);
						$this->plugin->getServer()->getLogger()->alert("{$sender->getName()} Added player $pName to group $args[3]");
						return;
					} else{
						$sender->sendMessage(self::PEX.TF::RED." That group doesn't exist");
						return ;
					}
				}
				if($args[1] == "inherit"){
					if($pex->groupExists($args[2])){
						if($pex->groupExists($args[3])){
							$pex->addInheritanceToGroup($args[2], $args[3]);
							$this->plugin->getServer()->getLogger()->alert("{$sender->getName()} $args[2] Now inheriting from group $args[3]");
							$sender->sendMessage("Added Inherent");
							return;
						}
					}
				}
				break;
		}
    }
}