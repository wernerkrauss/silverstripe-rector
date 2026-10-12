<?php

namespace SilverStripe\Forms;

class FormField
{
    public function Value() {}
    public function getFormattedValue() {}
    public function validate(object $validator): bool { return true; }
}
