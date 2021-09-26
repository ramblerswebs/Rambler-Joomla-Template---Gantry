<?php

/**
 * @package     Joomla.Site
 * @subpackage  com_contact
 * RAMBLERS_WEBS modification
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

$cparams = JComponentHelper::getParams('com_media');

jimport('joomla.html.html.bootstrap');

echo '<div class="contact<' . $this->pageclass_sfx . '" itemscope itemtype="https://schema.org/Person">';
if ($this->params->get('show_page_heading')) :

    echo '<h1>';
    echo $this->escape($this->params->get('page_heading'));
    echo '</h1>';
endif;

if ($this->contact->name && $this->params->get('show_name')) :
    echo '<div class="page-header">';
    echo '<h2>';
    if ($this->item->published == 0) :
        echo '<span class="label label-warning">' . JText::_('JUNPUBLISHED') . '</span>';
    endif;
    echo '<span class="contact-name" itemprop="name">' . $this->contact->name . '</span>';
    echo '</h2>';
    echo '</div>';

endif;
if ($this->params->get('show_contact_category') == 'show_no_link') :

    echo '<h3>';
    echo '<span class="contact-category">' . $this->contact->category_title . '</span>';
    echo '</h3>';

endif;
echo $this->item->event->afterDisplayTitle;
if ($this->params->get('show_contact_category') == 'show_with_link') :
    $contactLink = ContactHelperRoute::getCategoryRoute($this->contact->catid);

    echo '<h3>';
    echo '<span class="contact-category"><a href="' . $contactLink . '">';
    echo $this->escape($this->contact->category_title) . '</a>';
    echo '</span>';
    echo '</h3>';

endif;
if ($this->params->get('show_contact_list') && count($this->contacts) > 1) :

    echo '<form action="#" method="get" name="selectForm" id="selectForm">';
    echo JText::_('COM_CONTACT_SELECT_CONTACT');
    echo JHtml::_('select.genericlist', $this->contacts, 'id', 'class="inputbox" onchange="document.location.href = this.value"', 'link', 'name', $this->contact->link);
    echo '</form>';

endif;
if ($this->params->get('show_tags', 1) && !empty($this->item->tags->itemTags)) :
    $this->item->tagLayout = new JLayoutFile('joomla.content.tags');
    echo $this->item->tagLayout->render($this->item->tags->itemTags);
endif;
echo $this->item->event->beforeDisplayContent;
if ($this->params->get('presentation_style') == 'sliders') :
    echo JHtml::_('bootstrap.startAccordion', 'slide-contact', array('active' => 'basic-details'));
endif;
if ($this->params->get('presentation_style') == 'tabs') : echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'basic-details'));
endif;
if ($this->params->get('presentation_style') == 'sliders') : echo JHtml::_('bootstrap.addSlide', 'slide-contact', JText::_('COM_CONTACT_DETAILS'), 'basic-details');

endif;
if ($this->params->get('presentation_style') == 'tabs') :
    echo JHtml::_('bootstrap.addTab', 'myTab', 'basic-details', JText::_('COM_CONTACT_DETAILS'));
endif;

if ($this->params->get('presentation_style') == 'plain'):
    echo '<h3>' . JText::_('COM_CONTACT_DETAILS') . '</h3>';
endif;
if ($this->contact->image && $this->params->get('show_image')) :

    echo '<div class="thumbnail pull-right">';
    echo JHtml::_('image', $this->contact->image, JText::_('COM_CONTACT_IMAGE_DETAILS'), array('align' => 'middle', 'itemprop' => 'image'));
    echo '</div>';

endif;
if ($this->contact->con_position && $this->params->get('show_position')) :

    echo '<dl class="contact-position dl-horizontal">';
    echo '<dt>';
    echo '<span class="jicons-text"> Position: </span>';
    echo '</dt>';
    echo '<dd itemprop="jobTitle">';
    echo $this->contact->con_position;
    echo '</dd>';
    echo '</dl>';

endif;
echo $this->loadTemplate('address');

if ($this->params->get('allow_vcard')) :
    echo JText::_('COM_CONTACT_DOWNLOAD_INFORMATION_AS');

    echo '<a href="' . JRoute::_('index.php?option=com_contact&amp;view=contact&amp;id=' . $this->contact->id . '&amp;format=vcf') . '">';
    echo JText::_('COM_CONTACT_VCARD') . '</a>';

endif;

if ($this->params->get('presentation_style') == 'sliders') :
    echo JHtml::_('bootstrap.endSlide');
endif;
if ($this->params->get('presentation_style') == 'tabs') :
    echo JHtml::_('bootstrap.endTab');
endif;

if ($this->contact->misc && $this->params->get('show_misc')) :
    if ($this->params->get('presentation_style') == 'sliders') :
        echo JHtml::_('bootstrap.addSlide', 'slide-contact', JText::_('COM_CONTACT_OTHER_INFORMATION'), 'display-misc');
    endif;
    if ($this->params->get('presentation_style') == 'tabs') :
        echo JHtml::_('bootstrap.addTab', 'myTab', 'display-misc', JText::_('COM_CONTACT_OTHER_INFORMATION'));
    endif;
    if ($this->params->get('presentation_style') == 'plain'):
        echo '<h3>' . JText::_('COM_CONTACT_OTHER_INFORMATION') . '</h3>';
    endif;


    echo '<div class="contact-miscinfo">';
    echo '<dl class="dl-horizontal">';
    echo '<dt>';
    echo '<span class="' . $this->params->get('marker_class') . '">';
   // echo $this->params->get('marker_misc');
    echo '</span>';
    echo '</dt>';
    echo '<dd>';
    echo '<span class="contact-misc">';
    echo $this->contact->misc;
    echo '</span>';
    echo '</dd>';
    echo '</dl>';
    echo '</div>';


    if ($this->params->get('presentation_style') == 'sliders') :
        echo JHtml::_('bootstrap.endSlide');
    endif;
    if ($this->params->get('presentation_style') == 'tabs') :
        echo JHtml::_('bootstrap.endTab');
    endif;
endif;


if ($this->params->get('show_email_form') && ($this->contact->email_to || $this->contact->user_id)) :
    if ($this->params->get('presentation_style') == 'sliders') :
        echo JHtml::_('bootstrap.addSlide', 'slide-contact', JText::_('COM_CONTACT_EMAIL_FORM'), 'display-form');
    endif;
    if ($this->params->get('presentation_style') == 'tabs') :
        echo JHtml::_('bootstrap.addTab', 'myTab', 'display-form', JText::_('COM_CONTACT_EMAIL_FORM'));
    endif;
    if ($this->params->get('presentation_style') == 'plain'):
        echo '<h3>' . JText::_('COM_CONTACT_EMAIL_FORM') . '</h3>';
    endif;

    echo $this->loadTemplate('form');
    if ($this->params->get('presentation_style') == 'sliders') :
        echo JHtml::_('bootstrap.endSlide');

    endif;

    if ($this->params->get('presentation_style') == 'tabs') :
        echo JHtml::_('bootstrap.endTab');
    endif;
endif;
if ($this->params->get('show_links')) :
    echo $this->loadTemplate('links');
endif;
if ($this->params->get('show_articles') && $this->contact->user_id && $this->contact->articles) :

    if ($this->params->get('presentation_style') == 'sliders') :
        echo JHtml::_('bootstrap.addSlide', 'slide-contact', JText::_('JGLOBAL_ARTICLES'), 'display-articles');
    endif;
    if ($this->params->get('presentation_style') == 'tabs') :
        echo JHtml::_('bootstrap.addTab', 'myTab', 'display-articles', JText::_('JGLOBAL_ARTICLES'));
    endif;
    if ($this->params->get('presentation_style') == 'plain'):
        echo '<h3>' . JText::_('JGLOBAL_ARTICLES') . '</h3>';
    endif;
    echo $this->loadTemplate('articles');
    if ($this->params->get('presentation_style') == 'sliders') :
        echo JHtml::_('bootstrap.endSlide');
    endif;
    if ($this->params->get('presentation_style') == 'tabs') :

        echo JHtml::_('bootstrap.endTab');
    endif;
endif;
if ($this->params->get('show_profile') && $this->contact->user_id && JPluginHelper::isEnabled('user', 'profile')) : if ($this->params->get('presentation_style') == 'sliders') :
        echo JHtml::_('bootstrap.addSlide', 'slide-contact', JText::_('COM_CONTACT_PROFILE'), 'display-profile');
    endif;
    if ($this->params->get('presentation_style') == 'tabs') :
        echo JHtml::_('bootstrap.addTab', 'myTab', 'display-profile', JText::_('COM_CONTACT_PROFILE', true));


    endif;
    if ($this->params->get('presentation_style') == 'plain'):
        echo '<h3>' . JText::_('COM_CONTACT_PROFILE') . '</h3>';
    endif;
    echo $this->loadTemplate('profile');
    if ($this->params->get('presentation_style') == 'sliders') :
        echo JHtml::_('bootstrap.endSlide');
    endif;
    if ($this->params->get('presentation_style') == 'tabs') :
        echo JHtml::_('bootstrap.endTab');
    endif;
endif;


if ($this->params->get('presentation_style') == 'sliders') :
    echo JHtml::_('bootstrap.endAccordion');
endif;
if ($this->params->get('presentation_style') == 'tabs') :
    echo JHtml::_('bootstrap.endTabSet');
endif;
echo $this->item->event->afterDisplayContent;
echo '</div>';