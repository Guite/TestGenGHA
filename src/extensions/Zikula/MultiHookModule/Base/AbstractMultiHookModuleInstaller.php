<?php

/**
 * MultiHook.
 *
 * @copyright Zikula Team (Zikula)
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 * @author Zikula Team <info@ziku.la>.
 * @see https://ziku.la
 * @version Generated by ModuleStudio 1.5.0 (https://modulestudio.de).
 */

declare(strict_types=1);

namespace Zikula\MultiHookModule\Base;

use Doctrine\Persistence\ManagerRegistry;
use Exception;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Contracts\Translation\TranslatorInterface;
use Zikula\Bundle\CoreBundle\Doctrine\Helper\SchemaHelper;
use Zikula\ExtensionsModule\AbstractExtension;
use Zikula\ExtensionsModule\Api\ApiInterface\VariableApiInterface;
use Zikula\ExtensionsModule\Installer\AbstractExtensionInstaller;
use Zikula\MultiHookModule\Entity\EntryEntity;
use Zikula\MultiHookModule\Entity\EntryTranslationEntity;

/**
 * Installer base class.
 */
abstract class AbstractMultiHookModuleInstaller extends AbstractExtensionInstaller
{
    /**
     * @var string[]
     */
    protected $entities = [
        EntryEntity::class,
        EntryTranslationEntity::class,
    ];
    
    /**
     * @var LoggerInterface
     */
    protected $logger;

    public function __construct(
        AbstractExtension $extension,
        ManagerRegistry $managerRegistry,
        SchemaHelper $schemaTool,
        RequestStack $requestStack,
        TranslatorInterface $translator,
        VariableApiInterface $variableApi,
        LoggerInterface $logger) {
        parent::__construct($extension, $managerRegistry, $schemaTool, $requestStack, $translator, $variableApi);
        $this->logger = $logger;
    }
    
    public function install(): bool
    {
        // create all tables from according entity definitions
        try {
            $this->schemaTool->create($this->entities);
        } catch (Exception $exception) {
            $this->addFlash('error', $this->trans('Doctrine Exception') . ': ' . $exception->getMessage());
            $this->logger->error(
                '{app}: Could not create the database tables during installation. Error details: {errorMessage}.',
                ['app' => 'ZikulaMultiHookModule', 'errorMessage' => $exception->getMessage()]
            );
    
            throw $exception;
        }
    
        // set up all our vars with initial values
        $this->setVar('showEditLink', true);
        $this->setVar('replaceOnlyFirstInstanceOfItems', false);
        $this->setVar('applyReplacementsToCodeTags', false);
        $this->setVar('replaceAbbreviations', true);
        $this->setVar('replaceAcronyms', true);
        $this->setVar('replaceAbbreviationsWithLongText', false);
        $this->setVar('replaceLinks', true);
        $this->setVar('replaceLinksWithTitle', false);
        $this->setVar('cssClassForExternalLinks', '');
        $this->setVar('replaceCensoredWords', true);
        $this->setVar('replaceCensoredWordsWhenTheyArePartOfOtherWords', false);
        $this->setVar('doNotCensorFirstAndLastLetterInWordsWithMoreThanTwoChars', false);
        $this->setVar('replaceNeedles', true);
        $this->setVar('entryEntriesPerPage', 10);
        $this->setVar('showOnlyOwnEntries', false);
        $this->setVar('allowModerationSpecificCreatorForEntry', false);
        $this->setVar('allowModerationSpecificCreationDateForEntry', false);
    
        // initialisation successful
        return true;
    }
    
    public function upgrade(string $oldVersion): bool
    {
    /*
        // upgrade dependent on old version number
        switch ($oldVersion) {
            case '1.0.0':
                // do something
                // ...
                // update the database schema
                try {
                    $this->schemaTool->update($this->entities);
                } catch (Exception $exception) {
                    $this->addFlash('error', $this->trans('Doctrine Exception') . ': ' . $exception->getMessage());
                    $this->logger->error(
                        '{app}: Could not update the database tables during the upgrade.'
                            . ' Error details: {errorMessage}.',
                        ['app' => 'ZikulaMultiHookModule', 'errorMessage' => $exception->getMessage()]
                    );
    
                    throw $exception;
                }
        }
    */
    
        // update successful
        return true;
    }
    
    public function uninstall(): bool
    {
        try {
            $this->schemaTool->drop($this->entities);
        } catch (Exception $exception) {
            $this->addFlash('error', $this->trans('Doctrine Exception') . ': ' . $exception->getMessage());
            $this->logger->error(
                '{app}: Could not remove the database tables during uninstallation. Error details: {errorMessage}.',
                ['app' => 'ZikulaMultiHookModule', 'errorMessage' => $exception->getMessage()]
            );
    
            throw $exception;
        }
    
        // remove all module vars
        $this->delVars();
    
        // uninstallation successful
        return true;
    }
}
