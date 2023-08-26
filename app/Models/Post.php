<?php
namespace App\Models;

use Bdt\Example\Model;

class Post extends Model
{
    public static function titleExists($title, $excludeId = null) {
        // Crear la consulta SQL básica
        $sql = 'SELECT COUNT(*) FROM ' . static::getName() . ' WHERE title = ?';
        $parameters = [$title];
    
        // Si se proporciona un ID para excluir (por ejemplo, durante una edición), ajustamos la consulta
        if ($excludeId !== null) {
            $sql .= ' AND id != ?';
            $parameters[] = $excludeId;
        }
    
        // Ejecutar la consulta
        $stmt = self::$connection->executeQuery($sql, $parameters);
    
        // Si el conteo es mayor que 0, significa que el título ya existe
        return $stmt->fetchOne() > 0;
    }

}