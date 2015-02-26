<?php
/**
 * Created by PhpStorm.
 * User: olivier
 * Date: 26/02/15
 * Time: 10:13
 */

namespace AppBundle\Notification;

use Symfony\Component\Templating\EngineInterface;
use AppBundle\Entity\QuotationRequest;

class Notifier
{

    protected $mailer;
    protected $templating;
    protected $parameters;
    protected $replyTo;

    public function __construct($mailer, EngineInterface $templating)
    {
        $this->mailer = $mailer;
        $this->templating = $templating;
    }

    public function sendQuotationRequestNotification(QuotationRequest $quotationRequest)
    {
        $mail = \Swift_Message::newInstance();
        $serviceRefList = array();
        $mail
            ->setFrom('contact@casual-web.com', 'Autodom')
            ->setTo('contact@casual-web.com;contact@autodom.biz')
            ->setSubject(sprintf("Demande de devis : %s", $serviceRefList))
            ->setBody($this->renderQuotationRequestNotificationBody($quotationRequest))
            ->setReplyTo('no-reply@autodom.biz')
            ->setContentType('text/html; charset="UTF-8')
            ->setContentTransferEncoding('8bit');

        $this->mailer->send($mail);
    }

    public function renderQuotationRequestNotificationBody(QuotationRequest $quotationRequest)
    {
        return $this->templating->render(
            'AppBundle:Notification:quotation_request.html.twig',
            ['entity' => $quotationRequest]);
    }

    /*
    'Content-Type: text/html; charset="UTF-8"' . "\r\n";
    'Content-Transfer-Encoding: 8bit' . "\r\n" .
    'X-Mailer: PHP/'*/
}

