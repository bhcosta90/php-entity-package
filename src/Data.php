<?php

declare(strict_types=1);

namespace Costa\Entity;

use Costa\Entity\Contracts\DataInterface;
use Costa\Entity\Contracts\ValueObjectInterface;
use Costa\Entity\Exceptions\NotificationException;
use Costa\Entity\Factory\ValidatorFactory;
use Costa\Entity\Support\NotificationSupport;
use Costa\Entity\Support\ParameterSupport;
use Costa\Entity\Traits\MethodMagicTrait;
use Costa\Entity\Traits\ValidateTrait;
use Costa\Entity\ValueObject\Uuid;
use DateTime;
use DateTimeInterface;

abstract class Data implements DataInterface
{
    use ValidateTrait;
    use MethodMagicTrait;

    private NotificationSupport $notification;

    protected Uuid $id;

    protected DateTimeInterface $createdAt;

    protected DateTimeInterface $updatedAt;

    protected function __construct()
    {
        $this->notification = new NotificationSupport();
        $this->id = Uuid::make();
        $this->createdAt = new DateTime();
        $this->updatedAt = new DateTime();

        $this->validated();
    }

    public function id(): string
    {
        return (string)$this->id;
    }

    public function createdAt(): string
    {
        return (string)$this->createdAt->format('Y-m-d H:i:s');
    }

    public function updatedAt(): string
    {
        return (string)$this->updatedAt->format('Y-m-d H:i:s');
    }

    public static function make(mixed ...$payloads): static
    {
        if (is_array($payloads)) {
            $payloads = $payloads[0];
        }

        $parameters = new ParameterSupport(static::class);

        $dataConstructor = [];

        foreach ($parameters->getConstructorProperties() as $property) {
            $value = null;
            $name = $property['value'];
            $type = $property['type'];

            if (in_array($property['value'], array_keys($payloads))) {
                $value = $payloads[$name];
            }

            $dataConstructor[$name] = self::transformValueInTypePropery($type, $value);
        }

        $obj = new static(...$dataConstructor);

        $properties = [];
        foreach($parameters->getProperties() as $property) {
            $properties[$property['value']] = $property['type'];
        }

        foreach ($payloads as $key => $payload) {
            if (in_array($key, ['id', 'updatedAt', 'createdAt'])) {
                $obj->{$key} = self::transformValueInTypePropery($properties[$key], $payload);
            }
        }

        $obj->validated();

        return $obj;
    }

    public function toArray(): array
    {
        $parameters = new ParameterSupport(static::class);

        $response = [];
        foreach ($parameters->getProperties() as $property) {
            $key = strtolower(preg_replace('/([a-z])([A-Z])/', '$1_$2', $property['value']));

            $valueProperty = $this->{$property['value']};

            if ($valueProperty instanceof DateTimeInterface) {
                $valueProperty = $valueProperty->format('Y-m-d H:i:s');
            }

            if ($valueProperty instanceof ValueObjectInterface) {
                $valueProperty = (string)$valueProperty;
            }

            if (is_array($valueProperty)) {
                $newDataValue = [];
                foreach ($valueProperty as $value) {
                    if ($value instanceof DataInterface) {
                        $newDataValue[] = $value->toArray();
                    }

                    if ($value instanceof ValueObjectInterface) {
                        $newDataValue[] = (string)$value;
                    }
                }
                $valueProperty = $newDataValue;
            }

            if ($valueProperty instanceof DataInterface) {
                $valueProperty = $valueProperty->toArray();
            }

            $response[$key] = $valueProperty;
        }

        return $response;
    }

    protected function rules(): array
    {
        return [];
    }

    protected function notification(): NotificationSupport
    {
        return $this->notification;
    }

    /**
     * @throws NotificationException
     */
    protected function validated(): void
    {
        $data = $this->toArray();

        if ($errors = ValidatorFactory::make($data, $this->rules())) {
            array_map(fn($error) => $this->notification()->push(static::class, $error), $errors);
        }

        if ($this->notification()->has()) {
            throw new NotificationException($this->notification()->messages());
        }
    }

    protected static function transformValueInTypePropery($type, mixed $value): mixed
    {
        if ($type == Uuid::class && in_array(gettype($value), ['string'])) {
            $value = new Uuid($value);
        }

        return $value;
    }

}
