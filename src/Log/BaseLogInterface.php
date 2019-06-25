<?php

namespace Scheduler\Log;

interface BaseLogInterface
{
    const STATUS_COMPLETED = 'completed';
	const STATUS_ERROR     = 'error';
	
	/**
	 * @param string $status Статус выполнения задачи
	 * @return void
	 */
	public function setStatus(string $status);

	/**
	 * @param float $executionTime Время выполнения задачи в секундах
	 * @return void
	 */
	public function setExecutionTime(float $executionTime);

	/**
	 * @param string $output Вывод выполнения задачи
	 * @return void
	 */
	public function setOutput(?string $output);

	/**
	 * @param string $errorMessage Сообщение об ошибке
	 * @return void
	 */
	public function setErrorMessage(?string $errorMessage);

	/**
	 * @param \DateTimeInterface $createdAt Дата создания лога
	 * @return void
	 */
	public function setCreatedAt(\DateTimeInterface $createdAt);
}