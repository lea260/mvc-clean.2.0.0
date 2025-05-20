<?php

namespace App\Applicacion;

use App\Dominio\Auto;
use App\Infraestructura\AutoRepositorio;
// require_once 'Dominio/Auto.php';       // Importante: Incluir la clase Auto
// require_once 'Infraestructura/AutoRepository.php'; // Incluir el repositorio

class AgregarAutoUseCase
{
    private AutoRepositorio $autoRepository;

    public function __construct(AutoRepositorio $autoRepository)
    {
        $this->autoRepository = $autoRepository;
    }

    public function agregarAuto(Auto $auto): bool
    {
        // Aquí podrías agregar más lógica de negocio antes de la persistencia
        // Por ejemplo, verificar si ya existe un auto con la misma marca y modelo

        return $this->autoRepository->guardar($auto);
    }
}
