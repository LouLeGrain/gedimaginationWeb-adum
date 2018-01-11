<?php

namespace Gedimagination\Domain;

use Symfony\Component\Security\Core\User\UserInterface;

class User implements UserInterface
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
     * User password.
     *
     * @var string
     */
    private $password;

    /**
     * User salt (password encoding).
     *
     * @var string
     */
    private $salt;

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

    /**
     * User role.
     *
     * @var string
     */
    private $role;


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

    public function getPassword() {
        return $this->password;
    }

    public function setPassword($password) {
        $this->password = $password;
        return $this;
    }
    
    public function getSalt()
    {
        return $this->salt;
    }

    public function setSalt($salt)
    {
        $this->salt = $salt;
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

    public function getRole()
    {
        return $this->role;
    }

    public function setRole($role) {
        $this->role = $role;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getRoles()
    {
        return array($this->getRole());
    }

    /**
     * @inheritDoc
     */
    public function eraseCredentials() {
        // Nothing to do here
    }

}