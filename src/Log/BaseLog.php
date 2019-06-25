<?php

namespace Scheduler\Log;

class BaseLog implements BaseLogInterface
{
	/**
	 * @var string $status Статус выполнения задачи
	 */
	private $status;

	/**
	 * @var float $executionTime Время выполнения задачи в секундах
	 */
	private $executionTime;

	/**
	 * @var string $output Вывод результата выполнения задачи
	 */
	private $output;

	/**
	 * @var string $errorMessage Сообщение об ошибке
	 */
	private $errorMessage;

	/**
	 * @var \DateTimeInterface $createdAt Время создания лога
	 */
	private $createdAt;

	/**
	 * @return string|null Статус выполнения задачи
	 */
	public function getStatus(): ?string
	{
		return $this->status;
	}

	/**
	 * @param string $status Статус выполнения задачи
	 * @return void
	 */
	public function setStatus(string $status)
	{
		$this->status = $status;
	}

	/**
	 * @return float|null Время выполнения задачи в микросекундах
	 */
	public function getExecutionTime(): ?float
	{
		return $this->executionTime;
	}

	/**
	 * @param float $executionTime Время выполнения задачи в микросекундах
	 * @return void
	 */
	public function setExecutionTime(float $executionTime)
	{
		$this->executionTime = $executionTime;
	}

	/**
	 * @return string|null Вывод результата выполнения задачи
	 */
	public function getOutput(): ?string
	{
		return $this->output;
	}

	/**
	 * @param string|null $output Вывод результата выполнения задачи
	 * @return void
	 */
	public function setOutput(?string $output)
	{
		$this->output = $output;
	}

	/**
	 * @return string|null Сообщение об ошибке
	 */
	public function getErrorMessage(): ?string
	{
		return $this->errorMessage;
	}

	/**
	 * @param string|null $errorMessage Сообщение об ошибке
	 * @return void
	 */
	public function setErrorMessage(?string $errorMessage)
	{
		$this->errorMessage = $errorMessage;
	}

	/**
	 * @return \DateTimeInterface|null Время создания лога
	 */
	public function getCreatedAt(): ?\DateTimeInterface
	{
		return $this->createdAt;
	}

	/**
	 * @param string $createdAt Время создания лога
	 * @return void
	 */
	public function setCreatedAt(\DateTimeInterface $createdAt)
	{
		$this->createdAt = $createdAt;
	}
}