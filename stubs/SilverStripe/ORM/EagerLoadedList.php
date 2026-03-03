<?php

namespace SilverStripe\ORM;

class EagerLoadedList
{
    public function getIDList(): array
    {
        return [];
    }

    public function column($column = 'ID'): array
    {
        return [];
    }
}
