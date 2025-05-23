<?php

namespace Aplicacion;

use Dominio\Auto;
use Exception;
use Infraestructura\AutoRepositorio;

class ReservarAuto
{
    public function ejecutar(int $idUsuario, int $idAuto): void
    {
        $autoRepo = new AutoRepositorio();
        $auto = $autoRepo->obtenerPorId($idAuto);
        if (!$auto) {
            throw new Exception("Auto no encontrado.");
        }
        $auto->reservar();
        $autoRepo->actualizar($auto);
        // Aquí podrías agregar lógica para registrar la reserva en otra tabla si es necesario
    }
}
