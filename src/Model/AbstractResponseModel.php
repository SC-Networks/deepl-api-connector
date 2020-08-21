<?php

declare(strict_types=1);

namespace Scn\DeeplApiConnector\Model;

use stdClass;

abstract class AbstractResponseModel implements ResponseModelInterface
{
    const SETTER_PREFIX = 'set';

    public function hydrate(stdClass $responseModel): ResponseModelInterface
    {
        foreach ($responseModel as $key => $value) {
            if (is_array($value)) {
                $this->hydrate(current($value));
            }

            $modelSetter = $this->getModelSetter($key);

            if (method_exists($this, $modelSetter)) {
                $this->$modelSetter($value);
            }
        }

        return $this;
    }

    private function getModelSetter(string $key): string
    {
        return self::SETTER_PREFIX.
            str_replace(
                ' ',
                '',
                ucwords(
                    str_replace('_', ' ', $key)
                )
            );
    }
}
