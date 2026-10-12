<?php

use SilverStripe\Forms\Form;

function check(Form $form): mixed
{
    $result = $form->validate();
    $result->doSomething();
    return $result;
}
