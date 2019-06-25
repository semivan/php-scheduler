<?php

namespace Scheduler\Job;

use Scheduler\Log\BaseLogInterface;

class BaseJob implements BaseJobInterface
{
	/**
	 * @var string $status Статус задания
	 */
	private $status;

	/**
	 * @var string $expression Выражение времени выполнения задачи
	 */
	private $expression;

	/**
	 * @var string $callableClass Вызываемый класс
	 */
	private $callableClass;

	/**
	 * @var string $callableMethod Вызываемый метод
	 */
	private $callableMethod;

	/**
	 * @var BaseLogInterface $log
	 */
	private $log;

	public function __construct()
	{
		$this->status = $this::STATUS_ACTIVE;
	}

	/**
	 * @return string|null Статус задания
	 */
	public function getStatus(): ?string
	{
		return $this->status;
	}

	/**
	 * @return string|null Статус задания
	 */
	public function setStatus(string $status)
	{
		$this->status = $status;

		return $this;
	}

	/**
	 * @return string|null Период выполнения задания
	 */
	public function getExpression(): ?string
	{
		return $this->expression;
	}

	/**
	 * @param string $expression Период выполнения задания
	 * @return self
	 */
	public function setExpression(string $expression): self
	{
		$this->expression = $expression;

		return $this;
	}

	/**
	 * @return string|null Вызываемый класс
	 */
	public function getCallableClass(): ?string
	{
		return $this->callableClass;
	}

	/**
	 * @param string $callableClass Вызываемый класс
	 * @return self
	 */
	public function setCallableClass(string $callableClass): self
	{

		$this->callableClass = $callableClass;

		return $this;
	}

	/**
	 * @return string|null Вызываемый метод
	 */
	public function getCallableMethod(): ?string
	{
		return $this->callableMethod;
	}

	/**
	 * @param string $callableMethod Вызываемый метод
	 * @return self
	 */
	public function setCallableMethod(string $callableMethod): self
	{
		$this->callableMethod = $callableMethod;

		return $this;
	}

	/**
	 * @return BaseLogInterface Лог
	 */
	public function getLog(): ?BaseLogInterface
	{
		return $this->log;
	}

	/**
	 * Добавление лога
	 *
	 * @param BaseLogInterface $log
	 * @return void
	 */
	public function addLog(BaseLogInterface $log): self
	{
		$this->log = $log;

		return $this;
	}
}