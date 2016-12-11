<?php
namespace AppBundle\Exceptions;

class RecordException extends \Exception
{
    public function __construct($message)
    {
        parent::__construct($message);
    }
}