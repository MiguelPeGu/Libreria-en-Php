<?php
declare (strict_types = 1);
namespace App\model;
use ArrayIterator;
use Countable;
use Traversable;
use IteratorAggregate;
class Carrito implements IteratorAggregate, Countable
{
    private array $items =[];

    public function alCarrito(Libro $libro): void{
        $this->items[]=$libro;
    }

    public function verCarrito(): array{
        return $this->items;
    }

    public function getIterator(): Traversable{
        return new ArrayIterator($this->items);
    }
    public function count(): int{
        return count($this->items);
    }


    public function contarLibro(int $id): int {
        $cantidad = 0;
        foreach ($this->items as $libro) {
            if ($libro->getId() === $id) {
                $cantidad++;
            }
        }
        return $cantidad;
    }

    public function sumarLibro(Libro $libro): void {
        $this->items[] = $libro;
    }

    public function restarLibro(int $id): void {
        foreach ($this->items as $key => $libro) {
            if ($libro->getId() === $id) {
                unset($this->items[$key]);
                break; 
            }
        }
        $this->items = array_values($this->items);
    }

    public function eliminarTodos(int $id): void {
        foreach ($this->items as $key => $libro) {
            if ($libro->getId() === $id) {
                unset($this->items[$key]);
            }
        }
        $this->items = array_values($this->items);
    }


}