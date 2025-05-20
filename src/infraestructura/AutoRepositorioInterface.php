<?php
interface AutoRepositorioInterface
{
    public function guardar(Auto $car): void;
    public function buscarPorPatente(string $patente): ?Auto;
    public function actualizar(Auto $auto): void;
}
