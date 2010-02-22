<?php

class Console_Command {
    
    public $arguments = array();
    public $name = null;
    
    public function __construct ($rawcommand) {
        
        $parts = explode(" ", $rawcommand);
        
        $this->name = array_shift($parts);
        
        $arguments = array();
        
        $skipnext = false;
        foreach ($parts as $i => $part) {
            if ($skipnext) {
                $skipnext = false;
                continue;
            }
            
            if (substr($part, 0, 1) == '-') {
                $key = substr($part, 1);
                $value = $parts[$i+1];
                
                $arguments[$key] = $value;
                $skipnext = true;
            }
            else {
                $arguments []= $part;
            }
        }
        
        $this->arguments = $arguments;
    }
}