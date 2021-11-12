<?php

namespace ContaoEstateManager\EstateManager\EventListener;

use Contao\Config;
use Contao\CoreBundle\Framework\ContaoFramework;
use Contao\Email;
use Contao\FrontendTemplate;
use Contao\StringUtil;
use Contao\System;
use ContaoEstateManager\EstateManager\Exception\BaseException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Handle exceptions
 *
 * @author Daniele Sciannimanica <https://github.com/doishub>
 */
class ExceptionSubscriber implements EventSubscriberInterface
{
    private ?string $email;
    private TranslatorInterface $translator;

    public function __construct(ContaoFramework $framework, TranslatorInterface $translator)
    {
        $framework->initialize();

        // Set translator
        $this->translator = $translator;

        // Get email for reportings
        $this->email = Config::get('estateManagerAdminEmail') ?? Config::get('adminEmail');

        // Load language file
        System::loadLanguageFile('tl_real_estate_config');
    }

    public function onKernelException(RequestEvent $event)
    {
        $e = $event->getThrowable();

        if (!$e instanceof BaseException) {
            return;
        }

        $arrExceptions = Config::get('cemExceptionNotifications');

        if($arrExceptions && $arrNotify = StringUtil::deserialize($arrExceptions))
        {
            foreach ($arrNotify as $exception)
            {
                if($GLOBALS['CEM_EEN'][ $exception ] === $e->getCode())
                {
                    $this->notify($e);
                }
            }
        }
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::EXCEPTION => 'onKernelException'
        ];
    }

    private function notify($e)
    {
        $email = new Email();

        // Set email specs
        $email->from = $this->email;
        $email->fromName = $this->translator->trans('tl_real_estate_config.reportFromName', [], 'contao_default');
        $email->subject = $this->translator->trans('tl_real_estate_config.reportSubject', [], 'contao_default');

        // Create message
        $htmlTemplate = new FrontendTemplate('mail_report_exception_html');
        $rawTemplate  = new FrontendTemplate('mail_report_exception_raw');

        $arrMailData = [
            'title'     => $this->translator->trans('tl_real_estate_config.reportSubject', [], 'contao_default'),
            'headline'  => $this->translator->trans('tl_real_estate_config.reportHeadline', [], 'contao_default'),
            'text'      => $this->translator->trans('tl_real_estate_config.reportText', [], 'contao_default'),
            'message'   => $e->getMessage(),
            'code'      => $e->getCode(),
            'file'      => $e->getFile(),
            'line'      => $e->getLine()
        ];

        $htmlTemplate->setData($arrMailData);
        $rawTemplate->setData($arrMailData);

        // Set html content
        $email->text = $rawTemplate->parse();
        $email->html = $htmlTemplate->parse();

        // Send mail
        $email->sendTo($this->email);
    }
}
