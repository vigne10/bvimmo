<?php

use App\Auth;
use App\DBconnection;
use App\Exception\Table\FindAllException;
use App\Table\CityTable;
use App\Table\CountryTable;
use App\Table\UserTable;

Auth::checkAlreadyLogged();

$title = "Mon site - Inscription";
$mainLink = $router->url('login');

try {
    $countryTable = new CountryTable(DBconnection::getPDO());
    $countries = $countryTable->findAll();

    $cityTable = new CityTable(DBconnection::getPDO());
    $cities = $cityTable->findAll();

    if (!empty($_POST)) {
        $userTable = new UserTable(DBconnection::getPDO());
        if ($userTable->exists($_POST['email'])) {
            header('Location: ' . $router->url('register') . '?emailAlreadyUse=1');
            exit();
        } else {
            $userID = $userTable->create($_POST);
            $_SESSION['auth'] = $userID;
            $_SESSION['name'] = $_POST['name_surname'];
            header('Location: ' . $router->url('properties') . '?successfulRegistration=1');
            exit();
        }
    }
} catch (FindAllException) {
    header('Location: ' . $router->url('register') . '?datasException=1');
    exit();
}


?>

<?php if (isset($_GET['emailAlreadyUse'])) : ?>
    <div class="alert alert-danger">
        Cette adresse mail est déjà utilisée
    </div>
<?php endif ?>

<?php if (isset($_GET['datasException'])) : ?>
    <div class="alert alert-danger">
        Erreur dans la récupération des données
    </div>
<?php endif ?>

<div class="container mt-4 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card">
                <div class="card-header text-center bg-primary text-white">
                    <h4>Inscription</h4>
                </div>
                <div class="card-body">
                    <form action="<?= $router->url('register') ?>" method="post">

                        <div class="form-group">
                            <label for="email">Adresse mail *</label>
                            <div class="input-with-icon">
                                <input type="email" name="email" id="email" class="form-control" required>
                                <i id="email_icon" class="fa-solid"></i>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email_confirmation">Confirmation de l'adresse mail</label>
                            <div class="input-with-icon">
                                <input type="email" name="email_confirmation" id="email_confirmation" class="form-control" required>
                                <i id="email_confirmation_icon" class="fa-solid"></i>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password">Mot de passe *</label>
                            <div class="input-with-icon">
                                <input type="password" name="password" id="password" class="form-control" autocapitalize="off" required>
                                <i id="password_icon" class="fa-solid"></i>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation">Confirmation du mot de passe</label>
                            <div class="input-with-icon">
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                                <i id="password_confirmation_icon" class="fa-solid"></i>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="name_surname">Nom et prénom *</label>
                            <div class="input-with-icon">
                                <input type="text" name="name_surname" id="name_surname" class="form-control" required>
                                <i id="name_surname_icon" class="fa-solid"></i>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="address">Adresse *</label>
                            <div class="input-with-icon">
                                <input type="text" name="address" id="address" class="form-control" required>
                                <i id="address_icon" class="fa-solid"></i>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="country">Pays</label>
                            <select class="selectpicker show-tick form-control" title="Sélectionnez un pays" name="country" id="country" data-live-search="true">
                                <?php foreach ($countries as $country) : ?>
                                    <option value="<?= $country['CDE_PAYS'] ?>"><?= $country['NOM_PAYS'] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="city">Localité *</label>
                            <select class="selectpicker show-tick form-control" data-live-search="true" title="Sélectionnez une ville" name="city" id="city">
                                <?php foreach ($cities as $city) : ?>
                                    <option value="<?= $city['ID_VILLE'] ?>" data-country="<?= $city['CDE_PAYS'] ?>"><?= $city['VILLE'] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>



                        <div class="form-check text-center">
                            <input type="checkbox" name="conditions" id="conditions" class="form-check-input" required>
                            <label for="conditions" class="form-check-label">J'accepte les conditions générales</label>
                        </div>

                        <hr>

                        <button type="submit" class="btn btn-primary btn-block" id="register_button">S'inscrire</button>
                        <hr>

                        <a href="<?= $router->url('login') ?>" class="btn btn-secondary btn-block">Annuler</a>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
<script src="https://kit.fontawesome.com/1e190d6f3a.js" crossorigin="anonymous"></script>
<script src="/src/JS/register/select.js"></script>
<script src="/src/JS/register/formValidation.js"></script>