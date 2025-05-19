<?php


class MySQLCarRepository implements CarRepositoryInterface
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function guardar(Car $car): void
    {
        $stmt = $this->pdo->prepare("INSERT INTO cars (patente, modelo, disponible, reservado, version) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$car->getPatente(), $car->getModelo(), $car->isDisponible(), $car->esReservado(), $car->getVersion()]);
    }

    public function buscarPorPatente(string $patente): ?Car
    {
        $stmt = $this->pdo->prepare("SELECT patente, modelo, disponible, reservado, version FROM cars WHERE patente = ?");
        $stmt->execute([$patente]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return new Car(
                $row['patente'],
                $row['modelo'],
                (bool) $row['disponible'],
                (bool) $row['reservado'],
                $row['version']
            );
        }

        return null;
    }

    public function actualizar(Car $car): void
    {
        $stmt = $this->pdo->prepare("UPDATE cars SET disponible = ?, reservado = ?, version = ? WHERE patente = ? AND version = ?");
        $stmt->execute([
            $car->isDisponible(),
            $car->esReservado(),
            $car->getVersion(),
            $car->getPatente(),
            $car->getVersion() - 1 // Condición de bloqueo optimista
        ]);

        if ($stmt->rowCount() == 0) {
            throw new Exception("Conflicto de concurrencia: Otro usuario ha modificado el auto.");
        }
    }
}