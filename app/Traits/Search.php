<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

trait Search
{
    /**
     * You must create an instance of the model you want to use for searching.
     *
     * @return object
     */
    abstract protected static function getModel();

    /**
     * You must specify the path to the folder where the filter is located.
     *
     * @return string
     */
    abstract protected static function pathFilter();

    /**
     * @param array $filters
     * @return Builder
     */
    public static function apply(array $filters)
    {
        $query = static::applyDecoratorsFromRequest($filters, (static::getModel())->newQuery());
        return static::getResults($query);
    }

    /**
     * @param array $filters
     * @param $query
     * @return Builder
     */
    protected static function applyDecoratorsFromRequest(array $filters, Builder $query)
    {

        foreach ($filters as $filterName => $value) {
            $decorator = static::createFilterDecorator($filterName);

            if (static::isValidDecorator($decorator) && !is_null($value)) {
                $query = $decorator::apply($query, $value);
            }

        }

        return $query;
    }

    /**
     * @param $name
     * @return string
     */
    protected static function createFilterDecorator($name)
    {
        return self::pathFilter() . Str::studly($name);
    }

    /**
     * @param $decorator
     * @return bool
     */
    protected static function isValidDecorator($decorator)
    {
        return class_exists($decorator);
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    protected static function getResults(Builder $query)
    {
        return $query;
    }
}