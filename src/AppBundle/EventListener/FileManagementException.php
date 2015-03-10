<?php
/**
 * Created by PhpStorm.
 * User: olivier
 * Date: 28/02/15
 * Time: 22:09
 */

namespace AppBundle\EventListener;

use \AppBundle\Entity\ImageSite;

class FileManagementException extends \Exception
{
    const FILE_NOT_FOUND = 0;

    /**
     * @param string $file
     * @param ImageSite $imageSite
     * @param \Exception $previous
     */
    public function __construct($file, ImageSite $imageSite, \Exception $previous = null)
    {
        $id = $imageSite->getId();

        if (!file_exists($file)) {
            $message = __CLASS__ . "[FILE_NOT_FOUND]:The file '$file' from entity with ID: '$id' can't be found.";
        } else {
            $message = __CLASS__ . "[]:Unexpected '$file' problem from entity with ID: '$id'.";
        }

        parent::__construct($message, 0, $previous);
    }


}
