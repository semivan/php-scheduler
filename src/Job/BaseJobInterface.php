<?php

namespace Scheduler\Job;

use Scheduler\Log\BaseLogInterface;

interface BaseJobInterface
{
    const STATUS_ACTIVE   = 'active';
	const STATUS_INACTIVE = 'inactive';
	
	/**
	 * @return string|null Вызываемый класс
	 */
	public function getCallableClass(): ?string;

	/**
	 * @return string|null Вызываемый метод
	 */
	public function getCallableMethod(): ?string;

	/**
	 * @return string|null Период выполнения задания
	 */
	public function getExpression(): ?string;

	/**
	 * @return string|null Статус задания
	 */
	public function getStatus(): ?string;

	/**
	 * Добавление лога
	 *
	 * @param BaseLogInterface $log
	 * @return void
	 */
	public function addLog(BaseLogInterface $log);
}