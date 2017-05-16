<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

require(BASEPATH . 'libraries/Smarty/libs/Smarty.class.php');

/**
 * Smarty Class
 * @package     CodeIgniter
 * @subpackage  Smarty
 */
class CI_Smarty extends Smarty {

    private $_ci;

    public function __construct()
    {
        parent::__construct();

        $this->_ci =& get_instance();
        $this->_ci->load->config('smarty');

        $this->template_dir    = $this->_ci->config->item('template_dir');
        $this->compile_dir     = $this->_ci->config->item('compile_dir');
        $this->left_delimiter  = $this->_ci->config->item('left_delimiter');
        $this->right_delimiter = $this->_ci->config->item('right_delimiter');

        $this->assign('APPPATH', APPPATH);
        $this->assign('BASEPATH', BASEPATH);

        // Assign CodeIgniter object by reference to CI
        if ( method_exists( $this, 'assignByRef') )
        {
            $this->assignByRef("ci", $this->_ci);
        }

        log_message('debug', "Smarty Class Initialized");
    }

    /**
     * Parse a template using the Smarty engine
     * This is a convenience method that combines assign() and
     * display() into one step.
     *
     * Values to assign are passed in an associative array of
     * name => value pairs.
     * If the output is to be returned as a string to the caller
     * instead of being output, pass true as the third parameter.
     *
     * @param  string $template
     * @param  array  $data
     * @param  bool   $return
     * @return string
     */
    public function view($template, $data = array(), $return = FALSE)
    {
        foreach ($data as $key => $val)
        {
            $this->assign($key, $val);
        }

        if ($return == FALSE)
        {
            $this->_ci->output->final_output = $this->fetch($template);
            return;
        }
        else {
            return $this->fetch($template);
        }
    }
}

// END Smarty Class
