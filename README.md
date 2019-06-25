# Cron Scheduler

## Требования
* PHP >= 7.1
* [dragonmantank/cron-expression](https://github.com/dragonmantank/cron-expression)


## Установка
```sh
composer require semivan/php-scheduler
```


## Настройка задания

### Стандартные задания
```php
$job = new \Scheduler\Job\BaseJob();

// Установка интервала (раз в неделю)
$job->setExpression('0 0 * * 0');

// Установка выполняемого метода
$job
    ->setCallableClass(CallableClass::class)
    ->setCallableMethod('callableMethod');
```

### Пользовательские задания (например: из базы данных)
```php
// CustomJob реализует интерфейс \Scheduler\Job\BaseJobInterface
$jobs = CustomJob::findAll();
```


## Настройка планировщика
```php
$loader = new \Scheduler\Loader\BaseLoader();

// Добавление задания
$loader->addJob($job);
//$loader->addJobs($jobs);

$scheduler = new \Scheduler\Scheduler($loader);
```

### Установка пользовательского класса лога
```php
// CustomLog реализует интерфейс \Scheduler\Log\BaseLogInterface
$loader->setLogClass(CustomLog::class);
```

### Установка функции дополнительной обработки задания или лога
В функцию передаются задание с логом и лог отдельно.

Ее можно использовать для проверки результата, сохранения лога в базу и т.д.
```php
$loader->setCallback([new CallableClass(), 'callback']);
```


## Запуск планировщика
```php
$completedJobs = $scheduler->run();
```
Настройте файл конфигурации cron на выполнение этой команды с интервалом раз в минуту


## Запуск задания без добавления в очередь
```php
$log = $scheduler->runJob($job);
$job->addLog($log);
```