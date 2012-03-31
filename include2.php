<?php
//ALL FUNCTIONS THAT ARE PART OF LIBRARIES - DO NOT TOUCH

// vim: set expandtab tabstop=4 shiftwidth=4 fdm=marker:
// +----------------------------------------------------------------------+
// | PHP Version 4                                                        |
// +----------------------------------------------------------------------+
// | Copyright (c) 1997-2003 The PHP Group                                |
// +----------------------------------------------------------------------+
// | This source file is subject to version 2.02 of the PHP license,      |
// | that is bundled with this package in the file LICENSE, and is        |
// | available at through the world-wide-web at                           |
// | http://www.php.net/license/2_02.txt.                                 |
// | If you did not receive a copy of the PHP license and are unable to   |
// | obtain it through the world-wide-web, please send a note to          |
// | license@php.net so we can mail you a copy immediately.               |
// +----------------------------------------------------------------------+
// | Authors: Martin Jansen <mj@php.net>                                  |
// |                                                                      |
// +----------------------------------------------------------------------+
//
// $Id: rss.php,v 1.1 2004/02/01 09:01:47 Shane A. Froebel Exp $
//

//require_once 'XML/Parser.php';

///////////////////////////////////////////////////////////////
//
// +----------------------------------------------------------------------+
// | PEAR, the PHP Extension and Application Repository                   |
// +----------------------------------------------------------------------+
// | Copyright (c) 1997-2004 The PHP Group                                |
// +----------------------------------------------------------------------+
// | This source file is subject to version 2.0 of the PHP license,       |
// | that is bundled with this package in the file LICENSE, and is        |
// | available through the world-wide-web at the following url:           |
// | http://www.php.net/license/3_0.txt.                                  |
// | If you did not receive a copy of the PHP license and are unable to   |
// | obtain it through the world-wide-web, please send a note to          |
// | license@php.net so we can mail you a copy immediately.               |
// +----------------------------------------------------------------------+
// | Authors: Sterling Hughes <sterling@php.net>                          |
// |          Stig Bakken <ssb@php.net>                                   |
// |          Tomas V.V.Cox <cox@idecnet.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: PEAR.php,v 1.50.2.18 2004/04/03 06:28:46 cellog Exp $
//

define('PEAR_ERROR_RETURN',     1);
define('PEAR_ERROR_PRINT',      2);
define('PEAR_ERROR_TRIGGER',    4);
define('PEAR_ERROR_DIE',        8);
define('PEAR_ERROR_CALLBACK',  16);
/**
 * WARNING: obsolete
 * @deprecated
 */
define('PEAR_ERROR_EXCEPTION', 32);
define('PEAR_ZE2', (function_exists('version_compare') &&
                    version_compare(zend_version(), "2-dev", "ge")));

if (substr(PHP_OS, 0, 3) == 'WIN') {
    define('OS_WINDOWS', true);
    define('OS_UNIX',    false);
    define('PEAR_OS',    'Windows');
} else {
    define('OS_WINDOWS', false);
    define('OS_UNIX',    true);
    define('PEAR_OS',    'Unix'); // blatant assumption
}

// instant backwards compatibility
if (!defined('PATH_SEPARATOR')) {
    if (OS_WINDOWS) {
        define('PATH_SEPARATOR', ';');
    } else {
        define('PATH_SEPARATOR', ':');
    }
}

$GLOBALS['_PEAR_default_error_mode']     = PEAR_ERROR_RETURN;
$GLOBALS['_PEAR_default_error_options']  = E_USER_NOTICE;
$GLOBALS['_PEAR_destructor_object_list'] = array();
$GLOBALS['_PEAR_shutdown_funcs']         = array();
$GLOBALS['_PEAR_error_handler_stack']    = array();

ini_set('track_errors', true);

/**
 * Base class for other PEAR classes.  Provides rudimentary
 * emulation of destructors.
 *
 * If you want a destructor in your class, inherit PEAR and make a
 * destructor method called _yourclassname (same name as the
 * constructor, but with a "_" prefix).  Also, in your constructor you
 * have to call the PEAR constructor: $this->PEAR();.
 * The destructor method will be called without parameters.  Note that
 * at in some SAPI implementations (such as Apache), any output during
 * the request shutdown (in which destructors are called) seems to be
 * discarded.  If you need to get any debug information from your
 * destructor, use error_log(), syslog() or something similar.
 *
 * IMPORTANT! To use the emulated destructors you need to create the
 * objects by reference: $obj =& new PEAR_child;
 *
 * @since PHP 4.0.2
 * @author Stig Bakken <ssb@php.net>
 * @see http://pear.php.net/manual/
 */
class PEAR
{
    // {{{ properties

    /**
     * Whether to enable internal debug messages.
     *
     * @var     bool
     * @access  private
     */
    var $_debug = false;

    /**
     * Default error mode for this object.
     *
     * @var     int
     * @access  private
     */
    var $_default_error_mode = null;

    /**
     * Default error options used for this object when error mode
     * is PEAR_ERROR_TRIGGER.
     *
     * @var     int
     * @access  private
     */
    var $_default_error_options = null;

    /**
     * Default error handler (callback) for this object, if error mode is
     * PEAR_ERROR_CALLBACK.
     *
     * @var     string
     * @access  private
     */
    var $_default_error_handler = '';

    /**
     * Which class to use for error objects.
     *
     * @var     string
     * @access  private
     */
    var $_error_class = 'PEAR_Error';

    /**
     * An array of expected errors.
     *
     * @var     array
     * @access  private
     */
    var $_expected_errors = array();

    // }}}

    // {{{ constructor

    /**
     * Constructor.  Registers this object in
     * $_PEAR_destructor_object_list for destructor emulation if a
     * destructor object exists.
     *
     * @param string $error_class  (optional) which class to use for
     *        error objects, defaults to PEAR_Error.
     * @access public
     * @return void
     */
    function PEAR($error_class = null)
    {
        $classname = get_class($this);
        if ($this->_debug) {
            print "PEAR constructor called, class=$classname\n";
        }
        if ($error_class !== null) {
            $this->_error_class = $error_class;
        }
        while ($classname) {
            $destructor = "_$classname";
            if (method_exists($this, $destructor)) {
                global $_PEAR_destructor_object_list;
                $_PEAR_destructor_object_list[] = &$this;
                break;
            } else {
                $classname = get_parent_class($classname);
            }
        }
    }

    // }}}
    // {{{ destructor

    /**
     * Destructor (the emulated type of...).  Does nothing right now,
     * but is included for forward compatibility, so subclass
     * destructors should always call it.
     *
     * See the note in the class desciption about output from
     * destructors.
     *
     * @access public
     * @return void
     */
    function _PEAR() {
        if ($this->_debug) {
            printf("PEAR destructor called, class=%s\n", get_class($this));
        }
    }

    // }}}
    // {{{ getStaticProperty()

    /**
    * If you have a class that's mostly/entirely static, and you need static
    * properties, you can use this method to simulate them. Eg. in your method(s)
    * do this: $myVar = &PEAR::getStaticProperty('myclass', 'myVar');
    * You MUST use a reference, or they will not persist!
    *
    * @access public
    * @param  string $class  The calling classname, to prevent clashes
    * @param  string $var    The variable to retrieve.
    * @return mixed   A reference to the variable. If not set it will be
    *                 auto initialised to NULL.
    */
    function &getStaticProperty($class, $var)
    {
        static $properties;
        return $properties[$class][$var];
    }

    // }}}
    // {{{ registerShutdownFunc()

    /**
    * Use this function to register a shutdown method for static
    * classes.
    *
    * @access public
    * @param  mixed $func  The function name (or array of class/method) to call
    * @param  mixed $args  The arguments to pass to the function
    * @return void
    */
    function registerShutdownFunc($func, $args = array())
    {
        $GLOBALS['_PEAR_shutdown_funcs'][] = array($func, $args);
    }

    // }}}
    // {{{ isError()

    /**
     * Tell whether a value is a PEAR error.
     *
     * @param   mixed $data   the value to test
     * @param   int   $code   if $data is an error object, return true
     *                        only if $code is a string and
     *                        $obj->getMessage() == $code or
     *                        $code is an integer and $obj->getCode() == $code
     * @access  public
     * @return  bool    true if parameter is an error
     */
    function isError($data, $code = null)
    {
        if (is_a($data, 'PEAR_Error')) {
            if (is_null($code)) {
                return true;
            } elseif (is_string($code)) {
                return $data->getMessage() == $code;
            } else {
                return $data->getCode() == $code;
            }
        }
        return false;
    }

    // }}}
    // {{{ setErrorHandling()

    /**
     * Sets how errors generated by this object should be handled.
     * Can be invoked both in objects and statically.  If called
     * statically, setErrorHandling sets the default behaviour for all
     * PEAR objects.  If called in an object, setErrorHandling sets
     * the default behaviour for that object.
     *
     * @param int $mode
     *        One of PEAR_ERROR_RETURN, PEAR_ERROR_PRINT,
     *        PEAR_ERROR_TRIGGER, PEAR_ERROR_DIE,
     *        PEAR_ERROR_CALLBACK or PEAR_ERROR_EXCEPTION.
     *
     * @param mixed $options
     *        When $mode is PEAR_ERROR_TRIGGER, this is the error level (one
     *        of E_USER_NOTICE, E_USER_WARNING or E_USER_ERROR).
     *
     *        When $mode is PEAR_ERROR_CALLBACK, this parameter is expected
     *        to be the callback function or method.  A callback
     *        function is a string with the name of the function, a
     *        callback method is an array of two elements: the element
     *        at index 0 is the object, and the element at index 1 is
     *        the name of the method to call in the object.
     *
     *        When $mode is PEAR_ERROR_PRINT or PEAR_ERROR_DIE, this is
     *        a printf format string used when printing the error
     *        message.
     *
     * @access public
     * @return void
     * @see PEAR_ERROR_RETURN
     * @see PEAR_ERROR_PRINT
     * @see PEAR_ERROR_TRIGGER
     * @see PEAR_ERROR_DIE
     * @see PEAR_ERROR_CALLBACK
     * @see PEAR_ERROR_EXCEPTION
     *
     * @since PHP 4.0.5
     */

    function setErrorHandling($mode = null, $options = null)
    {
        if (isset($this) && is_a($this, 'PEAR')) {
            $setmode     = &$this->_default_error_mode;
            $setoptions  = &$this->_default_error_options;
        } else {
            $setmode     = &$GLOBALS['_PEAR_default_error_mode'];
            $setoptions  = &$GLOBALS['_PEAR_default_error_options'];
        }

        switch ($mode) {
            case PEAR_ERROR_EXCEPTION:
            case PEAR_ERROR_RETURN:
            case PEAR_ERROR_PRINT:
            case PEAR_ERROR_TRIGGER:
            case PEAR_ERROR_DIE:
            case null:
                $setmode = $mode;
                $setoptions = $options;
                break;

            case PEAR_ERROR_CALLBACK:
                $setmode = $mode;
                // class/object method callback
                if (is_callable($options)) {
                    $setoptions = $options;
                } else {
                    trigger_error("invalid error callback", E_USER_WARNING);
                }
                break;

            default:
                trigger_error("invalid error mode", E_USER_WARNING);
                break;
        }
    }

    // }}}
    // {{{ expectError()

    /**
     * This method is used to tell which errors you expect to get.
     * Expected errors are always returned with error mode
     * PEAR_ERROR_RETURN.  Expected error codes are stored in a stack,
     * and this method pushes a new element onto it.  The list of
     * expected errors are in effect until they are popped off the
     * stack with the popExpect() method.
     *
     * Note that this method can not be called statically
     *
     * @param mixed $code a single error code or an array of error codes to expect
     *
     * @return int     the new depth of the "expected errors" stack
     * @access public
     */
    function expectError($code = '*')
    {
        if (is_array($code)) {
            array_push($this->_expected_errors, $code);
        } else {
            array_push($this->_expected_errors, array($code));
        }
        return sizeof($this->_expected_errors);
    }

    // }}}
    // {{{ popExpect()

    /**
     * This method pops one element off the expected error codes
     * stack.
     *
     * @return array   the list of error codes that were popped
     */
    function popExpect()
    {
        return array_pop($this->_expected_errors);
    }

    // }}}
    // {{{ _checkDelExpect()

    /**
     * This method checks unsets an error code if available
     *
     * @param mixed error code
     * @return bool true if the error code was unset, false otherwise
     * @access private
     * @since PHP 4.3.0
     */
    function _checkDelExpect($error_code)
    {
        $deleted = false;

        foreach ($this->_expected_errors AS $key => $error_array) {
            if (in_array($error_code, $error_array)) {
                unset($this->_expected_errors[$key][array_search($error_code, $error_array)]);
                $deleted = true;
            }

            // clean up empty arrays
            if (0 == count($this->_expected_errors[$key])) {
                unset($this->_expected_errors[$key]);
            }
        }
        return $deleted;
    }

    // }}}
    // {{{ delExpect()

    /**
     * This method deletes all occurences of the specified element from
     * the expected error codes stack.
     *
     * @param  mixed $error_code error code that should be deleted
     * @return mixed list of error codes that were deleted or error
     * @access public
     * @since PHP 4.3.0
     */
    function delExpect($error_code)
    {
        $deleted = false;

        if ((is_array($error_code) && (0 != count($error_code)))) {
            // $error_code is a non-empty array here;
            // we walk through it trying to unset all
            // values
            foreach($error_code as $key => $error) {
                if ($this->_checkDelExpect($error)) {
                    $deleted =  true;
                } else {
                    $deleted = false;
                }
            }
            return $deleted ? true : PEAR::raiseError("The expected error you submitted does not exist"); // IMPROVE ME
        } elseif (!empty($error_code)) {
            // $error_code comes alone, trying to unset it
            if ($this->_checkDelExpect($error_code)) {
                return true;
            } else {
                return PEAR::raiseError("The expected error you submitted does not exist"); // IMPROVE ME
            }
        } else {
            // $error_code is empty
            return PEAR::raiseError("The expected error you submitted is empty"); // IMPROVE ME
        }
    }

    // }}}
    // {{{ raiseError()

