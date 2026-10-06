<?php

namespace DNADesign\Elemental\Models;

class BaseElement
{
    /**
     * @deprecated BaseElement::getDescription() has been deprecated. To update or get the CMS description of elemental blocks, use the description configuration property and the localisation API.
     * See: https://docs.silverstripe.org/en/5/changelogs/5.3.0/#api-changes
     */
    public function getDescription()
    {
    }
}
