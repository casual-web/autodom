<?php

namespace AppBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use AppBundle\Entity\QuotationRequest;
use CrEOF\Spatial\PHP\Types\Geography\Point;

class QuotationRequestGeocoding
{

    const GOOGLE_GEOCODING_API = "http://maps.googleapis.com/maps/api/geocode/json?address=%s&sensor=true";

    /**
     * @param string $lat
     * @param string $lng
     * @return bool
     */
    private function isPointValid($lat, $lng)
    {
        return !(($lng < -180 || $lng > 180) || ($lat < -90 || $lat > 90));
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
      /*  if ($entity instanceof QuotationRequest) {
            $query = sprintf(self::GOOGLE_GEOCODING_API, urlencode(utf8_encode($entity->getAddress())));
            $result = json_decode(file_get_contents($query));


            if (isset($result->results[0])) {
                {
                    $json = $result->results[0];
                    $lat = (string)$json->geometry->location->lat;
                    $lng = (string)$json->geometry->location->lng;
                    if ($this->isPointValid($lat, $lng)) {
                        $entity->setPoint(new Point($lat, $lng));
                    }
                }
            }


        }*/
    }
}