<?php
declare(strict_types=1);

namespace App\model;

class Libro
{
    private ?int $id;
    private string $isbn;
    private string $img;
    private string $titulo;
    private string $autor;
    private float $precio;
    private float $iva;
    private int $stock;
    private int $stock_lim;

    /**
     * @param int|null $id
     * @param string $isbn
     * @param string $img
     * @param string $titulo
     * @param string $autor
     * @param float $precio
     * @param float $iva
     * @param int $stock
     * @param int $stock_lim
     */
    public function __construct(?int $id, string $isbn, string $img, string $titulo, string $autor, float $precio, float $iva, int $stock, int $stock_lim)
    {
        $this->id = $id;
        $this->isbn = $isbn;
        $this->img = $img;
        $this->titulo = $titulo;
        $this->autor = $autor;
        $this->precio = $precio;
        $this->iva = $iva;
        $this->stock = $stock;
        $this->stock_lim = $stock_lim;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getIsbn(): string
    {
        return $this->isbn;
    }

    /**
     * @param string $isbn
     */
    public function setIsbn(string $isbn): void
    {
        $this->isbn = $isbn;
    }

    /**
     * @return string
     */
    public function getImg(): string
    {
        return $this->img;
    }

    /**
     * @param string $img
     */
    public function setImg(string $img): void
    {
        $this->img = $img;
    }

    /**
     * @return string
     */
    public function getTitulo(): string
    {
        return $this->titulo;
    }

    /**
     * @param string $titulo
     */
    public function setTitulo(string $titulo): void
    {
        $this->titulo = $titulo;
    }

    /**
     * @return string
     */
    public function getAutor(): string
    {
        return $this->autor;
    }

    /**
     * @param string $autor
     */
    public function setAutor(string $autor): void
    {
        $this->autor = $autor;
    }

    /**
     * @return float
     */
    public function getIva(): float
    {
        return $this->iva;
    }

    /**
     * @param float $iva
     */
    public function setIva(float $iva): void
    {
        $this->iva = $iva;
    }

    /**
     * @return float
     */
    public function getPrecio(): float
    {
        return $this->precio;
    }

    /**
     * @param float $precio
     */
    public function setPrecio(float $precio): void
    {
        $this->precio = $precio;
    }

    /**
     * @return int
     */
    public function getStock(): int
    {
        return $this->stock;
    }

    /**
     * @param int $stock
     */
    public function setStock(int $stock): void
    {
        $this->stock = $stock;
    }

    /**
     * @return int
     */
    public function getStockLim(): int
    {
        return $this->stock_lim;
    }

    /**
     * @param int $stock_lim
     */
    public function setStockLim(int $stock_lim): void
    {
        $this->stock_lim = $stock_lim;
    }


}