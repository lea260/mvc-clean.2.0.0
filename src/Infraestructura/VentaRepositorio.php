<?php

namespace Infraestructura;

use Dominio\Venta;
use PDO;

class VentaRepositorio
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function registrar(Venta $venta): bool
    {

        $stmt = $this->pdo->prepare("
            INSERT INTO venta (id_auto, id_vendedor, fecha_venta, precio)
            VALUES (?, ?, ?, ?)
        ");
        return $stmt->execute([
            $venta->getAuto()->getId(),
            $venta->getVendedor()->getId(),
            $venta->getFechaVenta()->format('Y-m-d H:i:s'),
            $venta->getPrecio()
        ]);
    }
}
