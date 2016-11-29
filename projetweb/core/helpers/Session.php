<?php
namespace core\helpers;

class Session {

    public function setFlash($message, $type = 'success')
    {
        $_SESSION['Flash'] = [
            'message' => $message,
            'type'    => $type
        ];
    }

    public function getFlash()
    {
        if ($this->hasFlash())
        {
            echo '<div class="alert alert-' . $_SESSION['Flash']['type'] . '">' . $_SESSION['Flash']['message'] . '</div>';

            unset($_SESSION['Flash']);
        }
    }

    public function hasFlash()
    {
        return isset($_SESSION['Flash']);
    }

}