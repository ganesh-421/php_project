<?php

namespace App\Transformers;

class UserTransformer
{
    /**
     * @var array resource
     */
    public $resource;

    /**
     * Transform single record to an array
     */
    public static function transformItem(array $item): array
    {
        return [
            'id' => (int) $item['id'],
            'name' => $item['first_name'] . " " . $item['last_name'],
            'email' => $item['email'],
            'role' => $item['role']
        ];
    }

    /**
     * Transform multiple records into array
     */
    public static function transformCollection(array $items): array
    {
        return array_map([self::class, 'transformItem'], $items);
    }

    /**
     * Transform paginated collection
     * @param array $items (paginated items with all page details)
     */
    public static function transformPaginated(array $items): array
    {
        return [
            'current_page' => $items['currentPage'],
            'per_page' => $items['perPage'],
            'total' => $items['total'],
            'total_pages' => $items['totalPages'],
            'from' => $items['from'],
            'to' => $items['to'],
            'data' => self::transformCollection($items['data'])
        ];
    }
}
