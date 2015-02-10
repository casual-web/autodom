<?php
/**
 * Created by PhpStorm.
 * User: olivier
 * Date: 10/02/15
 * Time: 16:53
 */

namespace AppBundle\Twig;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class AutodomExtension extends \Twig_Extension
{

    /**
     * @var \Symfony\Component\HttpFoundation\Request
     */
    protected $request;

    /**
     * Constructor
     */
    public function __construct(RequestStack $requestStack)
    {
        $this->currentRequest = $requestStack->getCurrentRequest();
    }

    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('is_route_active', array($this, 'isRouteActiveFilter')),
        );
    }

    public function isRouteActiveFilter($route)
    {
        $class = '';
        if ($route == $this->currentRequest->attributes->get('_route')) {
            $class = 'active';
        }
        return $class;
    }

    public function getName()
    {
        return 'autodom_extension';
    }
}