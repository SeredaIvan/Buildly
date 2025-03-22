<?php
var_dump($_SESSION['user']);
echo "Core session get <br>";
var_dump(\core\Core::getInstance()->session->get('user'));
echo "<br>";
echo "Users->GetUser";
var_dump(\models\User::GetUser());
echo "IsLogged<br>";
echo \models\User::IsLogged();
echo "<br>User name<br>";
echo \models\User::GetUser()->name;
echo "<br>User id<br>";
echo \models\User::GetUser()->id;