<?php

namespace SilverStripe\ORM;

class UnsavedRelationList
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
