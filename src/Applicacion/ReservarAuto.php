<?php

namespace Applicacion;

use Dominio\Auto;
use Exception;
use Infraestructura\AutoRepositorio;

class ReservarAuto
{
    public function ejecutar(int $idUsuario, int $idAuto): void
    {
        try {
            $autoRepo = new AutoRepositorio();
            $auto = $autoRepo->obtenerPorId($idAuto);
            if (!$auto) {
                throw new Exception("Auto no encontrado.");
            }
            $auto->reservar();
            $autoRepo->actualizar($auto);
        } catch (Exception $e) {
            throw $e;
        }
    }
}
