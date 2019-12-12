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

namespace Zikula\MultiHookModule\Listener\Base;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Zikula\Core\Event\GenericEvent;
use Zikula\GroupsModule\GroupEvents;

/**
 * Event handler implementation class for group-related events.
 */
abstract class AbstractGroupListener implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            GroupEvents::GROUP_CREATE                => ['create', 5],
            GroupEvents::GROUP_UPDATE                => ['update', 5],
            GroupEvents::GROUP_PRE_DELETE            => ['preDelete', 5],
            GroupEvents::GROUP_DELETE                => ['delete', 5],
            GroupEvents::GROUP_ADD_USER              => ['addUser', 5],
            GroupEvents::GROUP_REMOVE_USER           => ['removeUser', 5],
            GroupEvents::GROUP_APPLICATION_PROCESSED => ['applicationProcessed', 5],
            GroupEvents::GROUP_NEW_APPLICATION       => ['newApplication', 5]
        ];
    }
    
    /**
     * Listener for the `group.create` event.
     *
     * Occurs after a group is created. All handlers are notified.
     * The full group record created is available as the subject.
     *
     * You can access general data available in the event.
     *
     * The event name:
     *     `echo 'Event: ' . $event->getName();`
     *
     */
    public function create(GenericEvent $event): void
    {
    }
    
    /**
     * Listener for the `group.update` event.
     *
     * Occurs after a group is updated. All handlers are notified.
     * The full updated group record is available as the subject.
     *
     * You can access general data available in the event.
     *
     * The event name:
     *     `echo 'Event: ' . $event->getName();`
     *
     */
    public function update(GenericEvent $event): void
    {
    }
    
    /**
     * Listener for the `group.pre_delete` event.
     *
     * Occurs before a group is deleted from the system. All handlers are notified.
     * The full group record to be deleted is available as the subject.
     *
     * You can access general data available in the event.
     *
     * The event name:
     *     `echo 'Event: ' . $event->getName();`
     *
     */
    public function preDelete(GenericEvent $event): void
    {
    }
    
    /**
     * Listener for the `group.delete` event.
     *
     * Occurs after a group is deleted from the system. All handlers are notified.
     * The full group record deleted is available as the subject.
     *
     * You can access general data available in the event.
     *
     * The event name:
     *     `echo 'Event: ' . $event->getName();`
     *
     */
    public function delete(GenericEvent $event): void
    {
    }
    
    /**
     * Listener for the `group.adduser` event.
     *
     * Occurs after a user is added to a group. All handlers are notified.
     * It does not apply to pending membership requests.
     * The uid and gid are available as the subject.
     *
     * You can access general data available in the event.
     *
     * The event name:
     *     `echo 'Event: ' . $event->getName();`
     *
     */
    public function addUser(GenericEvent $event): void
    {
    }
    
    /**
     * Listener for the `group.removeuser` event.
     *
     * Occurs after a user is removed from a group. All handlers are notified.
     * The uid and gid are available as the subject.
     *
     * You can access general data available in the event.
     *
     * The event name:
     *     `echo 'Event: ' . $event->getName();`
     *
     */
    public function removeUser(GenericEvent $event): void
    {
    }
    
    /**
     * Listener for the `group.application.processed` event.
     *
     * Occurs after a group application has been processed.
     * The subject is the GroupApplicationEntity.
     * Arguments are the form data from \Zikula\GroupsModule\Form\Type\ManageApplicationType
     *
     * You can access general data available in the event.
     *
     * The event name:
     *     `echo 'Event: ' . $event->getName();`
     *
     */
    public function applicationProcessed(GenericEvent $event): void
    {
    }
    
    /**
     * Listener for the `group.application.new` event.
     *
     * Occurs after the successful creation of a group application.
     * The subject is the GroupApplicationEntity.
     *
     * You can access general data available in the event.
     *
     * The event name:
     *     `echo 'Event: ' . $event->getName();`
     *
     */
    public function newApplication(GenericEvent $event): void
    {
    }
}
