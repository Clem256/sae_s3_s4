<?php

class Game
{
    public $id;
    public $name;
    public $image_url;

    public function __construct($id, $name, $image_url)
    {
        $this->id = $id;
        $this->name = $name;
        $this->image_url = $image_url;
    }

    public function getImageUrl()
    {
        return $this->image_url;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }
}
