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

namespace Zikula\MultiHookModule\Controller\Base;

use Exception;
use Psr\Log\LoggerInterface;
use RuntimeException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Zikula\Bundle\HookBundle\Category\UiHooksCategory;
use Zikula\Component\SortableColumns\Column;
use Zikula\Component\SortableColumns\SortableColumns;
use Zikula\Bundle\CoreBundle\Controller\AbstractController;
use Zikula\UsersModule\Api\ApiInterface\CurrentUserApiInterface;
use Zikula\MultiHookModule\Entity\EntryEntity;
use Zikula\MultiHookModule\Entity\Factory\EntityFactory;
use Zikula\MultiHookModule\Form\Handler\Entry\EditHandler;
use Zikula\MultiHookModule\Helper\ControllerHelper;
use Zikula\MultiHookModule\Helper\HookHelper;
use Zikula\MultiHookModule\Helper\PermissionHelper;
use Zikula\MultiHookModule\Helper\ViewHelper;
use Zikula\MultiHookModule\Helper\WorkflowHelper;

/**
 * Entry controller base class.
 */
abstract class AbstractEntryController extends AbstractController
{
    
    /**
     * This is the default action handling the index area called without defining arguments.
     *
     * @throws AccessDeniedException Thrown if the user doesn't have required permissions
     */
    protected function indexInternal(
        Request $request,
        PermissionHelper $permissionHelper,
        bool $isAdmin = false
    ): Response {
        $objectType = 'entry';
        // permission check
        $permLevel = $isAdmin ? ACCESS_ADMIN : ACCESS_OVERVIEW;
        if (!$permissionHelper->hasComponentPermission($objectType, $permLevel)) {
            throw new AccessDeniedException();
        }
        
        $templateParameters = [
            'routeArea' => $isAdmin ? 'admin' : ''
        ];
        
        return $this->redirectToRoute('zikulamultihookmodule_entry_' . $templateParameters['routeArea'] . 'view');
    }
    
    
    /**
     * This action provides an item list overview.
     *
     * @throws AccessDeniedException Thrown if the user doesn't have required permissions
     * @throws Exception
     */
    protected function viewInternal(
        Request $request,
        RouterInterface $router,
        PermissionHelper $permissionHelper,
        ControllerHelper $controllerHelper,
        ViewHelper $viewHelper,
        string $sort,
        string $sortdir,
        int $pos,
        int $num,
        bool $isAdmin = false
    ): Response {
        $objectType = 'entry';
        // permission check
        $permLevel = $isAdmin ? ACCESS_ADMIN : ACCESS_READ;
        if (!$permissionHelper->hasComponentPermission($objectType, $permLevel)) {
            throw new AccessDeniedException();
        }
        
        $templateParameters = [
            'routeArea' => $isAdmin ? 'admin' : ''
        ];
        
        $request->query->set('sort', $sort);
        $request->query->set('sortdir', $sortdir);
        $request->query->set('pos', $pos);
        
        $routeName = 'zikulamultihookmodule_entry_' . ($isAdmin ? 'admin' : '') . 'view';
        $sortableColumns = new SortableColumns($router, $routeName, 'sort', 'sortdir');
        
        $sortableColumns->addColumns([
            new Column('shortForm'),
            new Column('longForm'),
            new Column('title'),
            new Column('entryType'),
            new Column('active'),
            new Column('createdBy'),
            new Column('createdDate'),
            new Column('updatedBy'),
            new Column('updatedDate'),
        ]);
        
        $templateParameters = $controllerHelper->processViewActionParameters(
            $objectType,
            $sortableColumns,
            $templateParameters,
            true
        );
        
        // filter by permissions
        $templateParameters['items'] = $permissionHelper->filterCollection(
            $objectType,
            $templateParameters['items'],
            $permLevel
        );
        
        // fetch and return the appropriate template
        return $viewHelper->processTemplate($objectType, 'view', $templateParameters);
    }
    
    
    /**
     * This action provides a handling of edit requests.
     *
     * @throws AccessDeniedException Thrown if the user doesn't have required permissions
     * @throws RuntimeException Thrown if another critical error occurs (e.g. workflow actions not available)
     * @throws Exception
     */
    protected function editInternal(
        Request $request,
        PermissionHelper $permissionHelper,
        ControllerHelper $controllerHelper,
        ViewHelper $viewHelper,
        EditHandler $formHandler,
        bool $isAdmin = false
    ): Response {
        $objectType = 'entry';
        // permission check
        $permLevel = $isAdmin ? ACCESS_ADMIN : ACCESS_EDIT;
        if (!$permissionHelper->hasComponentPermission($objectType, $permLevel)) {
            throw new AccessDeniedException();
        }
        
        $templateParameters = [
            'routeArea' => $isAdmin ? 'admin' : ''
        ];
        
        $templateParameters = $controllerHelper->processEditActionParameters($objectType, $templateParameters);
        
        // delegate form processing to the form handler
        $result = $formHandler->processForm($templateParameters);
        if ($result instanceof RedirectResponse) {
            return $result;
        }
        
        $templateParameters = $formHandler->getTemplateParameters();
        
        // fetch and return the appropriate template
        return $viewHelper->processTemplate($objectType, 'edit', $templateParameters);
    }
    
    
    /**
     * Process status changes for multiple items.
     *
     * This function processes the items selected in the admin view page.
     * Multiple items may have their state changed or be deleted.
     *
     * @throws RuntimeException Thrown if executing the workflow action fails
     */
    protected function handleSelectedEntriesActionInternal(
        Request $request,
        LoggerInterface $logger,
        EntityFactory $entityFactory,
        WorkflowHelper $workflowHelper,
        HookHelper $hookHelper,
        CurrentUserApiInterface $currentUserApi,
        bool $isAdmin = false
    ): RedirectResponse {
        $objectType = 'entry';
        
        // Get parameters
        $action = $request->request->get('action');
        $items = $request->request->get('items');
        if (!is_array($items) || !count($items)) {
            return $this->redirectToRoute('zikulamultihookmodule_entry_' . ($isAdmin ? 'admin' : '') . 'index');
        }
        
        $action = strtolower($action);
        
        $repository = $entityFactory->getRepository($objectType);
        $userName = $currentUserApi->get('uname');
        
        // process each item
        foreach ($items as $itemId) {
            // check if item exists, and get record instance
            $entity = $repository->selectById($itemId, false);
            if (null === $entity) {
                continue;
            }
        
            // check if $action can be applied to this entity (may depend on it's current workflow state)
            $allowedActions = $workflowHelper->getActionsForObject($entity);
            $actionIds = array_keys($allowedActions);
            if (!in_array($action, $actionIds, true)) {
                // action not allowed, skip this object
                continue;
            }
        
            if ($entity->supportsHookSubscribers()) {
                // Let any ui hooks perform additional validation actions
                $hookType = 'delete' === $action
                    ? UiHooksCategory::TYPE_VALIDATE_DELETE
                    : UiHooksCategory::TYPE_VALIDATE_EDIT
                ;
                $validationErrors = $hookHelper->callValidationHooks($entity, $hookType);
                if (count($validationErrors) > 0) {
                    foreach ($validationErrors as $message) {
                        $this->addFlash('error', $message);
                    }
                    continue;
                }
            }
        
            $success = false;
            try {
                // execute the workflow action
                $success = $workflowHelper->executeAction($entity, $action);
            } catch (Exception $exception) {
                $this->addFlash(
                    'error',
                    $this->trans(
                        'Sorry, but an error occured during the %action% action.',
                        ['%action%' => $action]
                    ) . '  ' . $exception->getMessage()
                );
                $logger->error(
                    '{app}: User {user} tried to execute the {action} workflow action for the {entity} with id {id},'
                        . ' but failed. Error details: {errorMessage}.',
                    [
                        'app' => 'ZikulaMultiHookModule',
                        'user' => $userName,
                        'action' => $action,
                        'entity' => 'entry',
                        'id' => $itemId,
                        'errorMessage' => $exception->getMessage()
                    ]
                );
            }
        
            if (!$success) {
                continue;
            }
        
            if ('delete' === $action) {
                $this->addFlash(
                    'status',
                    $this->trans(
                        'Done! Entry deleted.',
                        [],
                        'entry'
                    )
                );
                $logger->notice(
                    '{app}: User {user} deleted the {entity} with id {id}.',
                    [
                        'app' => 'ZikulaMultiHookModule',
                        'user' => $userName,
                        'entity' => 'entry',
                        'id' => $itemId
                    ]
                );
            } else {
                $this->addFlash(
                    'status',
                    $this->trans(
                        'Done! Entry updated.',
                        [],
                        'entry'
                    )
                );
                $logger->notice(
                    '{app}: User {user} executed the {action} workflow action for the {entity} with id {id}.',
                    [
                        'app' => 'ZikulaMultiHookModule',
                        'user' => $userName,
                        'action' => $action,
                        'entity' => 'entry',
                        'id' => $itemId
                    ]
                );
            }
        
            if ($entity->supportsHookSubscribers()) {
                // Let any ui hooks know that we have updated or deleted an item
                $hookType = 'delete' === $action
                    ? UiHooksCategory::TYPE_PROCESS_DELETE
                    : UiHooksCategory::TYPE_PROCESS_EDIT
                ;
                $url = null;
                $hookHelper->callProcessHooks($entity, $hookType, $url);
            }
        }
        
        return $this->redirectToRoute('zikulamultihookmodule_entry_' . ($isAdmin ? 'admin' : '') . 'index');
    }
    
}
