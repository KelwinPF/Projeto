<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Dompdf\Dompdf;
require_once 'dompdf/autoload.inc.php';

class Empresas extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('table');
		$this->load->library('form_validation');
		$this->load->library('pagination');
		$this->load->library('user_agent');
		$this->load->model('option_model','option');
	
	}

	public function index(){
		redirect('empresas/listar','refresh');
	}

	public function listar($pesquisa=null){
		verifica_login();
		if($pesquisa != null){
			if($pesquisa == 'all-'){
				$pesquisa = 'all';
			}	
			$pesquisa = str_replace(array("?", "~"),array(" ","/"),$pesquisa);
		}
		$config['base_url'] = base_url('empresas/listar');
		$config['num_links'] = 5;
		$config['per_page'] = 4;
		$config['full_tag_open'] ="<ul class ='pagination'>";
		$config['full_tag_close'] = "</ul>";
		$config['first_link'] = FALSE;
		$config['last_link'] = FALSE;
		$config['first_tag_open'] = "<li>";
		$config['first_tag_close'] = "</li>";
		$config['prev_link'] = "Anterior";
		$config['prev_tag_open'] = "<li class ='prev'>";
		$config['prev_tag_close'] = "</li>";
		$config['next_link'] = "Próxima";
		$config['next_tag_open'] = "<li class ='next'>";
		$config['next_tag_close'] = "</li>";
		$config['prev_tag_open'] = "<li>";
		$config['prev_tag_close'] = "</li>";
		$config['cur_tag_open'] = "<li class ='active'><a href= '#'>";
		$config['cur_tag_close'] = "</a></li>";
		$config['num_tag_open'] = "<li>";
		$config['num_tag_close'] = "</li>";

		$qtd = $config['per_page'];

		if($this->uri->segment(3) == 'all'){
			$inicio = 0;
			$config['base_url'] = base_url('empresas/listar/all');
			$config['uri_segment'] = 4;
			($this->uri->segment(4) != '') ? $inicio = $this->uri->segment(4) : $inicio = 0;
			$dados['Empresas'] = $this->option->get_all_empresas($qtd,$inicio);
			$config['total_rows'] = $this->option->get_qtd_empresa();
			$this->pagination->initialize($config);
			$dados['Paginacao'] = $this->pagination->create_links();
			$pesquisa = null;
		}

		else{
			$inicio = 0;
			$config['base_url'] = base_url('empresas/listar/'.$pesquisa);
			$config['uri_segment'] = 4;
			($this->uri->segment(4) != '') ? $inicio = $this->uri->segment(4) : $inicio = 0;
			$dados['Empresas'] = $this->option->get_pesquisa_empresas($pesquisa,$qtd,$inicio);
			$config['total_rows'] = $this->option->get_qtd_pesquisa_empresa($pesquisa);
			$this->pagination->initialize($config);
			$dados['Paginacao'] = $this->pagination->create_links();
		}

		$this->form_validation->set_rules('pesquisarr','pesquisarr','trim',array(
        ));

		if($this->form_validation->run() == FALSE):
			if(validation_errors()):
				set_msg(validation_errors());
			endif;
		else:
			if(!empty($_POST['pdf'])):
				$inicio = 0;
				$dompdf = new DOMPDF(array('enable_remote' => true));
				$qtd=$this->option->get_qtd_empresa();
				$dados['Empresas'] = $this->option->get_pesquisa_empresas(null,$qtd,$inicio);
				$this->load->view('painel/etabela',$dados);
				$html = $this->output->get_output();
				$dompdf->loadHtml($html);

				$dompdf->setPaper('A4', 'landscape');

				$dompdf->render();

				$dompdf->stream();
				endif;
			if (!empty($_POST['pesquisar'])):
				$dados_form = $this->input->post();
				if($dados_form['pesquisarr']==null){
					redirect('empresas/listar/all','refresh');	
				}
				if($dados_form['pesquisarr']=='all'){
					redirect('empresas/listar/all-','refresh');	
				}
				if (!preg_match('/^[a-z0-9 .\-\/ ]+$/i', $dados_form['pesquisarr'])){
					set_msg('<p>Digite os caracteres corretos e sem acentos</p>');
					redirect('colaboradores/listar/all','refresh');
				}
	
				$titulo = str_replace(array(" ","/"),array("?", "~") , $dados_form['pesquisarr']);
				redirect('empresas/listar/'.$titulo,'refresh');	
		endif;
		endif;

		$dados['User'] = $this->session->userdata('user_login');
		$dados['Email'] = $this->session->userdata('user_email');
		$this->load->view('painel/elistar',$dados);	
	}


	public function excluir($id=null){
		verifica_login();
		if($this->option->delete_empresa($id)):
			$this->option->delete_empresa_col($id);
			set_msg('<p>Empresa Deletada</p>');
			redirect('empresas/listar/all','refresh');
		else:
			redirect('empresas/listar/all','refresh');
		endif;	
	}

	public function editar($id=null){
		verifica_login();
		$this->form_validation->set_rules('nome','Nome','trim|required|min_length[5]|alpha_numeric_spaces',array(
                'required'      => 'Insira o %s.',
                'min_length'	=> 'Mínimo de 5 dígitos para o %s.',
                'alpha_numeric_spaces'	=> 'Somente caracteres sem acento no campo %s'
        ));
		$this->form_validation->set_rules('email','Email','trim|required|valid_email',array(
                'required'      => 'Insira o %s.',
                'valid_email'   => 'Insira %s válido.'
        ));
		$this->form_validation->set_rules('cnpj','CNPJ','trim|required|exact_length[18]|callback_regex_check',array(
                'required'      => 'Insira o %s.',
                'exact_length'  => 'Insira %s com formato válido! (XX.XXX.XXX/XXXX-XX)'
        ));

		if($this->form_validation->run() == FALSE):
			if(validation_errors()):
				set_msg(validation_errors());
			endif;
		else:
			$dados_form = $this->input->post();
			if (!$this->option->get_verify_cnpj_empresa($id,$dados_form['cnpj'])):
        		set_msg('Já existe empresa com este CNPJ cadastrado');
        		redirect('empresas/editar/'.$id,'refresh');
    			endif;
    			if (!$this->option->get_verify_empresa($id,$dados_form['nome'])):
			    	set_msg('Já existe empresa com este Nome cadastrado');
        			redirect('empresas/editar/'.$id,'refresh');
    			endif;
			$inserido = $this->option->update_empresa($id,$dados_form['nome'],$dados_form['email'],$dados_form['cnpj']);
			if($inserido != null):
				set_msg('<p>Empresa '.$dados_form['nome'].' Alterada com sucesso!</p>');
				redirect('empresas/listar/all','refresh');
			endif;
		endif;
		$dados['Empresa'] = $this->option->get_empresa($id);
		$dados['User'] = $this->session->userdata('user_login');
		$dados['Email'] = $this->session->userdata('user_email');
		$this->load->view('painel/eeditar',$dados);
	}

	public function inserir(){
		verifica_login();
		$this->form_validation->set_rules('nome','Nome','trim|required|alpha_numeric_spaces|min_length[5]|callback_verify_new_nome',array(
                'required'      => 'Insira o %s.',
                'is_unique'     => '%s de empresa já cadastrada, tente outro.',
                'min_length'	=> 'Mínimo de 5 dígitos para o %s.',
                'alpha_numeric_spaces'	=> 'Somente caracteres sem acento no campo %s'
        ));
		$this->form_validation->set_rules('email','Email','trim|required|valid_email',array(
                'required'      => 'Insira o %s.',
                'valid_email'   => 'Insira %s válido.'
        ));
		$this->form_validation->set_rules('cnpj','CNPJ','trim|required|callback_verify_new_cnpj|exact_length[18]|callback_regex_check',array(
                'required'      => 'Insira o %s.',
                'numeric'		=> 'Campo %s precisa conter apenas números.',
                'exact_length'  => 'Insira %s com formato válido! (XX.XXX.XXX/XXXX-XX)'
        ));

		if($this->form_validation->run() == FALSE):
			if(validation_errors()):
				set_msg(validation_errors());
			endif;
		else:
			$dados_form = $this->input->post();

				$inserido = $this->option->insert_empresa($dados_form['nome'],$dados_form['email'],$dados_form['cnpj']);
				if($inserido != null):
					set_msg('<p>Empresa '.$dados_form['nome'].' cadastrada com Sucesso!</p>');
					redirect('empresas/listar/all','refresh');
				endif;
		endif;
		$dados['User'] = $this->session->userdata('user_login');
		$dados['Email'] = $this->session->userdata('user_email');
		$this->load->view('painel/einserir',$dados);	
	}


	public function visualizar($id=null,$pesquisa=null){
		verifica_login();
		if($pesquisa != null){
			if($pesquisa == 'all-'){
				$pesquisa = 'all';
			}	
			$pesquisa = str_replace(array("?", "~"),array(" ","/"),$pesquisa);
		}
		$config['num_links'] = 5;
		$config['per_page'] = 4;
		$config['cur_page'] = 0;
		$config['full_tag_open'] ="<ul class ='pagination'>";
		$config['full_tag_close'] = "</ul>";
		$config['first_link'] = FALSE;
		$config['last_link'] = FALSE;
		$config['first_tag_open'] = "<li>";
		$config['first_tag_close'] = "</li>";
		$config['prev_link'] = "Anterior";
		$config['prev_tag_open'] = "<li class ='prev'>";
		$config['prev_tag_close'] = "</li>";
		$config['next_link'] = "Próxima";
		$config['next_tag_open'] = "<li class ='next'>";
		$config['next_tag_close'] = "</li>";
		$config['prev_tag_open'] = "<li>";
		$config['prev_tag_close'] = "</li>";
		$config['cur_tag_open'] = "<li class ='active'><a href= '#'>";
		$config['cur_tag_close'] = "</a></li>";
		$config['num_tag_open'] = "<li>";
		$config['num_tag_close'] = "</li>";

		$qtd = $config['per_page'];
		if($this->uri->segment(4) == 'all'){
			$inicio = 0;
			$config['base_url'] = base_url('empresas/visualizar/'.$id.'/all');
			$config['uri_segment'] = 5;
			$config['total_rows'] = $this->option->get_qtd_empcol($id);
			($this->uri->segment(5) != '') ? $inicio = $this->uri->segment(5) : $inicio = 0;
			$dados['Colaboradores'] = $this->option->buscar_colaborador($id,$qtd,$inicio);
			$dados['Quantidade'] = $this->option->get_qtd_empcol($id);
			$this->pagination->initialize($config);
			$dados['Paginacao'] = $this->pagination->create_links();
		}
		else{
			$inicio = 0;
			$config['base_url'] = base_url('empresas/visualizar/'.$id.'/'.$pesquisa);
			$pesquisa = preg_replace('/[ -]+/' , ' ' , $pesquisa);
			$config['uri_segment'] = 5;
			$config['total_rows'] = $this->option->get_qtd_pesquisa_empcol($pesquisa,$id);
			($this->uri->segment(5) != '') ? $inicio = $this->uri->segment(5) : $inicio = 0;
			$dados['Colaboradores'] = $this->option->pesquisa_colaborador($pesquisa,$id,$qtd,$inicio);
			$dados['Quantidade'] = $this->option->get_qtd_pesquisa_empcol($pesquisa,$id);
			$this->pagination->initialize($config);
			$dados['Paginacao'] = $this->pagination->create_links();
		}

		$this->form_validation->set_rules('pesquisarr','pesquisarr','trim',array(
        ));

		if($this->form_validation->run() == FALSE):
			if(validation_errors()):
				set_msg(validation_errors());
			endif;
		else:
			if(!empty($_POST['pdf'])):
				$inicio = 0;
				$dompdf = new DOMPDF(array('enable_remote' => true));
				$qtd=$this->option->get_qtd_empcol($id);
				$dados['Empresa'] = $this->option->get_empresa($id);
				$dados['Colaboradores'] = $this->option->buscar_colaborador($id,$qtd,$inicio);
				$dados['Quantidade'] = $this->option->get_qtd_empcol($id);
				$this->load->view('painel/cetabela',$dados);
				$html = $this->output->get_output();
				$dompdf->loadHtml($html);

				$dompdf->setPaper('A4', 'landscape');

				$dompdf->render();

				$dompdf->stream();
				endif;
				if(!empty($_POST['pdfm'])):
				$inicio = 0;
				$dompdf = new DOMPDF(array('enable_remote' => true));
				$dados['Empresa'] = $this->option->get_empresa($id);
				$dados['Colaboradores'] = $this->option->buscar_mulheres_empresa($id,$qtd,$inicio);
				$dados['Quantidade'] = $this->option->get_qtd_empfemale($id);
				$this->load->view('painel/ceftabela',$dados);
				$html = $this->output->get_output();
				$dompdf->loadHtml($html);

				$dompdf->setPaper('A4', 'landscape');

				$dompdf->render();

				$dompdf->stream();
				endif;
			if (!empty($_POST['pesquisar'])):
				$dados_form = $this->input->post();
				if($dados_form['pesquisarr']==null){
					redirect('empresas/visualizar/'.$id.'/all','refresh');	
				}
				if($dados_form['pesquisarr']=='all'){
					redirect('empresas/visualizar/'.$id.'/all-','refresh');	
				}
				if (!preg_match('/^[a-z0-9 .\-\/ ]+$/i', $dados_form['pesquisarr'])){
					set_msg('<p>Digite os caracteres corretos e sem acentos</p>');
					redirect('colaboradores/listar/all','refresh');
				}
				$titulo = str_replace(array(" ","/"),array("?", "~") , $dados_form['pesquisarr']);
				redirect('empresas/visualizar/'.$id.'/'.$titulo,'refresh');	
			endif;
		endif;

		if($id<1):
			redirect('empresas/listar/all','refresh');
		endif;

		$dados['Empresa'] = $this->option->get_empresa($id);
		$dados['User'] = $this->session->userdata('user_login');
		$dados['Email'] = $this->session->userdata('user_email');
		$this->load->view('painel/evisualizar',$dados);	
	}

	public function regex_check($str){

    if (preg_match('/^(([0-9]{2}\.[0-9]{3}\.[0-9]{3}\/[0-9]{4}\-[0-9]{2}))$/', $str)):
        return TRUE;
    else:
    	$this->form_validation->set_message('regex_check', 'Insira %s com formato válido! (XX.XXX.XXX/XXXX-XX)');
        return FALSE;
    endif;
	}

	public function verify_new_nome($str){

	if ($this->option->get_verify_new_empresa($str)):
        return TRUE;
    else:
    	$this->form_validation->set_message('verify_new_nome','Já existe empresa com este %s cadastrado');
        return FALSE;
    endif;

	}

	public function verify_new_cnpj($str){

	if ($this->option->get_verify_new_cnpj_empresa($str)):
        return TRUE;
    else:
    	$this->form_validation->set_message('verify_new_cnpj','Já existe empresa com este %s cadastrado');
        return FALSE;
    endif;

	}



}


