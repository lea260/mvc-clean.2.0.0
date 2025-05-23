<?php

namespace Aplicacion;

use Dominio\Auto;
use Exception;
use Infraestructura\AutoRepositorio;
use Infraestructura\UsuarioRepositorio;
use PDO;

class ReservarAuto
{
    private PDO $pdo;
    private AutoRepositorio $autoRepo;
    private UsuarioRepositorio $usuarioRepo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->autoRepo = new AutoRepositorio($pdo);
        $this->usuarioRepo = new UsuarioRepositorio($pdo);
    }

    public function ejecutar(int $idUsuario, int $idAuto): void
    {
        $this->pdo->beginTransaction();

        try {
            $usuario = $this->usuarioRepo->obtenerPorId($idUsuario);
            $auto = $this->autoRepo->obtenerPorId($idAuto);

            if (!$usuario) {
                throw new Exception("Usuario no encontrado.");
            }

            if (!$auto) {
                throw new Exception("Auto no encontrado.");
            }

            $auto->reservar();

            $stmt = $this->pdo->prepare("INSERT INTO reserva (id_usuario, id_auto) VALUES (?, ?)");
            $stmt->execute([$usuario->getId(), $auto->getId()]);

            $this->autoRepo->actualizar($auto);

            $this->pdo->commit();
        } catch (Exception $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }
};
