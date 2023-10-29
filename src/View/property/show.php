<?php

use App\Auth;
use App\DBconnection;
use App\Exception\Table\NotFoundException;
use App\Table\AdTypeTable;
use App\Table\PropertyTable;
use App\Table\PropertyTypeTable;

Auth::checkAccess();

$mainLink = $router->url('properties');

try {
    $pdo = DBconnection::getPDO();

    $adTypeTable = new AdTypeTable($pdo);
    $adTypes = $adTypeTable->findAll();

    $propertyTypeTable = new PropertyTypeTable($pdo);
    $propertyTypes = $propertyTypeTable->findAll();

    $propertyTable = new PropertyTable($pdo);
    $property = $propertyTable->findByID($params['id']);

    $title = "Mon site - Affichage du bien n°" . $property->getID();
    $image_folder = "/img/properties/";
} catch (NotFoundException) {
    header('Location: ' . $router->url('properties') . '?datasException=1');
    exit();
}
?>

<div class="container my-4">
    <div class="row">
        <div class="col-md-6 mb-3">
            <div class="card border">
                <?php
                $imageToShow = "";
                $image_name = $property->getImage();
                if ($image_name !== null) {
                    $imageToShow = $image_folder . $image_name;
                }
                ?>
                <img src="<?= $imageToShow ?>" alt="Ajoutez une image" class="card-img-top" id="previewImage">
            </div>
        </div>

        <div class="col-md-6">
            <form>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="label">Libellé :</label>
                            <input type="text" class="form-control" id="label" name="label" value="<?= $property->getLabel() ?>" disabled>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="adType">Type d'annonce :</label>
                            <input type="text" class="form-control" id="adType" name="adType" value="<?= $adTypes[$property->getAdType()] ?>" disabled>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="propertyType">Type de bien :</label>
                            <input type="text" class="form-control" id="propertyType" name="propertyType" value="<?= $propertyTypes[$property->getPropertyType()] ?>" disabled>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="price">Prix (€) :</label>
                            <input type="text" class="form-control" id="price" name="price" value="<?= $property->getPrice() ?>" disabled>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="isSold" name="isSold" <?= $property->getIsSold() === 1 ? 'checked' : '' ?> disabled>
                            <label class="form-check-label" for="isSold">Vendu / Loué</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="description">Description :</label>
                            <textarea class="form-control" id="description" name="description" rows="5" disabled><?= $property->getDescription() ?></textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="energyClass">Classe énergétique :</label>
                            <input type="text" class="form-control" id="energyClass" name="energyClass" value="<?= $property->getEnergyClass() ?>" disabled>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="livingArea">Superficie habitable (m²) :</label>
                            <input type="text" class="form-control" id="livingArea" name="livingArea" value="<?= $property->getLivingArea() ?>" disabled>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="bedroom">Nombre de chambre(s) :</label>
                            <input type="text" class="form-control" id="bedroom" name="bedroom" value="<?= $property->getBedroom() ?>" disabled>
                        </div>
                        <div class="form-group">
                            <label for="bathroom">Nombre de salle(s) de bain :</label>
                            <input type="text" class="form-control" id="bathroom" name="bathroom" value="<?= $property->getBathroom() ?>" disabled>
                        </div>
                        <div class="form-group">
                            <label for="toilet">Nombre de toilette(s) :</label>
                            <input type="text" class="form-control" id="toilet" name="toilet" value="<?= $property->getToilet() ?>" disabled>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="totalArea">Superficie totale du terrain (m²) :</label>
                            <input type="text" class="form-control" id="totalArea" name="totalArea" value="<?= $property->getTotalArea() ?>" disabled>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12 text-right">
                        <a href="javascript:void(0)" onclick="restoreMainPageWithFilters()" class="btn btn-secondary"><i class="fa-solid fa-list" style="color: #ffffff; margin-right: 5px;"></i> Retour à la liste</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://kit.fontawesome.com/1e190d6f3a.js" crossorigin="anonymous"></script>
<script src="/src/JS/property/restoreFilter.js"></script>