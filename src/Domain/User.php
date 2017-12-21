<?php

namespace Gedimagination\Domain;

class User 
{
    /**
     * User id.
     *
     * @var integer
     */
    private $id;

    /**
     * User email.
     *
     * @var string
     */
    private $email;

    /**
     * User prenom.
     *
     * @var string
     */
    private $prenom;

    /**
     * User nom.
     *
     * @var string
     */
    private $nom;

    /**
     * User Img Url.
     *
     * @var string
     */
    private $urlImgParticipation;


    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
        return $this;
    }

    public function getPrenom() {
        return $this->prenom;
    }

    public function setPrenom($prenom) {
        $this->prenom = $prenom;
        return $this;
    }

    public function getNom() {
        return $this->nom;
    }

    public function setNom($nom) {
        $this->nom = $nom;
        return $this;
    }

    public function getUrlImgParticipation() {
        return $this->urlImgParticipation;
    }

    public function setUrlImgParticipation($urlImgParticipation) {
        $this->urlImgParticipation = $urlImgParticipation;
        return $this;
    }
}