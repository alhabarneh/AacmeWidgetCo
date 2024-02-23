<?php

// we should implement Throwable here
class Exception {
    
    public function __construct(
        private string $message = "", 
        private int $code = 0, 
        private ?Exception $previous = null
        ) {}

    public function getCode() {
        return $this->code;
    }
    
    public function getMessage() {
        return $this->message;
    }
    
    public function getPrevious() {
        return $this->previous;
    }

}