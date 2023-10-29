<?php

use App\Helpers\NumberHelper;

$statusClass = 'text-left font-weight-bold';
$status = $property->getStatus();

if ($status === "En Vente") {
    $statusClass .= " text-success";
}
if ($status === "En Location") {
    $statusClass .= " text-warning";
}
if ($status === "Vendu/Loué") {
    $statusClass .= " text-danger";
}

?>

<div class="card mb-3">
    <?php if ($property->getImage()) : ?>
        <img src="<?= $property->getImageURL() ?>" class="card-img-top">
    <?php endif ?>
    <div class="card-body">
        <h5 class="card-title"><?= htmlentities($property->getLabel()) ?></h5>
        <p class="text-muted">
            <?= $property->getExcerpt() ?>
        </p>
        <div class="row">
            <div class="col-md-6">
                <p><?= $propertyTypes[$property->getPropertyType()] ?></p>
            </div>
            <div class="col-md-6">
                <p class="text-right"><?= NumberHelper::price($property->getPrice()) ?></p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <p class="<?= $statusClass ?>"><?= $status ?></p>
            </div>
        </div>
        <div class="row justify-content-end text-right">
            <div class="col-md-6">
                <?php if ($isUserProperty === "my-properties") : ?>
                    <a href="<?= $router->url('edit_property', ['id' => $property->getID()]) ?>" class="btn btn-light">
                        <i class="fa-solid fa-pen" style="color: #919191; margin-right: 5px;"></i> Modifier
                    </a>
                <?php else : ?>
                    <a href="<?= $router->url('show_property', ['id' => $property->getID()]) ?>" class="btn btn-light">
                        <i class="fa-solid fa-eye" style="color: #919191; margin-right: 5px;"></i> Consulter
                    </a>
                <?php endif ?>
            </div>
        </div>

    </div>
</div>

<script src="https://kit.fontawesome.com/1e190d6f3a.js" crossorigin="anonymous"></script>