<?php
require __DIR__.'/bootstrap/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';

$users = App\Models\User::all();
foreach($users as $u){
    echo $u->id.' '.$u->name.' '.$u->email.' Guardian:';
    if($u->guardian){
        echo $u->guardian->id.' Name:'.$u->guardian->name;
    }else{
        echo 'null';
    }
    echo PHP_EOL;
}
