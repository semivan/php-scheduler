<?php

namespace Scheduler;

use Cron\CronExpression;
use Scheduler\Job\BaseJobInterface;

class Helper
{
    /**
     * Получить время следующего запуска задания
     *
     * @param BaseJobInterface $expression Задание
     * @return boolean
     */
    public static function isValidExpression(string $expression): bool
    {
        return CronExpression::isValidExpression($expression);
    }

    /**
     * Получить время следующего запуска задания
     *
     * @param string $expression Выражение времени
     * @return \DateTime|null
     */
    public static function getNextRunDate(string $expression): ?\DateTime
    {
        if (!self::isValidExpression($expression)) {
            return null;
        }

        return CronExpression::factory($expression)
            ->getNextRunDate();
    }

    /**
     * Получить время предыдущего запуска задания
     *
     * @param string $expression Выражение времени
     * @return \DateTime|null
     */
    public static function getPreviousRunDate(string $expression): ?\DateTime
    {
        if (!self::isValidExpression($expression)) {
            return null;
        }

        return CronExpression::factory($expression)
            ->getPreviousRunDate();
    }

    /**
     * Получить расписание работы задания
     *
     * @param string  $expression Выражение времени
     * @param integer $total      Количество дат
     * @return \DateTime[]
     */
	public static function getRunDates(string $expression, int $total = 5): array
	{
        if (!self::isValidExpression($expression)) {
            return [];
        }

        return CronExpression::factory($expression)
            ->getMultipleRunDates($total);
    }
    
    /**
     * Получить все открытые методы запрошенного класса
     *
     * @param string $class
     * @return array
     */
    public static function getClassMethods(string $class): array
    {
        if (class_exists($class)) {
            $classMethods = get_class_methods($class);
        }

        return $classMethods ?? [];
    }

    /**
     * Получить синтаксис выражения крона
     *
     * @return string
     */
    public static function getCronExpressionSyntax(): string
    {
        return file_get_contents(__DIR__ .'/cron_expression_syntax.html');
    }

    /**
     * Получить список выражений крона по умолчанию
     *
     * @return array
     */
    public function getDefaultCronExpressionList(): array
    {
        return [
            '* * * * *' => 'Каждую минуту',
            '0 * * * *' => 'Каждый час',
            '0 0 * * *' => 'Каждый день',
            '0 0 * * 0' => 'Каждую неделю',
            '0 0 1 * *' => 'Каждый месяц',
            '0 0 1 1 *' => 'Каждый год',
        ];
    }
}
