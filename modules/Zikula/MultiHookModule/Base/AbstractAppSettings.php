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

namespace Zikula\MultiHookModule\Base;

use Symfony\Component\Validator\Constraints as Assert;
use Zikula\ExtensionsModule\Api\ApiInterface\VariableApiInterface;

/**
 * Application settings class for handling module variables.
 */
abstract class AbstractAppSettings
{
    /**
     * @var VariableApiInterface
     */
    protected $variableApi;
    
    /**
     * @Assert\NotNull
     * @Assert\Type(type="bool")
     * @var bool $showEditLink
     */
    protected $showEditLink = true;
    
    /**
     * @Assert\NotNull
     * @Assert\Type(type="bool")
     * @var bool $replaceOnlyFirstInstanceOfItems
     */
    protected $replaceOnlyFirstInstanceOfItems = false;
    
    /**
     * @Assert\NotNull
     * @Assert\Type(type="bool")
     * @var bool $applyReplacementsToCodeTags
     */
    protected $applyReplacementsToCodeTags = false;
    
    /**
     * @Assert\NotNull
     * @Assert\Type(type="bool")
     * @var bool $replaceAbbreviations
     */
    protected $replaceAbbreviations = true;
    
    /**
     * @Assert\NotNull
     * @Assert\Type(type="bool")
     * @var bool $replaceAcronyms
     */
    protected $replaceAcronyms = true;
    
    /**
     * @Assert\NotNull
     * @Assert\Type(type="bool")
     * @var bool $replaceAbbreviationsWithLongText
     */
    protected $replaceAbbreviationsWithLongText = false;
    
    /**
     * @Assert\NotNull
     * @Assert\Type(type="bool")
     * @var bool $replaceLinks
     */
    protected $replaceLinks = true;
    
    /**
     * @Assert\NotNull
     * @Assert\Type(type="bool")
     * @var bool $replaceLinksWithTitle
     */
    protected $replaceLinksWithTitle = false;
    
    /**
     * @Assert\NotNull
     * @Assert\Length(min="0", max="255")
     * @var string $cssClassForExternalLinks
     */
    protected $cssClassForExternalLinks = '';
    
    /**
     * @Assert\NotNull
     * @Assert\Type(type="bool")
     * @var bool $replaceCensoredWords
     */
    protected $replaceCensoredWords = true;
    
    /**
     * @Assert\NotNull
     * @Assert\Type(type="bool")
     * @var bool $replaceCensoredWordsWhenTheyArePartOfOtherWords
     */
    protected $replaceCensoredWordsWhenTheyArePartOfOtherWords = false;
    
    /**
     * @Assert\NotNull
     * @Assert\Type(type="bool")
     * @var bool $doNotCensorFirstAndLastLetterInWordsWithMoreThanTwoChars
     */
    protected $doNotCensorFirstAndLastLetterInWordsWithMoreThanTwoChars = false;
    
    /**
     * @Assert\NotNull
     * @Assert\Type(type="bool")
     * @var bool $replaceNeedles
     */
    protected $replaceNeedles = true;
    
    /**
     * The amount of entries shown per page
     *
     * @Assert\Type(type="integer")
     * @Assert\NotBlank
     * @Assert\NotEqualTo(value=0)
     * @Assert\LessThan(value=100000000000)
     * @var int $entryEntriesPerPage
     */
    protected $entryEntriesPerPage = 10;
    
    /**
     * Whether only own entries should be shown on view pages by default or not
     *
     * @Assert\NotNull
     * @Assert\Type(type="bool")
     * @var bool $showOnlyOwnEntries
     */
    protected $showOnlyOwnEntries = false;
    
    /**
     * Whether to allow moderators choosing a user which will be set as creator.
     *
     * @Assert\NotNull
     * @Assert\Type(type="bool")
     * @var bool $allowModerationSpecificCreatorForEntry
     */
    protected $allowModerationSpecificCreatorForEntry = false;
    
    /**
     * Whether to allow moderators choosing a custom creation date.
     *
     * @Assert\NotNull
     * @Assert\Type(type="bool")
     * @var bool $allowModerationSpecificCreationDateForEntry
     */
    protected $allowModerationSpecificCreationDateForEntry = false;
    
    
    public function __construct(
        VariableApiInterface $variableApi
    ) {
        $this->variableApi = $variableApi;
    
        $this->load();
    }
    
    public function getShowEditLink(): bool
    {
        return $this->showEditLink;
    }
    
