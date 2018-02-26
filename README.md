Installation
============

Step 1: Download the Bundle
---------------------------

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

```console
$ composer require fintem/workflow-logger-bundle "~1.0.1"
```

This command requires you to have Composer installed globally, as explained
in the [installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.

Step 2: Enable the Bundle
-------------------------

Then, enable the bundle by adding it to the list of registered bundles
in the `app/AppKernel.php` file of your project:

```php
<?php
// app/AppKernel.php

// ...
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = [
            // ...
            new Fintem\WorkflowLoggerBundle\WorkflowLoggerBundle(),
        ];

        // ...
    }

    // ...
}
```

Step 3: Update schema
-------------------------

```console
$ php app/console doctrine:schema:update --force
```

How to use
============

When you install workflow logger bundle, you can use this bundle straight away, all workflow is recorded to workflow_logger table (WorkflowLogger entity).

If you want to log particular workflow in your application you should note it explicitly. For example if you have got three workflows in your application (wfl-1, wfl-2, wfl3) and you want to log only wfl-1 and wfl-3. You should add additional lines of code to your config.yml file.  
```
workflow_logger:
    workflows:
        - 'wfl-1'
        - 'wfl-3'
```

If you want to stop logging all workflows, set logging property to false. Its property true by default.
```
workflow_logger:
    logging: false
```