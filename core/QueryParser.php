<?php

namespace core;

class QueryParser
{
    protected array $params = [];

    public function __construct(string $queryString = '')
    {
        if (empty($queryString)) {
            $queryString = $_SERVER['QUERY_STRING'] ?? '';
        }

        parse_str($queryString, $this->params);
    }

    public function get(string $key, $default = null)
    {
        return $this->params[$key] ?? $default;
    }

    public function all(): array
    {
        return $this->params;
    }

    public function has(string $key): bool
    {
        return array_key_exists($key, $this->params);
    }

    public function __get($name)
    {
        return $this->get($name);
    }

    public function __isset($name)
    {
        return $this->has($name);
    }
}
