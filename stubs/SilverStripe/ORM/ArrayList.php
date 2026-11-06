<?php

namespace SilverStripe\ORM;

if (class_exists('SilverStripe\ORM\ArrayList')) {
    return;
}

class ArrayList
{
    public function sort($column, $direction = null): self
    {
        return $this;
    }

    public function orderBy($sort): self
    {
        return $this;
    }

    public function shuffle(): self
    {
        return $this;
    }
}
