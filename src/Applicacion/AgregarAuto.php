<?php

namespace Applicacion;

use Dominio\Auto;
use Infraestructura\AutoRepositorio;

class AgregarAuto
{
    public function agregar(Auto $auto): bool
    {
        $repo = new AutoRepositorio();
        $auto->validar();
        $result = $repo->agregar($auto);
        return $result;
    }
}
