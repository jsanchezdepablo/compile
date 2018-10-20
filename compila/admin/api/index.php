<?php

include_once './epiphany/src/Epi.php';

include_once './path/usuario/usuario.php';


include_once './path/home/home.php';

chdir('.');
Epi::setPath('base', './epiphany/src');
Epi::setPath('config', dirname(__FILE__));
Epi::setSetting('exceptions', true);
Epi::init('route','database','api');
EpiDatabase::employ('mysql', 'elrinco7_compila', '127.0.0.1', 'root', '');

getDatabase()->execute("SET NAMES 'utf8'");

getRoute()->load('routes.ini');

getRoute()->load('path/usuario/routes.ini');


getRoute()->run();
?>
