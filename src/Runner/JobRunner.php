<?php

namespace Scheduler\Runner;

use Scheduler\Job\BaseJobInterface;

class JobRunner
{
	/**
	 * @var BaseJobInterface $job Задание
	 */
	private $job;

	/**
	 * @var array $allowedClasses Массив разрешенных классов
	 */
	private $allowedClasses;

	/**
	 * @var float $executionTime Время выполнения в секундах
	 */
	private $executionTime;

	/**
	 * @var string $errorMessage Сообщение об ошибке
	 */
	private $errorMessage;

	/**
	 * @var mixed $response Результат выполнения задания
	 */
	private $response;

	/**
	 * @param BaseJobInterface $job            Задание
	 * @param array            $allowedClasses Массив разрешенных классов
	 */
	public function __construct(BaseJobInterface $job, array $allowedClasses = [])
	{
		$this->job            = $job;
		$this->allowedClasses = $allowedClasses;
	}

	/**
	 * Валидация задания
	 *
	 * @return void
	 */
	private function jobValidation()
	{
		$class  = $this->job->getCallableClass();
		$method = $this->job->getCallableMethod();

		if (!class_exists($class)) {
			throw new \Exception("Не найден класс");
		}

		if ($this->allowedClasses AND !in_array($class, $this->allowedClasses)) {
			throw new \Exception("Доступ к классу ограничен");
		}

		$object = new $class;

		if (!method_exists($object, $method)) {
			throw new \Exception("Не найден метод");
		}
	}

	/**
	 * Выполнение задания
	 *
	 * @return void
	 */
	private function executeCommand()
	{
		$this->jobValidation();

		$class  = $this->job->getCallableClass();
		$method = $this->job->getCallableMethod();

		$this->response = call_user_func_array(
			[new $class, $method],
			[$this->job]
		);

		if ($this->response === false) {
			throw new \Exception('Результат выполнения задания = false');
		}
	}

	/**
	 * Запустить задание
	 *
	 * @return
	 */
	public function run()
	{
		ob_start();
		$startTime = microtime(true);

		try {
			$this->executeCommand($this->job);
		} catch (\Exception $e) {
			$this->errorMessage = $e->getMessage();
		}

		$this->executionTime = round((microtime(true) - $startTime), 2);
	}

	/**
	 * @return float|null Время выполнения задания в секундах
	 */
	public function getExecutionTime(): ?float
	{
		return $this->executionTime;
	}

	/**
	 * @return string|null Сообщение об ошибке
	 */
	public function getErrorMessage(): ?string
	{
		return $this->errorMessage;
	}

	/**
	 * @return mixed Результат выполнения команды
	 */
	public function getResponse()
	{
		return $this->response;
	}
}