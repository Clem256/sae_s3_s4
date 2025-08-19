<?php

class video_run
{
    public $id_jeu;
    public $id_run;

    public $link_video;

    public function __construct($id_jeu, $id_run, $link_video)
    {
        $this->$id_jeu = $id_jeu;
        $this->id_run = $id_run;
        $this->link_video = $link_video;
    }

    /**
     * @return mixed
     */
    public function getIdJeu()
    {
        return $this->id_jeu;
    }

    /**
     * @param mixed $id_jeu
     */
    public function setIdJeu($id_jeu): void
    {
        $this->id_jeu = $id_jeu;
    }

    /**
     * @return mixed
     */
    public function getIdRun()
    {
        return $this->id_run;
    }

    /**
     * @param mixed $id_run
     */
    public function setIdRun($id_run): void
    {
        $this->id_run = $id_run;
    }

    /**
     * @return mixed
     */
    public function getLinkVideo()
    {
        return $this->link_video;
    }

    /**
     * @param mixed $link_video
     */
    public function setLinkVideo($link_video): void
    {
        $this->link_video = $link_video;
    }


}