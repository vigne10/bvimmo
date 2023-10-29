<?php

namespace App\Table;

use App\Exception\Table\FindAllException;
use PDO;
use PDOException;

final class CityTable extends Table
{

    protected $table = "TBL_VILLE";

    public function findAll(): array
    {
        $this->pdo->beginTransaction();

        try {
            $query = $this->pdo->prepare("SELECT * FROM {$this->table} ORDER BY VILLE ASC");
            $query->execute();

            $results = $query->fetchAll(PDO::FETCH_ASSOC);

            $this->pdo->commit();

            return $results;
        } catch (PDOException) {
            $this->pdo->rollback();
            throw new FindAllException();
        }
    }
}
