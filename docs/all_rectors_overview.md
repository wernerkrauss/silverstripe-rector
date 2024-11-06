# 3 Rules Overview

<br>

## Categories

- [Rector](#rector) (3)

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
