<?php

namespace Dominio;

class Venta
{
    private int $id;
    private Auto $auto;
    private Usuario $vendedor;
    private \DateTime $fechaVenta;
    private  float $precio;

    public function __construct(Auto $auto, Usuario $vendedor, ?\DateTime $fechaVenta = null, ?int $id = null, $precio)
    {
        $this->auto = $auto;
        $this->vendedor = $vendedor;
        $this->fechaVenta = $fechaVenta ?? new \DateTime();
        $this->id = $id ?? 0;
        $this->precio = $precio;
    }

    public function getId(): int
    {
        return $this->id;
    }
    public function getAuto(): Auto
    {
        return $this->auto;
    }
    public function getVendedor(): Usuario
    {
        return $this->vendedor;
    }
    public function getFechaVenta(): \DateTime
    {
        return $this->fechaVenta;
    }

    public function getIdAuto(): int
    {
        return $this->auto->getId();
    }

    public function getIdVendedor(): int
    {
        return $this->vendedor->getId();
    }
    public function getFecha(): \DateTime
    {
        return $this->fechaVenta;
    }
    public function getPrecio(): float
    {
        return $this->precio;
    }
}
