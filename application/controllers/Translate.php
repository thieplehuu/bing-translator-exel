<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Translate extends CI_Controller {
	public function __construct() {
		parent::__construct ();
		$this->load->model ( 'files_model' );
		$this->load->database ();
		$this->load->helper ( 'url' );
	}
	
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * http://example.com/index.php/welcome
	 * - or -
	 * http://example.com/index.php/welcome/index
	 * - or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * 
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index() {
		$temp ['title'] = "Bing Tranlator";
		$this->load->view ( 'translate/index', $temp );
	}
	public function translate_file() {
		$status = "";
		$msg = "";
		$file_dir = './public/upload/' . $_FILES['file']['name'];
		 if ( 0 < $_FILES['file']['error'] ) {
			echo 'Error: ' . $_FILES['file']['error'] . '<br>';
		}
		else {
			move_uploaded_file($_FILES['file']['tmp_name'], $file_dir);
			$this->files_model->insert_file ( $file_dir);
			@unlink ( $_FILES ["file"] );
			
			$this->load->library('excel');
						
			$filename='just_some_random_name.xls'; //save our workbook as this file name
			header('Content-Type: application/vnd.ms-excel'); //mime type
			header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
			header('Cache-Control: max-age=0'); //no cache
			 
			//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
			//if you want to save it as .XLSX Excel 2007 format
			$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
			//force user to download the Excel file without writing it to server's HD
			$objWriter->save('php://output');
			
		}	 		
				
		echo json_encode ( array (
				'status' => $status,
				'msg' => $msg 
		) );
	}
	
	public function files()
	{
		$files = $this->files_model->get_files();
		$this->load->view ( 'translate/files', array('files' => $files) );		
	}
}
