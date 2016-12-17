<?php

/**
	* All rights reserved InspectorGadget
	* This Repository is protected under GNU license, copying may lead to Copyrights issue!
	* @link https://GitHub.com/RTGNetworkkk
	* @link https://rtgnetwork.tk
	* @author InspectorGadget | RTGTeam
	*
*/

namespace SFC\SuperShop;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\Server;
use pocketmine\Player;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\entity\Effect;
use pocketmine\item\Item;
use pocketmine\level\Position;
use pocketmine\level\Level;
use pocketmine\utils\TextFormat as TF;

class Main extends PluginBase implements Listener {

	public function onEnable() {
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		if($this->getServer()->getPluginManager()->getPlugin("EconomyAPI") === null) {
			$this->getLogger()->warning(" Unable to find EconomyAPI, disabling SuperShop!");
			$this->setEnabled(false);
		}
	}
	
	public function onCommand(CommandSender $sender, Command $cmd, $label, array $args) {
		switch(strtolower($cmd->getName())) {
			
			case "shop":
				if(isset($args[0])) {
					switch(strtolower($args[0])) {
					
						case "buy":
							if(isset($args[1])) {
								switch(strtolower($args[1])) {
									
									case "beginer":
										
										$p = $this->getServer()->getPlayer($sender->getName());
										
										$item = Item::get(276, 0, 1);
										
										$name = $item->setCustomName("Beginer's Sword \n§bHaste I");
										
										$money = $this->getServer()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender);
										
											if($money < 2500) {
												$sender->sendMessage(TF::RED . "[SuperShop] Insufficient Money!");
											}
											else {
												$this->getServer()->getPluginManager()->getPlugin("EconomyAPI")->reduceMoney($sender->getName(), 2500);
												$sender->getInventory()->addItem($item);
												$item->setCustomName($name);
												$sender->sendMessage(TF::GREEN . "You have bought the Beginer's Sword! Start fighting warior!");
											}
										return true;
									break;
								}
							}
							return true;
						break;
						
						case "help":
						
							$sender->sendMessage(" -- SuperShop V 1.0.0 Beta -- ");
							$sender->sendMessage(TF::RED . "/shop -" . TF::YELLOW . " to check the item list!");
						
							return true;
						break;
					}
				}
				else {
					$sender->sendMessage(TF::GREEN . " -- SuperShop Shopping list V 1.0.0 --");
					$sender->sendMessage(" Usage: /shop buy <itemname>");
					$sender->sendMessage(TF::RED . "- Item List -");
					$sender->sendMessage(" - beginer costs §b2500");
				}
				return true;
			break;
		}
	}
	
	public function onDamage(EntityDamageEvent $e) {
	
		if($e instanceof EntityDamageByEntityEvent) {
			$damager = $e->getDamager();
			$hitget = $e->getEntity();
			$hand = $damager->getInventory()->getItemInHand();
			
			$x = $hitget->getX();
			$y = $hitget->getY();
			$z = $hitget->getZ();
			
			$level = $damager->getLevel();
			
			if($hand->getId() === 276 && $hand->getCustomName() === "Beginer's Sword \n§bHaste I") {
			
						$effect = Effect::getEffect(3);
						$effect->setDuration(100);
						$effect->setAmplifier(5);
						
						$hitget->addEffect($effect);
						
						$damager->sendMessge("You have effected your opponent and guess what he/she is effected with Haste!");
						
						$hitget->sendMessage("Oh no! Oops..");
						$hitget->setHealth(15);
				
			}
		}
	}
	
	public function onDisable() {
	}
}
