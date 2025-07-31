# 4 Rules Overview

<br>

## Categories

- [Rector](#rector) (4)

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

### RenameAddFieldsToTabWithoutArrayParamRector

Renames ->addFieldsToTab($name, `$singleField)` to ->addFieldToTab($name, `$singleField)`

- class: [`Netwerkstatt\SilverstripeRector\Rector\Misc\RenameAddFieldsToTabWithoutArrayParamRector`](../src/Rector/Misc/RenameAddFieldsToTabWithoutArrayParamRector.php)

```diff
-class SomeClass
+class SomeClass extends \SilverStripe\ORM\DataObject
 {
-    public function getCMSFields()
-    {
-        $time = mktime(1, 2, 3);
-        $nextTime = mktime();
+    public function getCMSFields() {
+        $myfield = FormField::create();
+        $fields->addFieldToTab('Root.Main', $myfield);
     }
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
