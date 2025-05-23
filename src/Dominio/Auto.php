<?php

namespace Dominio;

class Auto
{
    private int $id;
    private string $patente;
    private string $modelo;
    private string $estado;
    private int $version;

    public function __construct(string $patente, string $modelo, string $estado = 'disponible', int $version = 0, ?int $id = null)
    {
        $this->patente = $patente;
        $this->modelo = $modelo;
        $this->estado = $estado;
        $this->version = $version;
        $this->id = $id ?? 0;
    }

    public function reservar(): void
    {
        if ($this->estado !== 'disponible') {
            throw new \Exception("El auto no está disponible.");
        }
        $this->estado = 'reservado';
        $this->version++;
    }

    public function getId(): int
    {
        return $this->id;
    }
    public function getPatente(): string
    {
        return $this->patente;
    }
    public function getModelo(): string
    {
        return $this->modelo;
    }
    public function getEstado(): string
    {
        return $this->estado;
    }
    public function getVersion(): int
    {
        return $this->version;
    }
}
