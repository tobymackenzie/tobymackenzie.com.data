---
categories: [www]
date: 2015-11-19T02:18:08-05:00
date_gmt: 2015-11-19T07:18:08+00:00
guid: 'https://tobymackenzie.wordpress.com/?p=732'
id: 732
modified: 2017-11-25T03:09:00-05:00
modified_gmt: 2017-11-25T08:09:00+00:00
name: testing-the-monty-hall-problem
tags: [code, problem, statistics, test]
---

Testing the Monty Hall problem
==============================

I have always had trouble understanding and even believing the proposition of the [Monty Hall problem](https://en.wikipedia.org/wiki/Monty_Hall_problem).  It feels like it is proposing that the probability of past events affect the probability of future events, like suggesting that a coin landing on heads will be more likely to land on tails the next time.  Rather, it's about the information provided by the circumstances.  I still don't intuitively understand it, but at least I have now verified for myself that the proposed probability approximates outcomes.  I have created a [PHP simulation of the game](https://github.com/tobymackenzie/php-problem-tests/blob/master/src/MontyHallGame.php) and [script to iterate it numerous times](https://github.com/tobymackenzie/php-problem-tests/blob/master/bin/montyHallGame).

The code allows testing other numbers of doors and number of doors for the host to reveal.  Increasing the numbers shows increasing odds.  Even if Monty opens less than all but the remaining door (obviously requires more than three total doors), it still increases odds by switching.

<!--more-->

The Wikipedia articles on the related [Bertrand's box paradox](https://en.wikipedia.org/wiki/Bertrand's_box_paradox) and [Boy or Girl paradox](https://en.wikipedia.org/wiki/Boy_or_Girl_paradox) are helping me to understand better.  It is important to note that the Monty Hall proposition requires some assumptions to be true:

- The doors must be set up where it is known that one has the good prize and the rest of the doors have bad or less desirable prizes.  Not knowing the prize configuration changes things.
- The contestant must pick one (or perhaps a set number) of the doors at random.
- Monty Hall must always open his set number of doors (one in the presented problem).  If there is the possibility he won't open a door, the meaningful calculation of probability is essentially lost, or perhaps only calculatable by looking at previous shows.  This is because we don't know how the choice to reveal or not reveal is being made.  He might be more likely to reveal when he knows you have chosen the right door.
- <s>Monty Hall must only be able to reveal the non-prize door(s).  If his choice is random, then it doesn't increase the knowledge available, and the probability would go back to 50/50 in the presented problem.</s>  I thought Monty choosing a non-prize randomly would even the odds based on what some have said in discussion of the problem, but it is wrong, and I think figuring this out has helped me understand the original problem better.

The object oriented representation of the game looks like:

``` php
<?php
class MontyHallGame{
	protected $doorCount = 3;
	protected $hostDoorCount = 1;
	protected $carDoor;
	protected $playerDoor;
	protected $newPlayerDoor;
	protected $hostDoors = Array();

	protected $switchedFromCar;
	protected $switchedToCar;
	public function __construct($opts = Array()){
		//--opts
		if(isset($opts['doorCount'])){
			$this->doorCount = $opts['doorCount'];
		}
		if(isset($opts['hostDoorCount'])){
			$this->hostDoorCount = $opts['hostDoorCount'];
		}
		if($this->hostDoorCount > $this->doorCount){
			throw new Exception("Can't have more host doors than total doors.");
		}elseif($this->hostDoorCount > $this->doorCount - 2){
			throw new Exception("Not enough doors for the host to open his count and still have enough to switch.");
		}

		//--game
		//---put car behind door
		$this->carDoor = mt_rand(1,$this->doorCount);
		//---player selects door
		$this->playerDoor = mt_rand(1,$this->doorCount);
		//---host selects door(s)
		$hostAvailableDoors = ($this->carDoor === $this->playerDoor) ? $this->doorCount - 1 : $this->doorCount - 2;
		for($i = 0; $i < $this->hostDoorCount; ++$i){
			$this->hostDoors[$i] = mt_rand(1, $hostAvailableDoors);
			while($this->hostDoors[$i] === $this->playerDoor || $this->hostDoors[$i] === $this->carDoor){
				++$this->hostDoors[$i];
			}
			--$hostAvailableDoors;
		}
		//---determine if player switch would move away from car
		$this->switchedFromCar = ($this->carDoor === $this->playerDoor);
		//---determine if player switch would move to car
		$remainingDoors = $this->doorCount - 1 - $this->hostDoorCount;
		$this->newPlayerDoor = mt_rand(1, $remainingDoors);
		while($this->newPlayerDoor === $this->playerDoor || in_array($this->newPlayerDoor, $this->hostDoors)){
			++$this->newPlayerDoor;
		}
		$this->switchedToCar = ($this->newPlayerDoor === $this->carDoor);
	}
	public function getCarDoor(){
		return $this->carDoor;
	}
	public function getSwitchedFromCar(){
		return $this->switchedFromCar;
	}
	public function getSwitchedToCar(){
		return $this->switchedToCar;
	}
}
```

A simple script to iterate 100000 simulations of the game and tally the results: 

``` php
#!/usr/bin/env php
<?php
require_once(__DIR__ . '/MontyHallGame.php');
$doorCount = (isset($argv[1]) ? $argv[1] : 3);
$hostDoorCount = (isset($argv[2]) ? $argv[2] : 1);

$iterationCount = 100000;
$iterations = 0;
$switchedFromIterations = 0;
$switchedToIterations = 0;

for($i = 1; $i <= $iterationCount; ++$i){
	$game = new MontyHallGame(Array(
		'doorCount'=> $doorCount
		,'hostDoorCount'=> $hostDoorCount
	));
	++$iterations;
	if($game->getSwitchedFromCar()){
		++$switchedFromIterations;
	}
	if($game->getSwitchedToCar()){
		++$switchedToIterations;
	}
}

echo "Switch would be from the car " . ($switchedFromIterations / $iterations * 100) . '% of the time and to the car ' . ($switchedToIterations / $iterations * 100) . '% of the time.';
```
