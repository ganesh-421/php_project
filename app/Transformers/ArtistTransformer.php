<?php

namespace App\Transformers;

use App\Models\User;

class ArtistTransformer
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
        $user = (new User())->find($item['user_id']);
        return [
            'id' => (int) $item['id'],
            'name' => $item['name'],
            'email' => $user['email'],
            'role' => $user['role'],
            'dob' => $item['dob'],
            'gender' => $item['gender'],
            'address' => $item['address'],
            'first_release_year' => $item['first_release_year'],
            'no_of_albums' => $item['no_of_albums'],
            'phone' => $user['phone'],
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
