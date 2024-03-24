<?php
session_start();

// Datos de usuarios autorizados
$USERS = [
    'admin' => 'Admin1234',
    'user01' => 'user01'
];

// Función para autenticar al usuario
function authenticate_user($username, $password)
{
    global $USERS;
    if (isset($USERS[$username]) && $USERS[$username] === $password) {
        $_SESSION['authenticated'] = true;
        $_SESSION['username'] = $username;
        return true;
    }
    return false;
}

// Función para verificar si el usuario está autenticado
function is_authenticated()
{
    return isset($_SESSION['authenticated']) && $_SESSION['authenticated'] === true;
}

// Función para obtener los datos del usuario autenticado
function get_authenticated_user()
{
    global $USERS;
    $username = $_SESSION['username'];
    $role = ($username === 'admin') ? 'admin' : 'user';
    return ['username' => $username, 'role' => $role];
}

// Función para cerrar sesión
function logout()
{
    session_destroy();
}
?>
