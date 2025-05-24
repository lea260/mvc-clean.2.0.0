<?php

namespace Aplicacion;

use Dominio\Venta;
use Exception;
use Infraestructura\AutoRepositorio;
use Infraestructura\UsuarioRepositorio;
use Infraestructura\VentaRepositorio;
use PDO;

class RegistrarVenta
{
    private VentaRepositorio $ventaRepo;
    private AutoRepositorio $autoRepo;
    private UsuarioRepositorio $usuarioRepo;
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->ventaRepo = new VentaRepositorio($pdo);
        $this->autoRepo = new AutoRepositorio($pdo);
        $this->usuarioRepo = new UsuarioRepositorio($pdo);
    }

    public function ejecutar(int $idAuto, int $idVendedor): void
    {
        $this->pdo->beginTransaction();

        try {
            $auto = $this->autoRepo->obtenerPorId($idAuto);
            $vendedor = $this->usuarioRepo->obtenerPorId($idVendedor);

            if (!$auto || !$vendedor) {
                throw new Exception("Auto o usuario no encontrado.");
            }

            if ($auto->getEstado() !== 'disponible') {
                throw new Exception("El auto no está disponible para vender.");
            }

            // Lógica de negocio
            $auto->vender();
            $this->autoRepo->actualizar($auto);

            $venta = new Venta($auto, $vendedor);
            $this->ventaRepo->registrar($venta);

            $this->pdo->commit();
        } catch (Exception $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }
}
