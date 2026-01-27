<?php

namespace App\Model;

class User
{
    public string $name;

    public function printName(): void
    {
        echo $this->name;
    }
}

?>
-----
<?php

namespace App\Model;

class User
{
    public string $name;

    public function printName(): void
    {
        echo $this->getName();
    }
}

?>
