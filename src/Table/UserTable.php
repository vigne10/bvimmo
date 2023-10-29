<?php

namespace App\Table;

use App\Exception\Table\CreateException;
use App\Model\User;
use App\Exception\Table\NotFoundException;
use DateTime;
use DateTimeZone;
use PDO;
use PDOException;

const DATE_TIME_ZONE = new DateTimeZone('Europe/Brussels');

final class UserTable extends Table
{

    protected $table = "TBL_USER";
    protected $class = User::class;

    public function create(array $datas): int
    {
        $this->pdo->beginTransaction();

        try {
            $query = $this->pdo->prepare("INSERT INTO {$this->table} (ID_USER, NOM_PRENOM, ADRESSE, ID_VILLE, EMAIL, PASSWORD, OPTIN) VALUES (:idUser, :nameSurname, :address, :cityID, :email, :password, :optin)");
            $query->execute([
                'idUser' => $datas['email'],
                'nameSurname' => $datas['name_surname'],
                'address' => $datas['address'],
                'cityID' => $datas['city'],
                'email' => $datas['email'],
                'password' => password_hash($datas['password'], PASSWORD_BCRYPT),
                'optin' => (new DateTime('now', DATE_TIME_ZONE))->format('Y-m-d H:i:s')
            ]);

            $userID = (int)$this->pdo->lastInsertId();

            $this->pdo->commit();

            return $userID;
        } catch (PDOException) {
            $this->pdo->rollBack();
            throw new CreateException();
        }
    }

    public function exists(string $email): bool
    {
        $this->pdo->beginTransaction();

        try {

            $query = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE email = :email");
            $query->execute(['email' => $email]);

            $result = $query->fetch(PDO::FETCH_ASSOC);

            $this->pdo->commit();

            if ($result !== false) {
                return true;
            }
            return $result;
        } catch (PDOException) {
            $this->pdo->rollback();
            throw new NotFoundException();
        }
    }

    public function findByEmail(string $email): ?User
    {

        $this->pdo->beginTransaction();

        try {
            $query = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE email = :email");
            $query->execute(['email' => $email]);

            $result = $query->fetch(PDO::FETCH_ASSOC);

            $this->pdo->commit();

            if ($result === false) {
                throw new NotFoundException();
            } else {
                $user = new User(
                    $result['ID_USER'],
                    $result['NOM_PRENOM'],
                    $result['ADRESSE'],
                    $result['ID_VILLE'],
                    $result['EMAIL'],
                    $result['PASSWORD'],
                    DateTime::createFromFormat('Y-m-d H:i:s', $result['OPTIN'])
                );
            }
            return $user;
        } catch (PDOException) {
            $this->pdo->rollback();
            throw new NotFoundException();
        }
    }

    public function findByID(int $id): ?User
    {

        $this->pdo->beginTransaction();

        try {
            $query = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE ID_USER = :id");
            $query->execute(['id' => $id]);

            $result = $query->fetch(PDO::FETCH_ASSOC);

            $this->pdo->commit();

            if ($result === false) {
                throw new NotFoundException();
            } else {
                $user = new User(
                    $result['ID_USER'],
                    $result['NOM_PRENOM'],
                    $result['ADRESSE'],
                    $result['ID_VILLE'],
                    $result['EMAIL'],
                    $result['PASSWORD'],
                    DateTime::createFromFormat('Y-m-d H:i:s', $result['OPTIN'])
                );
            }
            return $user;
        } catch (PDOException) {
            $this->pdo->rollback();
            throw new NotFoundException();
        }
    }
}
