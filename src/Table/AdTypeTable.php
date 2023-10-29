<?php

namespace App\Table;

use PDO;
use PDOException;
use App\Exception\Table\FindAllException;

final class AdTypeTable extends Table
{
    protected $table = "TBL_TYPE_ANNONCE";

    public function findAll(): array
    {
        $this->pdo->beginTransaction();

        try {
            $query = $this->pdo->prepare("SELECT * FROM {$this->table}");
            $query->execute();

            $results = $query->fetchAll(PDO::FETCH_ASSOC);

            $this->pdo->commit();

            //Transform the results into an associative array with ID_TYPE_ANNONCE as the key
            $adTypes = [];
            foreach ($results as $result) {
                $adTypes[$result['ID_TYPE_ANNONCE']] = $result['TYPE_ANNONCE'];
            }

            return $adTypes;
        } catch (PDOException) {
            $this->pdo->rollback();
            throw new FindAllException();
        }
    }
}
