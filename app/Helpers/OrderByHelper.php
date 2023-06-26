<?php

declare(strict_types=1);

namespace App\Helpers;

use InvalidArgumentException;

abstract class OrderByHelper
{
    public static function treat(string $orderBy): array
    {
        $orderByArray = [];

        foreach (explode(',', $orderBy) as $value) {
            $value = trim($value);

            if (!preg_match('/^(-)?[A-Za-z0-9_]+/i', $value)) {
                throw new InvalidArgumentException('The "order_by" param is not in the valid format');
            }

            $orderByArray[$value] = 'ASC';

            if (strstr($value, '-')) {
                $orderByArray[$value] = 'DESC';
            }
        }

        return $orderByArray;
    }
}
