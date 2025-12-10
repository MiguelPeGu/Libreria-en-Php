<?php
declare(strict_types=1);
namespace App\model;

class Factura_Detalles
{
    private ?int $idDetalle;
    private string $idFactura;
    private int $idLibro;
    private int $cantidad;
    private float $precioUd;
    private float $subtotal;
    private float $iva;
    private float $totalLinea;

    public function __construct(?int $idDetalle, string $idFactura, int $idLibro, int $cantidad, float $precioUd, float $subtotal, float $iva, float $totalLinea){$this->idDetalle = $idDetalle;$this->idFactura = $idFactura;$this->idLibro = $idLibro;$this->cantidad = $cantidad;$this->precioUd = $precioUd;$this->subtotal = $subtotal;$this->iva = $iva;$this->totalLinea = $totalLinea;}
	
    public function setIdDetalle(int $idDetalle): void {$this->idDetalle = $idDetalle;}

	public function setIdFactura(string $idFactura): void {$this->idFactura = $idFactura;}

	public function setIdLibro(int $idLibro): void {$this->idLibro = $idLibro;}

	public function setCantidad(int $cantidad): void {$this->cantidad = $cantidad;}

	public function setPrecioUd(float $precioUd): void {$this->precioUd = $precioUd;}

	public function setSubtotal(float $subtotal): void {$this->subtotal = $subtotal;}

	public function setIva(float $iva): void {$this->iva = $iva;}

	public function setTotalLinea(float $totalLinea): void {$this->totalLinea = $totalLinea;}

	public function getIdDetalle(): int {return $this->idDetalle;}

	public function getIdFactura(): string {return $this->idFactura;}

	public function getIdLibro(): int {return $this->idLibro;}

	public function getCantidad(): int {return $this->cantidad;}

	public function getPrecioUd(): float {return $this->precioUd;}

	public function getSubtotal(): float {return $this->subtotal;}

	public function getIva(): float {return $this->iva;}

	public function getTotalLinea(): float {return $this->totalLinea;}

	


}