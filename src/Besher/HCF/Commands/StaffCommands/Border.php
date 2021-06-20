<?php


namespace Besher\HCF\Commands\StaffCommands;


use Besher\HCF\Main;
use pocketmine\command\CommandSender;
use pocketmine\command\utils\CommandException;
use pocketmine\utils\TextFormat as TF;

class Border extends \pocketmine\command\Command
{

	public const HCF = TF::GRAY."[".TF::RED."HCF".TF::GRAY."] ".TF::RESET;

	public function __construct(Main $pg)
	{
		parent::__construct("setborder", "Set world border", "/setborder <int>");
		$this->setPermission("border.hcf");
	}

	/**
     * @inheritDoc
     */
    public function execute(CommandSender $sender, string $commandLabel, array $args) : void
    {
		$s = Main::getServerManager();
        if(!$this->testPermission($sender)){
        	$sender->sendMessage(self::HCF.TF::RED."No permission");
        	return;
		}
        if(!isset($args[0])){
        	$sender->sendMessage(self::HCF.$this->usageMessage);
        	return;
		}
        $border = $args[0];
        $s->setBorder($border);
        $sender->sendMessage(self::HCF.TF::GREEN."Border size has been set to $border");
        return;
    }
}