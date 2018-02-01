<?php

namespace Gedimagination;

class User
{
    public function __construct($row)
    {
        $this->setId($row['id']);
        $this->setEmail($row['email']);
        $this->setPassword($row['pwd']);
        $this->setNom($row['nom']);
        $this->setUrlImgParticipation($row['urlImgParticipation']);
        $this->setRole($row['role']);
        return $this;
    }

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

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    public function getNom()
    {
        return $this->nom;
    }

    public function setNom($nom)
    {
        $this->nom = $nom;
        return $this;
    }

    public function getUrlImgParticipation()
    {
        return $this->urlImgParticipation;
    }

    public function setUrlImgParticipation($urlImgParticipation)
    {
        $this->urlImgParticipation = $urlImgParticipation;
        return $this;
    }

    public function getRole()
    {
        return $this->role;
    }

    public function setRole($role)
    {
        $this->role = $role;
        return $this;
    }

    public function findById($id)
    {
        $sql = "select * from User where id=?";
        $row = $this->getDb()->fetchAssoc($sql, array($id));

        if ($row) {
            return new User($row);
        } else {
            throw new \Exception("No user matching id " . $id);
        }

    }

    public static function findByEmail($id)
    {
        $query = $klein->$app->db->prepare("Select * from User where email='" . $login . "';");
        $query->execute();
        $results = $query->fetch();
        if ($row) {
            return new User($row);
        } else {
            throw new \Exception("No user matching email " . $id);
        }

    }
}
