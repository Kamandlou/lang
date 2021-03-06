<?php

namespace LaravelLang\Lang\Services\Compilers;

use LaravelLang\Lang\Constants\Resource;

final class Referents extends Compiler
{
    public function toString(): string
    {
        $content = $this->compileContent();

        return $this->template(Resource::REFERENTS, compact('content'));
    }

    protected function compileContent(): string
    {
        $rows = [];

        foreach ($this->items as $key => $value) {
            $rows[] = $this->mapRow($key, $value);
        }

        return Table::make($this->app)->items($rows)->toString();
    }

    protected function mapRow(string $key, int|array $values): array
    {
        $row = [$key, ''];

        if (is_array($values)) {
            $row[1] = $this->mapAssignees($values);
        }

        return $row;
    }

    protected function mapAssignees(array $values): string
    {
        $result = [];

        foreach ($values as $value) {
            $result[] = $this->template(Resource::COMPONENT_LINK, [
                'title' => '@' . $value,
                'link'  => 'https://github.com/' . $value,
            ]);
        }

        return implode(', ', $result);
    }
}
