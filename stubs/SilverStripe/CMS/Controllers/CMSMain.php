<?php

namespace SilverStripe\CMS\Controllers;

class CMSMain
{
    public function LinkPreview(): string {}
    public function getSearchContext(): object {}
    public function performPublish(): void {}
    public function PageListSidebar(): string { return ''; }
}
