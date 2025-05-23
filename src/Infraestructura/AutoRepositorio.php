<?php

namespace Infraestructura;

use Core\Conexion;
use Dominio\Auto;
use PDO;
use PDOException;

class AutoRepositorio
{

    public function __construct() {}

    public function obtenerPorId(int $id): ?Auto
    {
        $pdo = Conexion::getPDOConnection();
        $sql = "SELECT * FROM auto WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) return null;

        return new Auto(
            $row['patente'],
            $row['modelo'],
            $row['estado'],
            $row['version'],
            $row['id']
        );
    }

    public function actualizar(Auto $auto): void
    {
        $pdo = Conexion::getPDOConnection();
        $stmt = $pdo->prepare("
            UPDATE auto 
            SET estado = ?, version = ?
            WHERE id = ?
        ");
        $stmt->execute([
            $auto->getEstado(),
            $auto->getVersion(),
            $auto->getId()
        ]);
    }
    public static function listar(): array
    {
        $pdo = null;
        $stmt = null;
        try {
            $pdo = Conexion::getPDOConnection();
            $sql = "SELECT id, patente,marca,modelo,estado, version FROM auto";
            $stmt = $pdo->query($sql);
            while ($row = $stmt->fetch()) {
                $auto = self::arrayToAuto($row);
                $autos[] = $auto;
            }
            //retornar los autos
            return $autos;
        } catch (PDOException $e) {
            error_log("Error al obtener autos: " . $e->getMessage());
            return [];
        } finally {
            $stmt = null;
            $pdo = null;
        }
    }
    private static function arrayToAuto(array $row): Auto
    {
        return new Auto(
            $row['patente'],
            $row['modelo'],
            $row['estado'],
            $row['version'],
            $row['id']
        );
    }
}
