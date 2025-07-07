<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * Este modelo UsuarioModel; será la interfaz entre nuestra aplicación del codeigniter y
 * nuestra tabla usuario en la base de datos :D
 */

class UsuarioModel extends Model
{
    // Define el nombre de la tabla de la base de datos a la que este modelo está asociado.
    protected $table = 'usuario';

    // Define el nombre de la columna que es la clave primaria de la tabla.
    // CodeIgniter usa esto para operaciones como find(), update(), delete().
    protected $primaryKey = 'ID_USUARIO';

    // Indica si el campo $primaryKey es auto-incrementable.
    protected $useAutoIncrement = true;

    // Define el tipo de dato que se espera que retorne el método find().
    // 'array' para array asociativo, 'object' para objeto.
    protected $returnType = 'array';

    // Si se deben usar soft deletes (borrado lógico en lugar de físico).
    // true si tienes una columna 'deleted_at' en tu tabla.
    protected $useSoftDeletes = false; // No necesitamos esto para el registro

    // Lista de campos (columnas) que se pueden insertar o actualizar
    // a través del modelo.
    // ¡Es CRÍTICO incluir solo los campos que quieres permitir desde el formulario!
    protected $allowedFields = [
        'CORREO_USUARIO',
        'CONTRASENA', // Aquí guardaremos la contraseña hasheada
        'NOMBRE_USUARIO',
        'APELLIDO_USUARIO',
        'TEL_USUARIO',
        'ROL_ID_ROL', // Este será el ID del rol (ej. 1 para comprador, 2 para vendedor)
        'TIPO_DOCUMENTO', // Estos dos son NULLABLE ahora, por lo que no es obligatorio que lleguen
        'NUMERO_USUARIO', // Pero los incluimos porque pueden ser llenados más tarde
        'ESTADO_USUARIO', // Tiene un DEFAULT 'Activo', pero lo podemos incluir si queremos setearlo explícitamente
        'NOMBRE_EMPRESA', 
        'FECHA_CREACION',
    ];

    // Si true, el modelo intentará manejar automáticamente los timestamps (fechas de creación/actualización).
    // Necesita columnas 'created_at' y 'updated_at' en la tabla.
    // En tu caso tienes 'FECHA_CREACION', pero CI espera 'created_at' por defecto.
    // Podemos configurarlo manualmente para 'FECHA_CREACION'.
    protected $useTimestamps = false; // Habilitamos los timestamps
    //protected $dateFormat    = 'datetime'; // Formato de fecha para la base de datos

    // Nombres de las columnas de fecha y hora para creación y actualización.
    // Si tu columna es diferente a 'created_at', la defines aquí.
    //protected $createdField  = 'FECHA_CREACION';
    //protected $updatedField  = null; // No tienes una columna 'updated_at' en tu tabla actual
    //protected $deletedField  = 'deleted_at'; // Si usaras soft deletes

    // Reglas de validación para los campos antes de insertar/actualizar.
    // Opcional, se puede hacer en el controlador también.
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callbacks que se ejecutarán antes o después de ciertas operaciones del ORM.
    protected $allowCallbacks = true;
    protected $beforeInsert   = ['hashPassword']; // Llamará a este método antes de insertar
    protected $afterInsert    = [];
    protected $beforeUpdate   = ['hashPassword']; // También hashea antes de actualizar por si se cambia la contraseña
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    /**
     * Callback para hashear la contraseña antes de guardarla.
     */
    protected function hashPassword(array $data)
    {
        // Solo hashear si la contraseña está presente en los datos
        if (isset($data['data']['CONTRASENA'])) {
            $data['data']['CONTRASENA'] = password_hash($data['data']['CONTRASENA'], PASSWORD_DEFAULT);
        }

        return $data;
    }
}