    /**
     * This method is a wrapper that returns an instance of the
     * configured error class with this object's default error
     * handling applied.  If the $mode and $options parameters are not
     * specified, the object's defaults are used.
     *
     * @param mixed $message a text error message or a PEAR error object
     *
     * @param int $code      a numeric error code (it is up to your class
     *                  to define these if you want to use codes)
     *
     * @param int $mode      One of PEAR_ERROR_RETURN, PEAR_ERROR_PRINT,
     *                  PEAR_ERROR_TRIGGER, PEAR_ERROR_DIE,
     *                  PEAR_ERROR_CALLBACK, PEAR_ERROR_EXCEPTION.
     *
     * @param mixed $options If $mode is PEAR_ERROR_TRIGGER, this parameter
     *                  specifies the PHP-internal error level (one of
     *                  E_USER_NOTICE, E_USER_WARNING or E_USER_ERROR).
     *                  If $mode is PEAR_ERROR_CALLBACK, this
     *                  parameter specifies the callback function or
     *                  method.  In other error modes this parameter
     *                  is ignored.
     *
     * @param string $userinfo If you need to pass along for example debug
     *                  information, this parameter is meant for that.
     *
     * @param string $error_class The returned error object will be
     *                  instantiated from this class, if specified.
     *
     * @param bool $skipmsg If true, raiseError will only pass error codes,
     *                  the error message parameter will be dropped.
     *
     * @access public
     * @return object   a PEAR error object
     * @see PEAR::setErrorHandling
     * @since PHP 4.0.5
     */
    function raiseError($message = null,
                         $code = null,
                         $mode = null,
                         $options = null,
                         $userinfo = null,
                         $error_class = null,
                         $skipmsg = false)
    {
        // The error is yet a PEAR error object
        if (is_object($message)) {
            $code        = $message->getCode();
            $userinfo    = $message->getUserInfo();
            $error_class = $message->getType();
            $message->error_message_prefix = '';
            $message     = $message->getMessage();
        }

        if (isset($this) && isset($this->_expected_errors) && sizeof($this->_expected_errors) > 0 && sizeof($exp = end($this->_expected_errors))) {
            if ($exp[0] == "*" ||
                (is_int(reset($exp)) && in_array($code, $exp)) ||
                (is_string(reset($exp)) && in_array($message, $exp))) {
                $mode = PEAR_ERROR_RETURN;
            }
        }
        // No mode given, try global ones
        if ($mode === null) {
            // Class error handler
            if (isset($this) && isset($this->_default_error_mode)) {
                $mode    = $this->_default_error_mode;
                $options = $this->_default_error_options;
            // Global error handler
            } elseif (isset($GLOBALS['_PEAR_default_error_mode'])) {
                $mode    = $GLOBALS['_PEAR_default_error_mode'];
                $options = $GLOBALS['_PEAR_default_error_options'];
            }
        }

        if ($error_class !== null) {
            $ec = $error_class;
        } elseif (isset($this) && isset($this->_error_class)) {
            $ec = $this->_error_class;
        } else {
            $ec = 'PEAR_Error';
        }
        if ($skipmsg) {
            return new $ec($code, $mode, $options, $userinfo);
        } else {
            return new $ec($message, $code, $mode, $options, $userinfo);
        }
    }

    // }}}
    // {{{ throwError()

    /**
     * Simpler form of raiseError with fewer options.  In most cases
     * message, code and userinfo are enough.
     *
     * @param string $message
     *
     */
    function throwError($message = null,
                         $code = null,
                         $userinfo = null)
    {
        if (isset($this) && is_a($this, 'PEAR')) {
            return $this->raiseError($message, $code, null, null, $userinfo);
        } else {
            return PEAR::raiseError($message, $code, null, null, $userinfo);
        }
    }

    // }}}
    // {{{ pushErrorHandling()

    /**
     * Push a new error handler on top of the error handler options stack. With this
     * you can easily override the actual error handler for some code and restore
     * it later with popErrorHandling.
     *
     * @param mixed $mode (same as setErrorHandling)
     * @param mixed $options (same as setErrorHandling)
     *
     * @return bool Always true
     *
     * @see PEAR::setErrorHandling
     */
    function pushErrorHandling($mode, $options = null)
    {
        $stack = &$GLOBALS['_PEAR_error_handler_stack'];
        if (isset($this) && is_a($this, 'PEAR')) {
            $def_mode    = &$this->_default_error_mode;
            $def_options = &$this->_default_error_options;
        } else {
            $def_mode    = &$GLOBALS['_PEAR_default_error_mode'];
            $def_options = &$GLOBALS['_PEAR_default_error_options'];
        }
        $stack[] = array($def_mode, $def_options);

        if (isset($this) && is_a($this, 'PEAR')) {
            $this->setErrorHandling($mode, $options);
        } else {
            PEAR::setErrorHandling($mode, $options);
        }
        $stack[] = array($mode, $options);
        return true;
    }

    // }}}
    // {{{ popErrorHandling()

    /**
    * Pop the last error handler used
    *
    * @return bool Always true
    *
    * @see PEAR::pushErrorHandling
    */
    function popErrorHandling()
    {
        $stack = &$GLOBALS['_PEAR_error_handler_stack'];
        array_pop($stack);
        list($mode, $options) = $stack[sizeof($stack) - 1];
        array_pop($stack);
        if (isset($this) && is_a($this, 'PEAR')) {
            $this->setErrorHandling($mode, $options);
        } else {
            PEAR::setErrorHandling($mode, $options);
        }
        return true;
    }

    // }}}
    // {{{ loadExtension()

    /**
    * OS independant PHP extension load. Remember to take care
    * on the correct extension name for case sensitive OSes.
    *
    * @param string $ext The extension name
    * @return bool Success or not on the dl() call
    */
    function loadExtension($ext)
    {
        if (!extension_loaded($ext)) {
            // if either returns true dl() will produce a FATAL error, stop that
            if ((ini_get('enable_dl') != 1) || (ini_get('safe_mode') == 1)) {
                return false;
            }
            if (OS_WINDOWS) {
                $suffix = '.dll';
            } elseif (PHP_OS == 'HP-UX') {
                $suffix = '.sl';
            } elseif (PHP_OS == 'AIX') {
                $suffix = '.a';
            } elseif (PHP_OS == 'OSX') {
                $suffix = '.bundle';
            } else {
                $suffix = '.so';
            }
            return @dl('php_'.$ext.$suffix) || @dl($ext.$suffix);
        }
        return true;
    }

    // }}}
}

// {{{ _PEAR_call_destructors()

function _PEAR_call_destructors()
{
    global $_PEAR_destructor_object_list;
    if (is_array($_PEAR_destructor_object_list) &&
        sizeof($_PEAR_destructor_object_list))
    {
        reset($_PEAR_destructor_object_list);
        while (list($k, $objref) = each($_PEAR_destructor_object_list)) {
            $classname = get_class($objref);
            while ($classname) {
                $destructor = "_$classname";
                if (method_exists($objref, $destructor)) {
                    $objref->$destructor();
                    break;
                } else {
                    $classname = get_parent_class($classname);
                }
            }
        }
        // Empty the object list to ensure that destructors are
        // not called more than once.
        $_PEAR_destructor_object_list = array();
    }

    // Now call the shutdown functions
    if (is_array($GLOBALS['_PEAR_shutdown_funcs']) AND !empty($GLOBALS['_PEAR_shutdown_funcs'])) {
        foreach ($GLOBALS['_PEAR_shutdown_funcs'] as $value) {
            call_user_func_array($value[0], $value[1]);
        }
    }
}

// }}}

class PEAR_Error
{
    // {{{ properties

    var $error_message_prefix = '';
    var $mode                 = PEAR_ERROR_RETURN;
    var $level                = E_USER_NOTICE;
    var $code                 = -1;
    var $message              = '';
    var $userinfo             = '';
    var $backtrace            = null;

    // }}}
    // {{{ constructor

    /**
     * PEAR_Error constructor
     *
     * @param string $message  message
     *
     * @param int $code     (optional) error code
     *
     * @param int $mode     (optional) error mode, one of: PEAR_ERROR_RETURN,
     * PEAR_ERROR_PRINT, PEAR_ERROR_DIE, PEAR_ERROR_TRIGGER,
     * PEAR_ERROR_CALLBACK or PEAR_ERROR_EXCEPTION
     *
     * @param mixed $options   (optional) error level, _OR_ in the case of
     * PEAR_ERROR_CALLBACK, the callback function or object/method
     * tuple.
     *
     * @param string $userinfo (optional) additional user/debug info
     *
     * @access public
     *
     */
    function PEAR_Error($message = 'unknown error', $code = null,
                        $mode = null, $options = null, $userinfo = null)
    {
        if ($mode === null) {
            $mode = PEAR_ERROR_RETURN;
        }
        $this->message   = $message;
        $this->code      = $code;
        $this->mode      = $mode;
        $this->userinfo  = $userinfo;
        if (function_exists("debug_backtrace")) {
            $this->backtrace = debug_backtrace();
        }
        if ($mode & PEAR_ERROR_CALLBACK) {
            $this->level = E_USER_NOTICE;
            $this->callback = $options;
        } else {
            if ($options === null) {
                $options = E_USER_NOTICE;
            }
            $this->level = $options;
            $this->callback = null;
        }
        if ($this->mode & PEAR_ERROR_PRINT) {
            if (is_null($options) || is_int($options)) {
                $format = "%s";
            } else {
                $format = $options;
            }
            printf($format, $this->getMessage());
        }
        if ($this->mode & PEAR_ERROR_TRIGGER) {
            trigger_error($this->getMessage(), $this->level);
        }
        if ($this->mode & PEAR_ERROR_DIE) {
            $msg = $this->getMessage();
            if (is_null($options) || is_int($options)) {
                $format = "%s";
                if (substr($msg, -1) != "\n") {
                    $msg .= "\n";
                }
            } else {
                $format = $options;
            }
            die(sprintf($format, $msg));
        }
        if ($this->mode & PEAR_ERROR_CALLBACK) {
            if (is_callable($this->callback)) {
                call_user_func($this->callback, $this);
            }
        }
        if ($this->mode & PEAR_ERROR_EXCEPTION) {
            trigger_error("PEAR_ERROR_EXCEPTION is obsolete, use class PEAR_ErrorStack for exceptions", E_USER_WARNING);
            eval('$e = new Exception($this->message, $this->code);$e->PEAR_Error = $this;throw($e);');
        }
    }

    // }}}
    // {{{ getMode()

    /**
     * Get the error mode from an error object.
     *
     * @return int error mode
     * @access public
     */
    function getMode() {
        return $this->mode;
    }

    // }}}
    // {{{ getCallback()

    /**
     * Get the callback function/method from an error object.
     *
     * @return mixed callback function or object/method array
     * @access public
     */
    function getCallback() {
        return $this->callback;
    }

    // }}}
    // {{{ getMessage()


    /**
     * Get the error message from an error object.
     *
     * @return  string  full error message
     * @access public
     */
    function getMessage()
    {
        return ($this->error_message_prefix . $this->message);
    }


    // }}}
    // {{{ getCode()

    /**
     * Get error code from an error object
     *
     * @return int error code
     * @access public
     */
     function getCode()
     {
        return $this->code;
     }

    // }}}
    // {{{ getType()

    /**
     * Get the name of this error/exception.
     *
     * @return string error/exception name (type)
     * @access public
     */
    function getType()
    {
        return get_class($this);
    }

    // }}}
    // {{{ getUserInfo()

    /**
     * Get additional user-supplied information.
     *
     * @return string user-supplied information
     * @access public
     */
    function getUserInfo()
    {
        return $this->userinfo;
    }

    // }}}
    // {{{ getDebugInfo()

    /**
     * Get additional debug information supplied by the application.
     *
     * @return string debug information
     * @access public
     */
    function getDebugInfo()
    {
        return $this->getUserInfo();
    }

    // }}}
    // {{{ getBacktrace()

    /**
     * Get the call backtrace from where the error was generated.
     * Supported with PHP 4.3.0 or newer.
     *
     * @param int $frame (optional) what frame to fetch
     * @return array Backtrace, or NULL if not available.
     * @access public
     */
    function getBacktrace($frame = null)
    {
        if ($frame === null) {
            return $this->backtrace;
        }
        return $this->backtrace[$frame];
    }

    // }}}
    // {{{ addUserInfo()

    function addUserInfo($info)
    {
        if (empty($this->userinfo)) {
            $this->userinfo = $info;
        } else {
            $this->userinfo .= " ** $info";
        }
    }

    // }}}
    // {{{ toString()

    /**
     * Make a string representation of this object.
     *
     * @return string a string with an object summary
     * @access public
     */
    function toString() {
        $modes = array();
        $levels = array(E_USER_NOTICE  => 'notice',
                        E_USER_WARNING => 'warning',
                        E_USER_ERROR   => 'error');
        if ($this->mode & PEAR_ERROR_CALLBACK) {
            if (is_array($this->callback)) {
                $callback = get_class($this->callback[0]) . '::' .
                    $this->callback[1];
            } else {
                $callback = $this->callback;
            }
            return sprintf('[%s: message="%s" code=%d mode=callback '.
                           'callback=%s prefix="%s" info="%s"]',
                           get_class($this), $this->message, $this->code,
                           $callback, $this->error_message_prefix,
                           $this->userinfo);
        }
        if ($this->mode & PEAR_ERROR_PRINT) {
            $modes[] = 'print';
        }
        if ($this->mode & PEAR_ERROR_TRIGGER) {
            $modes[] = 'trigger';
        }
        if ($this->mode & PEAR_ERROR_DIE) {
            $modes[] = 'die';
        }
        if ($this->mode & PEAR_ERROR_RETURN) {
            $modes[] = 'return';
        }
        return sprintf('[%s: message="%s" code=%d mode=%s level=%s '.
                       'prefix="%s" info="%s"]',
                       get_class($this), $this->message, $this->code,
                       implode("|", $modes), $levels[$this->level],
                       $this->error_message_prefix,
                       $this->userinfo);
    }

    // }}}
}

register_shutdown_function("_PEAR_call_destructors");

