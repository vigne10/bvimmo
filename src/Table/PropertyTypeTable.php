<?php

namespace App\Table;

use App\Exception\Table\FindAllException;
use PDO;
use PDOException;

final class PropertyTypeTable extends Table
{

    protected $table = "TBL_TYPE_BIEN";

    public function findAll(): array
    {
        $this->pdo->beginTransaction();

        try {

            $query = $this->pdo->prepare("SELECT * FROM {$this->table}");
            $query->execute();

            $results = $query->fetchAll(PDO::FETCH_ASSOC);

            $this->pdo->commit();

            //Transform the results into an associative array with ID_TYPE_BIEN as the key
            $propertyTypes = [];
            foreach ($results as $result) {
                $propertyTypes[$result['ID_TYPE_BIEN']] = $result['TYPE_BIEN'];
            }

            return $propertyTypes;
        } catch (PDOException) {
            $this->pdo->rollBack();
            throw new FindAllException();
        }
    }
}
