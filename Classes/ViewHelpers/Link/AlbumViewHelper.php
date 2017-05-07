<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010-2013 Daniel Lienert <typo3@lienert.cc>, Michael Knoll <mimi@kaktusteam.de>
*  All rights reserved
*
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/

/**
 * Class implements a viewhelper for rendering a link for an album
 *
 * @package ViewHelpers
 * @author Michael Knoll <mimi@kaktusteam.de>
 */
class Tx_Yag_ViewHelpers_Link_AlbumViewHelper extends Tx_Yag_ViewHelpers_Link_BaseActionViewHelper
{
    /**
     * Renders link for an album
     *
     * @param integer $albumUid UID of album to render link for
     * @param Tx_Yag_Domain_Model_Album $album Album object to render link for
     * @param Tx_Yag_Domain_Model_Gallery $gallery Gallery object to render link for
     * @param integer pageUid (Optional) ID of page to render link for. If null, current page is used
     * @param integer $pageType type of the target page. See typolink.parameter
     * @param boolean $noCache set this to disable caching for the target page. You should not need this.
     * @param boolean $noCacheHash set this to supress the cHash query parameter created by TypoLink. You should not need this.
     * @param string $section the anchor to be added to the URI
     * @param string $format The requested format, e.g. ".html"
     * @return string Rendered link for album
     * @throws Exception
     */
    public function render($albumUid = 0, Tx_Yag_Domain_Model_Album $album = null, Tx_Yag_Domain_Model_Gallery $gallery = null, $pageUid = null, $pageType = 0, $noCache = false, $noCacheHash = false, $section = '', $format = '')
    {
        if ($albumUid == 0 && $album === null) {
            throw new Exception('You have to set "albumUid" or "album" as parameter. Both parameters can not be empty when using albumLinkViewHelper', 1295575454);
        }

        if ($albumUid == 0) {
            $albumUid = $album->getUid();
        }

        $baseNamespace = Tx_Yag_Domain_Context_YagContextFactory::getInstance()->getObjectNamespace();
        $arguments = \PunktDe\PtExtbase\Utility\NamespaceUtility::saveDataInNamespaceTree($baseNamespace . '.albumUid', [], $albumUid);

        if ($gallery !== null) {
            $arguments = \PunktDe\PtExtbase\Utility\NamespaceUtility::saveDataInNamespaceTree($baseNamespace . '.galleryUid', $arguments, $gallery->getUid());
        }

        return parent::renderAction('submitFilter', $arguments, 'ItemList', null, null, $pageUid, $pageType, $noCache, $noCacheHash, $section, $format);
    }
}
