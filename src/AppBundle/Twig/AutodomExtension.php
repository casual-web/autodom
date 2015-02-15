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
use AppBundle\DBAL\Types\QuotationRequestStatusEnumType;

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

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('qr_status_enum_to_label', array($this, 'QRStatusEnumToLabel')),
            new \Twig_SimpleFunction('qr_status_enum_to_style', array($this, 'QRStatusEnumToStyle')),
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

    public function QRStatusEnumToLabel($enumItem)
    {
        $label = QuotationRequestStatusEnumType::getReadableValue($enumItem);
        return $label;

    }

    public function QRStatusEnumToStyle($enumItem)
    {
        $style = 'label label-default';

        switch ($enumItem) {
            case QuotationRequestStatusEnumType::CANCELLED:
                $style = 'default';
                break;
            case QuotationRequestStatusEnumType::CREATED:
                $style = 'info';
                break;
            case QuotationRequestStatusEnumType::SCHEDULED:
                $style = 'primary';
                break;
            case QuotationRequestStatusEnumType::CHARGED:
                $style = 'danger';
                break;
            case QuotationRequestStatusEnumType::CASHED:
                $style = 'success';
                break;
            case QuotationRequestStatusEnumType::PENDING:
                $style = 'warning';
                break;
        }

        return $style;

    }


    public function getName()
    {
        return 'autodom_extension';
    }
}