/*
 * Local Variables:
 * mode: php
 * tab-width: 4
 * c-basic-offset: 4
 * End:
 */
///////////////////////////////////////////////////////////////
//
// +----------------------------------------------------------------------+
// | PHP Version 4                                                        |
// +----------------------------------------------------------------------+
// | Copyright (c) 1997-2003 The PHP Group                                |
// +----------------------------------------------------------------------+
// | This source file is subject to version 2.02 of the PHP license,      |
// | that is bundled with this package in the file LICENSE, and is        |
// | available at through the world-wide-web at                           |
// | http://www.php.net/license/2_02.txt.                                 |
// | If you did not receive a copy of the PHP license and are unable to   |
// | obtain it through the world-wide-web, please send a note to          |
// | license@php.net so we can mail you a copy immediately.               |
// +----------------------------------------------------------------------+
// | Author: Stig Bakken <ssb@fast.no>                                    |
// +----------------------------------------------------------------------+
//
// $Id: Parser.php,v 1.5 2003/02/23 10:48:31 ssb Exp $

//require_once 'PEAR.php';

/**
 * XML Parser class.  This is an XML parser based on PHP's "xml" extension,
 * based on the bundled expat library.
 *
 * @author  Stig Bakken <ssb@fast.no>
 * @todo    Tests that need to be made:
 *          - error class
 *          - mixing character encodings
 *          - a test using all expat handlers
 *          - options (folding, output charset)
 *          - different parsing modes
 *
 * @notes   - It requires PHP 4.0.4pl1 or greater
 *          - From revision 1.17, the function names used by the 'func' mode
 *            are in the format "xmltag_$elem", for example: use "xmltag_name"
 *            to handle the <name></name> tags of your xml file.
 */
class XML_Parser extends PEAR
{
    // {{{ properties

    /**
     * @var  resource  XML parser handle
     */
    var $parser;

    /**
     * @var  resource  File handle if parsing from a file
     */
    var $fp;

    /**
     * @var  boolean  Whether to do case folding
     */
    var $folding = true;

    /**
     * @var  string  Mode of operation, one of "event" or "func"
     */
    var $mode;

    /**
     * Mapping from expat handler function to class method.
     *
     * @var  array
     */
    var $handler = array(
        'character_data_handler'            => 'cdataHandler',
        'default_handler'                   => 'defaultHandler',
        'processing_instruction_handler'    => 'piHandler',
        'unparsed_entity_decl_handler'      => 'unparsedHandler',
        'notation_decl_handler'             => 'notationHandler',
        'external_entity_ref_handler'       => 'entityrefHandler'
    );

    /**
     * @var string source encoding
     */
    var $srcenc;

    /**
     * @var string target encoding
     */
    var $tgtenc;

    /*
     * Use call_user_func when php >= 4.0.7
     * @var boolean
     * @see setMode()
     */
    var $use_call_user_func = true;

    // }}}
    // {{{ constructor

    /**
     * Creates an XML parser.
     *
     * @param    string  source charset encoding, use NULL (default) to use
     *                   whatever the document specifies
     * @param    string  how this parser object should work, "event" for
     *                   startelement/endelement-type events, "func"
     *                   to have it call functions named after elements
     *
     * @see xml_parser_create
     */
    function XML_Parser($srcenc = null, $mode = "event", $tgtenc = null)
    {
        $this->PEAR('XML_Parser_Error');

        if ($srcenc === null) {
            $xp = @xml_parser_create();
        } else {
            $xp = @xml_parser_create($srcenc);
        }
        if (is_resource($xp)) {
            if ($tgtenc !== null) {
                if (!@xml_parser_set_option($xp, XML_OPTION_TARGET_ENCODING,
                                            $tgtenc)) {
                    return $this->raiseError("invalid target encoding");
                }
            }
            $this->parser = $xp;
            $this->setMode($mode);
            xml_parser_set_option($xp, XML_OPTION_CASE_FOLDING, $this->folding);
        }
        $this->srcenc = $srcenc;
        $this->tgtenc = $tgtenc;
    }
    // }}}

    // {{{ setMode()

    /**
     * Sets the mode and all handler.
     *
     * @param    string
     * @see      $handler
     */
    function setMode($mode)
    {

        $this->mode = $mode;

        xml_set_object($this->parser, $this);

        switch ($mode) {

            case "func":
                // use call_user_func() when php >= 4.0.7
                // or call_user_method() if not
                if (version_compare(phpversion(), '4.0.7', 'lt')) {
                    $this->use_call_user_func = false;
                } else {
                    $this->use_call_user_func = true;
                }

                xml_set_element_handler($this->parser, "funcStartHandler", "funcEndHandler");
                break;

            case "event":
                xml_set_element_handler($this->parser, "startHandler", "endHandler");
                break;
        }

        foreach ($this->handler as $xml_func => $method)
            if (method_exists($this, $method)) {
                $xml_func = "xml_set_" . $xml_func;
                $xml_func($this->parser, $method);
            }

    }

    // }}}
    // {{{ setInputFile()

    /**
     * Defines
     *
     * @param    string      Filename (full path)
     * @return   resource    fopen handle of the given file
     * @throws   XML_Parser_Error
     * @see      setInput(), parse()
     * @access   public
     */
    function setInputFile($file)
    {

        $fp = @fopen($file, "rb");
        if (is_resource($fp)) {
            $this->fp = $fp;
            return $fp;
        }

        return $this->raiseError($php_errormsg);
    }

    // }}}
    // {{{ setInput()

    /**
     * Sets the file handle to use with parse().
     *
     * @param    resource    fopen
     * @access   public
     * @see      parse(), setInputFile()
     */
    function setInput($fp)
    {
        if (is_resource($fp)) {
            $this->fp = $fp;
            return true;
        }

        return $this->raiseError("not a file resource");
    }

    // }}}
    // {{{ parse()

    /**
     * Central parsing function.
     *
     * @throws   XML_Parser_Error
     * @return   boolean true on success
     * @see      parseString()
     * @access   public
     */
    function parse()
    {
        if (!is_resource($this->fp)) {
            return $this->raiseError("no input");
        }

        while ($data = fread($this->fp, 2048)) {

            $err = $this->parseString($data, feof($this->fp));
            if (PEAR::isError($err)) {
                fclose($this->fp);
                return $err;
            }

        }

        fclose($this->fp);

        return true;
    }

    // }}}
    // {{{ parseString()

    /**
     * Parses a string.
     *
     * @param    string  XML data
     * @param    boolean ???
     * @throws   XML_Parser_Error
     * @return   mixed   true on success or a string with the xml parser error
     */
    function parseString($data, $eof = false)
    {
        if (!xml_parse($this->parser, $data, $eof)) {
            $err = $this->raiseError($this->parser);
            xml_parser_free($this->parser);
            return $err;
        }

        return true;
    }

    // }}}
    // {{{ funcStartHandler()

    function funcStartHandler($xp, $elem, $attribs)
    {
        $func = 'xmltag_' . $elem;
        if (method_exists($this, $func)) {
            if ($this->use_call_user_func) {
                call_user_func(array(&$this, $func), $xp, $elem, $attribs);
            } else {
                call_user_method($func, $this, $xp, $elem, $attribs);
            }
        }

    }

    // }}}
    // {{{ funcEndHandler()

    function funcEndHandler($xp, $elem)
    {
        $func = 'xmltag_' . $elem . '_';
        if (method_exists($this, $func)) {
            if ($this->use_call_user_func) {
                call_user_func(array(&$this, $func), $xp, $elem);
            } else {
                call_user_method($func, $this, $xp, $elem);
            }
        }
    }

    // }}}
    // {{{ startHandler()

    /**
     *
     * @abstract
     */
    function startHandler($xp, $elem, &$attribs)
    {
        return NULL;
    }

    // }}}
    // {{{ endHandler()

    /**
     *
     * @abstract
     */
    function endHandler($xp, $elem)
    {
        return NULL;
    }


    // }}}
}

class XML_Parser_Error extends PEAR_Error
{
    // {{{ properties

    var $error_message_prefix = 'XML_Parser: ';

    // }}}
    // {{{ constructor()

    function XML_Parser_Error($msgorparser = 'unknown error', $code = 0, $mode = PEAR_ERROR_RETURN, $level = E_USER_NOTICE)
    {
        if (is_resource($msgorparser)) {
            $code = xml_get_error_code($msgorparser);
            $msgorparser = sprintf("%s at XML input line %d",
                                   xml_error_string($code),
                                   xml_get_current_line_number($msgorparser));
        }
        $this->PEAR_Error($msgorparser, $code, $mode, $level);

    }

    // }}}
}
///////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////

/**
* RSS parser class.
*
* This class is a parser for Resource Description Framework (RDF) Site
* Summary (RSS) documents. For more information on RSS see the
* website of the RSS working group (http://www.purl.org/rss/).
*
* @author Martin Jansen <mj@php.net>
* @version $Revision: 1.1 $
* @access  public
*/
class XML_RSS extends XML_Parser
{
    // {{{ properties

    /**
     * @var string
     */
    var $insideTag = '';

    /**
     * @var string
     */
    var $activeTag = '';

    /**
     * @var array
     */
    var $channel = array();

    /**
     * @var array
     */
    var $items = array();

    /**
     * @var array
     */
    var $item = array();

    /**
     * @var array
     */
    var $image = array();

    /**
     * @var array
     */
    var $textinput = array();
    
    /**
     * @var array
     */
    var $textinputs = array();

    /**
     * @var array
     */
    var $parentTags = array('CHANNEL', 'ITEM', 'IMAGE', 'TEXTINPUT');

    /**
     * @var array
     */
    var $channelTags = array('TITLE', 'LINK', 'DESCRIPTION', 'IMAGE',
                              'ITEMS', 'TEXTINPUT');

    /**
     * @var array
     */
    var $itemTags = array('TITLE', 'LINK', 'DESCRIPTION', 'PUBDATE');

    /**
     * @var array
     */
    var $imageTags = array('TITLE', 'URL', 'LINK');

    var $textinputTags = array('TITLE', 'DESCRIPTION', 'NAME', 'LINK');

    /**
     * List of allowed module tags
     *
     * Currently Dublin Core Metadata and the blogChannel RSS module
     * are supported.
     *
     * @var array
     */
    var $moduleTags = array('DC:TITLE', 'DC:CREATOR', 'DC:SUBJECT', 'DC:DESCRIPTION',
                            'DC:PUBLISHER', 'DC:CONTRIBUTOR', 'DC:DATE', 'DC:TYPE',
                            'DC:FORMAT', 'DC:IDENTIFIER', 'DC:SOURCE', 'DC:LANGUAGE',
                            'DC:RELATION', 'DC:COVERAGE', 'DC:RIGHTS',
                            'BLOGCHANNEL:BLOGROLL', 'BLOGCHANNEL:MYSUBSCRIPTIONS',
                            'BLOGCHANNEL:MYSUBSCRIPTIONS', 'BLOGCHANNEL:CHANGES');

    // }}}
    // {{{ Constructor

    /**
     * Constructor
     *
     * @access public
     * @param mixed File pointer or name of the RDF file.
     * @return void
     */
    function XML_RSS($handle = '')
    {
        $this->XML_Parser();

        if (@is_resource($handle)) {
            $this->setInput($handle);
        } elseif ($handle != '') {
            $this->setInputFile($handle);
        } else {
            $this->raiseError('No filename passed.');
        }
    }

    // }}}
    // {{{ startHandler()

    /**
     * Start element handler for XML parser
     *
     * @access private
     * @param  object XML parser object
     * @param  string XML element
     * @param  array  Attributes of XML tag
     * @return void
     */
    function startHandler($parser, $element, $attribs)
    {
        switch ($element) {
            case 'CHANNEL':
            case 'ITEM':
            case 'IMAGE':
            case 'TEXTINPUT':
                $this->insideTag = $element;
                break;

            default:
                $this->activeTag = $element;
        }
    }

    // }}}
    // {{{ endHandler()

    /**
     * End element handler for XML parser
     *
     * If the end of <item>, <channel>, <image> or <textinput>
     * is reached, this function updates the structure array
     * $this->struct[] and adds the field "type" to this array,
     * that defines the type of the current field.
     *
     * @access private
     * @param  object XML parser object
     * @param  string
     * @return void
     */
    function endHandler($parser, $element)
    {
        if ($element == $this->insideTag) {
            $this->insideTag = '';
            $this->struct[] = array_merge(array('type' => strtolower($element)),
                                          $this->last);
        }

        if ($element == 'ITEM') {
            $this->items[] = $this->item;
            $this->item = '';
        }

        if ($element == 'IMAGE') {
            $this->images[] = $this->image;
            $this->image = '';
        }

        if ($element == 'TEXTINPUT') {
            $this->textinputs = $this->textinput;
            $this->textinput = '';
        }

        $this->activeTag = '';
    }

    // }}}
    // {{{ cdataHandler()

    /**
     * Handler for character data
     *
     * @access private
     * @param  object XML parser object
     * @param  string CDATA
     * @return void
     */
    function cdataHandler($parser, $cdata)
    {
        if (in_array($this->insideTag, $this->parentTags)) {
            $tagName = strtolower($this->insideTag);
            $var = $this->{$tagName . 'Tags'};

            if (in_array($this->activeTag, $var) ||
                in_array($this->activeTag, $this->moduleTags)) {
                $this->_add($tagName, strtolower($this->activeTag),
                            $cdata);
            }
            
        }
    }

    // }}}
    // {{{ defaultHandler()

    /**
     * Default handler for XML parser
     *
     * @access private
     * @param  object XML parser object
     * @param  string CDATA
     * @return void
     */
    function defaultHandler($parser, $cdata)
    {
        return;
    }

    // }}}
    // {{{ _add()

    /**
     * Add element to internal result sets
     *
     * @access private
     * @param  string Name of the result set
     * @param  string Fieldname
     * @param  string Value
     * @return void
     * @see    cdataHandler
     */
    function _add($type, $field, $value)
    {
        if (empty($this->{$type}) || empty($this->{$type}[$field])) {
            $this->{$type}[$field] = $value;
        } else {
            $this->{$type}[$field] .= $value;
        }

        $this->last = $this->{$type};
    }

