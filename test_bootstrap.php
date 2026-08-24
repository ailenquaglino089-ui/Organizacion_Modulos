<?php
// Diagnóstico de carga del bootstrap y sus dependencias.
// Carga el arranque completo para comprobar que sus dependencias no fallan.
require_once __DIR__ . '/core/bootstrap.php';

// Solo se imprime si bootstrap.php terminó correctamente.
echo 'Bootstrap OK';
