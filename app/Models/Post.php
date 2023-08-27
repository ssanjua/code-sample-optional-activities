<?php
namespace App\Models;

use Bdt\Example\Model;

/**
 * Represents a Post in the application.
 * 
 * Provides methods for querying and interacting with post data.
 */

class Post extends Model
{   
     /**
     * Check if a post title already exists in the database.
     * 
     * Optionally, an ID can be provided to exclude a specific post from the check. 
     * This is useful when updating an existing post, as we want to exclude the post being edited 
     * from the duplicate check.
     *
     * @param string $title     - The title to check.
     * @param int|null $excludeId - Optional. The ID of the post to exclude from the check.
     *
     * @return bool - Returns true if the title exists (excluding the provided ID if provided), 
     *                otherwise false.
     */

    public static function titleExists($title, $excludeId = null) {
        // Basic SQL to check if a title exists in the database.
        $sql = 'SELECT COUNT(*) FROM ' . static::getName() . ' WHERE title = ?';
        $parameters = [$title];
    
        // If an ID is provided to exclude, add a condition to the SQL query.
        if ($excludeId !== null) {
            $sql .= ' AND id != ?';
            $parameters[] = $excludeId;
        }
    
        // Execute the query.
        $stmt = self::$connection->executeQuery($sql, $parameters);
    
        // If the result is greater than 0, the title exists.
        return $stmt->fetchOne() > 0;
    }

}