# 14 Rules Overview

<br>

## Categories

- [Rector](#rector) (14)

<br>

## Rector

### AddConfigPropertiesRector

Code Style: Adds `@config` property to predefined private statics, e.g. `$db` or `$allowed_actions`

:wrench: **configure it!**

- class: [`Netwerkstatt\SilverstripeRector\Rector\Misc\AddConfigPropertiesRector`](../src/Rector/Misc/AddConfigPropertiesRector.php)

```diff
 class SomeClass extends \SilverStripe\ORM\DataObject
 {
+    /**
+    * @config
+    */
     private static $db = [];
 }
```

<br>

### DataObjectGetByIdToByIDRector

Code Style: Changes DataObject::get_by_id('ClassName', `$id)` to `ClassName::get()->byID($id)`

- class: [`Netwerkstatt\SilverstripeRector\Rector\DataObject\DataObjectGetByIdToByIDRector`](../src/Rector/DataObject/DataObjectGetByIdToByIDRector.php)

```diff
-DataObject::get_by_id('MyPage', $id);
+MyPage::get()->byID($id);
```

<br>

### DataObjectStaticMethodsToFluentRector

Silverstripe 6.1: Replace DataObject static methods `get_by_id()`, `get_one()`, and `delete_by_id()` with fluent equivalents.

- class: [`Netwerkstatt\SilverstripeRector\Rector\DataObject\DataObjectStaticMethodsToFluentRector`](../src/Rector/DataObject/DataObjectStaticMethodsToFluentRector.php)

```diff
-DataObject::get_by_id($className, $id);
-DataObject::get_one($className, $filter);
-DataObject::delete_by_id($className, $id);
+DataObject::get($className)->setUseCache(true)->byID($id);
+DataObject::get($className)->setUseCache(true)->filter($filter)->first();
+DataObject::get($className)->setUseCache(true)->byID($id)->delete();
```

<br>

### EnsureTableNameIsSetRector

Silverstripe 4.0: DataObject subclasses must have "$table_name" defined

- class: [`Netwerkstatt\SilverstripeRector\Rector\DataObject\EnsureTableNameIsSetRector`](../src/Rector/DataObject/EnsureTableNameIsSetRector.php)

```diff
 class SomeClass extends \SilverStripe\ORM\DataObject
 {
+    private static $table_name = 'SomeClass';
+
     private static $db = [];
 }
```

<br>

### GetIDListToColumnIDRector

Silverstripe 6.2: Replace `getIDList()` with sort(null)->column('ID') or column('ID')

- class: [`Netwerkstatt\SilverstripeRector\Rector\ORM\GetIDListToColumnIDRector`](../src/Rector/ORM/GetIDListToColumnIDRector.php)

```diff
-$dataList->getIDList();
-$eagerLoadedList->getIDList();
+$dataList->sort(null)->column('ID');
+$eagerLoadedList->column('ID');
```

<br>

### ListFilterToArrayRector

Code Style: Translates Silverstripe ORM `filter()` and similar calls from string notation to array notation.

- class: [`Netwerkstatt\SilverstripeRector\Rector\ORM\ListFilterToArrayRector`](../src/Rector/ORM/ListFilterToArrayRector.php)

```diff
-$list->filter('key', 'value');
-$list->exclude('key', 'value');
-$list->filterAny('key', 'value');
-$list->excludeAny('key', 'value');
+$list->filter(['key' => 'value']);
+$list->exclude(['key' => 'value']);
+$list->filterAny(['key' => 'value']);
+$list->excludeAny(['key' => 'value']);
```

<br>

### ListSortToArrayRector

Code Style: Translates Silverstripe ORM `sort()` calls from string notation to array notation.

- class: [`Netwerkstatt\SilverstripeRector\Rector\ORM\ListSortToArrayRector`](../src/Rector/ORM/ListSortToArrayRector.php)

```diff
-$list->sort('Title', 'DESC');
-$list->sort('Title');
-$list->sort('Title ASC, Created DESC');
+$list->sort(['Title' => 'DESC']);
+$list->sort(['Title' => 'ASC']);
+$list->sort(['Title' => 'ASC', 'Created' => 'DESC']);
```

<br>

### ParentClassToTraitsRector

Silverstripe 4.0: Replace specific parent classes with traits and remove extends

:wrench: **configure it!**

- class: [`Netwerkstatt\SilverstripeRector\Rector\Misc\ParentClassToTraitsRector`](../src/Rector/Misc/ParentClassToTraitsRector.php)

```diff
 <?php

-class MyObject extends Object
+use SilverStripe\Core\Injector\Injectable;
+use SilverStripe\Core\Config\Configurable;
+use SilverStripe\Core\Extensible;
+
+class MyObject
 {
+    use Injectable;
+    use Configurable;
+    use Extensible;
 }
```

<br>

### PropertyFetchToMethodCallRector

Code Style: Replace specific property fetches with method calls

:wrench: **configure it!**

- class: [`Netwerkstatt\SilverstripeRector\Rector\Misc\PropertyFetchToMethodCallRector`](../src/Rector/Misc/PropertyFetchToMethodCallRector.php)

```diff
 <?php

 use App\Model\User;

 class User
 {
     public string $name;

     public function print(): void
     {
-        echo $this->name;
+        echo $this->getName();
     }
 }
```

<br>

### RenameAddFieldsToTabWithoutArrayParamRector

Silverstripe 5.3: Renames ->addFieldsToTab($name, `$singleField)` to ->addFieldToTab($name, `$singleField)`

- class: [`Netwerkstatt\SilverstripeRector\Rector\Misc\RenameAddFieldsToTabWithoutArrayParamRector`](../src/Rector/Misc/RenameAddFieldsToTabWithoutArrayParamRector.php)

```diff
 class SomeClass extends \SilverStripe\ORM\DataObject
 {
     public function getCMSFields() {
         $myfield = FormField::create();
-        $fields->addFieldsToTab('Root.Main', $myfield);
+        $fields->addFieldToTab('Root.Main', $myfield);
     }
 }
```

<br>

### ReplaceHasCurrWithCurrRector

Silverstripe 6.0: Replace `Controller::has_curr()` with `Controller::curr()` !== null

- class: [`Netwerkstatt\SilverstripeRector\Rector\Control\ReplaceHasCurrWithCurrRector`](../src/Rector/Control/ReplaceHasCurrWithCurrRector.php)

```diff
 use SilverStripe\Control\Controller;
-if (Controller::has_curr()) {
+if (Controller::curr() !== null) {
     // ...
 }
```

<br>

### SilverstripeDeprecationCommentRector

Silverstripe: Add deprecation comments to classes or methods without direct substitute.

:wrench: **configure it!**

- class: [`Netwerkstatt\SilverstripeRector\Rector\Misc\SilverstripeDeprecationCommentRector`](../src/Rector/Misc/SilverstripeDeprecationCommentRector.php)

```diff
 class SomeClass
 {
+    /**
+     * @deprecated This method is deprecated.
+     * See: https://docs.silverstripe.org/...
+     */
     public function oldMethod()
     {
     }
 }
```

<br>

### StatToConfigGetRector

Silverstripe 4.0: Replace `$this->stat('foo')` with `static::config()->get('foo')`

- class: [`Netwerkstatt\SilverstripeRector\Rector\Config\StatToConfigGetRector`](../src/Rector/Config/StatToConfigGetRector.php)

```diff
 class MyClass {
     use \SilverStripe\Core\Config\Configurable;
     public function myMethod() {
-        $this->stat('foo');
+        static::config()->get('foo');
     }
 }
```

<br>

### UseCreateRector

Code Style: Change new Object to static call for classes that use Injectable trait

- class: [`Netwerkstatt\SilverstripeRector\Rector\Injector\UseCreateRector`](../src/Rector/Injector/UseCreateRector.php)

```diff
 class SomeClass
 {
     public function run()
     {
-        new InjectableClass($name);
+        InjectableClass::create($name);
     }
 }
```

<br>
