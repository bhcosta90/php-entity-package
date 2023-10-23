<?php

declare(strict_types=1);

namespace Costa\Entity;

use Costa\Entity\Contracts\DataInterface;
use Costa\Entity\Exceptions\NotificationException;
use Costa\Entity\Factory\ValidatorFactory;
use Costa\Entity\Support\NotificationSupport;
use Costa\Entity\Traits\EventTrait;
use Costa\Entity\Traits\MakeTrait;
use Costa\Entity\Traits\MethodMagicTrait;
use Costa\Entity\Traits\ToArrayTrait;
use Costa\Entity\Traits\ValidateTrait;
use Costa\Entity\ValueObject\Uuid;
use DateTime;
use DateTimeInterface;

abstract class Data implements DataInterface
{
    use ValidateTrait;
    use MethodMagicTrait;
    use ToArrayTrait;
    use MakeTrait;
    use EventTrait;

    protected Uuid $id;

    protected DateTimeInterface $createdAt;

    protected DateTimeInterface $updatedAt;

    private NotificationSupport $notification;

    /**
     * @throws NotificationException
     */
    protected function __construct()
    {
        $this->notification = new NotificationSupport();
        $this->id = Uuid::make();
        $this->createdAt = new DateTime();
        $this->updatedAt = new DateTime();

        $this->validated();
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

    protected function rules(): array
    {
        return [];
    }

    protected function notification(): NotificationSupport
    {
        return $this->notification;
    }

    protected static function transformValueInTypePropery($type, mixed $value): mixed
    {
        if ($type == Uuid::class && in_array(gettype($value), ['string'])) {
            $value = new Uuid($value);
        }

        return $value;
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

}
