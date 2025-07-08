<?php 

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    // Nombre de la tabla en la base de datos
    protected $table = 'producto'; 

    // Clave primaria de la tabla
    protected $primaryKey = 'ID'; 

    // Indica si la clave primaria es auto-incremental
    protected $useAutoIncrement = true; 

    // Tipo de retorno para los resultados de la base de datos (array u objeto)
    protected $returnType = 'array'; 

    // Si se deben usar soft deletes (borrado lógico)
    protected $useSoftDeletes = false; 

    // Nombres de las columnas que se pueden llenar masivamente (desde el formulario)
    // Asegúrate de que estos nombres coincidan EXACTAMENTE con las columnas de tu DB
    protected $allowedFields = [
        'NOMBRE', 
        'DESCRIPCION', 
        'MARCA', 
        'IMAGEN', // Campo para la imagen (se guardará el nombre/ruta)
        'TALLA', 
        'LOTE', 
        'CANTIDAD', 
        'PRECIO', 
        'CATEGORIA', 
        'SUBCATEGORIA',
        'ID_USUARIO'
    ];

    // Si se deben agregar automáticamente las marcas de tiempo de creación y actualización
    protected $useTimestamps = false; // Tu tabla no tiene FECHA_CREACION/ACTUALIZACION para productos

    // Reglas de validación para la inserción/actualización de datos en el MODELO.
    // Estas deben ser consistentes con las del controlador y la DB.
    protected $validationRules = [
        'NOMBRE'       => 'required|max_length[45]', // Coincide con el controlador y DB
        'DESCRIPCION'  => 'permit_empty', // La descripción puede estar vacía
        'MARCA'        => 'required|max_length[15]', // Coincide con controlador y DB
        'IMAGEN'       => 'permit_empty|max_length[1000]', // <-- AJUSTADO: max_length para el nombre de archivo/ruta. 
        'TALLA'        => 'permit_empty|in_list[S,M,L,XL,XM,No aplica]', // Asegúrate de que coincida con tu ENUM
        'LOTE'         => 'permit_empty|max_length[15]', // Coincide con el controlador y DB
        'CANTIDAD'     => 'required|integer|greater_than_equal_to[0]',
        'PRECIO'       => 'required|decimal|greater_than[0]',
        'CATEGORIA'    => 'required|max_length[50]', // Coincide con el controlador y DB
        'SUBCATEGORIA' => 'required|max_length[70]', // Coincide con el controlador y DB
        'ID_USUARIO'   => 'required|integer'
    ];

    // Mensajes de error personalizados para las reglas de validación
    protected $validationMessages = [
        'NOMBRE' => [
            'required'   => 'El nombre del producto es obligatorio.',
            'max_length' => 'El nombre no puede exceder los 45 caracteres.'
        ],
        'MARCA' => [
            'required'   => 'La marca es obligatoria.',
            'max_length' => 'La marca no puede exceder los 15 caracteres.'
        ],
        'IMAGEN' => [
            'max_length' => 'La ruta de la imagen es demasiado larga.' // Nuevo mensaje para la imagen
        ],
        'TALLA' => [
            'in_list'    => 'La talla seleccionada no es válida.'
        ],
        'CANTIDAD' => [
            'required'              => 'La cantidad es obligatoria.',
            'integer'               => 'La cantidad debe ser un número entero.',
            'greater_than_equal_to' => 'La cantidad no puede ser negativa.'
        ],
        'PRECIO' => [
            'required'         => 'El precio de venta es obligatorio.',
            'decimal'          => 'El precio debe ser un número decimal.',
            'greater_than'     => 'El precio debe ser mayor que cero.'
        ],
        'CATEGORIA' => [
            'required'   => 'La categoría es obligatoria.',
            'max_length' => 'La categoría no puede exceder los 50 caracteres.'
        ],
        'SUBCATEGORIA' => [
            'required'   => 'La subcategoría es obligatoria.',
            'max_length' => 'La subcategoría no puede exceder los 70 caracteres.'
        ],
        'ID_USUARIO' => [ 
            'required' => 'El ID del usuario (vendedor) es obligatorio.',
            'integer'  => 'El ID del usuario (vendedor) debe ser un número entero.'
        ]
    ];

    // Callbacks que se ejecutan antes o después de ciertas operaciones
    protected $beforeInsert = [];
    protected $afterInsert = [];
    protected $beforeUpdate = [];
    protected $afterUpdate = [];
    protected $beforeFind = [];
    protected $afterFind = [];
    protected $afterDelete = [];
}