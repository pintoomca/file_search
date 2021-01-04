<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User class.
 * 
 * @extends CI_Controller
 */
class User extends CI_Controller {

	/**
	 * __construct function.
	 * 
	 * @access public
	 * @return void
	 */
	public function __construct() {

		parent::__construct();
		$this->load->library('session');
		$this->load->helper('url');
		$this->load->helper('Pdftotext');
		$this->load->model('user_model');
		
	}
	
	
	public function index() {
		

		
	}
	
	/**
	 * register function.
	 * 
	 * @access public
	 * @return void
	 */
	public function register() {
		
		// create the data object
		$data = new stdClass();
		
		// load form helper and validation library
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		// set validation rules
		$this->form_validation->set_rules('username', 'Username', 'trim|required|alpha_numeric|min_length[4]|is_unique[users.username]', array('is_unique' => 'This username already exists. Please choose another one.'));
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[users.email]');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]');
		$this->form_validation->set_rules('password_confirm', 'Confirm Password', 'trim|required|min_length[6]|matches[password]');
		
		if ($this->form_validation->run() === false) {
			
			// validation not ok, send validation errors to the view
			$this->load->view('header');
			$this->load->view('user/register/register', $data);
			$this->load->view('footer');
			
		} else {
			
			// set variables from the form
			$username = $this->input->post('username');
			$email    = $this->input->post('email');
			$password = $this->input->post('password');
			
			if ($this->user_model->create_user($username, $email, $password)) {
				
				// user creation ok
				$this->load->view('header');
				$this->load->view('user/register/register_success', $data);
				$this->load->view('footer');
				
			} else {
				
				// user creation failed, this should never happen
				$data->error = 'There was a problem creating your new account. Please try again.';
				
				// send error to the view
				$this->load->view('header');
				$this->load->view('user/register/register', $data);
				$this->load->view('footer');
				
			}
			
		}
		
	}
		
	/**
	 * login function.
	 * 
	 * @access public
	 * @return void
	 */
	public function login() {

		// create the data object
		$data = new stdClass();
		
		// load form helper and validation library
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		// set validation rules
		$this->form_validation->set_rules('username', 'Username', 'required|alpha_numeric');
		$this->form_validation->set_rules('password', 'Password', 'required');
		
		if ($this->form_validation->run() == false) {
			
			// validation not ok, send validation errors to the view
			$this->load->view('header');
			$this->load->view('user/login/login');
			$this->load->view('footer');
			
		} else {
			
			// set variables from the form
			$username = $this->input->post('username');
			$password = $this->input->post('password');
			
			if ($this->user_model->resolve_user_login($username, $password)) {
				
				$user_id = $this->user_model->get_user_id_from_username($username);
				$user    = $this->user_model->get_user($user_id);
				
				// set session user datas
				$newdata = array(
					'user_id'  => (int)$user->id,
					'username'     => (string)$user->username,
					'logged_in' => (bool)true,
					'is_confirmed' => (bool)$user->is_confirmed,
					//'is_admin' => (bool)$user->is_admin
				);
	            $this->session->set_userdata($newdata);

	            // user login ok
				//redirect('/user/import', 'refresh');
                redirect('/user/import');
				
			} else {
				
				// login failed
				$data->error = 'Wrong username or password.';
				
				// send error to the view
				$this->load->view('header');
				$this->load->view('user/login/login', $data);
				$this->load->view('footer');
				
			}
			
		}
		
	}
	
	/**
	 * logout function.
	 * 
	 * @access public
	 * @return void
	 */
	public function logout() {
		
		// create the data object
		$data = new stdClass();
		
		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
			
			// remove session datas
			foreach ($_SESSION as $key => $value) {
				unset($_SESSION[$key]);
			}
			
			// user logout ok
			$this->load->view('header');
			$this->load->view('user/logout/logout_success', $data);
			$this->load->view('footer');
			
		} else {
			
			// there user was not logged in, we cannot logged him out,
			// redirect him to site root
			redirect('/');
			
		}
		
	}

	public function import()
	{
       if ($this->session->userdata('username') == '')
		{
			redirect('/login', 'refresh');
		}
		else{
			$this->load->view('header');
			//$this->load->view('user/import', $data);
            $this->load->view('user/import');
			$this->load->view('footer');
		}

	}
    public function getDirContents($dir, $search_key = array(), &$results = array()){
        $files = scandir($dir);
        foreach($files as $key => $value){
			$path = realpath($dir.DIRECTORY_SEPARATOR.$value);
            if(!is_dir($path)) {
				$allowed = array('pdf', 'xml','js');
				$ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
				
				if (in_array($ext, $allowed)) {
					//Compare File Name
					foreach($search_key as $searh_val)
					{
						if (stripos($value, $searh_val) !== false) {
							$results[] = $path;
						}
						// $pattern = preg_quote($searh_val, '/');
						// // finalise the regular expression, matching the whole line
						// $pattern = "/^.*$pattern.*\$/m";
						// // search, and store all matching occurences in $matches
						// if(preg_match_all($pattern, $value, $matches)){
						// 	//echo implode("\n", $matches[0]);
						// 	$results[] = $path;
						// }
					}
					//Compare File content
					foreach($search_key as $searh_val)
					{
						// get the file contents, assuming the file to be readable (and exist)
							if($ext == 'pdf')
							{
								$contents = pdf2text($path);
							}
							else{
								$contents = file_get_contents($path);
							}
							
							// escape special characters in the query
							$pattern = preg_quote($searh_val, '/');
							// finalise the regular expression, matching the whole line
							$pattern = "/^.*$pattern.*\$/m";
							// search, and store all matching occurences in $matches
							if(preg_match_all($pattern, $contents, $matches)){
								//echo implode("\n", $matches[0]);
								$results[] = $path;
							}
					}
				}

            } else if($value != "." && $value != "..") {
                $this->getDirContents($path, $search_key, $results);
                //$results[] = $path;
            }
        }

        return $results;
    }
	public function search()
    {
       // $data = new stdClass();
        $data = array();
        //echo FCPATH; exit;
        if($this->input->post('searchContent') != '') {
            $search_key = str_replace("  ", " ", $this->input->post('searchContent'));
            $search_key = explode(",", $search_key);
            $dir = $this->input->post('folder');
            if (count($search_key) > 0) {
                $files = $this->getDirContents($dir, $search_key);

            }
            $data['list'] = $files;
        }

        $this->load->view('header');
        $this->load->view('user/import', $data);
        $this->load->view('footer');

    }
	public function download_zip()
    {

        // Create directory if it does not exist
        if(!is_dir(FCPATH."assets/uploads/". $this->session->userdata('username') ."/")) {
            mkdir(FCPATH."assets/uploads/". $this->session->userdata('username') ."/");
        }
        else{

        }

        //echo "<pre>"; print_r($this->input->post('file')); exit;
        $files = $this->input->post('file');

        //compy files into folder
        foreach($files as $resFile){

            $file = basename($resFile);
            copy($resFile, FCPATH."assets/uploads/". $this->session->userdata('username') ."/". $file);
        }
        //create zip and push download
        // Get real path for our folder
        $rootPath = realpath(FCPATH."assets/uploads/". $this->session->userdata('username') ."/");
        unlink(FCPATH.'files.zip');
        // Initialize archive object
        $zip = new ZipArchive();
        $zip->open('files.zip', ZipArchive::CREATE | ZipArchive::OVERWRITE);

        // Initialize empty "delete list"
        $filesToDelete = array();

        // Create recursive directory iterator
        /** @var SplFileInfo[] $files */
        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($rootPath),
            RecursiveIteratorIterator::LEAVES_ONLY
        );

        foreach ($files as $name => $file)
        {
            // Skip directories (they would be added automatically)
            if (!$file->isDir())
            {
                // Get real and relative path for current file
                $filePath = $file->getRealPath();
                $relativePath = substr($filePath, strlen($rootPath) + 1);

                // Add current file to archive
                $zip->addFile($filePath, $relativePath);

                // Add current file to "delete list"
                // delete it later cause ZipArchive create archive only after calling close function and ZipArchive lock files until archive created)
                if ($file->getFilename() != 'important.txt')
                {
                    $filesToDelete[] = $filePath;
                }
            }
        }
        $zip->close();
        // Delete all files from "delete list"
        foreach ($filesToDelete as $file)
        {
            unlink($file);
        }
        redirect(base_url('files.zip'));
        // header("Location:files.zip");



    }
}
