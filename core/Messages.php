<?php

namespace core;

class Messages
{
    public static $arrayMessages=[];
    public static function addMessage($message, $type = 'alert-warning')
    {
        self::$arrayMessages[] = "<div class='alert {$type} alert-dismissible fade show m-5' role='alert'>" . htmlspecialchars($message, ENT_QUOTES, 'UTF-8') .
            "<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>  </div>";
    }
    protected static function getMessages(){
        $messages=self::$arrayMessages;
        self::$arrayMessages=[];
        return $messages;
    }
    public static function writeMessages()
    {
        $messages = \core\Messages::getMessages();
        if (!empty($messages)) {
            foreach ($messages as $mess) {
                echo $mess;
            }
        }
    }
}