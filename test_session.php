<?php
// Diagnóstico de creación y lectura de sesiones PHP.
// Comprueba que PHP pueda iniciar o recuperar una sesión.
session_start();

// Solo se imprime si session_start() no produjo un error.
echo 'Session works!';
