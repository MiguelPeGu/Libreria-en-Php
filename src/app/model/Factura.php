<?php
declare(strict_types=1);
namespace App\model;

use DateTime;

class Factura
{
    private string $idFactura;
    private int $idUsuario;
    private string $fecha;
    private string $dni;
    private string $nombre;
    private string $apellidos;
    private string $telefono;
    private string $direccion;
    private int $cp;
    private string $localidad;
    private float $total;
    private string $metodoPago;
    
    public function __construct(string $idFactura, int $idUsuario, string $fecha, string $dni, string $nombre, string $apellidos, string $telefono, string $direccion, int $cp, string $localidad, float $total, string $metodoPago){$this->idFactura = $idFactura;$this->idUsuario = $idUsuario;$this->fecha = $fecha;$this->dni = $dni;$this->nombre = $nombre;$this->apellidos = $apellidos;$this->telefono = $telefono;$this->direccion = $direccion;$this->cp = $cp;$this->localidad = $localidad;$this->total = $total;$this->metodoPago = $metodoPago;}
	
    public function getIdFactura(): string {return $this->idFactura;}

	public function getIdUsuario(): int {return $this->idUsuario;}

	public function getFecha(): string {return $this->fecha;}

	public function getDni(): string {return $this->dni;}

	public function getNombre(): string {return $this->nombre;}

	public function getApellidos(): string {return $this->apellidos;}

	public function getTelefono(): string {return $this->telefono;}

	public function getDireccion(): string {return $this->direccion;}

	public function getCp(): int {return $this->cp;}

	public function getLocalidad(): string {return $this->localidad;}

	public function getTotal(): float {return $this->total;}

	public function getMetodoPago(): string {return $this->metodoPago;}

	public function setIdFactura(string $idFactura): void {$this->idFactura = $idFactura;}

	public function setIdUsuario(int $idUsuario): void {$this->idUsuario = $idUsuario;}

	public function setFecha(string $fecha): void {$this->fecha = $fecha;}

	public function setDni(string $dni): void {$this->dni = $dni;}

	public function setNombre(string $nombre): void {$this->nombre = $nombre;}

	public function setApellidos(string $apellidos): void {$this->apellidos = $apellidos;}

	public function setTelefono(string $telefono): void {$this->telefono = $telefono;}

	public function setDireccion(string $direccion): void {$this->direccion = $direccion;}

	public function setCp(int $cp): void {$this->cp = $cp;}

	public function setLocalidad(string $localidad): void {$this->localidad = $localidad;}

	public function setTotal(float $total): void {$this->total = $total;}

	public function setMetodoPago(string $metodoPago): void {$this->metodoPago = $metodoPago;}

	
    
public static function crearIdFactura(int $idUsuario) : string
{
    $fecha = new DateTime();
    $cadena = $fecha->format("Y-m-d H:i:s");

    $cadenaSinSimbolos = str_replace(["-", ":", " "], "", $cadena);

    $invertido = strrev($cadenaSinSimbolos);

    $idFactura = $idUsuario . $invertido;

    return $idFactura;
}



}