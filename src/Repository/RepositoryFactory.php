<?php
declare(strict_types=1);

namespace ErickFinancas\Repository;

class RepositoryFactory
{
    public static function factory(string $modelClass)
    {
        return new DefaultRepository($modelClass);
    }
}