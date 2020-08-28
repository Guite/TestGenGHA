<?php

/**
 * MultiHook.
 *
 * @copyright Zikula Team (Zikula)
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 * @author Zikula Team <info@ziku.la>.
 *
 * @see https://ziku.la
 *
 * @version Generated by ModuleStudio 1.5.0 (https://modulestudio.de).
 */

declare(strict_types=1);

namespace Zikula\MultiHookModule\Helper;

use Symfony\Component\Routing\RouterInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use Zikula\MultiHookModule\Helper\Base\AbstractHookHelper;
use Zikula\ExtensionsModule\Api\ApiInterface\VariableApiInterface;

/**
 * Helper implementation class for hook related methods.
 */
class HookHelper extends AbstractHookHelper
{
    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * @var VariableApiInterface
     */
    private $variableApi;

    public function createAbbr(array $abac, bool $showEditLink = false): string
    {
        $replaceAbbreviationsWithLongText = (bool) $this->variableApi->get(
            'ZikulaMultiHookModule',
            'replaceAbbreviationsWithLongText',
            false
        );

        $long = $abac['longform'];
        $short = $abac['shortform'];
        $id = $abac['id'] ?? 0;

        if (false === $replaceAbbreviationsWithLongText) {
            $xhtmllang = $this->getLanguageAttributes($abac['language']);
            $replace_temp = '<abbr' . $xhtmllang . ' title="' . str_replace('"', '', $long) . '">'
                . '<span class="abbr" title="' . str_replace('"', '', $long) . '">' . $short . '</span>'
                . '</abbr>'
            ;
        } else {
            $replace_temp = $long;
        }

        if (true === $showEditLink && 0 < $id) {
            $replace_temp = '<span>' . $replace_temp . ' '
                . $this->getEditLink($short, $this->translator->trans('Abbreviation'), $id)
                . '</span>'
            ;
        }

        return $replace_temp;
    }
    
    public function createAcronym(array $abac, bool $showEditLink = false): string
    {
        $long = $abac['longform'];
        $short = $abac['shortform'];
        $id = $abac['id'] ?? 0;

        $xhtmllang = $this->getLanguageAttributes($abac['language']);
        $replace_temp = '<acronym' . $xhtmllang . ' title="' . str_replace('"', '', $long) . '">'
            . $short . '</acronym>'
        ;

        if (true === $showEditLink && 0 < $id) {
            $replace_temp = '<span>' . $replace_temp . ' '
                . $this->getEditLink($short, $this->translator->trans('Acronym'), $id)
                . '</span>'
            ;
        }

        return $replace_temp;
    }

    public function createLink(array $abac, bool $showEditLink = false): string
    {
        $replaceLinksWithTitle = (bool) $this->variableApi->get(
            'ZikulaMultiHookModule',
            'replaceLinksWithTitle',
            false
        );
        $cssClassForExternalLinks = (string) $this->variableApi->get(
            'ZikulaMultiHookModule',
            'cssClassForExternalLinks',
            ''
        );

        $extclass = '';
        $accessibilityHack = '';
        if (1 === preg_match("/(^http:\/\/)/", $abac['longform'])) {
            if (!empty($cssClassForExternalLinks)) {
                $extclass = ' class="' . $cssClassForExternalLinks . '"';
            }
            $accessibilityHack = '';
            /* not working yet:
            $accessibilityHack = <span class="mhacconly"> '
                . str_replace('"', '', $this->translator->trans('(external link)'))
                . '</span>'
            ;*/
        }

        $long = $abac['longform'];
        $short = $abac['shortform'];
        $id = $abac['id'] ?? 0;
        $title = $abac['title'];

        $linkText = (false === $replaceLinksWithTitle ? $short : $title) . $accessibilityHack;
        $replace_temp = '<a' . $extclass
            . ' href="' . str_replace('"', '', $long) . '"'
            . ' title="' . str_replace('"', '', $title) . '"'
            . '>' . $linkText . '</a>'
        ;

        if (true === $showEditLink && 0 < $id) {
            $replace_temp = '<span>' . $replace_temp . ' '
                . $this->getEditLink($short, $this->translator->trans('Link'), $id)
                . '</span>'
            ;
        }

        return $replace_temp;
    }

    public function createCensor(
        array $abac,
        bool $showEditLink = false,
        bool $doNotCensorFirstAndLastLetterInWordsWithMoreThanTwoChars = false
    ): string {
        $short = $abac['shortform'];

        $len = mb_strlen($short);
        $replace_temp = str_repeat('*', $len);
        if (true === $doNotCensorFirstAndLastLetterInWordsWithMoreThanTwoChars && 2 < $len) {
            $replace_temp[0] = $short[0];
            $id = mb_strlen($replace_temp) - 1;
            $replace_temp[$id] = $short[$len - 1];
        }

        $id = $abac['id'] ?? 0;

        if (true === $showEditLink && 0 < $id) {
            $replace_temp = '<span>' . $replace_temp . ' '
                . $this->getEditLink($short, $this->translator->trans('Censor'), $id)
                . '</span>'
            ;
        }

        return $replace_temp;
    }

    private function getLanguageAttributes(string $lang): string
    {
        return !empty($lang) ? ' lang="' . $lang . '" xml:lang="' . $lang . '"' : '';
    }

    public function getEditLink(string $short, string $entryLabel = '', int $id = 0): string
    {
        $title = $this->translator->trans('Edit')
            . ': ' . $short . ' (' . str_replace('"', '', $entryLabel) . ')'
            . ' #' . $id
        ;

        $editUrl = $this->router->generate('zikulamultihookmodule_entry_edit', ['id' => $id]);

        return '<a href="' . $editUrl . '" class="mh-edit-link"'
            . ' title="' . str_replace('"', '', $title) . '"'
            . ' target="_blank"><i class="fas fa-pencil-alt"></i></a>'
        ;
    }

    public function createAbsoluteUrl(string $url = '', string $baseUrl = ''): string
    {
        static $schemes = ['http', 'https', 'ftp', 'gopher', 'ed2k', 'news', 'mailto', 'telnet'];

        if ('' === $url) {
            return $url;
        }

        // make sure that relative urls get converted to absolute urls (safehtml needs this)
        $exploded_url = explode(':', $url);
        if (!in_array($exploded_url[0], $schemes, true)) {
            // url does not start with one of the schemes defined above
            // we consider it being a relative path now

            // next check for leading / in  relative url
            if (0 === mb_strpos($url, '/')) {
                // and remove it
                $url = mb_substr($url, 1);
            }
            $url = $baseUrl . $url;
        }

        return $url;
    }

    /**
     * @required
     */
    public function setRouter(RouterInterface $router): void
    {
        $this->router = $router;
    }

    /**
     * @required
     */
    public function setVariableApi(VariableApiInterface $variableApi): void
    {
        $this->variableApi = $variableApi;
    }
}
