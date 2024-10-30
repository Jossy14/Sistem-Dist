<?php

class EntityExistsException extends Exception
{
    public function __construct(string $message, int $code = 0, $throwable = null)
    {
        parent::__construct($message, $code, $throwable);
    }
}