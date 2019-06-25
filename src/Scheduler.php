<?php

namespace Scheduler;

use Cron\CronExpression;
use Scheduler\Job\BaseJobInterface;
use Scheduler\Log\BaseLogInterface;
use Scheduler\Runner\JobRunner;
use Scheduler\Loader\BaseLoaderInterface;

class Scheduler extends Helper
{
	/**
	 * @var \DateTime $date Время запуска планировщика
	 */
	private $date;

	/**
	 * @var BaseLoaderInterface
	 */
	private $loader;

	/**
	 * @var BaseJobInterface[] $jobQueue Очередь заданий на выполнение
	 */
	private $jobQueue = [];

	/**
	 * @var BaseJobInterface[] $completedJobs Выполненные задания
	 */
	private $completedJobs = [];

	public function __construct(BaseLoaderInterface $loader)
	{
		$this->date   = new \DateTime();
		$this->loader = $loader;

		$this->createQueue();
	}

	/**
	 * Создать очередь
	 *
	 * @return void
	 */
	protected function createQueue()
	{
		foreach ($this->loader->getJobs() as $job) {
			if (
				CronExpression::factory($job->getExpression())->isDue($this->date) AND
				$job->getStatus() === $job::STATUS_ACTIVE
			) {
				$this->jobQueue[] = $job;
			}
		}
	}

	/**
	 * Получить все задания
	 *
	 * @return BaseJobInterface[]
	 */
	public function getJobs(): array
	{
		return $this->loader->getJobs();
	}

	/**
	 * Получить задания в очереди
	 *
	 * @return BaseJobInterface[]
	 */
	public function getJobQueue(): array
	{
		return $this->jobQueue;
	}

	/**
	 * Получить завершенные задания
	 *
	 * @return BaseJobInterface[]
	 */
	public function getCompletedJobs(): array
	{
		return $this->completedJobs;
	}

	/**
	 * Запустить задание
	 *
	 * @param BaseJobInterface $job Задание
	 * @return BaseLogInterface Лог
	 */
	public function runJob(BaseJobInterface $job): BaseLogInterface
	{
		/**
		 * @var BaseLogInterface $log
		 */
		$logClass = $this->loader->getLogClass();
		$log      = new $logClass;
		$runner   = new JobRunner($job, $this->loader->getAllowedClasses());

		$runner->run();

		$logStatus = $runner->getErrorMessage() ? $log::STATUS_ERROR : $log::STATUS_COMPLETED;

		$log->setStatus($logStatus);
		$log->setExecutionTime($runner->getExecutionTime());
		$log->setOutput(ob_get_clean());
		$log->setErrorMessage($runner->getErrorMessage());
		$log->setCreatedAt(new \DateTime());

		return $log;
	}

	/**
	 * Запуск планировщика
	 *
	 * @return BaseJobInterface[] Выполненные задачи
	 */
	public function run(): array
	{
		foreach ($this->jobQueue as $key => $job) {
			$log = $this->runJob($job);
			$job->addLog($log);

			$this->completedJobs[] = $job;
			unset($this->jobQueue[$key]);

			if ($this->loader->getCallback()) {
				call_user_func_array($this->loader->getCallback(), [$job, $log]);
			}
		}

		return $this->getCompletedJobs();
	}

	/**
	 * Получить массив разрешенных классов
	 * 
	 * @return array
	 */
	public function getAllowedClasses(): array
	{
		return $this->loader->getAllowedClasses();
	}
}