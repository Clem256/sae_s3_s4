<?php

class profile
{
    public $id;
    public $user;
    public $avatar_url;

    public function __construct($user, $id, $avatar_url)
    {
        $this->id = $id;
        $this->user = $user;
        $this->avatar_url = $avatar_url;
    }


}