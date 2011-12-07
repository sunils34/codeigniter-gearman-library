<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed gearman');
/**
 * Class to utilize Gearman http://gearman.org/
 * @author Aniruddha Kale
 */
class Gearman
{

    private $gearman_host = array();
    private $gearman_port = array();
    private $CI;
    protected $errors = array();
    private $client;
    private $worker;

    /**
     * Constructor
     * @access public
     * @return void
     */
    public function __construct()
    {
        $this->CI =& get_instance();
    }
    /**
     * Function to create a gearman client
     * @access public
     * @return void
     */
    public function gearman_client()
    {
        $this->client = new GearmanClient();
        $this->_auto_connect($this->client);
    }
    /**
     * Function to create a gearman worker
     * @access public
     * @return void
     */
    public function gearman_worker()
    {
        $this->worker = new GearmanWorker();
        $this->_auto_connect($this->worker);    
    }
    /**
     * Function to assign a function name against an identifier
     * @access public
     * @param string
     * @param string
     * @return void
     */
    public function add_worker_function($identifier,$function_name)
    {
        $this->worker->addFunction($identifier, $function_name);
        log_message('debug', "Gearman Library: Successfully added worker function with identifier $identifier with function $function_name");

    }
    /**
     * Listen for a job
     * @access public
     * @return void
     */
    public function work()
    {
        $this->worker->work();
    }
    /**
     * Perform a job in background for a client
     * @access public
     * @param string
     * @param string
     * @return void
     */
    public function do_job_background($function,$param)
    {
        $this->client->doBackground($function,$param);
        log_message('debug', "Gearman Library: Performed task with function $function with parameter $param");
    }

    /**
     * Runs through all of the servers defined in the configuration and attempts to connect to each
     * @param object
     * @return void
     */
    private function _auto_connect($object)
    {
        $this->CI->load->config('gearman');
        $this->gearman_host = $this->CI->config->item('gearman_server');
        $this->gearman_port = $this->CI->config->item('gearman_port');
        foreach($this->gearman_host as $key=>$server)
        {
            if(!$object->addServer($server,$this->gearman_port[$key]))
            {
                $this->errors[] = "Gearman Library: Could not connect to the server named $key";
                log_message('error', 'Gearman Library: Could not connect to the server named "'.$key.'"');
            }
            else
            {
                log_message('debug', 'Gearman Library: Successfully connected to the server named "'.$key.'"');
            }
        }
    }
    /**
     *  Returns worker error
     *  @access public
     *  @return void
     *         
     */
    function error()
    {
        return $this->worker->error();
    }

}
?> 
