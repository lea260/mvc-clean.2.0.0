<?php

// src/Dominio/Auto.php
// La clase Auto permanece similar, pero ajustamos el namespace

class Auto
{
    private ?int $id; // Añadido para la base de datos
    private string $marca;
    private string $modelo;
    private string $fechaCompra;

    public function __construct(string $marca, string $modelo, string $fechaCompra, ?int $id = null)
    {
        $this->marca = $marca;
        $this->modelo = $modelo;
        $this->fechaCompra = $fechaCompra;
        $this->id = $id;
       
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMarca(): string
    {
        return $this->marca;
    }

    public function getModelo(): string
    {
        return $this->modelo;
    }

    public function getFechaCompra(): string
    {
        return $this->fechaCompra;
    }

    public function validarFechaCompra(): void
    {
        $formato = 'Y-m-d';
        $fecha = DateTime::createFromFormat($formato, $this->fechaCompra);

        if (!($fecha && $fecha->format($formato) == $this->fechaCompra)) {
            throw new Exception("Formato de fecha de compra inválido (debe ser YYYY-MM-DD).");
        }
    }

    public function toArray(): array {
        return [
            'Marca' => $this->marca,
            'Modelo' => $this->modelo,
            'Fecha_Compra' => $this->fechaCompra
        ];
    }
}

// src/Aplication/AgregarAutoUseCase.php
// Caso de uso para agregar un auto

require_once 'Dominio/Auto.php';       // Importante: Incluir la clase Auto
require_once 'Infraestructura/AutoRepository.php'; // Incluir el repositorio

class AgregarAutoUseCase
{
    private AutoRepository $autoRepository;

    public function __construct(AutoRepository $autoRepository)
    {
        $this->autoRepository = $autoRepository;
    }

    public function agregarAuto(Auto $auto): bool
    {
        // Aquí podrías agregar más lógica de negocio antes de la persistencia
        // Por ejemplo, verificar si ya existe un auto con la misma marca y modelo

        return $this->autoRepository->insertar($auto);
    }
}

// src/Infraestructura/AutoRepository.php
// Clase que interactúa con la base de datos

require_once 'encore/Conexion.php'; // Incluir la clase Conexion
require_once 'Dominio/Auto.php';

use PDO;
use Exception;

class AutoRepository
{
    public function insertar(Auto $auto): bool
    {
        $pdo = null;
        $stmt = null;
        try {
            $pdo = Conexion::getPDOConnection();
            $sql = "INSERT INTO lanzamientosmodelos (Marca, Modelo, Fecha_Compra) VALUES (:marca, :modelo, :fechaCompra)";
            $stmt = $pdo->prepare($sql);

            // Vincular parámetros
            $params = $auto->toArray();
            $stmt->bindParam(':marca', $params['Marca'], PDO::PARAM_STR);
            $stmt->bindParam(':modelo', $params['Modelo'], PDO::PARAM_STR);
            $stmt->bindParam(':fechaCompra', $params['Fecha_Compra'], PDO::PARAM_STR);

            return $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Error al insertar el auto: " . $e->getMessage());
        } finally {
            if ($stmt) $stmt = null;
            if ($pdo) Conexion::cerrar();
        }
    }

    public function obtenerPorId(int $id): ?Auto
    {
        $pdo = null;
        $stmt = null;
        try {
            $pdo = Conexion::getPDOConnection();
            $sql = "SELECT id, Marca, Modelo, Fecha_Compra FROM lanzamientosmodelos WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row) {
                return new Auto(
                    $row['Marca'],
                    $row['Modelo'],
                    $row['Fecha_Compra'],
                    $row['id']
                );
            }
            return null;
        } catch (PDOException $e) {
            throw new Exception("Error al obtener el auto: " . $e->getMessage());
        } finally {
            if ($stmt) $stmt = null;
            if ($pdo) Conexion::cerrar();
        }
    }

    // Otros métodos del repositorio (actualizar, eliminar, etc.)
}

// Ejemplo de uso (en un archivo separado, por ejemplo, agregar_auto.php)
require_once 'config/config.php'; // Asegúrate de que la ruta sea correcta
require_once 'Dominio/Auto.php';
require_once 'Aplication/AgregarAutoUseCase.php';
require_once 'Infraestructura/AutoRepository.php';
require_once 'encore/Conexion.php';

try {
    $auto = new Auto("Toyota", "Corolla", "2024-10-25");
    $autoRepository = new AutoRepository();
    $agregarAutoUseCase = new AgregarAutoUseCase($autoRepository);

    if ($agregarAutoUseCase->agregarAuto($auto)) {
        echo "Auto agregado con éxito.\n";
    } else {
        echo "No se pudo agregar el auto.\n";
    }

    $autoObtenido = $autoRepository->obtenerPorId(1); // Ejemplo de obtener por ID
    if ($autoObtenido) {
        echo "Auto obtenido: \n";
        echo "Marca: " . $autoObtenido->getMarca() . "\n";
        echo "Modelo: " . $autoObtenido->getModelo() . "\n";
        echo "Fecha de Compra: " . $autoObtenido->getFechaCompra() . "\n";
    } else {
        echo "Auto no encontrado.\n";
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>