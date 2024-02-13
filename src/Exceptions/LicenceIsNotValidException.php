<?php

namespace SajedZarinpour\SpotPlayer\Exceptions;
use Exception;

class LicenceIsNotValidException extends Exception
{
    public function __construct(string $message) {
       $this->message = 'Error on line '.$this->getLine().' in '.$this->getFile().' : The parameter '.$message.' is out of range (0-99).';
    }

    // public function errorMessage() {
    //     return sprintf(
    //         'Error on line %s in %s : The parameter %s is out of range (0-99).',
    //         $this->getLine(),
    //         $this->getFile(),
    //         $this->getMessage()
    //     );
    //   }

}