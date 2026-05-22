<?php

namespace App\UI\Http\Api\Admin\Requests;

use DateTimeImmutable;
use Illuminate\Foundation\Http\FormRequest;

abstract class AbstractFormRequest extends FormRequest
{
    abstract public function rules(): array;
    abstract public function dto(): mixed;

    protected function field(string $key): mixed
    {
        return $this->has($key) ? $this->input($key) : null;
    }

    protected function fieldString(string $key): ?string
    {
        return $this->has($key) ? $this->string($key)->toString() : null;
    }

    protected function fieldInt(string $key): ?int
    {
        return $this->has($key) && $this->field($key) !== null
            ? $this->integer($key)
            : null;
    }

    protected function fieldFloat(string $key): ?float
    {
        return $this->has($key) ? $this->float($key) : null;
    }

    protected function fieldBool(string $key): ?bool
    {
        return $this->has($key) ? $this->boolean($key) : null;
    }

    /**
     * @throws \DateMalformedStringException
     */
    protected function fieldDate(string $key): ?DateTimeImmutable
    {
        return $this->has($key) ? new DateTimeImmutable($this->input($key)) : null;
    }

    protected function fieldEnum(string $key, string $enumClass): mixed
    {
        return $this->has($key) ? $this->enum($key, $enumClass) : null;
    }
}
