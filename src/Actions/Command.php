<?php

declare(strict_types=1);

namespace ResponseActions\Actions;

/**
 * @method static static make(CommandStatus $status, string $description = null)
 */
class Command extends AbstractAction
{
    public function __construct(protected CommandStatus $status, protected ?string $description = null)
    {
    }

    /**
     * @return array{status:string, description:string}|array{status:string}
     */
    protected function toActionArray(): array
    {
        $result = ['status' => $this->status->value];
        if ($this->description !== null) {
            $result['description'] = $this->description;
        }

        return $result;
    }

    public static function failed(string $description = null): static
    {
        return static::make(CommandStatus::Failed, $description);
    }

    public static function done(string $description = null): static
    {
        return static::make(CommandStatus::Done, $description);
    }
}
