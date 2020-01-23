<?php

/**
 * MultiHook.
 *
 * @copyright Zikula Team (Zikula)
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 * @author Zikula Team <info@ziku.la>.
 * @see https://ziku.la
 * @version Generated by ModuleStudio 1.4.0 (https://modulestudio.de).
 */

declare(strict_types=1);

namespace Zikula\MultiHookModule\HookSubscriber\Base;

use Symfony\Contracts\Translation\TranslatorInterface;
use Zikula\Bundle\HookBundle\Category\UiHooksCategory;
use Zikula\Bundle\HookBundle\HookSubscriberInterface;

/**
 * Base class for ui hooks subscriber.
 */
abstract class AbstractEntryUiHooksSubscriber implements HookSubscriberInterface
{
    /**
     * @var TranslatorInterface
     */
    protected $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    public function getOwner(): string
    {
        return 'ZikulaMultiHookModule';
    }
    
    public function getCategory(): string
    {
        return UiHooksCategory::NAME;
    }
    
    public function getTitle(): string
    {
        return $this->translator->trans('Entry ui hooks subscriber', [], 'hooks');
    }
    
    public function getAreaName(): string
    {
        return 'subscriber.zikulamultihookmodule.ui_hooks.entries';
    }

    public function getEvents(): array
    {
        return [
            // Display hook for view/display templates.
            UiHooksCategory::TYPE_DISPLAY_VIEW => 'zikulamultihookmodule.ui_hooks.entries.display_view',
            // Display hook for create/edit forms.
            UiHooksCategory::TYPE_FORM_EDIT => 'zikulamultihookmodule.ui_hooks.entries.form_edit',
            // Validate input from an item to be edited.
            UiHooksCategory::TYPE_VALIDATE_EDIT => 'zikulamultihookmodule.ui_hooks.entries.validate_edit',
            // Perform the final update actions for an edited item.
            UiHooksCategory::TYPE_PROCESS_EDIT => 'zikulamultihookmodule.ui_hooks.entries.process_edit',
            // Validate input from an item to be deleted.
            UiHooksCategory::TYPE_VALIDATE_DELETE => 'zikulamultihookmodule.ui_hooks.entries.validate_delete',
            // Perform the final delete actions for a deleted item.
            UiHooksCategory::TYPE_PROCESS_DELETE => 'zikulamultihookmodule.ui_hooks.entries.process_delete'
        ];
    }
}
