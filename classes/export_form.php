<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Form for exporting a gallerys items.
 *
 * @package    mod_mediagallery
 * @copyright  NetSpot Pty Ltd
 * @author     Adam Olley <adam.olley@netspot.com.au>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace mod_mediagallery;

defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir.'/formslib.php');

class export_form extends \moodleform {

    /**
     * Defines forms elements
     */
    public function definition() {
        global $CFG;

        $mform = $this->_form;
        $gallery = $this->_customdata['gallery'];

        // General settings.
        $mform->addElement('header', 'general', get_string('export', 'mediagallery'));

        $mform->addElement('checkbox', 'completegallery', get_string('completegallery', 'mediagallery'));

        // START UCLA MOD: CCLE-5608
        // Added thumbnails for individual images, because not all have captions.
        /*foreach ($gallery->get_items() as $item) {
            if (!empty($item->externalurl)) {
                continue;
            }
            $mform->addElement('checkbox', 'item_'.$item->id, $item->caption);
            $mform->disabledIf('item_'.$item->id, 'completegallery', 'checked');
        }*/
        $items = $gallery->get_items();
        $count = count($items);
        foreach ($items as $item) {
            if (!empty($item->externalurl)) {
                continue;
            }
            $line = array();
            if ($count <= 50) {
                // separate javascript into separate file, and complete the toggle
                $line[] =& $mform->createElement('html', "<img id='id_image_{$item->id}' class='gthumbnail' src='{$item->get_image_url(true)}'>");
            }
            $line[] =& $mform->createElement('checkbox', 'item_'.$item->id, $item->caption);
            $mform->addGroup($line, 'line', '', array(' '), false);
            $mform->disabledIf('item_'.$item->id, 'completegallery', 'checked');
        }
        // END UCLA MOD: CCLE-5608

        $mform->addElement('hidden', 'g', $gallery->id);
        $mform->setType('g', PARAM_INT);

        $this->add_action_buttons(true, get_string('download'));
    }

}
