<?php

namespace Felis;

// email adapter class
class Email{
    public function mail($to, $subject, $message, $headers) {
        mail($to, $subject, $message, $headers);
    }
}