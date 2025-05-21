<?php

namespace Applicacion;

use Infraestructura\AutoRepositorio;

class ListarAuto
{
    public function listar()
    {
        $repo = new AutoRepositorio();
        return $repo->listar();
    }
}
