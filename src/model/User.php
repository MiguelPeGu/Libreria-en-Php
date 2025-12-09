<?php
declare(strict_types=1);
namespace App\model;

class User
{
    private ?int $id;
    private string $usuario;
    private string $passwd;


    public function __construct(?int $id, string $usuario, string $passwd)
    {
        $this->id = $id;
        $this->usuario = $usuario;
        $this->passwd = $passwd;
    }


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
    public function getUsuario(): string
    {
        return $this->usuario;
    }

    /**
     * @param string $usuario
     */
    public function setUsuario(string $usuario): void
    {
        $this->usuario = $usuario;
    }

    /**
     * @return string
     */
    public function getPasswd(): string
    {
        return $this->passwd;
    }

    /**
     * @param string $passwd
     */
    public function setPasswd(string $passwd): void
    {
        $this->passwd = $passwd;
    }
}