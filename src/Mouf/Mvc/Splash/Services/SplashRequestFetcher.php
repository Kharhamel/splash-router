<?php

namespace Mouf\Mvc\Splash\Services;
use ReflectionParameter;

/**
 * This class is used to inject parameters into an object witch respect the RequestInterface of the PSR-7
 *
 * @author David Negrier and Benoit Ngo
 */
class SplashRequestFetcher implements ParameterFetcher
{
    /**
     * Returns whether this fetcher factory can handle the parameter passed in parameter for the url $url.
     *
     * @param ReflectionParameter $reflectionParameter
     * @param string $url
     * @return bool
     */
    public function canHandle(ReflectionParameter $reflectionParameter, string $url = null) : bool
    {
        $class = $reflectionParameter->getClass();
        if ($class === null) {
            return false;
        }
        $name = $class->getName();
        // Check type of requested parameter; Only interfaces are allowed in an action of a controller.
        if ($name === 'Psr\\Http\\Message\\RequestInterface' || $name === 'Psr\\Http\\Message\\ServerRequestInterface') {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Returns some data needed by this fetcher to fetch data from the request.
     * This data MUST be serializable (and will be serialized). This function will be called only once
     * and data cached. You can perform expensive computation in this function.
     *
     * @param ReflectionParameter $reflectionParameter
     * @param string|null $url
     * @return mixed
     */
    public function getFetcherData(ReflectionParameter $reflectionParameter, string $url = null)
    {
        return null;
    }

    /**
     * Returns the value to be injected in this parameter.
     *
     * @param mixed $data The data generated by "getFetcherData"
     * @param SplashRequestContext $context
     *
     * @return mixed
     */
    public function fetchValue($data, SplashRequestContext $context)
    {
        return $context->getRequest();
    }
}
