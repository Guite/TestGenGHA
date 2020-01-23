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

namespace Zikula\MultiHookModule\Menu\Base;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Zikula\ExtensionsModule\Api\ApiInterface\VariableApiInterface;
use Zikula\UsersModule\Api\ApiInterface\CurrentUserApiInterface;
use Zikula\UsersModule\Constant as UsersConstant;
use Zikula\MultiHookModule\Entity\EntryEntity;
use Zikula\MultiHookModule\MultiHookEvents;
use Zikula\MultiHookModule\Event\ConfigureItemActionsMenuEvent;
use Zikula\MultiHookModule\Event\ConfigureViewActionsMenuEvent;
use Zikula\MultiHookModule\Helper\ModelHelper;
use Zikula\MultiHookModule\Helper\PermissionHelper;

/**
 * Menu builder base class.
 */
class AbstractMenuBuilder
{
    /**
     * @var FactoryInterface
     */
    protected $factory;
    
    /**
     * @var EventDispatcherInterface
     */
    protected $eventDispatcher;
    
    /**
     * @var RequestStack
     */
    protected $requestStack;
    
    /**
     * @var PermissionHelper
     */
    protected $permissionHelper;
    
    /**
     * @var CurrentUserApiInterface
     */
    protected $currentUserApi;
    
    /**
     * @var VariableApiInterface
     */
    protected $variableApi;
    
    /**
     * @var ModelHelper
     */
    protected $modelHelper;
    
    public function __construct(
        FactoryInterface $factory,
        EventDispatcherInterface $eventDispatcher,
        RequestStack $requestStack,
        PermissionHelper $permissionHelper,
        CurrentUserApiInterface $currentUserApi,
        VariableApiInterface $variableApi,
        ModelHelper $modelHelper
    ) {
        $this->factory = $factory;
        $this->eventDispatcher = $eventDispatcher;
        $this->requestStack = $requestStack;
        $this->permissionHelper = $permissionHelper;
        $this->currentUserApi = $currentUserApi;
        $this->variableApi = $variableApi;
        $this->modelHelper = $modelHelper;
    }
    
    /**
     * Builds the item actions menu.
     */
    public function createItemActionsMenu(array $options = []): ItemInterface
    {
        $menu = $this->factory->createItem('itemActions');
        if (!isset($options['entity'], $options['area'], $options['context'])) {
            return $menu;
        }
    
        $entity = $options['entity'];
        $routeArea = $options['area'];
        $context = $options['context'];
        $menu->setChildrenAttribute('class', 'nav item-actions');
    
        $this->eventDispatcher->dispatch(
            new ConfigureItemActionsMenuEvent($this->factory, $menu, $options),
            MultiHookEvents::MENU_ITEMACTIONS_PRE_CONFIGURE
        );
    
        if ($entity instanceof EntryEntity) {
            $routePrefix = 'zikulamultihookmodule_entry_';
            
            if ($this->permissionHelper->mayEdit($entity)) {
                $menu->addChild('Edit', [
                    'route' => $routePrefix . $routeArea . 'edit',
                    'routeParameters' => $entity->createUrlArgs()
                ])
                    ->setLinkAttribute(
                        'title',
                        'Edit this entry'
                    )
                    ->setAttribute('icon', 'fas fa-edit')
                    ->setExtra('translation_domain', 'entry')
                ;
                $menu->addChild('Reuse', [
                    'route' => $routePrefix . $routeArea . 'edit',
                    'routeParameters' => ['astemplate' => $entity->getKey()]
                ])
                    ->setLinkAttribute(
                        'title',
                        'Reuse for new entry'
                    )
                    ->setAttribute('icon', 'fas fa-copy')
                    ->setExtra('translation_domain', 'entry')
                ;
            }
        }
    
        $this->eventDispatcher->dispatch(
            new ConfigureItemActionsMenuEvent($this->factory, $menu, $options),
            MultiHookEvents::MENU_ITEMACTIONS_POST_CONFIGURE
        );
    
        return $menu;
    }
    
    /**
     * Builds the view actions menu.
     */
    public function createViewActionsMenu(array $options = []): ItemInterface
    {
        $menu = $this->factory->createItem('viewActions');
        if (!isset($options['objectType'], $options['area'])) {
            return $menu;
        }
    
        $objectType = $options['objectType'];
        $routeArea = $options['area'];
        $menu->setChildrenAttribute('class', 'nav view-actions');
    
        $this->eventDispatcher->dispatch(
            new ConfigureViewActionsMenuEvent($this->factory, $menu, $options),
            MultiHookEvents::MENU_VIEWACTIONS_PRE_CONFIGURE
        );
    
        $query = $this->requestStack->getMasterRequest()->query;
        $currentTemplate = $query->getAlnum('tpl', '');
        if ('entry' === $objectType) {
            $routePrefix = 'zikulamultihookmodule_entry_';
            if (!in_array($currentTemplate, [])) {
                $canBeCreated = $this->modelHelper->canBeCreated($objectType);
                if ($canBeCreated) {
                    if ($this->permissionHelper->hasComponentPermission($objectType, ACCESS_EDIT)) {
                        $menu->addChild('Create entry', [
                            'route' => $routePrefix . $routeArea . 'edit'
                        ])
                            ->setAttribute('icon', 'fas fa-plus')
                            ->setExtra('translation_domain', 'entry')
                        ;
                    }
                }
                $routeParameters = $query->all();
                if (1 === $query->getInt('own')) {
                    $routeParameters['own'] = 1;
                } else {
                    unset($routeParameters['own']);
                }
                if (1 === $query->getInt('all')) {
                    unset($routeParameters['all']);
                    $menu->addChild('Back to paginated view', [
                        'route' => $routePrefix . $routeArea . 'view',
                        'routeParameters' => $routeParameters
                    ])
                        ->setAttribute('icon', 'fas fa-table')
                    ;
                } else {
                    $routeParameters['all'] = 1;
                    $menu->addChild('Show all entries', [
                        'route' => $routePrefix . $routeArea . 'view',
                        'routeParameters' => $routeParameters
                    ])
                        ->setAttribute('icon', 'fas fa-table')
                    ;
                }
                if ($this->permissionHelper->hasComponentPermission($objectType, ACCESS_EDIT)) {
                    $routeParameters = $query->all();
                    if (1 === $query->getInt('own')) {
                        unset($routeParameters['own']);
                        $menu->addChild('Show also entries from other users', [
                            'route' => $routePrefix . $routeArea . 'view',
                            'routeParameters' => $routeParameters
                        ])
                            ->setAttribute('icon', 'fas fa-users')
                        ;
                    } else {
                        $routeParameters['own'] = 1;
                        $menu->addChild('Show only own entries', [
                            'route' => $routePrefix . $routeArea . 'view',
                            'routeParameters' => $routeParameters
                        ])
                            ->setAttribute('icon', 'fas fa-user')
                        ;
                    }
                }
            }
        }
    
        $this->eventDispatcher->dispatch(
            new ConfigureViewActionsMenuEvent($this->factory, $menu, $options),
            MultiHookEvents::MENU_VIEWACTIONS_POST_CONFIGURE
        );
    
        return $menu;
    }
}
