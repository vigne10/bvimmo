<?php

use App\Attachment\PropertyAttachment;
use App\Auth;
use App\DBconnection;
use App\Table\PropertyTable;

Auth::checkAccess();

$pdo = DBconnection::getPDO();
$table = new PropertyTable($pdo);
$property = $table->findByID($params['id']);
PropertyAttachment::detach($property); // Delete the associated image
$table->delete($params['id']); // Delete the property in database

header('Location: ' . $router->url('properties') . '?delete=1'); // Redirects to the properties page
