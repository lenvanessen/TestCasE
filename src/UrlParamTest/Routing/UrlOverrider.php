<?php

namespace Bundle\UrlParamTest\Routing;

use Silex\Application;
use Symfony\Component\Routing\Generator\ConfigurableRequirementsInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RequestContext;

class UrlOverrider implements UrlGeneratorInterface, ConfigurableRequirementsInterface
{
    /** @var UrlGeneratorInterface */
    protected $wrapped;

    /**
     * UrlGeneratorFragmentWrapper constructor.
     *
     * @param UrlGeneratorInterface $wrapped
     */
    public function __construct(UrlGeneratorInterface $wrapped, Application $app)
    {
        $this->wrapped = $wrapped;
        $this->app = $app;
    }

    /**
     * {@inheritdoc}
     *
     * Makes sure the _locale parameter is always set.
     */
    public function generate($name, $parameters = [], $referenceType = UrlGeneratorInterface::ABSOLUTE_PATH)
    {
        if (empty($parameters['_bug'])) {
            $parameters['_bug'] = true;
        }

        return $this->wrapped->generate($name, $parameters, $referenceType);
    }

    /**
     * {@inheritdoc}
     */
    public function setContext(RequestContext $context)
    {
        $this->wrapped->setContext($context);
    }

    /**
     * {@inheritdoc}
     */
    public function getContext()
    {
        return $this->wrapped->getContext();
    }

    /**
     * {@inheritdoc}
     */
    public function setStrictRequirements($enabled)
    {
        if ($this->wrapped instanceof ConfigurableRequirementsInterface) {
            $this->wrapped->setStrictRequirements($enabled);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function isStrictRequirements()
    {
        if ($this->wrapped instanceof ConfigurableRequirementsInterface) {
            return $this->wrapped->isStrictRequirements();
        }

        return null; // requirements check is deactivated completely
    }
}
