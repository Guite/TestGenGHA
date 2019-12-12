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

namespace Zikula\MultiHookModule\EntryProvider;

use Zikula\Common\MultiHook\EntryProviderInterface;
use Zikula\Common\Translator\TranslatorInterface;
use Zikula\MultiHookModule\Entity\EntryEntity;
use Zikula\MultiHookModule\Entity\Factory\EntityFactory;

/**
 * Default entry provider.
 */
class DefaultEntryProvider implements EntryProviderInterface
{
    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * @var EntityFactory
     */
    private $entityFactory;

    /**
     * Bundle name
     *
     * @var string
     */
    private $bundleName;

    /**
     * The name of this provider
     *
     * @var string
     */
    private $name;

    public function __construct(
        TranslatorInterface $translator,
        EntityFactory $entityFactory
    ) {
        $this->translator = $translator;
        $this->entityFactory = $entityFactory;

        $nsParts = explode('\\', get_class($this));
        $vendor = $nsParts[0];
        $nameAndType = $nsParts[1];

        $this->bundleName = $vendor . $nameAndType;
        $this->name = str_replace('Provider', '', array_pop($nsParts));
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getIcon(): string
    {
        return 'cube';
    }

    public function getTitle(): string
    {
        return $this->translator->__('Default functionality', 'zikulamultihookmodule');
    }

    public function getDescription(): string
    {
        return $this->translator->__('Provides MultiHook\'s own entries.', 'zikulamultihookmodule');
    }

    public function getAdminInfo(): string
    {
        return '';
    }

    public function isActive(): bool
    {
        return true;
    }

    public function getEntries(array $entryTypes = []): array
    {
        $result = [];

        if (count($entryTypes) > 0) {
            $entities = $this->entityFactory->getRepository('entry')
                ->selectWhere('tbl.active = 1 AND tbl.entryType IN (\'' . implode('\', \'', $entryTypes) . '\')');

            /** @var EntryEntity $entity */
            foreach ($entities as $entity) {
                $result[] = [
                    'id' => $entity->getId(),
                    'longform' => $entity->getLongForm(),
                    'shortform' => $entity->getShortForm(),
                    'title' => $entity->getTitle(),
                    'type' => $entity->getEntryType(),
                    'language' => $entity->getLocale()
                ];
            }
        }

        return $result;
    }

    public function getBundleName(): string
    {
        return $this->bundleName;
    }
}
