<?php
/**
 * Webino
 *
 * PHP version 5.3
 *
 * LICENSE: This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt. It is also available through the
 * world-wide-web at this URL: http://www.webino.org/license/
 * If you did not receive a copy of the license and are unable to obtain it
 * through the world-wide-web, please send an email to license@webino.org
 * so we can send you a copy immediately.
 *
 * @category   Webino
 * @package    Picture
 * @subpackage DrawHelper
 * @author     Peter Bačinský <peter@bacinsky.sk>
 * @copyright  2012 Peter Bačinský (http://www.bacinsky.sk/)
 * @license    http://www.webino.org/license/ New BSD License
 * @version    GIT: $Id$
 * @link       http://pear.webino.org/picture/
 */

/**
 * Draw view helper to resize images
 *
 * example of options:
 *
 * - width  = 100
 * - height = 100
 * - method = adaptiveResize
 *
 * Methods depends on used thumb view helper.
 *
 * @category   Webino
 * @package    Picture
 * @subpackage DrawHelper
 * @author     Peter Bačinský <peter@bacinsky.sk>
 * @copyright  2012 Peter Bačinský (http://www.bacinsky.sk/)
 * @license    http://www.webino.org/license/ New BSD License
 * @version    Release: @@PACKAGE_VERSION@@
 * @link       http://pear.webino.org/picture/
 */
class Webino_DrawHelper_Resize
    extends Webino_DrawHelper_Abstract
{
    /**
     * Default resize method
     */
    const DEFAULT_METHOD = 'adaptiveResize';

    /**
     * Name of config key of method used to resize
     */
    const METHOD_KEYNAME = 'method';

    /**
     * Name of option key to set resized image width
     */
    const WIDTH_KEYNAME = 'width';

    /**
     * Name of option key to set resized image height
     */
    const HEIGHT_KEYNAME = 'height';

    /**
     * Render script to node
     *
     * @param DOMNode $node
     */
    public function draw(DOMNode $node)
    {
        if (!isset($this->_options[self::METHOD_KEYNAME])) {
            $this->_options[self::METHOD_KEYNAME] = self::DEFAULT_METHOD;
        }

        $node->nodeValue = $this->view->thumb(
            $node->nodeValue,
            $this->_options[self::WIDTH_KEYNAME],
            $this->_options[self::HEIGHT_KEYNAME]
        )->{$this->_options[self::METHOD_KEYNAME]}();
    }
}
