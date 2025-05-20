<?php

namespace App\Dominio;

use Exception;

class Auto
{
    private string $patente;
    private string $modelo;
    private bool $disponible;
    private bool $reservado;
    private ?int $version; // Para bloqueo optimista

    public function __construct(string $patente, string $modelo, bool $disponible = true, bool $reservado = false, ?int $version = 0)
    {
        $this->patente = $patente;
        $this->modelo = $modelo;
        $this->disponible = $disponible;
        $this->reservado = $reservado;
        $this->version = $version;
    }

    public function getPatente(): string
    {
        return $this->patente;
    }

    public function getModelo(): string
    {
        return $this->modelo;
    }

    public function isDisponible(): bool
    {
        return $this->disponible;
    }

    public function esReservado(): bool
    {
        return $this->reservado;
    }

    public function getVersion(): ?int
    {
        return $this->version;
    }

    public function reservar(): void
    {
        if (!$this->disponible) {
            throw new Exception("El auto no está disponible para reservar.");
        }
        if ($this->reservado) {
            throw new Exception("El auto ya está reservado.");
        }
        $this->disponible = false;
        $this->reservado = true;
    }

    public function cancelarReserva(): void
    {
        $this->reservado = false;
        $this->disponible = true;
    }

    public function vender(): void
    {
        if ($this->reservado) {
            throw new Exception("No se puede vender un auto reservado.");
        }
        $this->disponible = false;
    }

    public function validarPatente(): void
    {
        // Simple validación de formato (puedes usar una librería más robusta)
        if (!preg_match("/^[A-Z]{3}[0-9]{3}$/", $this->patente)) {
            throw new Exception("Formato de patente inválido.");
        }
    }

    public function validar(): void
    {
        if (empty($this->patente) || empty($this->modelo)) {
            throw new Exception("La patente y el modelo son obligatorios.");
        }
        $this->validarPatente();
    }

    public function incrementarVersion(): void
    {
        $this->version++;
    }
}
