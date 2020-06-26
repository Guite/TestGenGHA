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

namespace Zikula\MultiHookModule\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Zikula\Common\MultiHook\EntryProviderInterface;
use Zikula\Common\MultiHook\NeedleInterface;
use Zikula\MultiHookModule\DependencyInjection\Base\AbstractZikulaMultiHookExtension;

/**
 * DependencyInjection extension implementation class.
 */
class ZikulaMultiHookExtension extends AbstractZikulaMultiHookExtension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        parent::load($configs, $container);

        $container->registerForAutoconfiguration(EntryProviderInterface::class)
            ->addTag('multihook_entry_provider')
        ;

        $container->registerForAutoconfiguration(NeedleInterface::class)
            ->addTag('zikula.multihook_needle')
        ;
    }
}