    // }}}
    // {{{ getStructure()

    /**
     * Get complete structure of RSS file
     *
     * @access public
     * @return array
     */
    function getStructure()
    {
        return (array)$this->struct;
    }

    // }}}
    // {{{ getchannelInfo()

    /**
     * Get general information about current channel
     *
     * This function returns an array containing the information
     * that has been extracted from the <channel>-tag while parsing
     * the RSS file.
     *
     * @access public
     * @return array
     */
    function getChannelInfo()
    {
        return (array)$this->channel;
    }

    // }}}
    // {{{ getItems()

    /**
     * Get items from RSS file
     *
     * This function returns an array containing the set of items
     * that are provided by the RSS file.
     *
     * @access public
     * @return array
     */
    function getItems()
    {
        return (array)$this->items;
    }

    // }}}
    // {{{ getImages()

    /**
     * Get images from RSS file
     *
     * This function returns an array containing the set of images
     * that are provided by the RSS file.
     *
     * @access public
     * @return array
     */
    function getImages()
    {
        return (array)$this->images;
    }

    // }}}
    // {{{ getTextinputs()

    /**
     * Get text input fields from RSS file
     *
     * @access public
     * @return array
     */
    function getTextinputs()
    {
        return (array)$this->textinputs;
    }

    // }}}
}
























//XXXX
	#
	# PEAR::Flickr_API
	#
	# Author: Cal Henderson
	# Version: $Revision: 1.6 $
	# CVS: $Id: API.php,v 1.6 2005/07/25 18:22:13 cal Exp $
	#


	//require_once 'Tree.php';
	//require_once 'Request.php';


	class Flickr_API {

		var $_cfg = array(
				'api_key'	=> '',
				'api_secret'	=> '',
				'endpoint'	=> 'http://www.flickr.com/services/rest/',
				'auth_endpoint'	=> 'http://www.flickr.com/services/auth/?',
				'conn_timeout'	=> 5,
				'io_timeout'	=> 5,
			);

		var $_err_code = 0;
		var $_err_msg = '';
		var $tree;

		function Flickr_API($params = array()){
			foreach($params as $k => $v){
				$this->_cfg[$k] = $v;
			}
		}

		function callMethod($method, $params = array()){

			$this->_err_code = 0;
			$this->_err_msg = '';

			#
			# create the POST body
			#

			$p = $params;
         $p['method'] = $method;
			$p['api_key'] = $this->_cfg['api_key'];
			if ($this->_cfg['api_secret']){
				$p['api_sig'] = $this->signArgs($p);
			}

			$p2 = array();
			foreach($p as $k => $v){
				$p2[] = urlencode($k).'='.urlencode($v);
			}

			$body = implode('&', $p2);


			#
			# create the http request
			#

			$req =& new HTTP_Request($this->_cfg['endpoint'], array('timeout' => $this->_cfg['conn_timeout']));

			$req->_readTimeout = array($this->_cfg['io_timeout'], 0);

			$req->setMethod(HTTP_REQUEST_METHOD_POST);
			$req->addRawPostData($body);
         //print "POST BODY=\"".$body."\"\n";

			$req->sendRequest();

			$this->_http_code = $req->getResponseCode();
			$this->_http_head = $req->getResponseHeader();
			$this->_http_body = $req->getResponseBody();
			if ($this->_http_code != 200){

				$this->_err_code = 0;

				if ($this->_http_code){
					$this->_err_msg = "Bad response from remote server: HTTP status code $this->_http_code";
				}else{
					$this->_err_msg = "Couldn't connect to remote server";
				}

				return 0;
			}


			#
			# create xml tree
			#

			$tree =& new XML_Tree();
         //print "BODY:".$this->_http_body."\n";
			$tree->getTreeFromString($this->_http_body);

			$this->tree = $tree;


			#
			# check we got an <rsp> element at the root
			#

			if ($tree->root->name != 'rsp'){

				$this->_err_code = 0;
				$this->_err_msg = "Bad XML response";

				return 0;
			}


			#
			# stat="fail" ?
			#

			if ($tree->root->attributes['stat'] == 'fail'){

				$n = null;
				foreach($tree->root->children as $child){
					if ($child->name == 'err'){
						$n = $child->attributes;
					}
				}

				$this->_err_code = $n['code'];
				$this->_err_msg = $n['msg'];

				return 0;
			}


			#
			# weird status
			#

			if ($tree->root->attributes['stat'] != 'ok'){

				$this->_err_code = 0;
				$this->_err_msg = "Unrecognised REST response status";

				return 0;
			}


			#
			# return the tree
			#

			return $tree->root;
		}


		function getErrorCode(){
			return $this->_err_code;
		}

		function getErrorMessage(){
			return $this->_err_msg;
		}

		function getAuthUrl($perms, $frob=''){

			$args = array(
				'api_key'	=> $this->_cfg['api_key'],
				'perms'		=> $perms,
			);

			if (strlen($frob)){ $args['frob'] = $frob; }

			$args['api_sig'] = $this->signArgs($args);

			#
			# build the url params
			#

			$pairs =  array();
			foreach($args as $k => $v){
				$pairs[] = urlencode($k).'='.urlencode($v);
			}

			return $this->_cfg['auth_endpoint'].implode('&', $pairs);
		}

		function signArgs($args){
			ksort($args);
			$a = '';
			foreach($args as $k => $v){
				$a .= $k . $v;
			}
         //print "MD5(".$this->_cfg['api_secret'].$a.")\n";
			return md5($this->_cfg['api_secret'].$a);
		}

	}

//YYYY


















// +-----------------------------------------------------------------------+
// | Copyright (c) 2002-2003, Richard Heyes                                |
// | All rights reserved.                                                  |
// |                                                                       |
// | Redistribution and use in source and binary forms, with or without    |
// | modification, are permitted provided that the following conditions    |
// | are met:                                                              |
// |                                                                       |
// | o Redistributions of source code must retain the above copyright      |
// |   notice, this list of conditions and the following disclaimer.       |
// | o Redistributions in binary form must reproduce the above copyright   |
// |   notice, this list of conditions and the following disclaimer in the |
// |   documentation and/or other materials provided with the distribution.|
// | o The names of the authors may not be used to endorse or promote      |
// |   products derived from this software without specific prior written  |
// |   permission.                                                         |
// |                                                                       |
// | THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS   |
// | "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT     |
// | LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR |
// | A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT  |
// | OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, |
// | SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT      |
// | LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, |
// | DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY |
// | THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT   |
// | (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE |
// | OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.  |
// |                                                                       |
// +-----------------------------------------------------------------------+
// | Author: Richard Heyes <richard@phpguru.org>                           |
// +-----------------------------------------------------------------------+
//
// $Id: Request.php,v 1.1 2004/12/09 20:54:23 cal Exp $
//
// HTTP_Request Class
//
// Simple example, (Fetches yahoo.com and displays it):
//
// $a = &new HTTP_Request('http://www.yahoo.com/');
// $a->sendRequest();
// echo $a->getResponseBody();
//

//require_once 'PEAR.php';
//require_once 'Socket.php';
//require_once 'URL.php';

define('HTTP_REQUEST_METHOD_GET',     'GET',     true);
define('HTTP_REQUEST_METHOD_HEAD',    'HEAD',    true);
define('HTTP_REQUEST_METHOD_POST',    'POST',    true);
define('HTTP_REQUEST_METHOD_PUT',     'PUT',     true);
define('HTTP_REQUEST_METHOD_DELETE',  'DELETE',  true);
define('HTTP_REQUEST_METHOD_OPTIONS', 'OPTIONS', true);
define('HTTP_REQUEST_METHOD_TRACE',   'TRACE',   true);

define('HTTP_REQUEST_HTTP_VER_1_0', '1.0', true);
define('HTTP_REQUEST_HTTP_VER_1_1', '1.1', true);

class HTTP_Request {

    /**
    * Instance of Net_URL
    * @var object    
    */
    var $_url;

    /**
    * Type of request
    * @var string
    */
    var $_method;

    /**
    * HTTP Version
    * @var string
    */
    var $_http;

    /**
    * Request headers
    * @var array
    */
    var $_requestHeaders;

    /**
    * Basic Auth Username
    * @var string
    */
    var $_user;
    
    /**
    * Basic Auth Password
    * @var string
    */
    var $_pass;

    /**
    * Socket object
    * @var object
    */
    var $_sock;
    
    /**
    * Proxy server
    * @var string
    */
    var $_proxy_host;
    
    /**
    * Proxy port
    * @var integer
    */
    var $_proxy_port;
    
    /**
    * Proxy username
    * @var string
    */
    var $_proxy_user;
    
    /**
    * Proxy password
    * @var string
    */
    var $_proxy_pass;

    /**
    * Post data
    * @var mixed
    */
    var $_postData;

   /**
    * Files to post 
    * @var array
    */
    var $_postFiles = array();

    /**
    * Connection timeout.
    * @var integer
    */
    var $_timeout;
    
    /**
    * HTTP_Response object
    * @var object
    */
    var $_response;
    
    /**
    * Whether to allow redirects
    * @var boolean
    */
    var $_allowRedirects;
    
    /**
    * Maximum redirects allowed
    * @var integer
    */
    var $_maxRedirects;
    
    /**
    * Current number of redirects
    * @var integer
    */
    var $_redirects;

   /**
    * Whether to append brackets [] to array variables
    * @var bool
    */
    var $_useBrackets = true;

   /**
    * Attached listeners
    * @var array
    */
    var $_listeners = array();

   /**
    * Whether to save response body in response object property  
    * @var bool
    */
    var $_saveBody = true;

   /**
    * Timeout for reading from socket (array(seconds, microseconds))
    * @var array
    */
    var $_readTimeout = null;

   /**
    * Options to pass to Net_Socket::connect. See stream_context_create
    * @var array
    */
    var $_socketOptions = null;

    /**
    * Constructor
    *
    * Sets up the object
    * @param $url The url to fetch/access
    * @param $params Associative array of parameters which can be:
    *                  method         - Method to use, GET, POST etc
    *                  http           - HTTP Version to use, 1.0 or 1.1
    *                  user           - Basic Auth username
    *                  pass           - Basic Auth password
    *                  proxy_host     - Proxy server host
    *                  proxy_port     - Proxy server port
    *                  proxy_user     - Proxy auth username
    *                  proxy_pass     - Proxy auth password
    *                  timeout        - Connection timeout in seconds.
    *                  allowRedirects - Whether to follow redirects or not
    *                  maxRedirects   - Max number of redirects to follow
    *                  useBrackets    - Whether to append [] to array variable names
    *                  saveBody       - Whether to save response body in response object property
    * @access public
    */
    function HTTP_Request($url = '', $params = array())
    {
        $this->_sock           = &new Net_Socket();
        $this->_method         =  HTTP_REQUEST_METHOD_GET;
        $this->_http           =  HTTP_REQUEST_HTTP_VER_1_1;
        $this->_requestHeaders = array();
        $this->_postData       = null;

        $this->_user = null;
        $this->_pass = null;

        $this->_proxy_host = null;
        $this->_proxy_port = null;
        $this->_proxy_user = null;
        $this->_proxy_pass = null;

        $this->_allowRedirects = false;
        $this->_maxRedirects   = 3;
        $this->_redirects      = 0;

        $this->_timeout  = null;
        $this->_response = null;

        foreach ($params as $key => $value) {
            $this->{'_' . $key} = $value;
        }

        if (!empty($url)) {
            $this->setURL($url);
        }

        // Default useragent
        $this->addHeader('User-Agent', 'PEAR HTTP_Request class ( http://pear.php.net/ )');

        // Make sure keepalives dont knobble us
        $this->addHeader('Connection', 'close');

        // Basic authentication
        if (!empty($this->_user)) {
            $this->_requestHeaders['Authorization'] = 'Basic ' . base64_encode($this->_user . ':' . $this->_pass);
        }

        // Use gzip encoding if possible
        // Avoid gzip encoding if using multibyte functions (see #1781)
        if (HTTP_REQUEST_HTTP_VER_1_1 == $this->_http && extension_loaded('zlib') &&
            0 == (2 & ini_get('mbstring.func_overload'))) {

            $this->addHeader('Accept-Encoding', 'gzip');
        }
    }
    
    /**
    * Generates a Host header for HTTP/1.1 requests
    *
    * @access private
    * @return string
    */
    function _generateHostHeader()
    {
        if ($this->_url->port != 80 AND strcasecmp($this->_url->protocol, 'http') == 0) {
            $host = $this->_url->host . ':' . $this->_url->port;

        } elseif ($this->_url->port != 443 AND strcasecmp($this->_url->protocol, 'https') == 0) {
            $host = $this->_url->host . ':' . $this->_url->port;

        } elseif ($this->_url->port == 443 AND strcasecmp($this->_url->protocol, 'https') == 0 AND strpos($this->_url->url, ':443') !== false) {
            $host = $this->_url->host . ':' . $this->_url->port;
        
        } else {
            $host = $this->_url->host;
        }

        return $host;
    }
    
    /**
    * Resets the object to its initial state (DEPRECATED).
    * Takes the same parameters as the constructor.
    *
    * @param  string $url    The url to be requested
    * @param  array  $params Associative array of parameters
    *                        (see constructor for details)
    * @access public
    * @deprecated deprecated since 1.2, call the constructor if this is necessary
    */
    function reset($url, $params = array())
    {
        $this->HTTP_Request($url, $params);
    }

    /**
    * Sets the URL to be requested
    *
    * @param  string The url to be requested
    * @access public
    */
    function setURL($url)
    {
        $this->_url = &new Net_URL($url, $this->_useBrackets);

        if (!empty($this->_url->user) || !empty($this->_url->pass)) {
            $this->setBasicAuth($this->_url->user, $this->_url->pass);
        }

        if (HTTP_REQUEST_HTTP_VER_1_1 == $this->_http) {
            $this->addHeader('Host', $this->_generateHostHeader());
        }
    }
    
