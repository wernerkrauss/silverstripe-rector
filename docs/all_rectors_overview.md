# 10 Rules Overview

<br>

## Categories

- [Rector](#rector) (10)

<br>

## Rector

### AddConfigPropertiesRector

Adds `@config` property to predefined private statics, e.g. `$db` or `$allowed_actions`

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

Changes DataObject::get_by_id('ClassName', `$id)` to `ClassName::get()->byID($id)`

- class: [`Netwerkstatt\SilverstripeRector\Rector\DataObject\DataObjectGetByIdToByIDRector`](../src/Rector/DataObject/DataObjectGetByIdToByIDRector.php)

```diff
-DataObject::get_by_id('MyPage', $id);
+MyPage::get()->byID($id);
```

<br>

### EnsureTableNameIsSetRector

DataObject subclasses must have "$table_name" defined

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

### ListFilterToArrayRector

Translates Silverstripe ORM `filter()` and similar calls from string notation to array notation.

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

Translates Silverstripe ORM `sort()` calls from string notation to array notation.

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

Replace specific parent classes with traits and remove extends

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

Replace specific property fetches with method calls

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

Renames ->addFieldsToTab($name, `$singleField)` to ->addFieldToTab($name, `$singleField)`

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

Replace `Controller::has_curr()` with `Controller::curr()` !== null

- class: [`Netwerkstatt\SilverstripeRector\Rector\Control\ReplaceHasCurrWithCurrRector`](../src/Rector/Control/ReplaceHasCurrWithCurrRector.php)

```diff
 use SilverStripe\Control\Controller;
-if (Controller::has_curr()) {
+if (Controller::curr() !== null) {
     // ...
 }
```

<br>

### UseCreateRector

Change new Object to static call for classes that use Injectable trait

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