    public function setShowEditLink(bool $showEditLink): void
    {
        if ((bool)$this->showEditLink !== $showEditLink) {
            $this->showEditLink = $showEditLink;
        }
    }
    
    public function getReplaceOnlyFirstInstanceOfItems(): bool
    {
        return $this->replaceOnlyFirstInstanceOfItems;
    }
    
    public function setReplaceOnlyFirstInstanceOfItems(bool $replaceOnlyFirstInstanceOfItems): void
    {
        if ((bool)$this->replaceOnlyFirstInstanceOfItems !== $replaceOnlyFirstInstanceOfItems) {
            $this->replaceOnlyFirstInstanceOfItems = $replaceOnlyFirstInstanceOfItems;
        }
    }
    
    public function getApplyReplacementsToCodeTags(): bool
    {
        return $this->applyReplacementsToCodeTags;
    }
    
    public function setApplyReplacementsToCodeTags(bool $applyReplacementsToCodeTags): void
    {
        if ((bool)$this->applyReplacementsToCodeTags !== $applyReplacementsToCodeTags) {
            $this->applyReplacementsToCodeTags = $applyReplacementsToCodeTags;
        }
    }
    
    public function getReplaceAbbreviations(): bool
    {
        return $this->replaceAbbreviations;
    }
    
    public function setReplaceAbbreviations(bool $replaceAbbreviations): void
    {
        if ((bool)$this->replaceAbbreviations !== $replaceAbbreviations) {
            $this->replaceAbbreviations = $replaceAbbreviations;
        }
    }
    
    public function getReplaceAcronyms(): bool
    {
        return $this->replaceAcronyms;
    }
    
    public function setReplaceAcronyms(bool $replaceAcronyms): void
    {
        if ((bool)$this->replaceAcronyms !== $replaceAcronyms) {
            $this->replaceAcronyms = $replaceAcronyms;
        }
    }
    
    public function getReplaceAbbreviationsWithLongText(): bool
    {
        return $this->replaceAbbreviationsWithLongText;
    }
    
    public function setReplaceAbbreviationsWithLongText(bool $replaceAbbreviationsWithLongText): void
    {
        if ((bool)$this->replaceAbbreviationsWithLongText !== $replaceAbbreviationsWithLongText) {
            $this->replaceAbbreviationsWithLongText = $replaceAbbreviationsWithLongText;
        }
    }
    
    public function getReplaceLinks(): bool
    {
        return $this->replaceLinks;
    }
    
    public function setReplaceLinks(bool $replaceLinks): void
    {
        if ((bool)$this->replaceLinks !== $replaceLinks) {
            $this->replaceLinks = $replaceLinks;
        }
    }
    
    public function getReplaceLinksWithTitle(): bool
    {
        return $this->replaceLinksWithTitle;
    }
    
    public function setReplaceLinksWithTitle(bool $replaceLinksWithTitle): void
    {
        if ((bool)$this->replaceLinksWithTitle !== $replaceLinksWithTitle) {
            $this->replaceLinksWithTitle = $replaceLinksWithTitle;
        }
    }
    
    public function getCssClassForExternalLinks(): string
    {
        return $this->cssClassForExternalLinks;
    }
    
    public function setCssClassForExternalLinks(string $cssClassForExternalLinks): void
    {
        if ($this->cssClassForExternalLinks !== $cssClassForExternalLinks) {
            $this->cssClassForExternalLinks = $cssClassForExternalLinks ?? '';
        }
    }
    
    public function getReplaceCensoredWords(): bool
    {
        return $this->replaceCensoredWords;
    }
    
    public function setReplaceCensoredWords(bool $replaceCensoredWords): void
    {
        if ((bool)$this->replaceCensoredWords !== $replaceCensoredWords) {
            $this->replaceCensoredWords = $replaceCensoredWords;
        }
    }
    
    public function getReplaceCensoredWordsWhenTheyArePartOfOtherWords(): bool
    {
        return $this->replaceCensoredWordsWhenTheyArePartOfOtherWords;
    }
    
    public function setReplaceCensoredWordsWhenTheyArePartOfOtherWords(bool $replaceCensoredWordsWhenTheyArePartOfOtherWords): void
    {
        if ((bool)$this->replaceCensoredWordsWhenTheyArePartOfOtherWords !== $replaceCensoredWordsWhenTheyArePartOfOtherWords) {
            $this->replaceCensoredWordsWhenTheyArePartOfOtherWords = $replaceCensoredWordsWhenTheyArePartOfOtherWords;
        }
    }
    
