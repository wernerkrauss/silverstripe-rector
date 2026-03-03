<?php

namespace SilverStripe\ORM;

class DataList
{
    public function getIDList(): array
    {
        return [];
    }

    public function sort($column, $direction = null): self
    {
        return $this;
    }

    public function column($column = 'ID'): array
    {
        return [];
    }
}
