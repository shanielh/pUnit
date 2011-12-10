<?php 

// All rights reserved to 
// http://www.if-not-true-then-false.com/2010/php-class-for-coloring-php-command-line-cli-scripts-output-php-output-colorizing-using-bash-shell-colors/

namespace pUnit\External;

class ConsoleColors 
{
    private $mForegroundColors = array();
    private $mBackgroundColors = array();
    
    public function __construct() {
    	// Set up shell colors
    	$this->mForegroundColors['black'] = '0;30';
    	$this->mForegroundColors['dark_gray'] = '1;30';
    	$this->mForegroundColors['blue'] = '0;34';
    	$this->mForegroundColors['light_blue'] = '1;34';
    	$this->mForegroundColors['green'] = '0;32';
    	$this->mForegroundColors['light_green'] = '1;32';
    	$this->mForegroundColors['cyan'] = '0;36';
    	$this->mForegroundColors['light_cyan'] = '1;36';
    	$this->mForegroundColors['red'] = '0;31';
    	$this->mForegroundColors['light_red'] = '1;31';
    	$this->mForegroundColors['purple'] = '0;35';
    	$this->mForegroundColors['light_purple'] = '1;35';
    	$this->mForegroundColors['brown'] = '0;33';
    	$this->mForegroundColors['yellow'] = '1;33';
    	$this->mForegroundColors['light_gray'] = '0;37';
    	$this->mForegroundColors['white'] = '1;37';
    
    	$this->mBackgroundColors['black'] = '40';
    	$this->mBackgroundColors['red'] = '41';
    	$this->mBackgroundColors['green'] = '42';
    	$this->mBackgroundColors['yellow'] = '43';
    	$this->mBackgroundColors['blue'] = '44';
    	$this->mBackgroundColors['magenta'] = '45';
    	$this->mBackgroundColors['cyan'] = '46';
    	$this->mBackgroundColors['light_gray'] = '47';
    }
    
    
    public function getBoldString($string)
    {
        return "\033[1m" . $string . "\033[0m";
    }
    
    // Returns colored string
    public function getColoredString($string, $foreground_color = null, $background_color = null) {
    	$colored_string = '';
    
    	// Check if given foreground color found
    	if (isset($this->mForegroundColors[$foreground_color])) {
    		$colored_string .= "\033[" . $this->mForegroundColors[$foreground_color] . "m";
    	}
    	// Check if given background color found
    	if (isset($this->mBackgroundColors[$background_color])) {
    		$colored_string .= "\033[" . $this->mBackgroundColors[$background_color] . "m";
    	}
    
    	// Add string and end coloring
    	$colored_string .=  $string . "\033[0m";
    
    	return $colored_string;
    }
 
}
