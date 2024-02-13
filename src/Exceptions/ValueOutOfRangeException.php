<?php

namespace SajedZarinpour\SpotPlayer\Exceptions;
use Exception;

class ValueOutOfRangeException extends Exception
{
    public function errorMessage() {
        return sprintf(
            'Error on line %s in %s : The parameter %s is out of range (0-99).',
            $this->getLine(),
            $this->getFile(),
            $this->getMessage()
        );
      }
}