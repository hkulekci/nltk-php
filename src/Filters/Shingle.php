<?php
/**
 * @since     Sep 2023
 * @author    Haydar KULEKCI <haydarkulekci@gmail.com>
 */

namespace Nltk\Filters;

use Nltk\Exceptions\ValidationError;

class Shingle implements FilterInterface
{
    private int $min;
    private int $max;
    private string $delimiter;

    /**
     * @throws ValidationError
     */
    public function __construct(int $min, int $max, string $delimiter = ' ')
    {
        if ($min >= $max) {
            throw new ValidationError('Min should be smaller than max!');
        }
        $this->min = $min;
        $this->max = $max;
        $this->delimiter = $delimiter;
    }

    /**
     * @throws ValidationError
     */
    public function filter(array $tokens): array
    {
        $total = count($tokens);
        if ($total < $this->max) {
            $this->max = count($tokens) - $this->min;
        }
        if ($this->max < $this->min) {
            throw new ValidationError('Shingle filter: max value should be greater or equal than min value');
        }

        $result = [];
        for ($windowSize = $this->min; $windowSize < $this->max + 1; $windowSize++) {
            for ($windowPosition = 0; $windowPosition < $total - $windowSize; $windowPosition++) {
                $sub = [];
                for ($index = $windowPosition; $index < $windowPosition + $windowSize; $index++) {
                    $sub[] = $tokens[$index];
                }
                $result[] = implode($this->delimiter, $sub);
            }
        }

        return $result;
    }
}