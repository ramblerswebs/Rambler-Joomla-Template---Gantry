<?php

/**
 * @package     Joomla.Site
 * @subpackage  mod_breadcrumbs - modified
 *
 * @copyright   Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

JHtml::_('bootstrap.tooltip');

echo '<ul itemscope itemtype="https://schema.org/BreadcrumbList" class="breadcrumb' . $moduleclass_sfx . '">' . PHP_EOL;
if ($params->get('showHere', 1)) {
    echo '<li>' . PHP_EOL;
    echo JText::_('MOD_BREADCRUMBS_HERE') . '&#160;' . PHP_EOL;
    echo '</li>' . PHP_EOL;
} else {
    echo '<li class="active">' . PHP_EOL;
    echo '<span class="divider icon-location"></span>' . PHP_EOL;
    echo '</li>' . PHP_EOL;
}


// Get rid of duplicated entries on trail including home page when using multilanguage
for ($i = 0; $i < $count; $i++) {
    if ($i === 1 && !empty($list[$i]->link) && !empty($list[$i - 1]->link) && $list[$i]->link === $list[$i - 1]->link) {
        unset($list[$i]);
    }
}

// Find last and penultimate items in breadcrumbs list
end($list);
$last_item_key = key($list);
prev($list);
$penult_item_key = key($list);

// Make a link if not the last item in the breadcrumbs
$show_last = $params->get('showLast', 1);
// added check on seperator
$prefix = "<img ";

// Generate the trail
foreach ($list as $key => $item) {
    if ($key !== $last_item_key) {
        // Render all but last item - along with separator 

        echo '<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">' . PHP_EOL;
        if (!empty($item->link)) {
            echo '<a itemprop="item" href="' . $item->link . '" class="pathway"><span itemprop="name">' . $item->name . '</span></a>' . PHP_EOL;
        } else {
            echo '<span itemprop="name">' . $item->name . '</span>' . PHP_EOL;
        }

        if (($key !== $penult_item_key) || $show_last) {
            if (strncmp($separator, $prefix, strlen($prefix)) === 0) {
                 echo '<span class="divider gantrydivider"> </span>' . PHP_EOL;
            } else {
                echo '<span class="divider">' . $separator . '</span>' . PHP_EOL;
            }
        }
        echo '<meta itemprop="position" content="' . ($key + 1) . '">' . PHP_EOL;
        echo '</li>' . PHP_EOL;
    } else {
        // Render last item if reqd. 
        echo ' <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" class="active">' . PHP_EOL;
        echo '<span itemprop="name">' . $item->name . '</span>' . PHP_EOL;
        echo '<meta itemprop="position" content="' . ( $key + 1) . '">' . PHP_EOL;
        echo '</li>' . PHP_EOL;
    }
}
echo '</ul>' . PHP_EOL;
