#CodeIgniter Gearman Library

This is a library to use gearman within codeigniter.  The original source was pulled from Aniruddha Kale here 
http://codeigniter.com/wiki/Gearman/

0. Make sure you have the proper gearman daemon environment set up, libgearman and gearman pecl drivers. (http://pecl.php.net/package/gearman)
1. Add the file application/libraries/Gearman.php to your /application/libraries folder. 
2. Add the file application/config/gearman.php to your application/config/gearman.php folder
3. Update the config file. 

I created this repository to track the changes I make to the gearman library here. 

Feel free to pull this rep and make your own changes. 

## Client Example 
    $this->load->library('gearman_library');
    $this->gearman_library->gearman_client();
    $this->gearman_library->do_job_background('identifier',serialize($params)); 

## Worker Example 
    $this->load->library('gearman_library');
    $this->gearman_library->gearman_worker();

    function worker_fn() {
        //worker code ...
    }

    $this->gearman->add_worker_function('org_worker_fn', 'worker_fn'); 
    while($this->gearman->work()); 


Thanks,
Sunil
sunil@fancite.com
