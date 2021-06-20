<?php


namespace Besher\HCF\Commands\StaffCommands;


use Besher\HCF\Main;
use pocketmine\command\CommandSender;
use pocketmine\command\utils\CommandException;
use pocketmine\Player;
use pocketmine\utils\TextFormat as TF;

class Sotw extends \pocketmine\command\Command
{

	private $plugin;

	public $hide = false;

    public function __construct(Main $pg)
	{
		parent::__construct("sotw", "Star or end the start of the world timer", "Usage: /sotw help");
		$this->setPermission("sotw.hcf");
		$this->plugin = $pg;
	}

	public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
    	$s = Main::getPlayerManager();
        if(!$this->testPermission($sender)){
        	$sender->sendMessage(TF::RED."You don't have permission for that command!");
        	return true;
		}
        if(!$sender instanceof Player){
			$sender->sendMessage(TF::RED."Console can't run that command!");
        	return true;
		}
        if(!isset($args[0])){
        	$sender->sendMessage("/sotw help for a list of commands");
        	return true;
		}
        if($args[0] == "start"){
        	if(!isset($args[1])){
        		$sender->sendMessage("Usage: /sotw start <time>");
        		return true;
			}
			$int = (int) filter_var($args[1], FILTER_SANITIZE_NUMBER_INT);
        	$time = $args[1];
        	switch (true){
				case strpos($time, "m") == true:
					$duration = $int * 60 + time();
					$s->startSotw($duration);
					$sender->sendMessage("Start of the world has started");
					$this->plugin->getServer()->broadcastMessage(TF::GRAY."[".TF::GREEN."Sotw".TF::GRAY."] Start of the world has commenced and will end in $time minutes");
					return true;
					break;
				case strpos($time, "h") == true:
					$duration = $int * 60 * 60 + time();
					$s->startSotw($duration);
					$sender->sendMessage("Start of the world has started");
					$this->plugin->getServer()->broadcastMessage(TF::GRAY."[".TF::GREEN."Sotw".TF::GRAY."] Start of the world has commenced and will end in $time Hours");
					return true;
					break;
				default: $sender->sendMessage("Invalid format Hours = h, Minutes = m");
			}
		}
        if($args[0] == "end"){
        	$s->endSotw();
        	$sender->sendMessage("Start of the world timer has ended");
			$this->plugin->getServer()->broadcastMessage(TF::GRAY."[".TF::GREEN."Sotw".TF::GRAY."] Start of the world has ended");
			return true;
		}
    }
}