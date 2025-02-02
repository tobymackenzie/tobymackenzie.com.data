---
categories: [www]
date: 2020-08-18T01:26:00-04:00
guid: 'https://www.tobymackenzie.com/blog/?p=2996'
id: 2996
modified: 2020-08-18T01:26:00-04:00
name: automatic-reconnect-pdo-connection-time-out
tags: [database, mysql, pdo, php, solution]
---

Automatically reconnect PDO when connection times out
=====================================================

In PHP scripts that run queries to a MySQL database over a long period of time, the connection may time out and give a "MySQL server has gone away" error.<!--more-->  Using PDO, we can catch this "2006" error and reconnect, then continue.  In the past, I've implemented this logic in the individual scripts whenever the problem occurred.  Recently, I decided to make a more general solution with a database service wrapping PDO and automatically doing the reconnection for me.

The basic logic is:

1. Our class creates a PDO instance with the `PDO::ATTR_ERRMODE` option set to `PDO::ERRMODE_EXCEPTION` so we can catch the error
2. We run queries through a function on the class
3. That function will execute the query in a try/catch block
4. If we get into the catch block and the error is a particular type, we will try to reconnect by creating a new PDO instance, also in a try/catch block
5. If the connection succeeds, we will rerun the query and return the result, so the calling code doesn't even know anything happened

If reconnection fails, we will try again in case the server is restarting or hung up or whatever.  I set it up to retry for about 40 seconds.  After 40 seconds, it will simply rethrow the original error, halting the script just like it would have without the reconnection logic.

The error list I've used is MySQL specific, and ones that I came across in testing.  PDO has its own errors, but I don't think they can really be used for this.  The "gone away" error code is "HY000", which is somewhat generic and can mean other things.

A simple example implementation of this setup:

``` php
class DB{
	protected $connection;
	protected $password;
	protected $dsn;
	protected $maxReconnectTries = 100;
	protected $reconnectErrors = [
		1317 // interrupted
		,2002 // refused
		,2006 // gone away
	];
	protected $reconnectTries = 0;
	protected $reconnectDelay = 400; // in ms
	protected $user;
	protected $options = Array(
		PDO::ATTR_ERRMODE=> PDO::ERRMODE_EXCEPTION
	);
	public function __construct($dsn, $user = null, $password = null, $options = null){
		$this->dsn = $dsn;
		$this->user = $user;
		$this->password = $password;
		if($options){
			$this->options = $options;
		}
	}
	public function getConnection(){
		if(!$this->connection){
			$this->connection = new PDO($this->dsn, $this->user, $this->password, $this->options);
		}
		return $this->connection;
	}
	public function query($query, $params = Array()){
		$conn = $this->getConnection();
		if(is_string($query) && $params){
			$query = $conn->prepare($query);
		}
		try{
			if(is_string($query)){
				return $conn->query($query);
			}else{
				$query->execute($params);
				return $query;
			}
		}catch(Exception $e){
			if(isset($e->errorInfo) && in_array($e->errorInfo[1], $this->reconnectErrors)){
				try{
					$this->reconnect();
				}catch(Exception $e2){}
				return $this->query($query->queryString, $params);
			}
			throw $e;
		}
	}
	public function reconnect(){
		$connected = false;
		while(!$connected && $this->reconnectTries < $this->maxReconnectTries){
			usleep($this->reconnectDelay * 1000);
			++$this->reconnectTries;
			$this->connection = null;
			try{
				if($this->getConnection()){
					$connected = true;
				}
			}catch(Exception $e){}
		}
		if(!$connected){
			throw $e;
		}
	}
}
```

To test this, I created a simple long running loop that attempts to query for items in a table one by one up to a large ID:

``` php
$db = new DB('mysql:dbname=test;host=localhost', 'test', '12345');
$query = "SELECT id, name FROM items WHERE id = :id";
for($i = 1; $i < 1000000; ++$i){
	$query = $db->query($query, ['id'=> $i]);
	while($item = $query->fetch()){
		echo "item {$item['id']}: {$item['name']}\n";
		sleep(1);
	}
}
```

I put a one second delay between queries to give me time to break the connection.  One way is to stop and restart the MySQL server.  With the standard MySQL dmg install on Mac OS, this can be done like:

``` sh
sudo /usr/local/mysql/support-files/mysql.server stop && sleep 5 && sudo /usr/local/mysql/support-files/mysql.server start
```

For the "gone away" error, we can run the query `SHOW PROCESSLIST`, find the ID of our connection, and then run `KILL` with that ID.

So I started my loop script, waited for it to output several items, then broke the connection.  The loop script paused, then started back up again.  I then, of course, hit `ctrl-c` to stop it so I didn't have to wait for it to output all rows.

Nice.
