<?php

namespace App\Table;

use App\Exception\Table\{CreateException, UpdateException, DeleteException, FindAllException, NotFoundException};
use App\Model\Property;
use PDO;
use PDOException;

final class PropertyTable extends Table
{

    protected $table = "TBL_BIEN";
    protected $class = Property::class;

    public function create(Property $property): void
    {
        $this->pdo->beginTransaction();

        try {
            $sql = "INSERT INTO {$this->table} (SOLD, LIB, DESCRIPTION, PRIX, PHOTO, CLASSE_ENERGIE, CHAMBRE, SDB, WC, ST, SH, ID_USER, ID_TYPE_BIEN, ID_TYPE_ANNONCE) 
            VALUES (:isSold, :label, :description, :price, :image, :energyClass, :bedroom, :bathroom, :toilet, :totalArea, :livingArea, 
            :userID, :propertyType, :adType)";

            $query = $this->pdo->prepare($sql);
            $query->execute([
                'isSold' => $property->getIsSold(),
                'label' => $property->getLabel(),
                'description' => $property->getDescription(),
                'price' => $property->getPrice(),
                'image' => $property->getImage(),
                'energyClass' => $property->getEnergyClass(),
                'bedroom' => $property->getBedroom(),
                'bathroom' => $property->getBathroom(),
                'toilet' => $property->getToilet(),
                'totalArea' => $property->getTotalArea(),
                'livingArea' => $property->getLivingArea(),
                'userID' => $property->getUser(),
                'propertyType' => $property->getPropertyType(),
                'adType' => $property->getAdType()
            ]);

            $this->pdo->commit();
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            throw new CreateException();
        }
    }

    public function update(Property $property): void
    {
        $this->pdo->beginTransaction();

        try {
            $sql = "UPDATE {$this->table} SET SOLD = :isSold, LIB = :label, DESCRIPTION = :description, PRIX = :price, PHOTO = :image, CLASSE_ENERGIE = :energyClass, CHAMBRE = :bedroom,
            SDB = :bathroom, WC = :toilet, ST = :totalArea, SH = :livingArea, ID_USER = :userID, ID_TYPE_BIEN = :propertyType, ID_TYPE_ANNONCE = :adType
            WHERE ID_BIEN = :propertyID";

            $query = $this->pdo->prepare($sql);
            $query->execute([
                'isSold' => $property->getIsSold(),
                'label' => $property->getLabel(),
                'description' => $property->getDescription(),
                'price' => $property->getPrice(),
                'image' => $property->getImage(),
                'energyClass' => $property->getEnergyClass(),
                'bedroom' => $property->getBedroom(),
                'bathroom' => $property->getBathroom(),
                'toilet' => $property->getToilet(),
                'totalArea' => $property->getTotalArea(),
                'livingArea' => $property->getLivingArea(),
                'userID' => $property->getUser(),
                'propertyType' => $property->getPropertyType(),
                'adType' => $property->getAdType(),
                'propertyID' => $property->getID()
            ]);

            $this->pdo->commit();
        } catch (PDOException) {
            $this->pdo->rollBack();
            throw new UpdateException();
        }
    }

    public function delete(int $id)
    {
        $this->pdo->beginTransaction();

        try {
            $query = $this->pdo->prepare("DELETE FROM {$this->table} WHERE ID_BIEN = ?");
            $query->execute([$id]);

            $this->pdo->commit();
        } catch (PDOException) {
            $this->pdo->rollBack();
            throw new DeleteException();
        }
    }

    public function findAll(): ?array
    {
        $this->pdo->beginTransaction();

        try {

            $query = $this->pdo->prepare("SELECT * FROM {$this->table}");
            $query->execute();

            $results = $query->fetchAll(PDO::FETCH_ASSOC);

            $this->pdo->commit();

            $properties = [];
            foreach ($results as $result) {
                $properties[] = new Property(
                    $result['ID_BIEN'],
                    $result['SOLD'],
                    $result['LIB'],
                    $result['DESCRIPTION'],
                    $result['PRIX'],
                    $result['PHOTO'],
                    $result['CLASSE_ENERGIE'],
                    $result['CHAMBRE'],
                    $result['SDB'],
                    $result['WC'],
                    $result['ST'],
                    $result['SH'],
                    $result['ID_USER'],
                    $result['ID_TYPE_BIEN'],
                    $result['ID_TYPE_ANNONCE']
                );
            }

            return $properties;
        } catch (PDOException) {
            $this->pdo->rollBack();
            throw new FindAllException();
        }
    }

    public function findByID($id): ?Property
    {

        $this->pdo->beginTransaction();

        try {

            $query = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE ID_BIEN = ? ");
            $query->execute([$id]);

            $result = $query->fetch();

            $this->pdo->commit();

            return new Property(
                $result['ID_BIEN'],
                $result['SOLD'],
                $result['LIB'],
                $result['DESCRIPTION'],
                $result['PRIX'],
                $result['PHOTO'],
                $result['CLASSE_ENERGIE'],
                $result['CHAMBRE'],
                $result['SDB'],
                $result['WC'],
                $result['ST'],
                $result['SH'],
                $result['ID_USER'],
                $result['ID_TYPE_BIEN'],
                $result['ID_TYPE_ANNONCE']
            );
        } catch (PDOException) {
            $this->pdo->rollBack();
            throw new NotFoundException();
        }
    }
}
