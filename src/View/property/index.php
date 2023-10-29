<?php

use App\Auth;
use App\Table\PropertyTable;
use App\DBconnection;
use App\Exception\Table\FindAllException;
use App\Table\{AdTypeTable, PropertyTypeTable};

Auth::checkAccess();

$title = 'Mon site - Gestion des biens immobiliers';
$mainLink = $router->url('properties');

try {
    $pdo = DBconnection::getPDO();

    $propertyTypeTable = new PropertyTypeTable($pdo);
    $propertyTypes = $propertyTypeTable->findAll();

    $propertyTable = new PropertyTable($pdo);
    $properties = $propertyTable->findAll();

    $adTypeTable = new AdTypeTable($pdo);
    $adTypes = $adTypeTable->findAll();
} catch (FindAllException) {
    header('Location: ' . $router->url('properties') . '?datasException=1');
    exit();
}
?>

<div class="container my-4">
    <div class="row">
        <div class="col-md-6 mb-2">
            <h2>Bienvenue <?= $_SESSION['name'] ?></h2>
        </div>
        <div class="col-md-6 text-right">
            <a href="<?= $router->url('new_property') ?>" class="btn btn-primary mr-2">Ajouter</a>
            <form action="<?= $router->url('logout') ?>" method="post" style="display: inline;">
                <button type="submit" class="btn btn-danger">Déconnexion</button>
            </form>
        </div>
    </div>
</div>

<?php if (isset($_GET['successfulRegistration'])) : ?>
    <div class="alert alert-success">
        Inscription réussie
    </div>
<?php endif ?>

<?php if (isset($_GET['datasException'])) : ?>
    <div class="alert alert-danger">
        Erreur dans la récupération des données
    </div>
<?php endif ?>

<?php if (isset($_GET['propertyCreated'])) : ?>
    <div class="alert alert-success">
        Le bien immobilier a bien été créé
    </div>
<?php endif ?>

<?php if (isset($_GET['propertyUpdated'])) : ?>
    <div class="alert alert-success">
        Le bien immobilier a bien été modifié
    </div>
<?php endif ?>

<?php if (isset($_GET['delete'])) : ?>
    <div class="alert alert-success">
        Le bien immobilier a bien été supprimé
    </div>
<?php endif ?>

<div class="row mb-3">
    <div class="col-md-6 mb-4">
        <div class="btn-group btn-group-user" role="group">
            <button type="button" class="btn btn-outline-secondary" data-user-filter="all-properties">Tous les biens</button>
        </div>
        <div class="btn-group btn-group-user" role="group">
            <button type="button" class="btn btn-outline-secondary" data-user-filter="my-properties">Mes biens</button>

        </div>
    </div>
    <div class="col-md-6 text-right">
        <div class="btn-group btn-group-category" role="group">
            <button type="button" class="btn btn-outline-secondary" data-category-filter="all">Tout</button>
        </div>
        <div class="btn-group btn-group-category" role="group">
            <button type="button" class="btn btn-outline-secondary" data-category-filter="Vente">Vente</button>
        </div>
        <div class="btn-group btn-group-category" role="group">
            <button type="button" class="btn btn-outline-secondary" data-category-filter="Location">Location</button>
        </div>
    </div>
</div>

<div class="row mb-4">
    <?php foreach ($properties as $property) : ?>
        <?php
        $isUserProperty = $property->getUser() === $_SESSION['auth'] ? 'my-properties' : 'all-properties';
        $category = $adTypes[$property->getAdType()];
        foreach ($adTypes as $id => $value) {
            if ($property->getAdType() === $id) {
                $category = $value;
            }
        }
        ?>
        <div class="col-md-4" id="property-card" data-category="<?= $category ?>" data-user="<?= $isUserProperty ?>">
            <?php require 'card.php' ?>
        </div>
    <?php endforeach ?>
</div>

<script src="/src/JS/property/filter.js"></script>