    /**
    * Sets a proxy to be used
    *
    * @param string     Proxy host
    * @param int        Proxy port
    * @param string     Proxy username
    * @param string     Proxy password
    * @access public
    */
    function setProxy($host, $port = 8080, $user = null, $pass = null)
    {
        $this->_proxy_host = $host;
        $this->_proxy_port = $port;
        $this->_proxy_user = $user;
        $this->_proxy_pass = $pass;

        if (!empty($user)) {
            $this->addHeader('Proxy-Authorization', 'Basic ' . base64_encode($user . ':' . $pass));
        }
    }

    /**
    * Sets basic authentication parameters
    *
    * @param string     Username
    * @param string     Password
    */
    function setBasicAuth($user, $pass)
    {
        $this->_user = $user;
        $this->_pass = $pass;

        $this->addHeader('Authorization', 'Basic ' . base64_encode($user . ':' . $pass));
    }

    /**
    * Sets the method to be used, GET, POST etc.
    *
    * @param string     Method to use. Use the defined constants for this
    * @access public
    */
    function setMethod($method)
    {
        $this->_method = $method;
    }

    /**
    * Sets the HTTP version to use, 1.0 or 1.1
    *
    * @param string     Version to use. Use the defined constants for this
    * @access public
    */
    function setHttpVer($http)
    {
        $this->_http = $http;
    }

    /**
    * Adds a request header
    *
    * @param string     Header name
    * @param string     Header value
    * @access public
    */
    function addHeader($name, $value)
    {
        $this->_requestHeaders[$name] = $value;
    }

    /**
    * Removes a request header
    *
    * @param string     Header name to remove
    * @access public
    */
    function removeHeader($name)
    {
        if (isset($this->_requestHeaders[$name])) {
            unset($this->_requestHeaders[$name]);
        }
    }

    /**
    * Adds a querystring parameter
    *
    * @param string     Querystring parameter name
    * @param string     Querystring parameter value
    * @param bool       Whether the value is already urlencoded or not, default = not
    * @access public
    */
    function addQueryString($name, $value, $preencoded = false)
    {
        $this->_url->addQueryString($name, $value, $preencoded);
    }    
    
    /**
    * Sets the querystring to literally what you supply
    *
    * @param string     The querystring data. Should be of the format foo=bar&x=y etc
    * @param bool       Whether data is already urlencoded or not, default = already encoded
    * @access public
    */
    function addRawQueryString($querystring, $preencoded = true)
    {
        $this->_url->addRawQueryString($querystring, $preencoded);
    }

    /**
    * Adds postdata items
    *
    * @param string     Post data name
    * @param string     Post data value
    * @param bool       Whether data is already urlencoded or not, default = not
    * @access public
    */
    function addPostData($name, $value, $preencoded = false)
    {
        if ($preencoded) {
            $this->_postData[$name] = $value;
        } else {
            $this->_postData[$name] = $this->_arrayMapRecursive('urlencode', $value);
        }
    }

   /**
    * Recursively applies the callback function to the value
    * 
    * @param    mixed   Callback function
    * @param    mixed   Value to process
    * @access   private
    * @return   mixed   Processed value
    */
    function _arrayMapRecursive($callback, $value)
    {
        if (!is_array($value)) {
            return call_user_func($callback, $value);
        } else {
            $map = array();
            foreach ($value as $k => $v) {
                $map[$k] = $this->_arrayMapRecursive($callback, $v);
            }
            return $map;
        }
    }

   /**
    * Adds a file to upload
    * 
    * This also changes content-type to 'multipart/form-data' for proper upload
    * 
    * @access public
    * @param  string    name of file-upload field
    * @param  mixed     file name(s)
    * @param  mixed     content-type(s) of file(s) being uploaded
    * @return bool      true on success
    * @throws PEAR_Error
    */
    function addFile($inputName, $fileName, $contentType = 'application/octet-stream')
    {
        if (!is_array($fileName) && !is_readable($fileName)) {
            return PEAR::raiseError("File '{$fileName}' is not readable");
        } elseif (is_array($fileName)) {
            foreach ($fileName as $name) {
                if (!is_readable($name)) {
                    return PEAR::raiseError("File '{$name}' is not readable");
                }
            }
        }
        $this->addHeader('Content-Type', 'multipart/form-data');
        $this->_postFiles[$inputName] = array(
            'name' => $fileName,
            'type' => $contentType
        );
        return true;
    }

    /**
    * Adds raw postdata
    *
    * @param string     The data
    * @param bool       Whether data is preencoded or not, default = already encoded
    * @access public
    */
    function addRawPostData($postdata, $preencoded = true)
    {
        $this->_postData = $preencoded ? $postdata : urlencode($postdata);
    }

    /**
    * Clears any postdata that has been added (DEPRECATED). 
    * 
    * Useful for multiple request scenarios.
    *
    * @access public
    * @deprecated deprecated since 1.2
    */
    function clearPostData()
    {
        $this->_postData = null;
    }

    /**
    * Appends a cookie to "Cookie:" header
    * 
    * @param string $name cookie name
    * @param string $value cookie value
    * @access public
    */
    function addCookie($name, $value)
    {
        $cookies = isset($this->_requestHeaders['Cookie']) ? $this->_requestHeaders['Cookie']. '; ' : '';
        $this->addHeader('Cookie', $cookies . $name . '=' . $value);
    }
    
    /**
    * Clears any cookies that have been added (DEPRECATED). 
    * 
    * Useful for multiple request scenarios
    *
    * @access public
    * @deprecated deprecated since 1.2
    */
    function clearCookies()
    {
        $this->removeHeader('Cookie');
    }

    /**
    * Sends the request
    *
    * @access public
    * @param  bool   Whether to store response body in Response object property,
    *                set this to false if downloading a LARGE file and using a Listener
    * @return mixed  PEAR error on error, true otherwise
    */
    function sendRequest($saveBody = true)
    {
        if (!is_a($this->_url, 'Net_URL')) {
            return PEAR::raiseError('No URL given.');
        }

        $host = isset($this->_proxy_host) ? $this->_proxy_host : $this->_url->host;
        $port = isset($this->_proxy_port) ? $this->_proxy_port : $this->_url->port;

        // 4.3.0 supports SSL connections using OpenSSL. The function test determines
        // we running on at least 4.3.0
        if (strcasecmp($this->_url->protocol, 'https') == 0 AND function_exists('file_get_contents') AND extension_loaded('openssl')) {
            if (isset($this->_proxy_host)) {
                return PEAR::raiseError('HTTPS proxies are not supported.');
            }
            $host = 'ssl://' . $host;
        }

        // If this is a second request, we may get away without
        // re-connecting if they're on the same server
        if (PEAR::isError($err = $this->_sock->connect($host, $port, null, $this->_timeout, $this->_socketOptions)) ||
            PEAR::isError($err = $this->_sock->write($this->_buildRequest()))) {

            return $err;
        }
        if (!empty($this->_readTimeout)) {
            $this->_sock->setTimeout($this->_readTimeout[0], $this->_readTimeout[1]);
        }

        $this->_notify('sentRequest');

        // Read the response
        $this->_response = &new HTTP_Response($this->_sock, $this->_listeners);
        if (PEAR::isError($err = $this->_response->process($this->_saveBody && $saveBody)) ) {
            return $err;
        }

        // Check for redirection
        // Bugfix (PEAR) bug #18, 6 oct 2003 by Dave Mertens (headers are also stored lowercase, so we're gonna use them here)
        // some non RFC2616 compliant servers (scripts) are returning lowercase headers ('location: xxx')
        if (    $this->_allowRedirects
            AND $this->_redirects <= $this->_maxRedirects
            AND $this->getResponseCode() > 300
            AND $this->getResponseCode() < 399
            AND !empty($this->_response->_headers['location'])) {

            
            $redirect = $this->_response->_headers['location'];

            // Absolute URL
            if (preg_match('/^https?:\/\//i', $redirect)) {
                $this->_url = &new Net_URL($redirect);
                $this->addHeader('Host', $this->_generateHostHeader());
            // Absolute path
            } elseif ($redirect{0} == '/') {
                $this->_url->path = $redirect;
            
            // Relative path
            } elseif (substr($redirect, 0, 3) == '../' OR substr($redirect, 0, 2) == './') {
                if (substr($this->_url->path, -1) == '/') {
                    $redirect = $this->_url->path . $redirect;
                } else {
                    $redirect = dirname($this->_url->path) . '/' . $redirect;
                }
                $redirect = Net_URL::resolvePath($redirect);
                $this->_url->path = $redirect;
                
            // Filename, no path
            } else {
                if (substr($this->_url->path, -1) == '/') {
                    $redirect = $this->_url->path . $redirect;
                } else {
                    $redirect = dirname($this->_url->path) . '/' . $redirect;
                }
                $this->_url->path = $redirect;
            }

            $this->_redirects++;
            return $this->sendRequest($saveBody);

        // Too many redirects
        } elseif ($this->_allowRedirects AND $this->_redirects > $this->_maxRedirects) {
            return PEAR::raiseError('Too many redirects');
        }

        $this->_sock->disconnect();

        return true;
    }

    /**
    * Returns the response code
    *
    * @access public
    * @return mixed     Response code, false if not set
    */
    function getResponseCode()
    {
        return isset($this->_response->_code) ? $this->_response->_code : false;
    }

    /**
    * Returns either the named header or all if no name given
    *
    * @access public
    * @param string     The header name to return, do not set to get all headers
    * @return mixed     either the value of $headername (false if header is not present)
    *                   or an array of all headers
    */
    function getResponseHeader($headername = null)
    {
        if (!isset($headername)) {
            return isset($this->_response->_headers)? $this->_response->_headers: array();
        } else {
            return isset($this->_response->_headers[$headername]) ? $this->_response->_headers[$headername] : false;
        }
    }

    /**
    * Returns the body of the response
    *
    * @access public
    * @return mixed     response body, false if not set
    */
    function getResponseBody()
    {
        return isset($this->_response->_body) ? $this->_response->_body : false;
    }

    /**
    * Returns cookies set in response
    * 
    * @access public
    * @return mixed     array of response cookies, false if none are present
    */
    function getResponseCookies()
    {
        return isset($this->_response->_cookies) ? $this->_response->_cookies : false;
    }

    /**
    * Builds the request string
    *
    * @access private
    * @return string The request string
    */
    function _buildRequest()
    {
        $separator = ini_get('arg_separator.output');
        ini_set('arg_separator.output', '&');
        $querystring = ($querystring = $this->_url->getQueryString()) ? '?' . $querystring : '';
        ini_set('arg_separator.output', $separator);

        $host = isset($this->_proxy_host) ? $this->_url->protocol . '://' . $this->_url->host : '';
        $port = (isset($this->_proxy_host) AND $this->_url->port != 80) ? ':' . $this->_url->port : '';
        $path = (empty($this->_url->path)? '/': $this->_url->path) . $querystring;
        $url  = $host . $port . $path;

        $request = $this->_method . ' ' . $url . ' HTTP/' . $this->_http . "\r\n";

        if (HTTP_REQUEST_METHOD_POST != $this->_method && HTTP_REQUEST_METHOD_PUT != $this->_method) {
            $this->removeHeader('Content-Type');
        } else {
            if (empty($this->_requestHeaders['Content-Type'])) {
                // Add default content-type
                $this->addHeader('Content-Type', 'application/x-www-form-urlencoded');
            } elseif ('multipart/form-data' == $this->_requestHeaders['Content-Type']) {
                $boundary = 'HTTP_Request_' . md5(uniqid('request') . microtime());
                $this->addHeader('Content-Type', 'multipart/form-data; boundary=' . $boundary);
            }
        }

        // Request Headers
        if (!empty($this->_requestHeaders)) {
            foreach ($this->_requestHeaders as $name => $value) {
                $request .= $name . ': ' . $value . "\r\n";
            }
        }

        // No post data or wrong method, so simply add a final CRLF
        if ((HTTP_REQUEST_METHOD_POST != $this->_method && HTTP_REQUEST_METHOD_PUT != $this->_method) ||
            (empty($this->_postData) && empty($this->_postFiles))) {

            $request .= "\r\n";
        // Post data if it's an array
        } elseif ((!empty($this->_postData) && is_array($this->_postData)) || !empty($this->_postFiles)) {
            // "normal" POST request
            if (!isset($boundary)) {
                $postdata = implode('&', array_map(
                    create_function('$a', 'return $a[0] . \'=\' . $a[1];'), 
                    $this->_flattenArray('', $this->_postData)
                ));

            // multipart request, probably with file uploads
            } else {
                $postdata = '';
                if (!empty($this->_postData)) {
                    $flatData = $this->_flattenArray('', $this->_postData);
                    foreach ($flatData as $item) {
                        $postdata .= '--' . $boundary . "\r\n";
                        $postdata .= 'Content-Disposition: form-data; name="' . $item[0] . '"';
                        $postdata .= "\r\n\r\n" . urldecode($item[1]) . "\r\n";
                    }
                }
                foreach ($this->_postFiles as $name => $value) {
                    if (is_array($value['name'])) {
                        $varname       = $name . ($this->_useBrackets? '[]': '');
                    } else {
                        $varname       = $name;
                        $value['name'] = array($value['name']);
                    }
                    foreach ($value['name'] as $key => $filename) {
                        $fp   = fopen($filename, 'r');
                        $data = fread($fp, filesize($filename));
                        fclose($fp);
                        $basename = basename($filename);
                        $type     = is_array($value['type'])? @$value['type'][$key]: $value['type'];

                        $postdata .= '--' . $boundary . "\r\n";
                        $postdata .= 'Content-Disposition: form-data; name="' . $varname . '"; filename="' . $basename . '"';
                        $postdata .= "\r\nContent-Type: " . $type;
                        $postdata .= "\r\n\r\n" . $data . "\r\n";
                    }
                }
                $postdata .= '--' . $boundary . "\r\n";
            }
            $request .= 'Content-Length: ' . strlen($postdata) . "\r\n\r\n";
            $request .= $postdata;

        // Post data if it's raw
        } elseif(!empty($this->_postData)) {
            $request .= 'Content-Length: ' . strlen($this->_postData) . "\r\n\r\n";
            $request .= $this->_postData;
        }
        
        return $request;
    }

