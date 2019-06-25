<?php

namespace Scheduler\Loader;

use Scheduler\Job\BaseJobInterface;
use Scheduler\Log\BaseLogInterface;
use Scheduler\Log\BaseLog;

class BaseLoader implements BaseLoaderInterface
{
	/**
	 * @var BaseJobInterface[] $jobs Все загруженные задания
	 */
	private $jobs = [];

	/**
	 * @var string $logClass Класс лога
	 */
	private $logClass;

	/**
	 * Разрешенные классы
	 *
	 * @var array
	 */
	private $allowedClasses = [];

	/**
	 * @var callable $callback Функция, выполняемая после выполнения задания
	 */
	private $callback;

	public function __construct()
	{
		$this->date     = new \DateTime();
		$this->logClass = BaseLog::class;
	}

	/**
	 * Получить все задания
	 *
	 * @return BaseJobInterface[]
	 */
	public function getJobs(): array
	{
		return $this->jobs;
	}

	/**
	 * Добавить задание
	 *
	 * @param BaseJobInterface $job
	 * @return self
	 */
	public function addJob(BaseJobInterface $job): self
	{
		$this->jobs[] = $job;

		return $this;
	}

	/**
	 * Добавить массив заданий
	 *
	 * @param BaseJobInterface[] $job
	 * @return self
	 */
	public function addJobs(array $jobs): self
	{
		foreach ($jobs as $job) {
			$this->addJob($job);
		}

		return $this;
	}

	/**
	 * Получить массив разрешенных классов
	 *
	 * @return string[]
	 */
	public function getAllowedClasses(): array
	{
		return $this->allowedClasses;
	}

	/**
	 * Добавить разрешенный класс
	 *
	 * @param string $class
	 * @return self
	 */
	public function addAllowedClass(string $class): self
	{
		if (!class_exists($class)) {
			throw new \Exception("Не найден класс $class");
		}

		$this->allowedClasses[] = $class;

		return $this;
	}

	/**
	 * Добавить массив разрешенных классов
	 *
	 * @param string[] $classes
	 * @return self
	 */
	public function addAllowedClasses(array $classes): self
	{
		foreach ($classes as $class) {
			$this->addAllowedClass($class);
		}

		return $this;
	}

	/**
	 * Получить класс лога
	 *
	 * @return string
	 */
	public function getLogClass(): ?string
	{
		return $this->logClass;
	}

	/**
	 * Установить класс лога
	 *
	 * @param string $logClass
	 * @return self
	 */
	public function setLogClass(string $logClass): self
	{
		if (!(new $logClass instanceof BaseLogInterface)) {
			throw new \Exception("Класс $logClass не реализует интерфейс ". BaseLogInterface::class);
		}
		
		$this->logClass = $logClass;

		return $this;
	}

	/**
	 * Получить функцию, выполняемую после выполнения задания
	 *
	 * @return callable|null
	 */
	public function getCallback(): ?callable
	{
		return $this->callback;
	}

	/**
	 * Установить функцию, выполняемую после выполнения задания
	 *
	 * @param callable|null $callback
	 * @return self
	 */
	public function setCallback(?callable $callback): self
	{
		$this->callback = $callback;

		return $this;
	}
}