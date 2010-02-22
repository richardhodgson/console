<?

class Console {
    public function __construct () {
        spl_autoload_register(array($this, 'autoload'));
    }
    /**
     * Allows auto including of classes by making reference to them.
     * @param $className
     * @return void
     */
    public function autoload ($className) {
        $path = str_replace('_', '/', $className);
        require_once($path . '.php');
    }
}

new Console();


$rawinput = $_POST["input"]; // the command that has just been passed over...

if (! isset($rawinput)) {
    $rawinput = $_GET['input'];
}


if(!isset($rawinput)){ die("*"); } // prevent direct access to this file

# ==================================================================
include("config.php");
include("utils.php");
# ==================================================================
$core = import("core");
$installed = import("com");

$commands = array_merge($core, $installed);

// for now, commands are very simple... only first (and sometimes second) chunk of input is processed
$inputparts = explode(" ", $rawinput);
$firstpart = $inputparts[0];

if( is_numeric($firstpart) ){ // handling things like '10 print "hello"'
	echo basic($rawinput);
	exit();
}

# ==================================================================

$match = match($firstpart, $commands);

if ( $match[0] == 0 ) { # exact match for a command

	echo process($rawinput, $commands);

} else if(strstr($match[1], "_") == false){
	echo "$firstpart: command not found. Did you mean '$match[1]'?";
} else {
	echo "Sorry, you can't directly access the <strong>$firstpart</strong> command.";
}

# ==================================================================
# PROCESS THE COMMAND...
# needs to be cleaner, to be able to handle array input, etc.
# ==================================================================
function process($input, $commands){

	$inputparts = explode(" ", $input);

	$thecommand = $inputparts[0]; # only using the first 2 chunks if there's no ""

	//$args["command"] = $inputparts[0];
	$args = $inputparts;

	$inputquoted = explode('"', $input); # use strings inside "" as full string with spaces
	$quoted = str_replace("\\", "", $inputquoted[1]);

	if($quoted !=""){ $args = $quoted; }

	foreach ($commands as $command => $alias) {
		if(strstr($thecommand, $command) != false){
			return $alias($args, $commands); # fire the command, passing in $arg1 and all the other commands
		}
	}
}

# ==================================================================
# programming
function basic($input){
	$parts = explode(" ", $input);
	$number = $parts[0];
	$line = str_replace($number." ", "", $input);

	return c__addline($number, $line);
}


# ==================================================================
# dumb list of usernames
$users  = array(
	"thing",
	"rich13"
);

