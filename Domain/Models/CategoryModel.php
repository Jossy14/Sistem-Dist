<?php

class CategoryModel
{
    private $codigo;
    private $nombre_categoria;
    private $descripcion;
    private $fecha_creacion;
    private $estado;
    private $id_padre;
    private $imagen;
    private $orden;

    public function __construct(
        string $codigo,
        string $nombre_categoria,
        string $descripcion,
        string $fecha_creacion,
        string $estado,
        string $id_padre,
        string $imagen,
        string $orden
    ) {
        
        $nombre_categoria = trim($nombre_categoria);
        $descripcion = trim($descripcion);
        
        $estado = trim($estado);
        
        
        $orden = trim($orden);

        // if (empty($codigo)) {
        //     throw new InvalidArgumentException("El Código es requerido.");
        // }

        // if (empty($nombre_categoria)) {
        //     throw new InvalidArgumentException("La categoría es requerida.");
        // }

        // if (empty($descripcion)) {
        //     throw new InvalidArgumentException("La descripción es requerida.");
        // }

        // if (empty($fecha_creacion)) {
        //     throw new InvalidArgumentException("La fecha de creación es requerida.");
        // }

        // if (empty($estado)) {
        //     throw new InvalidArgumentException("El estado es requerido.");
        // }

        // if (empty($orden)) {
        //     throw new InvalidArgumentException("El orden es requerido.");
        // }

        $this->codigo = $codigo;
        $this->nombre_categoria = $nombre_categoria;
        $this->descripcion = $descripcion;
        $this->fecha_creacion = $fecha_creacion; // Inicializa fecha_creacion
        $this->estado = $estado;
        $this->id_padre = $id_padre;
        $this->imagen = $imagen;
        $this->orden = $orden;
    }

    // Getter y Setter para codigo
    public function getCodigo() {
        return $this->codigo;
    }
    public function setCodigo($codigo) {
        $this->codigo = $codigo;
    }

    // Getter y Setter para nombre_categoria
    public function getNombre_categoria() {
        return $this->nombre_categoria;
    }
    public function setNombre_categoria($nombre_categoria) {
        $this->nombre_categoria = $nombre_categoria;
    }

    // Getter y Setter para descripcion
    public function getDescripcion() {
        return $this->descripcion;
    }
    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    // Getter y Setter para fecha_creacion
    public function getFecha_creacion() {
        return $this->fecha_creacion;
    }
    public function setFecha_creacion($fecha_creacion) {
        $this->fecha_creacion = $fecha_creacion;
    }

    // Getter y Setter para estado
    public function getEstado() {
        return $this->estado;
    }
    public function setEstado($estado) {
        $this->estado = $estado;
    }

    // Getter y Setter para id_padre
    public function getId_padre() {
        return $this->id_padre;
    }
    public function setId_padre($id_padre) {
        $this->id_padre = $id_padre;
    }

    // Getter y Setter para imagen
    public function getImagen() {
        return '/"C:/Users/Josia/Downloads"/' . $this->imagen; 
    }
    public function setImagen($imagen) {
        $this->imagen = $imagen;
    }

    // Getter y Setter para orden
    public function getOrden() {
        return $this->orden;
    }
    public function setOrden($orden) {
        $this->orden = $orden;
    }
}