   /**
    * Helper function to change the (probably multidimensional) associative array
    * into the simple one.
    *
    * @param    string  name for item
    * @param    mixed   item's values
    * @return   array   array with the following items: array('item name', 'item value');
    */
    function _flattenArray($name, $values)
    {
        if (!is_array($values)) {
            return array(array($name, $values));
        } else {
            $ret = array();
            foreach ($values as $k => $v) {
                if (empty($name)) {
                    $newName = $k;
                } elseif ($this->_useBrackets) {
                    $newName = $name . '[' . $k . ']';
                } else {
                    $newName = $name;
                }
                $ret = array_merge($ret, $this->_flattenArray($newName, $v));
            }
            return $ret;
        }
    }


   /**
    * Adds a Listener to the list of listeners that are notified of
    * the object's events
    * 
    * @param    object   HTTP_Request_Listener instance to attach
    * @return   boolean  whether the listener was successfully attached
    * @access   public
    */
    function attach(&$listener)
    {
        if (!is_a($listener, 'HTTP_Request_Listener')) {
            return false;
        }
        $this->_listeners[$listener->getId()] =& $listener;
        return true;
    }


   /**
    * Removes a Listener from the list of listeners 
    * 
    * @param    object   HTTP_Request_Listener instance to detach
    * @return   boolean  whether the listener was successfully detached
    * @access   public
    */
    function detach(&$listener)
    {
        if (!is_a($listener, 'HTTP_Request_Listener') || 
            !isset($this->_listeners[$listener->getId()])) {
            return false;
        }
        unset($this->_listeners[$listener->getId()]);
        return true;
    }


   /**
    * Notifies all registered listeners of an event.
    * 
    * Events sent by HTTP_Request object
    * 'sentRequest': after the request was sent
    * Events sent by HTTP_Response object
    * 'gotHeaders': after receiving response headers (headers are passed in $data)
    * 'tick': on receiving a part of response body (the part is passed in $data)
    * 'gzTick': on receiving a gzip-encoded part of response body (ditto)
    * 'gotBody': after receiving the response body (passes the decoded body in $data if it was gzipped)
    * 
    * @param    string  Event name
    * @param    mixed   Additional data
    * @access   private
    */
    function _notify($event, $data = null)
    {
        foreach (array_keys($this->_listeners) as $id) {
            $this->_listeners[$id]->update($this, $event, $data);
        }
    }
}






















class Net_Socket extends PEAR {
    // {{{ properties

    /** Socket file pointer. */
    var $fp = null;

    /** Whether the socket is blocking. */
    var $blocking = true;

    /** Whether the socket is persistent. */
    var $persistent = false;

    /** The IP address to connect to. */
    var $addr = '';

    /** The port number to connect to. */
    var $port = 0;

    /** Number of seconds to wait on socket connections before
        assuming there's no more data. */
    var $timeout = false;

    /** Number of bytes to read at a time in readLine() and
        readAll(). */
    var $lineLength = 2048;
    // }}}

    // {{{ constructor
    /**
     * Constructs a new Net_Socket object.
     *
     * @access public
     */
    function Net_Socket()
    {
        $this->PEAR();
    }
    // }}}

    // {{{ connect()
    /**
     * Connect to the specified port. If called when the socket is
     * already connected, it disconnects and connects again.
     *
     * @param $addr string IP address or host name
     * @param $port int TCP port number
     * @param $persistent bool (optional) whether the connection is
     *        persistent (kept open between requests by the web server)
     * @param $timeout int (optional) how long to wait for data
     * @param $options array see options for stream_context_create
     * @access public
     * @return mixed true on success or error object
     */
    function connect($addr, $port, $persistent = null, $timeout = null, $options = null)
    {
        if (is_resource($this->fp)) {
            @fclose($this->fp);
            $this->fp = null;
        }

        if (strspn($addr, '.0123456789') == strlen($addr)) {
            $this->addr = $addr;
        } else {
            $this->addr = gethostbyname($addr);
        }
        $this->port = $port % 65536;
        if ($persistent !== null) {
            $this->persistent = $persistent;
        }
        if ($timeout !== null) {
            $this->timeout = $timeout;
        }
        $openfunc = $this->persistent ? 'pfsockopen' : 'fsockopen';
        $errno = 0;
        $errstr = '';
        if ($options && function_exists('stream_context_create')) {
            if ($this->timeout) {
                $timeout = $this->timeout;
            } else {
                $timeout = 0;
            }
            $context = stream_context_create($options);
            $fp = $openfunc($this->addr, $this->port, $errno, $errstr, $timeout, $context);
        } else {
            if ($this->timeout) {
                $fp = @$openfunc($this->addr, $this->port, $errno, $errstr, $this->timeout);
            } else {
                $fp = @$openfunc($this->addr, $this->port, $errno, $errstr);
            }
        }

        if (!$fp) {
            return $this->raiseError($errstr, $errno);
        }

        $this->fp = $fp;

        return $this->setBlocking($this->blocking);
    }
    // }}}

    // {{{ disconnect()
    /**
     * Disconnects from the peer, closes the socket.
     *
     * @access public
     * @return mixed true on success or an error object otherwise
     */
    function disconnect()
    {
        if (is_resource($this->fp)) {
            fclose($this->fp);
            $this->fp = null;
            return true;
        }
        return $this->raiseError("not connected");
    }
    // }}}

    // {{{ isBlocking()
    /**
     * Find out if the socket is in blocking mode.
     *
     * @access public
     * @return bool the current blocking mode.
     */
    function isBlocking()
    {
        return $this->blocking;
    }
    // }}}

    // {{{ setBlocking()
    /**
     * Sets whether the socket connection should be blocking or
     * not. A read call to a non-blocking socket will return immediately
     * if there is no data available, whereas it will block until there
     * is data for blocking sockets.
     *
     * @param $mode bool true for blocking sockets, false for nonblocking
     * @access public
     * @return mixed true on success or an error object otherwise
     */
    function setBlocking($mode)
    {
        if (is_resource($this->fp)) {
            $this->blocking = $mode;
            socket_set_blocking($this->fp, $this->blocking);
            return true;
        }
        return $this->raiseError("not connected");
    }
    // }}}

    // {{{ setTimeout()
    /**
     * Sets the timeout value on socket descriptor,
     * expressed in the sum of seconds and microseconds
     *
     * @param $seconds int seconds
     * @param $microseconds int microseconds
     * @access public
     * @return mixed true on success or an error object otherwise
     */
    function setTimeout($seconds, $microseconds)
    {
        if (is_resource($this->fp)) {
            socket_set_timeout($this->fp, $seconds, $microseconds);
            return true;
        }
        return $this->raiseError("not connected");
    }
    // }}}

    // {{{ getStatus()
    /**
     * Returns information about an existing socket resource.
     * Currently returns four entries in the result array:
     *
     * <p>
     * timed_out (bool) - The socket timed out waiting for data<br>
     * blocked (bool) - The socket was blocked<br>
     * eof (bool) - Indicates EOF event<br>
     * unread_bytes (int) - Number of bytes left in the socket buffer<br>
     * </p>
     *
     * @access public
     * @return mixed Array containing information about existing socket resource or an error object otherwise
     */
    function getStatus()
    {
        if (is_resource($this->fp)) {
            return socket_get_status($this->fp);
        }
        return $this->raiseError("not connected");
    }
    // }}}

    // {{{ gets()
    /**
     * Get a specified line of data
     *
     * @access public
     * @return $size bytes of data from the socket, or a PEAR_Error if
     *         not connected.
     */
    function gets($size)
    {
        if (is_resource($this->fp)) {
            return fgets($this->fp, $size);
        }
        return $this->raiseError("not connected");
    }
    // }}}

    // {{{ read()
    /**
     * Read a specified amount of data. This is guaranteed to return,
     * and has the added benefit of getting everything in one fread()
     * chunk; if you know the size of the data you're getting
     * beforehand, this is definitely the way to go.
     *
     * @param $size The number of bytes to read from the socket.
     * @access public
     * @return $size bytes of data from the socket, or a PEAR_Error if
     *         not connected.
     */
    function read($size)
    {
        if (is_resource($this->fp)) {
            return fread($this->fp, $size);
        }
        return $this->raiseError("not connected");
    }
    // }}}

    // {{{ write()
    /**
     * Write a specified amount of data.
     *
     * @access public
     * @return mixed true on success or an error object otherwise
     */
    function write($data)
    {
        if (is_resource($this->fp)) {
            return fwrite($this->fp, $data);
        }
        return $this->raiseError("not connected");
    }
    // }}}

    // {{{ writeLine()
    /**
     * Write a line of data to the socket, followed by a trailing "\r\n".
     *
     * @access public
     * @return mixed fputs result, or an error
     */
    function writeLine ($data)
    {
        if (is_resource($this->fp)) {
            return $this->write($data . "\r\n");
        }
        return $this->raiseError("not connected");
    }
    // }}}

    // {{{ eof()
    /**
     * Tests for end-of-file on a socket descriptor
     *
     * @access public
     * @return bool
     */
    function eof()
    {
        return (is_resource($this->fp) && feof($this->fp));
    }
    // }}}

    // {{{ readByte()
    /**
     * Reads a byte of data
     *
     * @access public
     * @return 1 byte of data from the socket, or a PEAR_Error if
     *         not connected.
     */
    function readByte()
    {
        if (is_resource($this->fp)) {
            return ord($this->read(1));
        }
        return $this->raiseError("not connected");
    }
    // }}}

    // {{{ readWord()
    /**
     * Reads a word of data
     *
     * @access public
     * @return 1 word of data from the socket, or a PEAR_Error if
     *         not connected.
     */
    function readWord()
    {
        if (is_resource($this->fp)) {
            $buf = $this->read(2);
            return (ord($buf[0]) + (ord($buf[1]) << 8));
        }
        return $this->raiseError("not connected");
    }
    // }}}

    // {{{ readInt()
    /**
     * Reads an int of data
     *
     * @access public
     * @return 1 int of data from the socket, or a PEAR_Error if
     *         not connected.
     */
    function readInt()
    {
        if (is_resource($this->fp)) {
            $buf = $this->read(4);
            return (ord($buf[0]) + (ord($buf[1]) << 8) +
                    (ord($buf[2]) << 16) + (ord($buf[3]) << 24));
        }
        return $this->raiseError("not connected");
    }
    // }}}

    // {{{ readString()
    /**
     * Reads a zeroterminated string of data
     *
     * @access public
     * @return string, or a PEAR_Error if
     *         not connected.
     */
    function readString()
    {
        if (is_resource($this->fp)) {
            $string = '';
            while (($char = $this->read(1)) != "\x00")  {
                $string .= $char;
            }
            return $string;
        }
        return $this->raiseError("not connected");
    }
    // }}}

    // {{{ readIPAddress()
    /**
     * Reads an IP Address and returns it in a dot formated string
     *
     * @access public
     * @return Dot formated string, or a PEAR_Error if
     *         not connected.
     */
    function readIPAddress()
    {
        if (is_resource($this->fp)) {
            $buf = $this->read(4);
            return sprintf("%s.%s.%s.%s", ord($buf[0]), ord($buf[1]),
                           ord($buf[2]), ord($buf[3]));
        }
        return $this->raiseError("not connected");
    }
    // }}}

    // {{{ readLine()
    /**
     * Read until either the end of the socket or a newline, whichever
     * comes first. Strips the trailing newline from the returned data.
     *
     * @access public
     * @return All available data up to a newline, without that
     *         newline, or until the end of the socket, or a PEAR_Error if
     *         not connected.
     */
    function readLine()
    {
        if (is_resource($this->fp)) {
            $line = '';
            $timeout = time() + $this->timeout;
            while (!$this->eof() && (!$this->timeout || time() < $timeout)) {
                $line .= $this->gets($this->lineLength);
                if (substr($line, -2) == "\r\n" ||
                    substr($line, -1) == "\n") {
                    return rtrim($line, "\r\n");
                }
            }
            return $line;
        }
        return $this->raiseError("not connected");
    }
    // }}}

    // {{{ readAll()
    /**
     * Read until the socket closes. THIS FUNCTION WILL NOT EXIT if the
     * socket is in blocking mode until the socket closes.
     *
     * @access public
     * @return All data until the socket closes, or a PEAR_Error if
     *         not connected.
     */
    function readAll()
    {
        if (is_resource($this->fp)) {
            $data = '';
            while (!$this->eof())
                $data .= $this->read($this->lineLength);
            return $data;
        }
        return $this->raiseError("not connected");
    }
    // }}}

}


















class Net_URL
{
    /**
    * Full url
    * @var string
    */
    var $url;

    /**
    * Protocol
    * @var string
    */
    var $protocol;

    /**
    * Username
    * @var string
    */
    var $username;

    /**
    * Password
    * @var string
    */
    var $password;

    /**
    * Host
    * @var string
    */
    var $host;

    /**
    * Port
    * @var integer
    */
    var $port;

    /**
    * Path
    * @var string
    */
    var $path;

    /**
    * Query string
    * @var array
    */
    var $querystring;

    /**
    * Anchor
    * @var string
    */
    var $anchor;

    /**
    * Whether to use []
    * @var bool
    */
    var $useBrackets;

    /**
    * PHP4 Constructor
    *
    * @see __construct()
    */
    function Net_URL($url = null, $useBrackets = true)
    {
        $this->__construct($url, $useBrackets);
    }

