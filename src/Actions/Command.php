<?php

declare(strict_types=1);

namespace ResponseActions\Actions;

class Command extends AbstractAction
{
    public function __construct(
        protected CommandStatus $status = CommandStatus::Pending,
        protected ?string $description = null
    ) {
    }

    public function name(): string
    {
        return 'cmd';
    }

    /**
     * @return array{status:string, description:string}|array{status:string}
     */
    protected function toActionArray(): array
    {
        $result = ['status' => $this->status];
        if ($this->description !== null) {
            $result['description'] = $this->description;
        }

        return $result;
    }

    public static function pending(?string $description = null): static
    {
        return new static(CommandStatus::Pending, $description);
    }

    public static function makeFailed(?string $description = null): static
    {
        return new static(CommandStatus::Failed, $description);
    }

    public static function makeDone(?string $description = null): static
    {
        return new static(CommandStatus::Done, $description);
    }

    public function setDescription(?string $description = null): static
    {
        if ($description !== null) {
            $this->description = $description;
        }

        return $this;
    }

    private function setStatus(CommandStatus $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function done(?string $description = null): static
    {
        return $this->setStatus(CommandStatus::Done)
            ->setDescription($description);
    }

    public function failed(?string $description = null): static
    {
        return $this->setStatus(CommandStatus::Failed)
            ->setDescription($description);
    }

    public function isFailed(): bool
    {
        return $this->status === CommandStatus::Failed;
    }
}
