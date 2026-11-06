# 23 Rules Overview

<br>

## Categories

- [Rector](#rector) (23)

<br>

## Rector

### AddConfigPropertiesRector

Code Style: Adds `@config` property to predefined private statics, e.g. `$db` or `$allowed_actions`

:wrench: **configure it!**

- class: [`Netwerkstatt\SilverstripeRector\Rector\Misc\AddConfigPropertiesRector`](../src/Rector/Misc/AddConfigPropertiesRector.php)

```diff
@@ -1,4 +1,7 @@
 class SomeClass extends \SilverStripe\ORM\DataObject
 {
+    /**
+    * @config
+    */
     private static $db = [];
 }
```

<br>

### BuildTaskUpdateRector

Silverstripe 6.0: Updates Silverstripe BuildTask from v5 to v6

- class: [`Netwerkstatt\SilverstripeRector\Rector\Misc\BuildTaskUpdateRector`](../src/Rector/Misc/BuildTaskUpdateRector.php)

```diff
@@ -1,11 +1,14 @@
 use SilverStripe\Dev\BuildTask;
+use Symfony\Component\Console\Input\InputInterface;
+use SilverStripe\PolyExecution\PolyOutput;

 class MyTask extends BuildTask
 {
-    protected $title = 'My Task';
+    protected string $title = 'My Task';

-    public function run($request)
+    protected function execute(InputInterface $input, PolyOutput $output): int
     {
-        echo "Running task";
+        $output->writeln('Running task');
+        return \Symfony\Component\Console\Command\Command::SUCCESS;
     }
 }
```

<br>

### DataObjectGetByIdToByIDRector

Code Style: Changes DataObject::get_by_id('ClassName', `$id)` to `ClassName::get()->byID($id)`

- class: [`Netwerkstatt\SilverstripeRector\Rector\DataObject\DataObjectGetByIdToByIDRector`](../src/Rector/DataObject/DataObjectGetByIdToByIDRector.php)

```diff
@@ -1,1 +1,1 @@
-DataObject::get_by_id('MyPage', $id);
+MyPage::get()->byID($id);
```

<br>

### DataObjectStaticMethodsToFluentRector

Silverstripe 6.1: Replace DataObject static methods `get_by_id()`, `get_one()`, and `delete_by_id()` with fluent equivalents.

- class: [`Netwerkstatt\SilverstripeRector\Rector\DataObject\DataObjectStaticMethodsToFluentRector`](../src/Rector/DataObject/DataObjectStaticMethodsToFluentRector.php)

```diff
@@ -1,3 +1,3 @@
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
@@ -1,4 +1,6 @@
 class SomeClass extends \SilverStripe\ORM\DataObject
 {
+    private static $table_name = 'SomeClass';
+
     private static $db = [];
 }
```

<br>

### FormLoadDataFromMergeStrategyRector

Silverstripe 5.4: Replace `Form::loadDataFrom()` merge strategy booleans with explicit values.

- class: [`Netwerkstatt\SilverstripeRector\Rector\Forms\FormLoadDataFromMergeStrategyRector`](../src/Rector/Forms/FormLoadDataFromMergeStrategyRector.php)

```diff
@@ -1,4 +1,4 @@
 use SilverStripe\Forms\Form;

-$form->loadDataFrom($data, true);
-$form->loadDataFrom($data, false);
+$form->loadDataFrom($data, \SilverStripe\Forms\Form::MERGE_CLEAR_MISSING);
+$form->loadDataFrom($data, 0);
```

<br>

### FormValidateToIsValidRector

Silverstripe 6.0: Convert `Form::validate()` boolean usage to `isValid()`.

- class: [`Netwerkstatt\SilverstripeRector\Rector\Forms\FormValidateToIsValidRector`](../src/Rector/Forms/FormValidateToIsValidRector.php)

```diff
@@ -1,10 +1,10 @@
 use SilverStripe\Forms\Form;

 function check(Form $form, bool $other): bool
 {
-    if ($form->validate()) {
+    if ($form->validate()->isValid()) {
         return true;
     }

-    return $form->validate() && $other;
+    return $form->validate()->isValid() && $other;
 }
```

<br>

### GetIDListToColumnIDRector

Silverstripe 6.2: Replace `getIDList()` with sort(null)->column('ID') or column('ID')

- class: [`Netwerkstatt\SilverstripeRector\Rector\ORM\GetIDListToColumnIDRector`](../src/Rector/ORM/GetIDListToColumnIDRector.php)

```diff
@@ -1,2 +1,2 @@
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
@@ -1,4 +1,4 @@
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
@@ -1,3 +1,3 @@
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
@@ -1,5 +1,12 @@
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
@@ -1,13 +1,13 @@
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

### PropertyToConfigRector

Convert protected properties to private static config properties

:wrench: **configure it!**

- class: [`Netwerkstatt\SilverstripeRector\Rector\Misc\PropertyToConfigRector`](../src/Rector/Misc/PropertyToConfigRector.php)

```diff
@@ -1,4 +1,7 @@
 class MyTask extends BuildTask
 {
-    protected $enabled = true;
+    /**
+     * @config
+     */
+    private static $is_enabled = true;
 }
```

<br>

### RemoveSilverstripeDeprecationCommentRector

Silverstripe: Remove deprecation comments that are no longer applicable after upgrade.

:wrench: **configure it!**

- class: [`Netwerkstatt\SilverstripeRector\Rector\Misc\RemoveSilverstripeDeprecationCommentRector`](../src/Rector/Misc/RemoveSilverstripeDeprecationCommentRector.php)

```diff
@@ -1,10 +1,6 @@
 class SomeClass
 {
-    /**
-     * @deprecated This method is deprecated. Use newMethod() instead.
-     * See: https://docs.silverstripe.org/...
-     */
     public function newMethod()
     {
     }
 }
```

<br>

### RenameFieldListMethodsWithoutArrayParamRector

Silverstripe 5.3: Renames FieldList plural methods to singular if second argument is not an array

- class: [`Netwerkstatt\SilverstripeRector\Rector\Misc\RenameFieldListMethodsWithoutArrayParamRector`](../src/Rector/Misc/RenameFieldListMethodsWithoutArrayParamRector.php)

```diff
@@ -1,2 +1,2 @@
-$fields->addFieldsToTab('Root.Main', $myfield);
-$fields->removeFieldsFromTab('Root.Main', $myfield);
+$fields->addFieldToTab('Root.Main', $myfield);
+$fields->removeFieldFromTab('Root.Main', $myfield);
```

<br>

### ReplaceHasCurrWithCurrRector

Silverstripe 6.0: Replace `Controller::has_curr()` with `Controller::curr()` !== null

- class: [`Netwerkstatt\SilverstripeRector\Rector\Control\ReplaceHasCurrWithCurrRector`](../src/Rector/Control/ReplaceHasCurrWithCurrRector.php)

```diff
@@ -1,4 +1,4 @@
 use SilverStripe\Control\Controller;
-if (Controller::has_curr()) {
+if (Controller::curr() !== null) {
     // ...
 }
```

<br>

### ReplaceSilverstripeNullArgumentRector

Silverstripe 5.4: Replace deprecated null arguments with explicit defaults.

:wrench: **configure it!**

- class: [`Netwerkstatt\SilverstripeRector\Rector\Misc\ReplaceSilverstripeNullArgumentRector`](../src/Rector/Misc/ReplaceSilverstripeNullArgumentRector.php)

```diff
@@ -1,1 +1,1 @@
-$result->addError("Message", "bad", null, null);
+$result->addError("Message", "bad", "", ValidationResult::CAST_TEXT);
```

<br>

### Silverstripe54MethodCallToStaticCallRector

Silverstripe 5.4: Move deprecated instance calls to their static replacements.

- class: [`Netwerkstatt\SilverstripeRector\Rector\Forms\Silverstripe54MethodCallToStaticCallRector`](../src/Rector/Forms/Silverstripe54MethodCallToStaticCallRector.php)

```diff
@@ -1,2 +1,2 @@
-$emails->isValidEmail($email);
-$handler->isCli();
+\SilverStripe\Control\Email\Email::is_valid_address($email);
+\SilverStripe\Control\Director::is_cli();
```

<br>

### Silverstripe54StaticCallRenameRector

Silverstripe 5.4: Rename selected static API calls.

- class: [`Netwerkstatt\SilverstripeRector\Rector\Misc\Silverstripe54StaticCallRenameRector`](../src/Rector/Misc/Silverstripe54StaticCallRenameRector.php)

```diff
@@ -1,1 +1,1 @@
-SilverStripe\View\SSViewer::fromString($template);
+SilverStripe\TemplateEngine\SSTemplateEngine::renderString($template);
```

<br>

### SilverstripeDeprecationCommentRector

Silverstripe: Add deprecation comments to classes or methods without direct substitute.

:wrench: **configure it!**

- class: [`Netwerkstatt\SilverstripeRector\Rector\Misc\SilverstripeDeprecationCommentRector`](../src/Rector/Misc/SilverstripeDeprecationCommentRector.php)

```diff
@@ -1,6 +1,10 @@
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

Silverstripe 4.0: Replace $this->stat('foo') with `static::config()->get('foo')`

- class: [`Netwerkstatt\SilverstripeRector\Rector\Config\StatToConfigGetRector`](../src/Rector/Config/StatToConfigGetRector.php)

```diff
@@ -1,6 +1,6 @@
 class MyClass {
     use \SilverStripe\Core\Config\Configurable;
     public function myMethod() {
-        $this->stat('foo');
+        static::config()->get('foo');
     }
 }
```

<br>

### StaticCallToConfigRector

Convert static method calls to config properties

:wrench: **configure it!**

- class: [`Netwerkstatt\SilverstripeRector\Rector\Misc\StaticCallToConfigRector`](../src/Rector/Misc/StaticCallToConfigRector.php)

```diff
@@ -1,8 +1,11 @@
 class MyObject extends DataObject
 {
+    /**
+     * @config
+     */
+    private static $subclass_access = false;
     public function onBeforeWrite()
     {
         parent::onBeforeWrite();
-        self::disable_subclass_access();
     }
 }
```

<br>

### UseCreateRector

Code Style: Change new Object to static call for classes that use Injectable trait

- class: [`Netwerkstatt\SilverstripeRector\Rector\Injector\UseCreateRector`](../src/Rector/Injector/UseCreateRector.php)

```diff
@@ -1,7 +1,7 @@
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
