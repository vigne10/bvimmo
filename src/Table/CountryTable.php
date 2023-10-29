<?php

namespace App\Table;

use App\Exception\Table\FindAllException;
use PDO;
use PDOException;

final class CountryTable extends Table
{

    protected $table = "TBL_PAYS";

    public function findAll(): array
    {
        $this->pdo->beginTransaction();

        try {
            $query = $this->pdo->prepare("SELECT * FROM {$this->table}");
            $query->execute();

            $results = $query->fetchAll(PDO::FETCH_ASSOC);

            $this->pdo->commit();

            return $results;
        } catch (PDOException) {
            $this->pdo->rollBack();
            throw new FindAllException();
        }
    }
}
