<?php 
interface AutoRepositorioInterface
{
    public function guardar(Car $car): void;
    public function buscarPorPatente(string $patente): ?Car;
    public function actualizar(Car $car): void;
}   