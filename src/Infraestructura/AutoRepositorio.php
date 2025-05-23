<?php

namespace Infraestructura;

use Core\Conexion;
use Dominio\Auto;
use PDO;
use PDOException;

class AutoRepositorio
{

    public function __construct() {}

    public function actualizar(Auto $auto): void
    {
        $pdo = Conexion::getPDOConnection();
        $stmt = $pdo->prepare("
            UPDATE auto 
            SET estado = :estado, version = :nueva_version
            WHERE id = :id AND version = :version_actual
        ");


        $stmt->execute([
            'estado' => $auto->getEstado(),
            'nueva_version' => $auto->getVersion(),
            'id' => $auto->getId(),
            'version_actual' => $auto->getVersion() - 1
        ]);

        if ($stmt->rowCount() === 0) {
            throw new \Exception("Conflicto de concurrencia: el auto fue modificado por otro proceso.");
        }
    }

    public function obtenerPorId(int $id): ?Auto
    {
        $pdo = Conexion::getPDOConnection();
        $sql = "SELECT  id, patente,marca,modelo,estado FROM auto WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) return null;

        $auto = self::arrayToAuto($row);
        return $auto;
    }
    public function agregar(Auto $auto): bool
    {
        $result = false;
        $pdo = null;
        try {
            $pdo = Conexion::getPDOConnection();
            $stmt = $pdo->prepare("
                INSERT INTO auto (patente, modelo, estado, version) 
                VALUES (:patente, :modelo, :estado, :version)
            ");

            $result = $stmt->execute([
                'patente' => $auto->getPatente(),
                'modelo' => $auto->getModelo(),
                'estado' => $auto->getEstado(),
                'version' => $auto->getVersion()
            ]);
            return $result;
        } catch (PDOException $e) {
            error_log("Error al agregar auto: " . $e->getMessage());
            throw new \Exception("Error al agregar auto.");
        } finally {
            $stmt = null;
            $pdo = null;
        }
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
    public static function listarDisponibles(): array
    {
        $pdo = null;
        $stmt = null;
        $autos = [];
        try {
            $pdo = Conexion::getPDOConnection();
            $sql = "SELECT id, patente,marca,modelo,estado, version FROM auto WHERE estado = 'disponible'";
            $stmt = $pdo->query($sql);
            while ($row = $stmt->fetch()) {
                $auto = self::arrayToAuto($row);
                $autos[] = $auto;
            }
            return $autos;
        } catch (PDOException $e) {
            error_log("Error al obtener autos disponibles: " . $e->getMessage());
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
            $row['version'] ?? 0,
            $row['id']
        );
    }
}
