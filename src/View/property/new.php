<?php

use App\Attachment\PropertyAttachment;
use App\Auth;
use App\Table\{AdTypeTable, PropertyTable, PropertyTypeTable};
use App\DBconnection;
use App\Model\EnergyClass;
use App\Exception\Property\{ImageFormatException, ImageSizeException};
use App\Exception\Table\CreateException;
use App\Exception\Table\FindAllException;
use App\Model\Property;

Auth::checkAccess();

$title = "Mon site - Ajouter un bien";
$mainLink = $router->url('properties');

try {
    $property = new Property();

    $pdo = DBconnection::getPDO();

    $adTypeTable = new AdTypeTable($pdo);
    $adTypes = $adTypeTable->findAll();

    $propertyTypeTable = new PropertyTypeTable($pdo);
    $propertyTypes = $propertyTypeTable->findAll();

    $energyClasses = EnergyClass::getEnergyClasses();

    if (!empty($_POST)) {
        $propertyTable = new PropertyTable($pdo);
        try {
            if (!empty($_FILES['image']['tmp_name'])) {
                $image = $_FILES['image']['tmp_name'];
                $finfo = new finfo();
                $info = $finfo->file($image, FILEINFO_MIME_TYPE);
                if (!in_array($info, ALLOWED_MIMES)) {
                    throw new ImageFormatException();
                }
                $size = getimagesize($image);
                $width = $size[0];
                $height = $size[1];
                if ($width < 800 || $width > 1920 || $height < 600 || $height > 1080) {
                    throw new ImageSizeException();
                }
                $property->setImage($_FILES['image']);
                PropertyAttachment::upload($property, $info);
            }
            $selectedPropertyType = $_POST['propertyType'];
            $selectedAdType = $_POST['adType'];

            foreach ($propertyTypes as $id => $value) {
                if ($value === $selectedPropertyType) {
                    $idPropertyType = $id;
                    break;
                }
            }

            foreach ($adTypes as $id => $value) {
                if ($value === $selectedAdType) {
                    $idAdType = $id;
                    break;
                }
            }


            $isSold = array_key_exists('isSold', $_POST) ? 1 : 0;
            $property
                ->setLabel($_POST['label'])
                ->setIsSold($isSold)
                ->setPrice($_POST['price'])
                ->setEnergyClass($_POST['energyClass'])
                ->setBedroom($_POST['bedroom'])
                ->setBathroom($_POST['bathroom'])
                ->setToilet($_POST['toilet'])
                ->setTotalArea($_POST['totalArea'])
                ->setLivingArea($_POST['livingArea'])
                ->setUser($_SESSION['auth'])
                ->setPropertyType($idPropertyType)
                ->setAdType($idAdType)
                ->setDecription($_POST['description']);
            $propertyTable->create($property);
            header('Location: ' . $this->url('properties') . '?propertyCreated=1');
            exit();
        } catch (ImageFormatException) {
            header('Location: ' . $this->url('new_property') . '?imageFormatError=1');
            exit();
        } catch (ImageSizeException) {
            header('Location: ' . $this->url('new_property') . '?imageSizeError=1');
            exit();
        } catch (CreateException) {
            header('Location: ' . $this->url('new_property') . '?createError=1');
            exit();
        }
    }
} catch (FindAllException) {
    header('Location: ' . $router->url('properties') . '?datasException=1');
    exit();
}
?>

<?php if (isset($_GET['imageFormatError'])) : ?>
    <div class="alert alert-danger">
        Le format de l'image est incorrect
    </div>
<?php endif ?>

<?php if (isset($_GET['imageSizeError'])) : ?>
    <div class="alert alert-danger">
        La taille de l'image est incorrecte. Veuillez choisir une image de minimum 800x600 et de maximum 1920x1080.
    </div>
<?php endif ?>

<?php if (isset($_GET['createError'])) : ?>
    <div class="alert alert-danger">
        Erreur lors de la création du bien immobilier
    </div>
<?php endif ?>

<div class="container my-4">
    <div class="row">
        <div class="col-md-6 mb-3">
            <?php if (true) : ?>
                <div class="card border">
                    <img src="" alt="Ajoutez une image" class="card-img-top" id="previewImage">
                </div>
            <?php endif ?>
        </div>

        <div class="col-md-6">
            <form action="<?= $router->url('new_property') ?>" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="label">Libellé :</label>
                            <input type="text" class="form-control" id="label" name="label">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="adType">Type d'annonce :</label>
                            <select class="form-control" id="adType" name="adType">
                                <?php foreach ($adTypes as $adType) : ?>
                                    <option><?= $adType ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="propertyType">Type de bien :</label>
                            <select class="form-control" id="propertyType" name="propertyType">
                                <?php foreach ($propertyTypes as $propertyType) : ?>
                                    <option><?= $propertyType ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="price">Prix (€) :</label>
                            <input type="text" class="form-control" id="price" name="price" oninput="validateNumericInput(this)">
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="isSold" name="isSold" value="off">
                            <label class="form-check-label" for="isSold">Vendu / Loué</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="description">Description :</label>
                            <textarea class="form-control" id="description" name="description" rows="5"></textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="energyClass">Classe énergétique :</label>
                            <select class="form-control" id="energyClass" name="energyClass">
                                <?php foreach ($energyClasses as $energyClass) : ?>
                                    <option><?= $energyClass ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="livingArea">Superficie habitable (m²) :</label>
                            <input type="text" class="form-control" id="livingArea" name="livingArea" oninput="validateNumericInput(this)">
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="bedroom">Nombre de chambre(s) :</label>
                            <input type="text" class="form-control" id="bedroom" name="bedroom" oninput="validateNumericInput(this)">
                        </div>
                        <div class="form-group">
                            <label for="bathroom">Nombre de salle(s) de bain :</label>
                            <input type="text" class="form-control" id="bathroom" name="bathroom" oninput="validateNumericInput(this)">
                        </div>
                        <div class="form-group">
                            <label for="toilet">Nombre de toilette(s) :</label>
                            <input type="text" class="form-control" id="toilet" name="toilet" oninput="validateNumericInput(this)">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="totalArea">Superficie totale du terrain (m²) :</label>
                            <input type="text" class="form-control" id="totalArea" name="totalArea" oninput="validateNumericInput(this)">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <input type="file" class="form-control-file" id="image" name="image">
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12 text-right">
                        <button type="submit" class="btn btn-success" id="submitButton" disabled>Ajouter</button>
                        <a href="javascript:void(0)" onclick="restoreMainPageWithFilters()" class="btn btn-danger">Annuler</a>
                    </div>
                </div>

            </form>

        </div>
    </div>
</div>

<script src="/src/JS/property/formValidation.js"></script>
<script src="/src/JS/property/image.js"></script>
<script src="/src/JS/property/restoreFilter.js"></script>