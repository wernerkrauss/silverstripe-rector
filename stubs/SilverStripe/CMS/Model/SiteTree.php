<?php

namespace SilverStripe\CMS\Model;

class SiteTree
{
    public static bool $need_permission = true;

    public static function page_type_classes(): array {}
    public static function setCreatableChildrenCache(object $cache): void {}
    public static function getCreatableChildrenCache(): ?object {}
    public function getPermissionChecker(): object {}
    public static function flushMemberCache(): void {}
    public function creatableChildPages(): array {}
    public function getIconClass(): string {}
    public function getPageIconURL(): string {}
    public static function generateChildrenCacheKey(): string {}
}
