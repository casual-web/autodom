<?php
/**
 * Created by PhpStorm.
 * User: olivier
 * Date: 26/02/15
 * Time: 10:13
 */

namespace AppBundle\Notification;

use AppBundle\Entity\QuotationRequest;
use Symfony\Component\Templating\EngineInterface;

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

        $relation = $quotationRequest->getQuotationRequestServiceRelations();
        $sumup = '';
        foreach ($relation as $item) {
            $sumup .= ' ' . $item->getBusinessServiceRef();
        }

        $mail
            ->setFrom(['contact@autodom.biz' => 'Autodom'])
            ->setTo(['contact@autodom.biz'])
            ->setBcc(['contact@casual-web.com'])
            ->setSubject(sprintf("Demande de devis : %s", $sumup))
            ->setBody($this->renderQuotationRequestNotificationBody($quotationRequest))
            ->setReplyTo('no-reply@autodom.biz')
            ->setContentType('text/html; charset="UTF-8');

        $this->mailer->send($mail);
    }

    public function renderQuotationRequestNotificationBody(QuotationRequest $quotationRequest)
    {
        return $this->templating->render(
            'AppBundle:Notification:quotation_request.html.twig',
            ['entity' => $quotationRequest]
        );
    }


    /*
    'Content-Type: text/html; charset="UTF-8"' . "\r\n";
    'Content-Transfer-Encoding: 8bit' . "\r\n" .
    'X-Mailer: PHP/'*/
}

