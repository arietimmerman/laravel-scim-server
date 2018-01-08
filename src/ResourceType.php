<?php

namespace ArieTimmerman\Laravel\SCIMServer;

use ArieTimmerman\Laravel\SCIMServer\Attribute\AttributeMapping;

//TODO: Inject an instance of this class to methods in ResourceController
class ResourceType{
    
    protected $configuration = null, $name = null;
    
    function __construct($name, $configuration){
        $this->configuration = $configuration;
    }
    
    public function getConfiguration(){
        return $this->configuration;
    }
    
    public function getMapping(){
        return AttributeMapping::object($this->configuration['mapping'])->setDefaultSchema($this->configuration['schema']);
    }
    
    public function getName(){
        return $this->name;
    }
    
    public function getSchema(){
        return $this->configuration['schema'];
    }
    
    public function getClass(){
        return $this->configuration['class'];
    }
    
    public static function user(){
        return new ResourceType('Users', config('scimserver.Users'));
    }
    
    
    public function getAllAttributeConfigs($mapping = -1){
        
        $result = [];
        
        if($mapping == -1){
            $mapping = $this->getMapping();
        }
        
        foreach($mapping as $key=>$value){
            
            if($value instanceof AttributeMapping && $value != null){
                $result[] = $value;
            }elseif(is_array($value)){
                
                $extra = $this->getAllAttributeConfigs($value);
                
                if(!empty($extra)){
                    $result = array_merge($result, $extra);
                }
            }
            
        }
        
        return $result;
        
    }
    
}