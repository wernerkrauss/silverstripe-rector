<?php

namespace App\Model;

class OtherClass
{
    public string $name;

    public function printName(): void
    {
        // Sollte NICHT ersetzt werden, da OtherClass nicht konfiguriert ist
        echo $this->name;
    }
}

class User
{
    public string $unrelated;

    public function printUnrelated(): void
    {
        // Sollte NICHT ersetzt werden, da 'unrelated' nicht konfiguriert ist
        echo $this->unrelated;
    }
}

?>
