<?php
class Route
{
    private $_delimiter;
    
    private $_route;
    private $_params;
    
    public function __construct()
    {
        $this->_delimiter = "/";
    }
    
    public function setDelimiter($delimiter)
    {
        $this->_delimiter = $delimiter;
    }
    
    public function getDelimiter()
    {
        return $this->_delimiter;
    }
    
    public function explode($uri)
    {
        $this->_route = array();
        $this->_params = array();
        
        $parts = explode($this->_delimiter, $uri);
        
        if (!is_array($parts)) {
            $parts = array($parts);
        }
        
        $parts = $this->_filter($parts);
        
        switch (count($parts)) {
            case 0:
                $this->_route["controller"] = "index";
                $this->_route["action"] = "index";
                break;
            case 1:
                $this->_route["controller"] = "index";
                $this->_route["action"] = $parts[0];
                array_shift($parts);
                break;
            default:
                $this->_route["controller"] = $parts[0];
                $this->_route["action"] = $parts[1];
                array_shift($parts);
                array_shift($parts);
                
                break;
        }
        
        if (count($parts) % 2 !== 0) {
            array_pop($parts);
        }
        
        if (count($parts)) {
            for ($i=0; $i<count($parts); $i=$i+2) {
                $this->_params[$parts[$i]] = $parts[$i+1];
            }
        }
        
        return $this;
    }
    
    private function _filter($parts)
    {
        $clean = array();
        foreach ($parts as $part) {
            $part = trim($part);
            if (!empty($part)) {
                $clean[] = $part;
            }
        }
        
        return $clean;
    }
    
    public function getRoute()
    {
        return $this->_route;
    }
    
    public function getParams()
    {
        return $this->_params;
    }
}