    /**
    * PHP5 Constructor
    *
    * Parses the given url and stores the various parts
    * Defaults are used in certain cases
    *
    * @param string $url         Optional URL
    * @param bool   $useBrackets Whether to use square brackets when
    *                            multiple querystrings with the same name
    *                            exist
    */
    function __construct($url = null, $useBrackets = true)
    {
        $HTTP_SERVER_VARS  = !empty($_SERVER) ? $_SERVER : $GLOBALS['HTTP_SERVER_VARS'];

        $this->useBrackets = $useBrackets;
        $this->url         = $url;
        $this->user        = '';
        $this->pass        = '';
        $this->host        = '';
        $this->port        = 80;
        $this->path        = '';
        $this->querystring = array();
        $this->anchor      = '';

        // Only use defaults if not an absolute URL given
        if (!preg_match('/^[a-z0-9]+:\/\//i', $url)) {

            $this->protocol    = (@$HTTP_SERVER_VARS['HTTPS'] == 'on' ? 'https' : 'http');

            /**
            * Figure out host/port
            */
            if (!empty($HTTP_SERVER_VARS['HTTP_HOST']) AND preg_match('/^(.*)(:([0-9]+))?$/U', $HTTP_SERVER_VARS['HTTP_HOST'], $matches)) {
                $host = $matches[1];
                if (!empty($matches[3])) {
                    $port = $matches[3];
                } else {
                    $port = $this->getStandardPort($this->protocol);
                }
            }

            $this->user        = '';
            $this->pass        = '';
            $this->host        = !empty($host) ? $host : (isset($HTTP_SERVER_VARS['SERVER_NAME']) ? $HTTP_SERVER_VARS['SERVER_NAME'] : 'localhost');
            $this->port        = !empty($port) ? $port : (isset($HTTP_SERVER_VARS['SERVER_PORT']) ? $HTTP_SERVER_VARS['SERVER_PORT'] : $this->getStandardPort($this->protocol));
            $this->path        = !empty($HTTP_SERVER_VARS['PHP_SELF']) ? $HTTP_SERVER_VARS['PHP_SELF'] : '/';
            $this->querystring = isset($HTTP_SERVER_VARS['QUERY_STRING']) ? $this->_parseRawQuerystring($HTTP_SERVER_VARS['QUERY_STRING']) : null;
            $this->anchor      = '';
        }

        // Parse the url and store the various parts
        if (!empty($url)) {
            $urlinfo = parse_url($url);

            // Default querystring
            $this->querystring = array();

            foreach ($urlinfo as $key => $value) {
                switch ($key) {
                    case 'scheme':
                        $this->protocol = $value;
                        $this->port     = $this->getStandardPort($value);
                        break;

                    case 'user':
                    case 'pass':
                    case 'host':
                    case 'port':
                        $this->$key = $value;
                        break;

                    case 'path':
                        if ($value{0} == '/') {
                            $this->path = $value;
                        } else {
                            $path = dirname($this->path) == DIRECTORY_SEPARATOR ? '' : dirname($this->path);
                            $this->path = sprintf('%s/%s', $path, $value);
                        }
                        break;

                    case 'query':
                        $this->querystring = $this->_parseRawQueryString($value);
                        break;

                    case 'fragment':
                        $this->anchor = $value;
                        break;
                }
            }
        }
    }

    /**
    * Returns full url
    *
    * @return string Full url
    * @access public
    */
    function getURL()
    {
        $querystring = $this->getQueryString();

        $this->url = $this->protocol . '://'
                   . $this->user . (!empty($this->pass) ? ':' : '')
                   . $this->pass . (!empty($this->user) ? '@' : '')
                   . $this->host . ($this->port == $this->getStandardPort($this->protocol) ? '' : ':' . $this->port)
                   . $this->path
                   . (!empty($querystring) ? '?' . $querystring : '')
                   . (!empty($this->anchor) ? '#' . $this->anchor : '');

        return $this->url;
    }

    /**
    * Adds a querystring item
    *
    * @param  string $name       Name of item
    * @param  string $value      Value of item
    * @param  bool   $preencoded Whether value is urlencoded or not, default = not
    * @access public
    */
    function addQueryString($name, $value, $preencoded = false)
    {
        if ($preencoded) {
            $this->querystring[$name] = $value;
        } else {
            $this->querystring[$name] = is_array($value) ? array_map('rawurlencode', $value): rawurlencode($value);
        }
    }

    /**
    * Removes a querystring item
    *
    * @param  string $name Name of item
    * @access public
    */
    function removeQueryString($name)
    {
        if (isset($this->querystring[$name])) {
            unset($this->querystring[$name]);
        }
    }

    /**
    * Sets the querystring to literally what you supply
    *
    * @param  string $querystring The querystring data. Should be of the format foo=bar&x=y etc
    * @access public
    */
    function addRawQueryString($querystring)
    {
        $this->querystring = $this->_parseRawQueryString($querystring);
    }

    /**
    * Returns flat querystring
    *
    * @return string Querystring
    * @access public
    */
    function getQueryString()
    {
        if (!empty($this->querystring)) {
            foreach ($this->querystring as $name => $value) {
                if (is_array($value)) {
                    foreach ($value as $k => $v) {
                        $querystring[] = $this->useBrackets ? sprintf('%s[%s]=%s', $name, $k, $v) : ($name . '=' . $v);
                    }
                } elseif (!is_null($value)) {
                    $querystring[] = $name . '=' . $value;
                } else {
                    $querystring[] = $name;
                }
            }
            $querystring = implode(ini_get('arg_separator.output'), $querystring);
        } else {
            $querystring = '';
        }

        return $querystring;
    }

    /**
    * Parses raw querystring and returns an array of it
    *
    * @param  string  $querystring The querystring to parse
    * @return array                An array of the querystring data
    * @access private
    */
    function _parseRawQuerystring($querystring)
    {
        $parts  = preg_split('/[' . preg_quote(ini_get('arg_separator.input'), '/') . ']/', $querystring, -1, PREG_SPLIT_NO_EMPTY);
        $return = array();

        foreach ($parts as $part) {
            if (strpos($part, '=') !== false) {
                $value = substr($part, strpos($part, '=') + 1);
                $key   = substr($part, 0, strpos($part, '='));
            } else {
                $value = null;
                $key   = $part;
            }
            if (substr($key, -2) == '[]') {
                $key = substr($key, 0, -2);
                if (@!is_array($return[$key])) {
                    $return[$key]   = array();
                    $return[$key][] = $value;
                } else {
                    $return[$key][] = $value;
                }
            } elseif (!$this->useBrackets AND !empty($return[$key])) {
                $return[$key]   = (array)$return[$key];
                $return[$key][] = $value;
            } else {
                $return[$key] = $value;
            }
        }

        return $return;
    }

    /**
    * Resolves //, ../ and ./ from a path and returns
    * the result. Eg:
    *
    * /foo/bar/../boo.php    => /foo/boo.php
    * /foo/bar/../../boo.php => /boo.php
    * /foo/bar/.././/boo.php => /foo/boo.php
    *
    * This method can also be called statically.
    *
    * @param  string $url URL path to resolve
    * @return string      The result
    */
    function resolvePath($path)
    {
        $path = explode('/', str_replace('//', '/', $path));

        for ($i=0; $i<count($path); $i++) {
            if ($path[$i] == '.') {
                unset($path[$i]);
                $path = array_values($path);
                $i--;

            } elseif ($path[$i] == '..' AND ($i > 1 OR ($i == 1 AND $path[0] != '') ) ) {
                unset($path[$i]);
                unset($path[$i-1]);
                $path = array_values($path);
                $i -= 2;

            } elseif ($path[$i] == '..' AND $i == 1 AND $path[0] == '') {
                unset($path[$i]);
                $path = array_values($path);
                $i--;

            } else {
                continue;
            }
        }

        return implode('/', $path);
    }

    /**
    * Returns the standard port number for a protocol
    *
    * @param  string  $scheme The protocol to lookup
    * @return integer         Port number or NULL if no scheme matches
    *
    * @author Philippe Jausions <Philippe.Jausions@11abacus.com>
    */
    function getStandardPort($scheme)
    {
        switch (strtolower($scheme)) {
            case 'http':    return 80;
            case 'https':   return 443;
            case 'ftp':     return 21;
            case 'imap':    return 143;
            case 'imaps':   return 993;
            case 'pop3':    return 110;
            case 'pop3s':   return 995;
            default:        return null;
       }
    }

    /**
    * Forces the URL to a particular protocol
    *
    * @param string  $protocol Protocol to force the URL to
    * @param integer $port     Optional port (standard port is used by default)
    */
    function setProtocol($protocol, $port = null)
    {
        $this->protocol = $protocol;
        $this->port = is_null($port) ? $this->getStandardPort() : $port;
    }

}






















class HTTP_Response
{
    /**
    * Socket object
    * @var object
    */
    var $_sock;

    /**
    * Protocol
    * @var string
    */
    var $_protocol;
    
    /**
    * Return code
    * @var string
    */
    var $_code;
    
    /**
    * Response headers
    * @var array
    */
    var $_headers;

    /**
    * Cookies set in response  
    * @var array
    */
    var $_cookies;

    /**
    * Response body
    * @var string
    */
    var $_body = '';

   /**
    * Used by _readChunked(): remaining length of the current chunk
    * @var string
    */
    var $_chunkLength = 0;

   /**
    * Attached listeners
    * @var array
    */
    var $_listeners = array();

    /**
    * Constructor
    *
    * @param  object Net_Socket     socket to read the response from
    * @param  array                 listeners attached to request
    * @return mixed PEAR Error on error, true otherwise
    */
    function HTTP_Response(&$sock, &$listeners)
    {
        $this->_sock      =& $sock;
        $this->_listeners =& $listeners;
    }


   /**
    * Processes a HTTP response
    * 
    * This extracts response code, headers, cookies and decodes body if it 
    * was encoded in some way
    *
    * @access public
    * @param  bool      Whether to store response body in object property, set
    *                   this to false if downloading a LARGE file and using a Listener.
    *                   This is assumed to be true if body is gzip-encoded.
    * @throws PEAR_Error
    * @return mixed     true on success, PEAR_Error in case of malformed response
    */
    function process($saveBody = true)
    {
        do {
            $line = $this->_sock->readLine();
            if (sscanf($line, 'HTTP/%s %s', $http_version, $returncode) != 2) {
                return PEAR::raiseError('Malformed response.');
            } else {
                $this->_protocol = 'HTTP/' . $http_version;
                $this->_code     = intval($returncode);
            }
            while ('' !== ($header = $this->_sock->readLine())) {
                $this->_processHeader($header);
            }
        } while (100 == $this->_code);

        $this->_notify('gotHeaders', $this->_headers);

        // If response body is present, read it and decode
        $chunked = isset($this->_headers['transfer-encoding']) && ('chunked' == $this->_headers['transfer-encoding']);
        $gzipped = isset($this->_headers['content-encoding']) && ('gzip' == $this->_headers['content-encoding']);
        $hasBody = false;
        while (!$this->_sock->eof()) {
            if ($chunked) {
                $data = $this->_readChunked();
            } else {
                $data = $this->_sock->read(4096);
            }
            if ('' != $data) {
                $hasBody = true;
                if ($saveBody || $gzipped) {
                    $this->_body .= $data;
                }
                $this->_notify($gzipped? 'gzTick': 'tick', $data);
            }
        }
        if ($hasBody) {
            // Uncompress the body if needed
            if ($gzipped) {
                $this->_body = gzinflate(substr($this->_body, 10));
                $this->_notify('gotBody', $this->_body);
            } else {
                $this->_notify('gotBody');
            }
        }
        return true;
    }


   /**
    * Processes the response header
    *
    * @access private
    * @param  string    HTTP header
    */
    function _processHeader($header)
    {
        list($headername, $headervalue) = explode(':', $header, 2);
        $headername_i = strtolower($headername);
        $headervalue  = ltrim($headervalue);
        
        if ('set-cookie' != $headername_i) {
            $this->_headers[$headername]   = $headervalue;
            $this->_headers[$headername_i] = $headervalue;
        } else {
            $this->_parseCookie($headervalue);
        }
    }


   /**
    * Parse a Set-Cookie header to fill $_cookies array
    *
    * @access private
    * @param  string    value of Set-Cookie header
    */
    function _parseCookie($headervalue)
    {
        $cookie = array(
            'expires' => null,
            'domain'  => null,
            'path'    => null,
            'secure'  => false
        );

        // Only a name=value pair
        if (!strpos($headervalue, ';')) {
            $pos = strpos($headervalue, '=');
            $cookie['name']  = trim(substr($headervalue, 0, $pos));
            $cookie['value'] = trim(substr($headervalue, $pos + 1));

        // Some optional parameters are supplied
        } else {
            $elements = explode(';', $headervalue);
            $pos = strpos($elements[0], '=');
            $cookie['name']  = trim(substr($elements[0], 0, $pos));
            $cookie['value'] = trim(substr($elements[0], $pos + 1));

            for ($i = 1; $i < count($elements); $i++) {
                list ($elName, $elValue) = array_map('trim', explode('=', $elements[$i]));
                $elName = strtolower($elName);
                if ('secure' == $elName) {
                    $cookie['secure'] = true;
                } elseif ('expires' == $elName) {
                    $cookie['expires'] = str_replace('"', '', $elValue);
                } elseif ('path' == $elName || 'domain' == $elName) {
                    $cookie[$elName] = urldecode($elValue);
                } else {
                    $cookie[$elName] = $elValue;
                }
            }
        }
        $this->_cookies[] = $cookie;
    }


   /**
    * Read a part of response body encoded with chunked Transfer-Encoding
    * 
    * @access private
    * @return string
    */
    function _readChunked()
    {
        // at start of the next chunk?
        if (0 == $this->_chunkLength) {
            $line = $this->_sock->readLine();
            if (preg_match('/^([0-9a-f]+)/i', $line, $matches)) {
                $this->_chunkLength = hexdec($matches[1]); 
                // Chunk with zero length indicates the end
                if (0 == $this->_chunkLength) {
                    $this->_sock->readAll(); // make this an eof()
                    return '';
                }
            }
        }
        $data = $this->_sock->read($this->_chunkLength);
        $this->_chunkLength -= strlen($data);
        if (0 == $this->_chunkLength) {
            $this->_sock->readLine(); // Trailing CRLF
        }
        return $data;
    }


   /**
    * Notifies all registered listeners of an event.
    * 
    * @param    string  Event name
    * @param    mixed   Additional data
    * @access   private
    * @see HTTP_Request::_notify()
    */
    function _notify($event, $data = null)
    {
        foreach (array_keys($this->_listeners) as $id) {
            $this->_listeners[$id]->update($this, $event, $data);
        }
    }
} // End class HTTP_Response

























class XML_Tree extends XML_Parser
{
    /**
    * File Handle
    *
    * @var  ressource
    */
    var $file = NULL;