    public function getDoNotCensorFirstAndLastLetterInWordsWithMoreThanTwoChars(): bool
    {
        return $this->doNotCensorFirstAndLastLetterInWordsWithMoreThanTwoChars;
    }
    
    public function setDoNotCensorFirstAndLastLetterInWordsWithMoreThanTwoChars(bool $doNotCensorFirstAndLastLetterInWordsWithMoreThanTwoChars): void
    {
        if ((bool)$this->doNotCensorFirstAndLastLetterInWordsWithMoreThanTwoChars !== $doNotCensorFirstAndLastLetterInWordsWithMoreThanTwoChars) {
            $this->doNotCensorFirstAndLastLetterInWordsWithMoreThanTwoChars = $doNotCensorFirstAndLastLetterInWordsWithMoreThanTwoChars;
        }
    }
    
    public function getReplaceNeedles(): bool
    {
        return $this->replaceNeedles;
    }
    
    public function setReplaceNeedles(bool $replaceNeedles): void
    {
        if ((bool)$this->replaceNeedles !== $replaceNeedles) {
            $this->replaceNeedles = $replaceNeedles;
        }
    }
    
    public function getEntryEntriesPerPage(): int
    {
        return $this->entryEntriesPerPage;
    }
    
    public function setEntryEntriesPerPage(int $entryEntriesPerPage): void
    {
        if ((int)$this->entryEntriesPerPage !== $entryEntriesPerPage) {
            $this->entryEntriesPerPage = $entryEntriesPerPage;
        }
    }
    
    public function getShowOnlyOwnEntries(): bool
    {
        return $this->showOnlyOwnEntries;
    }
    
    public function setShowOnlyOwnEntries(bool $showOnlyOwnEntries): void
    {
        if ((bool)$this->showOnlyOwnEntries !== $showOnlyOwnEntries) {
            $this->showOnlyOwnEntries = $showOnlyOwnEntries;
        }
    }
    
    public function getAllowModerationSpecificCreatorForEntry(): bool
    {
        return $this->allowModerationSpecificCreatorForEntry;
    }
    
    public function setAllowModerationSpecificCreatorForEntry(bool $allowModerationSpecificCreatorForEntry): void
    {
        if ((bool)$this->allowModerationSpecificCreatorForEntry !== $allowModerationSpecificCreatorForEntry) {
            $this->allowModerationSpecificCreatorForEntry = $allowModerationSpecificCreatorForEntry;
        }
    }
    
    public function getAllowModerationSpecificCreationDateForEntry(): bool
    {
        return $this->allowModerationSpecificCreationDateForEntry;
    }
    
    public function setAllowModerationSpecificCreationDateForEntry(bool $allowModerationSpecificCreationDateForEntry): void
    {
        if ((bool)$this->allowModerationSpecificCreationDateForEntry !== $allowModerationSpecificCreationDateForEntry) {
            $this->allowModerationSpecificCreationDateForEntry = $allowModerationSpecificCreationDateForEntry;
        }
    }
    
