<?php

namespace AmitxD\Feedback;

use pocketmine\plugin\PluginBase;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\Listener;
use pocketmine\player\Player;
use pocketmine\utils\Config;
use bbo51dog\pmdiscord\connection\Webhook;
use bbo51dog\pmdiscord\element\Content;

class Main extends PluginBase implements Listener {

    public function onEnable() : void{
        $this->getLogger()->info("Feedback is enabled");
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->saveResource("config.yml");
          $this->config = new Config($this->getDataFolder() . "config.yml");
	  $this->saveDefaultConfig();
    }

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args) : bool {
        switch($command->getName()){
            case "feedback":
                if(!isset($args[0])){
                    $sender->sendMessage("Please provide feedback");
                    return true;
                }
                $feedback = implode(" ", $args);
                $sender->sendMessage("Thank you for your feedback!");
                $webhook_url = $this->config->get("Webhook_url");
                $webhook = Webhook::create($webhook_url);
                
$content = new Content();
$content->setText($feedback);
$webhook->add($content);
$webhook->send();
                return true;
            default:
                return false;
        }
    }
}