    /**
    * Filename
    *
    * @var  string
    */
    var $filename = '';

    /**
    * Namespace
    *
    * @var  array
    */
    var $namespace = array();

    /**
    * Root
    *
    * @var  object XML_Tree_Node
    */
    var $root = NULL;

    /**
    * XML Version
    *
    * @var  string
    */
    var $version = '1.0';

    /**
    * Constructor
    *
    * @param  string  Filename
    * @param  string  XML Version
    */
    function XML_Tree($filename = '', $version = '1.0') {
        $this->filename = $filename;
        $this->version  = $version;
    }

    /**
    * Add root node.
    *
    * @param  string  $name     name of root element
    * @return object XML_Tree_Node   reference to root node
    *
    * @access public
    */
    function &addRoot($name, $content = '', $attributes = array()) {
        $this->root = new XML_Tree_Node($name, $content, $attributes);
        return $this->root;
    }

    /**
    * @deprecated
    */
    function &add_root($name, $content = '', $attributes = array()) {
        return $this->addRoot($name, $content, $attributes);
    }

    /**
    * inserts a child/tree (child) into tree ($path,$pos) and
    * maintains namespace integrity
    *
    * @param array      $path           path to parent of child to remove
    * @param integer    $pos            position of child to be inserted in its parents children-list
    * @param mixed      $child          child-node (by XML_Tree,XML_Node or Name)
    * @param string     $content        content (text) for new node
    * @param array      $attributes     attribute-hash for new node
    *
    * @return object XML_Tree_Node inserted child (node)
    * @access public
    */
    function &insertChild($path,$pos,$child, $content = '', $attributes = array()) {
        // update namespace to maintain namespace integrity
        $count=count($path);
        foreach($this->namespace as $key => $val) {
            if ((array_slice($val,0,$count)==$path) && ($val[$count]>=$pos))
                $this->namespace[$key][$count]++;
        }

        $parent=&$this->get_node_by_path($path);
        return($parent->insert_child($pos,$child,$content,$attributes));
    }

    /**
    * @deprecated
    */
    function &insert_child($path,$pos,$child, $content = '', $attributes = array()) {
        return $this->insertChild($path, $child, $content, $attributes);
    }

    /*
    * removes a child ($path,$pos) from tree ($path,$pos) and
    * maintains namespace integrity
    *
    * @param array      $path   path to parent of child to remove
    * @param integer    $pos    position of child in parents children-list
    *
    * @return object XML_Tree_Node parent whichs child was removed
    * @access public
    */
    function &removeChild($path,$pos) {
        // update namespace to maintain namespace integrity
        $count=count($path);
        foreach($this->namespace as $key => $val) {
            if (array_slice($val,0,$count)==$path) {
                if ($val[$count]==$pos) { unset($this->namespace[$key]); break; }
                if ($val[$count]>$pos)
                    $this->namespace[$key][$count]--;
            }
        }

        $parent=&$this->get_node_by_path($path);
        return($parent->remove_child($pos));
    }

    /**
    * @deprecated
    */
    function &remove_child($path, $pos) {
        return $this->removeChild($path, $pos);
    }

    /*
    * Maps a xml file to a objects tree
    *
    * @return mixed The objects tree (XML_tree or an Pear error)
    * @access public
    */
    function &getTreeFromFile ()
    {
        $this->folding = false;
        $this->XML_Parser(null, 'event');
        $err = $this->setInputFile($this->filename);
        if (PEAR::isError($err)) {
            return $err;
        }
        $this->cdata = null;
        $err = $this->parse();
        if (PEAR::isError($err)) {
            return $err;
        }
        return $this->root;
    }

    function getTreeFromString($str)
    {
        $this->folding = false;
        $this->XML_Parser(null, 'event');
        $this->cdata = null;
        $err = $this->parseString($str);
        if (PEAR::isError($err)) {
            return $err;
        }
        return $this->root;
    }

    /**
    * Handler for the xml-data
    *
    * @param mixed  $xp         ignored
    * @param string $elem       name of the element
    * @param array  $attribs    attributes for the generated node
    *
    * @access private
    */
    function startHandler($xp, $elem, &$attribs)
    {
        // root elem
        if (!isset($this->i)) {
            $this->obj1 =& $this->add_root($elem, null, $attribs);
            $this->i = 2;
        } else {
            // mixed contents
            if (!empty($this->cdata)) {
                $parent_id = 'obj' . ($this->i - 1);
                $parent    =& $this->$parent_id;
                $parent->children[] = &new XML_Tree_Node(null, $this->cdata);
            }
            $obj_id = 'obj' . $this->i++;
            $this->$obj_id = &new XML_Tree_Node($elem, null, $attribs);
        }
        $this->cdata = null;
        return null;
    }

    /**
    * Handler for the xml-data
    *
    * @param mixed  $xp         ignored
    * @param string $elem       name of the element
    *
    * @access private
    */
    function endHandler($xp, $elem)
    {
        $this->i--;
        if ($this->i > 1) {
            $obj_id = 'obj' . $this->i;
            // recover the node created in StartHandler
            $node   =& $this->$obj_id;
            // mixed contents
            if (count($node->children) > 0) {
                if (trim($this->cdata)) {
                    $node->children[] = &new XML_Tree_Node(null, $this->cdata);
                }
            } else {
                $node->set_content($this->cdata);
            }
            $parent_id = 'obj' . ($this->i - 1);
            $parent    =& $this->$parent_id;
            // attach the node to its parent node children array
            $parent->children[] = $node;
        }
        $this->cdata = null;
        return null;
    }

    /*
    * The xml character data handler
    *
    * @param mixed  $xp         ignored
    * @param string $data       PCDATA between tags
    *
    * @access private
    */
    function cdataHandler($xp, $data)
    {
        if (trim($data)) {
            $this->cdata .= $data;
        }
    }

    /**
    * Get a copy of this tree.
    *
    * @return object XML_Tree
    * @access public
    */
/* PREM
    function clone() {
        $clone=new XML_Tree($this->filename,$this->version);
        $clone->root=$this->root->clone();

        // clone all other vars
        $temp=get_object_vars($this);
        foreach($temp as $varname => $value)
            if (!in_array($varname,array('filename','version','root')))
                $clone->$varname=$value;

        return($clone);
    }
*/
    /**
    * Print text representation of XML tree.
    *
    * @access public
    */
    function dump() {
        echo $this->get();
    }

    /**
    * Get text representation of XML tree.
    *
    * @return  string  XML
    * @access public
    */
    function &get() {
        $out = '<?xml version="' . $this->version . "\"?>\n";
        $out .= $this->root->get();

        return $out;
    }

    /**
    * Get current namespace.
    *
    * @param  string  $name namespace
    * @return string
    *
    * @access public
    */
    function &getName($name) {
        return $this->root->get_element($this->namespace[$name]);
    }

    /**
    * @deprecated
    */
    function &get_name($name) {
        return $this->getName($name);
    }

    /**
    * Register a namespace.
    *
    * @param  string  $name namespace
    * @param  string  $path path
    *
    * @access public
    */
    function registerName($name, $path) {
        $this->namespace[$name] = $path;
    }

    /**
    * @deprecated
    */
    function register_name($name, $path) {
        return $this->registerName($name, $path);
    }
}






























class XML_Tree_Node {
    /**
    * Attributes of this node
    *
    * @var  array
    */
    var $attributes;

    /**
    * Children of this node
    *
    * @var  array
    */
    var $children;

    /**
    * Content
    *
    * @var  string
    */
    var $content;

    /**
    * Name
    *
    * @var  string
    */
    var $name;

    /**
    * Constructor
    *
    * @param  string  name
    * @param  string  content
    * @param  array   attributes
    */
    function XML_Tree_Node($name, $content = '', $attributes = array()) {
        $this->attributes = $attributes;
        $this->children   = array();
        $this->set_content($content);
        $this->name       = $name;
    }

    /**
    * Adds a child node to this node.
    *
    * @param  mixed   child
    * @param  string  content
    * @param  array   attributes
    * @return object  reference to new child node
    */
    function &addChild($child, $content = '', $attributes = array()) {
        $index = sizeof($this->children);

        if (is_object($child)) {
            if (strtolower(get_class($child)) == 'xml_tree_node') {
                $this->children[$index] = $child;
            }

            if (strtolower(get_class($child)) == 'xml_tree' && isset($child->root)) {
                $this->children[$index] = $child->root->get_element();
            }
        } else {
            $this->children[$index] = new XML_Tree_Node($child, $content, $attributes);
        }

        return $this->children[$index];
    }

    /**
    * @deprecated
    */
    function &add_child($child, $content = '', $attributes = array()) {
        return $this->addChild($child, $content, $attributes);
    }

    /**
    * clone node and all its children (recursive)
    *
    * @return object reference to the clone-node
    */
/* PREM
    function &clone() {
        $clone=new XML_Tree_Node($this->name,$this->content,$this->attributes);

        $max_child=count($this->children);
        for($i=0;$i<$max_child;$i++) {
            $clone->children[]=$this->children[$i]->clone();
        }

        return($clone);
    }
*/

    /**
    * inserts child ($child) to a specified child-position ($pos)
    *
    * @return  inserted node
    */
    function &insertChild($path,$pos,&$child, $content = '', $attributes = array()) {
        // direct insert of objects useing array_splice() faild :(
        array_splice($this->children,$pos,0,'dummy');
        if (is_object($child)) { // child offered is not instanziated
            // insert a single node
            if (strtolower(get_class($child)) == 'xml_tree_node') {
                $this->children[$pos]=&$child;
            }
            // insert a tree i.e insert root-element
            if (strtolower(get_class($child)) == 'xml_tree' && isset($child->root)) {
                $this->children[$pos]=$child->root->get_element();
            }
        } else { // child offered is not instanziated
            $this->children[$pos]=new XML_Tree_Node($child, $content, $attributes);
        }
        return($this);
    }

    /**
    * @deprecated
    */
    function &insert_child($path,$pos,&$child, $content = '', $attributes = array()) {
        return $this->insertChild($path,$pos,$child, $content, $attributes);
    }

    /**
    * removes child ($pos)
    *
    * @param integer pos position of child in children-list
    *
    * @return  removed node
    */
    function &removeChild($pos) {
        // array_splice() instead of a simple unset() to maintain index-integrity
        return(array_splice($this->children,$pos,1));
    }

    /**
    * @deprecated
    */
    function &remove_child($pos) {
        return $this->removeChild($pos);
    }

    /**
    * Returns text representation of this node.
    *
    * @return  string  xml
    */
    function &get()
    {
        static $deep = -1;
        static $do_ident = true;
        $deep++;
        if ($this->name !== null) {
            $ident = str_repeat('  ', $deep);
            if ($do_ident) {
                $out = $ident . '<' . $this->name;
            } else {
                $out = '<' . $this->name;
            }
            foreach ($this->attributes as $name => $value) {
                $out .= ' ' . $name . '="' . $value . '"';
            }

            $out .= '>' . $this->content;

            if (sizeof($this->children) > 0) {
                $out .= "\n";
                foreach ($this->children as $child) {
                    $out .= $child->get();
                }
            } else {
                $ident = '';
            }
            if ($do_ident) {
                $out .= $ident . '</' . $this->name . ">\n";
            } else {
                $out .= '</' . $this->name . '>';
            }
            $do_ident = true;
        } else {
            $out = $this->content;
            $do_ident = false;
        }
        $deep--;
        return $out;
    }

    /**
    * Gets an attribute by its name.
    *
    * @param  string  name
    * @return string  attribute
    */
    function getAttribute($name) {
        return $this->attributes[strtolower($name)];
    }

    /**
    * @deprecated
    */
    function get_attribute($name) {
        return $this->getAttribute($name);
    }

    /**
    * Gets an element by its 'path'.
    *
    * @param  string  path
    * @return object  element
    */
    function &getElement($path) {
        if (sizeof($path) == 0) {
            return $this;
        }

        $next = array_shift($path);

        return $this->children[$next]->get_element($path);
    }

    /**
    * @deprecated
    */
    function &get_element($path) {
        return $this->getElement($path);
    }

    /**
    * Sets an attribute.
    *
    * @param  string  name
    * @param  string  value
    */
    function setAttribute($name, $value = '') {
        $this->attributes[strtolower($name)] = $value;
    }

    /**
    * @deprecated
    */
    function set_attribute($name, $value = '') {
        return $this->setAttribute($name, $value);
    }

    /**
    * Unsets an attribute.
    *
    * @param  string  name
    */
    function unsetAttribute($name) {
        unset($this->attributes[strtolower($name)]);
    }

    /**
    * @deprecated
    */
    function unset_attribute($name) {
        return $this->unsetAttribute($name);
    }

    /**
    *
    *
    */
    function setContent(&$content)
    {
	# WHAT THE FUCK IS WRONG WITH PEOPLE?
        #$this->content = $this->_xml_entities($content);
        $this->content = $content;
    }

    function set_content(&$content)
    {
        return $this->setContent($content);
    }

    /**
    * Escape XML entities.
    *
    * @param   string  xml
    * @return  string  xml
    * @access  private
    */
    function _xml_entities($xml) {
        $xml = str_replace(array('ü', 'Ü', 'ö',
                                 'Ö', 'ä', 'Ä',
                                 'ß'
                                ),
                           array('&#252;', '&#220;', '&#246;',
                                 '&#214;', '&#228;', '&#196;',
                                 '&#223;'
                                ),
                           $xml
                          );

        $xml = preg_replace(array("/\&([a-z\d\#]+)\;/i",
                                  "/\&/",
                                  "/\#\|\|([a-z\d\#]+)\|\|\#/i",
                                  "/([^a-zA-Z\d\s\<\>\&\;\.\:\=\"\-\/\%\?\!\'\(\)\[\]\{\}\$\#\+\,\@_])/e"
                                 ),
                            array("#||\\1||#",
                                  "&amp;",
                                  "&\\1;",
                                  "'&#'.ord('\\1').';'"
                                 ),
                            $xml
                           );

        return $xml;
    }

    /**
    * Print text representation of XML tree.
    */
    function dump() {
        echo $this->get();
    }
}
