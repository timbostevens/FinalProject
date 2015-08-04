<?php
	// get file
$jsondata = file_get_contents("03-Full-Data.json");

	// decodes the data into an array
$json = json_decode($jsondata, true);

	// creates a new recursive array iterator
$iterator = new RecursiveArrayIterator($json);

	// calls function and passes in interator
iterator_apply($iterator, 'iteratorLooper', array($iterator));

// function to loop through multi-dimensional array
function iteratorLooper($iterator){
// checks for valid entry
	while ($iterator->valid()){
	// if the entry has children
		if($iterator->hasChildren()){
		// recursive call to loop down a level
			iteratorLooper($iterator -> getChildren());
        // if it doesn't have children
		} else {
    	// checks for a new entry - uses timestamp as a new line id
			if($iterator -> key()=="timestamp"){
				echo "NEW RECORD";
			}
    	// does the main stuff
			echo $iterator -> key().' : '.$iterator -> current().PHP_EOL;
		}
    // moves on to the next iteration
		$iterator->next();

	}

}

?>