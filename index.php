<?php
	/*
		Name: get-jokes.php
		Description: Returns an array of random jokes in JSON format
		Author: 
		Last Modified: 
		Example usage: get-jokes.php?limit=3
	*/
	
	// I. define some constants
	define('MIN_LIMIT', 1); 
	define('MAX_LIMIT', 10); 
	
	
	// II. $jokes contains our data
	// this is an indexed array of associative arrays
	// the associative arrays are jokes -  they have an 'q' key and an 'a' key
	$jokes = [
		["Q"=>"What do you call a very small valentine?","A"=>"A valen-tiny!"],
		["Q"=>"What did the dog say when he rubbed his tail on the sandpaper?","A"=>"Ruff, Ruff!"],
		["Q"=>"Why don't sharks like to eat clowns?","A"=>"Because they taste funny!"],
		["Q"=>"What did the boy cat say to the girl cat?","A"=>"You're Purr-fect!"],
		["Q"=>"What is a frog's favorite outdoor sport?","A"=>"Fly Fishing!"],
		["Q"=>"I hate jokes about German sausages.","A"=>"Theyre the wurst."],
		["Q"=>"Did you hear about the cheese factory that exploded in France?","A"=>"There was nothing left but de Brie."],
		["Q"=>"Our wedding was so beautiful ","A"=>"Even the cake was in tiers."],
		["Q"=>"Is this pool safe for diving?","A"=>"It deep ends."],
		["Q"=>"Dad, can you put my shoes on?","A"=>"I dont think theyll fit me."],
		["Q"=>"Can February March?","A"=>"No, but April May"],
		["Q"=>"What lies at the bottom of the ocean and twitches?","A"=>"A nervous wreck."],
		["Q"=>"Im reading a book on the history of glue.","A"=>"I just cant seem to put it down."],
		["Q"=>"Dad, can you put the cat out?","A"=>"I didnt know it was on fire."],
		["Q"=>"What did the ocean say to the sailboat?","A"=>"Nothing, it just waved."],
		["Q"=>"What do you get when you cross a snowman with a vampire?","A"=>"Frostbite"]
	];
	
	
	// III. Sanitize the `limit` parameter to be sure that it is numeric, and is not too small or large
	$limit = MIN_LIMIT; // the default
	if(array_key_exists('limit', $_GET)){ // if there is a `limit` parameter in the query string
		$limit = $_GET['limit'];
		$limit = (int)$limit; // explicitly cast value to an integer
		$limit =  ($limit < 1) ? MIN_LIMIT : $limit; // PHP has a ternary operator too
		$limit =  ($limit > MAX_LIMIT) ? MAX_LIMIT : $limit; // PHP has a ternary operator too
	}
	
	
	// IV. Do a final check that there are enough jokes in the $jokes array
	if($limit > count($jokes)){
		$limit = count($jokes);
	}
	
	
	// V. get a random element of the $jokes array
	// there are a bunch more PHP array functions at: http://php.net/manual/en/ref.array.php
	// https://www.php.net/manual/en/function.shuffle.php
	// https://www.php.net/manual/en/function.array-push.php
	$randomKeys = array_keys($jokes); // creates an array of indexes - something like [0,1,2,3,4,5,6,7,...]
	shuffle($randomKeys); // randomizes the $randomKeys array - something like [1,5,3,2,0,8,4,7,6, ...]
	$randomKeys = array_slice($randomKeys, 0, $limit); // just get the first `n` number of indexes we need
	$randomJokes = []; // the random jokes will go here
	foreach($randomKeys as $key){ // loop through $randomKeys
 		array_push($randomJokes,$jokes[$key]); // add a random joke to the array
 	}
	
	
	// VI. Send HTTP headers
	// https://www.php.net/manual/en/function.header.php
	// DO THIS **BEFORE** you `echo()` the content!
	header('content-type:application/json');      			// tell the requestor that this is JSON
	header('Access-Control-Allow-Origin: *');     			// turn on CORS
    header('X-this-430-service-is-kinda-lame: true');   // a custom header 
    header('X-author-name: alex');
	
	
	// VII. Send the content
	// json_encode() turns a PHP associative array into a string of well-formed JSON
	// https://www.php.net/manual/en/function.json-encode.php
	$string = json_encode($randomJokes);
	echo $string;

?>