    /**
     * Loads module variables from the database.
     */
    protected function load(): void
    {
        $moduleVars = $this->variableApi->getAll('ZikulaMultiHookModule');
    
        if (isset($moduleVars['showEditLink'])) {
            $this->setShowEditLink($moduleVars['showEditLink']);
        }
        if (isset($moduleVars['replaceOnlyFirstInstanceOfItems'])) {
            $this->setReplaceOnlyFirstInstanceOfItems($moduleVars['replaceOnlyFirstInstanceOfItems']);
        }
        if (isset($moduleVars['applyReplacementsToCodeTags'])) {
            $this->setApplyReplacementsToCodeTags($moduleVars['applyReplacementsToCodeTags']);
        }
        if (isset($moduleVars['replaceAbbreviations'])) {
            $this->setReplaceAbbreviations($moduleVars['replaceAbbreviations']);
        }
        if (isset($moduleVars['replaceAcronyms'])) {
            $this->setReplaceAcronyms($moduleVars['replaceAcronyms']);
        }
        if (isset($moduleVars['replaceAbbreviationsWithLongText'])) {
            $this->setReplaceAbbreviationsWithLongText($moduleVars['replaceAbbreviationsWithLongText']);
        }
        if (isset($moduleVars['replaceLinks'])) {
            $this->setReplaceLinks($moduleVars['replaceLinks']);
        }
        if (isset($moduleVars['replaceLinksWithTitle'])) {
            $this->setReplaceLinksWithTitle($moduleVars['replaceLinksWithTitle']);
        }
        if (isset($moduleVars['cssClassForExternalLinks'])) {
            $this->setCssClassForExternalLinks($moduleVars['cssClassForExternalLinks']);
        }
        if (isset($moduleVars['replaceCensoredWords'])) {
            $this->setReplaceCensoredWords($moduleVars['replaceCensoredWords']);
        }
        if (isset($moduleVars['replaceCensoredWordsWhenTheyArePartOfOtherWords'])) {
            $this->setReplaceCensoredWordsWhenTheyArePartOfOtherWords($moduleVars['replaceCensoredWordsWhenTheyArePartOfOtherWords']);
        }
        if (isset($moduleVars['doNotCensorFirstAndLastLetterInWordsWithMoreThanTwoChars'])) {
            $this->setDoNotCensorFirstAndLastLetterInWordsWithMoreThanTwoChars($moduleVars['doNotCensorFirstAndLastLetterInWordsWithMoreThanTwoChars']);
        }
        if (isset($moduleVars['replaceNeedles'])) {
            $this->setReplaceNeedles($moduleVars['replaceNeedles']);
        }
        if (isset($moduleVars['entryEntriesPerPage'])) {
            $this->setEntryEntriesPerPage($moduleVars['entryEntriesPerPage']);
        }
        if (isset($moduleVars['showOnlyOwnEntries'])) {
            $this->setShowOnlyOwnEntries($moduleVars['showOnlyOwnEntries']);
        }
        if (isset($moduleVars['allowModerationSpecificCreatorForEntry'])) {
            $this->setAllowModerationSpecificCreatorForEntry($moduleVars['allowModerationSpecificCreatorForEntry']);
        }
        if (isset($moduleVars['allowModerationSpecificCreationDateForEntry'])) {
            $this->setAllowModerationSpecificCreationDateForEntry($moduleVars['allowModerationSpecificCreationDateForEntry']);
        }
    }
    
    /**
     * Saves module variables into the database.
     */
    public function save(): void
    {
        $this->variableApi->set('ZikulaMultiHookModule', 'showEditLink', $this->getShowEditLink());
        $this->variableApi->set('ZikulaMultiHookModule', 'replaceOnlyFirstInstanceOfItems', $this->getReplaceOnlyFirstInstanceOfItems());
        $this->variableApi->set('ZikulaMultiHookModule', 'applyReplacementsToCodeTags', $this->getApplyReplacementsToCodeTags());
        $this->variableApi->set('ZikulaMultiHookModule', 'replaceAbbreviations', $this->getReplaceAbbreviations());
        $this->variableApi->set('ZikulaMultiHookModule', 'replaceAcronyms', $this->getReplaceAcronyms());
        $this->variableApi->set('ZikulaMultiHookModule', 'replaceAbbreviationsWithLongText', $this->getReplaceAbbreviationsWithLongText());
        $this->variableApi->set('ZikulaMultiHookModule', 'replaceLinks', $this->getReplaceLinks());
        $this->variableApi->set('ZikulaMultiHookModule', 'replaceLinksWithTitle', $this->getReplaceLinksWithTitle());
        $this->variableApi->set('ZikulaMultiHookModule', 'cssClassForExternalLinks', $this->getCssClassForExternalLinks());
        $this->variableApi->set('ZikulaMultiHookModule', 'replaceCensoredWords', $this->getReplaceCensoredWords());
        $this->variableApi->set('ZikulaMultiHookModule', 'replaceCensoredWordsWhenTheyArePartOfOtherWords', $this->getReplaceCensoredWordsWhenTheyArePartOfOtherWords());
        $this->variableApi->set('ZikulaMultiHookModule', 'doNotCensorFirstAndLastLetterInWordsWithMoreThanTwoChars', $this->getDoNotCensorFirstAndLastLetterInWordsWithMoreThanTwoChars());
        $this->variableApi->set('ZikulaMultiHookModule', 'replaceNeedles', $this->getReplaceNeedles());
        $this->variableApi->set('ZikulaMultiHookModule', 'entryEntriesPerPage', $this->getEntryEntriesPerPage());
        $this->variableApi->set('ZikulaMultiHookModule', 'showOnlyOwnEntries', $this->getShowOnlyOwnEntries());
        $this->variableApi->set('ZikulaMultiHookModule', 'allowModerationSpecificCreatorForEntry', $this->getAllowModerationSpecificCreatorForEntry());
        $this->variableApi->set('ZikulaMultiHookModule', 'allowModerationSpecificCreationDateForEntry', $this->getAllowModerationSpecificCreationDateForEntry());
    }
}
