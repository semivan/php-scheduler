<?php

namespace Scheduler\Loader;

interface BaseLoaderInterface
{
	/**
	 * @return BaseJobInterface[] Все задания
	 */
	public function getJobs(): array;

	/**
	 * @return string[] Массив разрешенных классов
	 */
	public function getAllowedClasses(): array;

	/**
	 * @return string Класс лога
	 */
	public function getLogClass(): ?string;

	/**
	 * @return callable|null Функция, выполняемая после выполнения задания
	 */
	public function getCallback(): ?callable;
}