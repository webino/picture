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
 * @subpackage ViewHelper
 * @author     Peter Bačinský <peter@bacinsky.sk>
 * @copyright  2012 Peter Bačinský (http://www.bacinsky.sk/)
 * @license    http://www.webino.org/license/ New BSD License
 * @version    GIT: $Id$
 * @link       http://pear.webino.org/picture/
 */

/**
 * Image manipulation library
 *
 * @link http://phpthumb.gxdlabs.com/
 */
require_once 'PHPThumb/ThumbLib.inc.php';

/**
 * View helper to make picture thumbnails
 *
 * Depends on PHPThumb library (http://phpthumb.gxdlabs.com/)
 *
 * @category   Webino
 * @package    Picture
 * @subpackage ViewHelper
 * @author     Peter Bačinský <peter@bacinsky.sk>
 * @copyright  2012 Peter Bačinský (http://www.bacinsky.sk/)
 * @license    http://www.webino.org/license/ New BSD License
 * @version    Release: @@PACKAGE_VERSION@@
 * @link       http://pear.webino.org/picture/
 */
class Webino_ViewHelper_Thumb
    extends Zend_View_Helper_Abstract
{
    /**
     * Relative path to image in public dir
     *
     * @var string
     */
    private $_href;

    /**
     * New width for image
     * 
     * @var int
     */
    private $_width;

    /**
     * New height for image
     *
     * @var int
     */
    private $_height;

    /**
     * Image object
     *
     * @var object
     */
    private $_thumb;

    /**
     * Relative path to thumbnails dir
     * 
     * @var string
     */
    private $_src;

    /**
     * Absolute path to thumbnail
     *
     * @var string
     */
    private $_imagePath;

    /**
     * Setup thumbnail helper
     *
     * @param string $href   Relative path to original picture
     * @param int    $width  Thumbnail width
     * @param int    $height Thumbnail height
     *
     * @return Webino_ViewHelper_Thumb
     */
    public function thumb($href, $width, $height)
    {
        $this->_href   = $href;
        $this->_width  = $width;
        $this->_height = $height;
        $this->_thumb  = null;
        
        $this->_src = $this->_getSrc();

        if (!is_dir($this->_src)) {
            mkdir($this->_src, 0755, true);
        }

        $this->_imagePath = realpath($this->_src) . '/' . basename($href);
        
        return $this;
    }

    /**
     * Resize image to fill width and height
     *
     * @return Webino_ViewHelper_Thumb
     */
    public function adaptiveResize()
    {
        if (is_file($this->_imagePath)) {

            return $this;
        }

        $this->_getThumb()->adaptiveResize(
            $this->_width, $this->_height
        );

        return $this;

    }

    /**
     * Inject thumbnail object
     *
     * @param object $thumb
     *
     * @return Webino_ViewHelper_Thumb
     */
    public function setThumb($thumb)
    {
        $this->_thumb = $thumb;

        return $this;
    }

    /**
     * Return relative path to thumbnails dir
     *
     * @return string
     */
    private function _getSrc()
    {
        return dirname('resized-' . $this->_href) . '/'
            . $this->_width . 'x' . $this->_height;
    }

    /**
     * Return thumbnail object
     *
     * @return object
     */
    private function _getThumb()
    {
        if (!$this->_thumb) {
            $this->setThumb(
                PhpThumbFactory::create(
                    realpath($this->_href)
                )
            );
        }

        return $this->_thumb;
    }

    /**
     * Save thumbnail and return relative path
     *
     * @return string
     */
    public function __toString()
    {
        $src = $this->_src. '/' . basename($this->_href);
        
        if (is_file($this->_imagePath)) {
            
            return $src;
        }
        
        $this->_getThumb()->save(
            $this->_imagePath
        );

        return $src;
    }
}
