<?php

use App\Auth;
use App\DBconnection;
use App\Exception\Table\NotFoundException;
use App\Table\UserTable;
use App\Exception\Security\LoginErrorException;

Auth::checkAlreadyLogged();

$title = 'Mon site - Connexion';
$mainLink = $router->url('login');

if (!empty($_POST['email']) && !empty($_POST['password'])) {
  $table = new UserTable(DBconnection::getPDO());
  try {
    $user = $table->findByEmail($_POST['email']);
    if (password_verify($_POST['password'], $user->getPassword())) {
      $_SESSION['auth'] = $user->getId();
      $_SESSION['name'] = $user->getNameSurname();
      header('Location: ' . $router->url('properties'));
      exit();
    } else {
      throw new LoginErrorException();
    }
  } catch (NotFoundException) {
    header('Location: ' . $this->url('login') . '?unknownUser=1');
    exit();
  } catch (LoginErrorException) {
    header('Location: ' . $this->url('login') . '?loginError=1');
    exit();
  }
}
?>

<?php if (isset($_GET['forbidden'])) : ?>
  <div class="alert alert-danger">
    Vous ne pouvez pas accéder à cette page.
  </div>
<?php endif ?>

<?php if (isset($_GET['unknownUser'])) : ?>
  <div class="alert alert-danger">
    Cet utilisateur n'existe pas ! Veuillez vous inscrire.
  </div>
<?php endif ?>

<?php if (isset($_GET['loginError'])) : ?>
  <div class="alert alert-danger">
    Email ou mot de passe incorrect !
  </div>
<?php endif ?>



<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">
      <div class="card">
        <div class="card-header text-center bg-primary text-white">
          <h4>Authentification</h4>
        </div>
        <div class="card-body">
          <form action="<?= $router->url('login') ?>" method="post">
            <div class="form-group">
              <label for="email">Adresse mail</label>
              <input type="email" name="email" id="email" class="form-control" required>
            </div>
            <div class="form-group">
              <label for="password">Mot de passe</label>
              <input type="password" name="password" id="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block" id="loginButton" disabled>Se connecter</button>
          </form>
          <hr>
          <p class="text-center">Vous n'avez pas de compte ?</p>
          <a href="<?= $router->url('register') ?>" class="btn btn-secondary btn-block">S'inscrire</a>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="/src/JS/login/login.js"></script>