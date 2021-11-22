<?php

/**
 * Entity superclass.
 *
 * Every other entity must inherit from this one. It represents a database
 * entity.
 */
abstract class Entity{
    protected $loaded = false;
    protected $complete = false;
    protected function mark_as_loaded($loaded){
        $this->loaded = (bool) $loaded;
    }
    protected function mark_as_complete($complete){
        $this->complete = (bool) $complete;
    }
    public function is_loaded(){
        return $this->loaded;
    }
    public function is_complete(){
        return $this->complete;
    }
}
