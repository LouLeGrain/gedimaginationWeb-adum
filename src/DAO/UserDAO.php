<?php

namespace Gedimagination\DAO;

use Doctrine\DBAL\Connection;
use Gedimagination\Domain\User;

class ArticleDAO
{
    /**
     * Database connection
     *
     * @var \Doctrine\DBAL\Connection
     */
    private $db;

    /**
     * Constructor
     *
     * @param \Doctrine\DBAL\Connection The database connection object
     */
    public function __construct(Connection $db) {
        $this->db = $db;
    }

    /**
     * Return a list of all users
     *
     * @return array A list of all users.
     */
    public function findAll() {
        $sql = "select * from users";
        $result = $this->db->fetchAll($sql);
        
        // Convert query result to an array of domain objects
        $users = array();
        foreach ($result as $row) {
            $userId = $row['id'];
            $articles[$userId] = $this->buildUser($row);
        }
        return $articles;
    }

    /**
     * Creates an User object based on a DB row.
     *
     * @param array $row The DB row containing User data.
     * @return \Gedimagination\Domain\User
     */
    private function buildUser(array $row) {
        $user = new User();
        $user->setId($row['id']);
        $user->setEmail($row['email']);
        $user->setPrenom($row['prenom']);
        $user->setNom($row['nom']);
        $user->setUrlImgParticipation($row['urlImgParticipation']);
        return $user;
    }
}