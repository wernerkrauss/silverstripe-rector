<?php

use SilverStripe\Forms\Form;

function check(Form $form, bool $other): bool
{
    if ($form->validate()) {
        return true;
    }

    return $form->validate() && $other;
}
-----
<?php

use SilverStripe\Forms\Form;

function check(Form $form, bool $other): bool
{
    if ($form->validate()->isValid()) {
        return true;
    }

    return $form->validate()->isValid() && $other;
}
