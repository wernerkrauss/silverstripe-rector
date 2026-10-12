<?php

use SilverStripe\Forms\Form;

function check(Form $form): bool
{
    return $form->validate()->isValid() === true;
}
