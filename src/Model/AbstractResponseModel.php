<?php

namespace Scn\DeeplApiConnector\Model;

/**
 * Class AbstractResponseModel
 *
 * @package Scn\DeeplApiConnector\Model
 */
abstract class AbstractResponseModel implements ResponseModelInterface
{

    const SETTER_PREFIX = 'set';

    /**
     * @param \stdClass $responseModel
     *
     * @return ResponseModelInterface
     */
    public function hydrate(\stdClass $responseModel)
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

    /**
     * @param string $key
     *
     * @return string
     */
    private function getModelSetter($key)
    {
        return self::SETTER_PREFIX .
            str_replace(
                ' ',
                '',
                ucwords(
                    str_replace('_', ' ', $key)
                )
            );
    }
}