<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Dompdf\Dompdf;
require_once 'dompdf/autoload.inc.php';

class Colaboradores extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('table');
		$this->load->library('form_validation');
		$this->load->library('user_agent');
		$this->load->model('option_model','option');
		$this->load->library('pagination');
	
	}

	public function index(){
		redirect('colaboradores/listar','refresh');
	}

	public function listar($pesquisa){
		verifica_login();
		if($pesquisa != null){
			if($pesquisa == 'all-'){
				$pesquisa = 'all';
			}	
			$pesquisa = str_replace(array("?", "~"),array(" ","/"),$pesquisa);	
		}
		$config['base_url'] = base_url('colaboradores/listar');
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
			$config['base_url'] = base_url('colaboradores/listar/all');
			$config['uri_segment'] = 4;
			($this->uri->segment(4) != '') ? $inicio = $this->uri->segment(4) : $inicio = 0;
			$dados['Colaboradores'] = $this->option->get_all_colaboradores($qtd,$inicio);
			$config['total_rows'] = $this->option->get_qtd_colaborador();
			$this->pagination->initialize($config);
			$dados['Paginacao'] = $this->pagination->create_links();
		}
		else{
			$inicio = 0;
			$config['base_url'] = base_url('colaboradores/listar/'.$pesquisa);
			$config['uri_segment'] = 4;
			($this->uri->segment(4) != '') ? $inicio = $this->uri->segment(4) : $inicio = 0;
			$dados['Colaboradores'] = $this->option->get_pesquisa_colaboradores($pesquisa,$qtd,$inicio);
			$config['total_rows'] = $this->option->get_qtd_pesquisa_colaborador($pesquisa);
			$this->pagination->initialize($config);
			$dados['Paginacao'] = $this->pagination->create_links();
		}

		$this->form_validation->set_rules('pesquisarr','pesquisarr','trim',array(
        ));

		$dados['User'] = $this->session->userdata('user_login');
		$dados['Email'] = $this->session->userdata('user_email');
		if($this->form_validation->run() == FALSE):
			if(validation_errors()):
				set_msg(validation_errors());
			endif;
		else:
				if(!empty($_POST['pdf'])):
				$inicio = 0;
				$dompdf = new DOMPDF(array('enable_remote' => true));
				$qtd=$this->option->get_qtd_colaborador();
				$dados['Colaboradores'] = $this->option->get_pesquisa_colaboradores(null,$qtd,$inicio);
				$this->load->view('painel/tabela',$dados);
				$html = $this->output->get_output();
				$dompdf->loadHtml($html);

				$dompdf->setPaper('A4', 'landscape');

				$dompdf->render();

				$dompdf->stream();
				endif;
				if(!empty($_POST['pdfm'])):
				$dompdf = new DOMPDF(array('enable_remote' => true));
				$dados['Colaboradores'] = $this->option->buscar_mulheres();
				$this->load->view('painel/ftabela',$dados);
				$html = $this->output->get_output();
				$dompdf->loadHtml($html);

				$dompdf->setPaper('A4', 'landscape');

				$dompdf->render();

				$dompdf->stream();
				endif;
				if (!empty($_POST['pesquisar'])):
				$dados_form = $this->input->post();
				if($dados_form['pesquisarr']==null){
					redirect('colaboradores/listar/all','refresh');	
				}
				if($dados_form['pesquisarr']=='all'){
					redirect('colaboradores/listar/all-','refresh');	
				}
				if (!preg_match('/^[a-z0-9 .\-\/ ]+$/i', $dados_form['pesquisarr'])){
					set_msg('<p>Digite os caracteres corretos e sem acentos</p>');
					redirect('colaboradores/listar/all','refresh');
				}
				$titulo = str_replace(array(" ","/"),array("?", "~") , $dados_form['pesquisarr']);
				redirect('colaboradores/listar/'.$titulo,'refresh');	
			endif;
		endif;

		$this->load->view('painel/clistar',$dados);	
	}
	
	public function inserir(){
		verifica_login();
		$this->form_validation->set_rules('nome','Nome','trim|required|alpha_numeric_spaces',array(
                'required'      => 'Insira o %s.',
                'alpha_numeric_spaces'      => 'Apenas caracteres do alfabeto e sem acento no campo %s',
        ));
		$this->form_validation->set_rules('email','Email','trim|required|valid_email',array(
                'required'      => 'Insira o %s.',
                'valid_email'   => 'Insira %s válido.'
        ));
        $this->form_validation->set_rules('cpf','CPF','trim|exact_length[14]|required|callback_verify_new|callback_regex_check',array(
             	'required'      => 'Insira o %s.',
                'exact_length'  => 'Insira %s com formato válido! (XXX.XXX.XXX-XX)'
        ));
        $this->form_validation->set_rules('sexo','Sexo','trim|required',array(
                'required'      => 'Erro no campo %s',
        ));
        $this->form_validation->set_rules('empresa','Empresa','trim|required',array(
                'required'      => 'Erro no campo %s',
        ));

		if($this->form_validation->run() == FALSE):
			if(validation_errors()):
				set_msg(validation_errors());
			endif;
		else:
			$dados_form = $this->input->post();
			$id_empresa = $this->option->get_id_empresa($dados_form['empresa']);

				$inserido = $this->option->insert_colaborador($dados_form['nome'],$dados_form['email'],$dados_form['cpf'],$dados_form['sexo'],$dados_form['empresa']);
				if($inserido != null):
					set_msg('<p>Colaborador(a) '.$dados_form['nome'].' cadastrado(a) com Sucesso!</p>');
					redirect('colaboradores/listar/all','refresh');
				endif;
		endif;
		$dados['Empresas'] = $this->option->get_allnome_empresa();
		$dados['User'] = $this->session->userdata('user_login');
		$dados['Email'] = $this->session->userdata('user_email');
		$this->load->view('painel/cinserir',$dados);	
	}

		public function editar($id=null){
		verifica_login();
		$this->form_validation->set_rules('nome','Nome','trim|required|min_length[5]|alpha_numeric_spaces',array(
                'required'      => 'Insira o %s.',
                'min_length'	=> 'Mínimo de 5 dígitos para o %s.',
                'alpha_numeric_spaces'      => 'Apenas caracteres do alfabeto e sem acento no campo %s'
        ));
		$this->form_validation->set_rules('email','Email','trim|required|valid_email',array(
                'required'      => 'Insira o %s.',
                'valid_email'   => 'Insira %s válido.'
        ));
		$this->form_validation->set_rules('cpf','cpf','trim|required|callback_regex_check',array(
                'required'      => 'Insira o %s.',
                'numeric'		=> 'Campo %s precisa conter apenas números.',
                'exact_length'  => 'Insira %s com formato válido! (XX.XXX.XXX/XXXX-XX)'
        ));
        $this->form_validation->set_rules('sexo','Sexo','trim|required',array(
                'required'      => 'Erro no campo %s',
        ));
        $this->form_validation->set_rules('empresa','Empresa','trim|required',array(
                'required'      => 'Erro no campo %s',
        ));

		if($this->form_validation->run() == FALSE):
			if(validation_errors()):
				set_msg(validation_errors());
			endif;
		else:
			$dados_form = $this->input->post();
			if (!$this->option->get_verify_cpf_colaborador($id,$dados_form['cpf'])):
	       		set_msg('<p>CPF existente tente outro</p>');
				redirect('colaboradores/editar/'.$id,'refresh');
    		endif;
			$dados_form = $this->input->post();
			$idempresa = $this->option->get_id_empresa($dados_form['empresa']);
			$inserido = $this->option->update_colaborador($id,$dados_form['nome'],$dados_form['email'],$dados_form['cpf'],$dados_form['sexo'],$idempresa);

			if($inserido != null):
				set_msg('<p>Colaborador '.$dados_form['nome'].' Alterada com sucesso!</p>');
				redirect('colaboradores/listar/all','refresh');
			endif;
		endif;
		$dados['Empresas'] = $this->option->get_allnome_empresa();
		$dados['Empresa'] = $this->option->get_n_empresa($this->option->get_id_col_empresa($id));
		$dados['Colaborador'] = $this->option->get_colaborador($id);
		$dados['User'] = $this->session->userdata('user_login');
		$dados['Email'] = $this->session->userdata('user_email');
		$this->load->view('painel/ceditar',$dados);
	}

	public function visualizar($id=null){
		verifica_login();

		$config['base_url'] = base_url('colaboradores/visualizar/'.$id);
		$config['total_rows'] = 1;
		$config['num_links'] = 5;
		$config['uri_segment'] = 4;
		$config['per_page'] = 1;
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

		$this->pagination->initialize($config);

		($this->uri->segment(4) != '') ? $inicio = $this->uri->segment(4) : $inicio = 0;
		$idempresa =  $this->option->get_id_col_empresa($id);
		if($id<1):
			redirect('colaboradores/listar/all','refresh');
		endif;

		$this->form_validation->set_rules('pdf','pdf','trim',array(
        ));

		if($this->form_validation->run() == FALSE):
			if(validation_errors()):
				set_msg(validation_errors());
			endif;
		else:
			if(!empty($_POST['pdf'])):
				$dompdf = new DOMPDF(array('enable_remote' => true));
				$qtd=$this->option->get_qtd_empcol($id);
				$dados['Empresa'] = $this->option->get_empresa($idempresa);
				$dados['Colaborador'] = $this->option->get_colaborador($id);
				$this->load->view('painel/ectabela',$dados);
				$html = $this->output->get_output();
				$dompdf->loadHtml($html);

				$dompdf->setPaper('A4', 'landscape');

				$dompdf->render();

				$dompdf->stream();
				endif;
		endif;
		$dados['Colaborador'] = $this->option->get_colaborador($id);
		$dados['Empresa'] = $this->option->get_empresa($idempresa);
		$dados['User'] = $this->session->userdata('user_login');
		$dados['Email'] = $this->session->userdata('user_email');
		$dados['Paginacao'] = $this->pagination->create_links();
		$this->load->view('painel/cvisualizar',$dados);	
	}

	public function excluir($id=null){
		verifica_login();
		
		if($this->option->delete_colaborador($id)):
			set_msg('<p>Colaborador Deletado</p>');
			redirect('colaboradores/listar/all','refresh');
		else:
			redirect('colaboradores/listar/all','refresh');
		endif;	
	}


	public function regex_check($str){

    if (preg_match('/^(([0-9]{3}.[0-9]{3}.[0-9]{3}-[0-9]{2}))$/', $str)):
        return TRUE;
    else:
    	$this->form_validation->set_message('regex_check', 'Insira %s com formato válido! (XXX.XXX.XXX-XX)');
        return FALSE;
    endif;
	}


	public function verify_cpf($str){

	if ($this->option->get_verify_cpf_colaborador($this->option->get_id_cpf_colaborador($str),$str)):
        $this->form_validation->set_message('verify_cpf',$this->option->get_verify_cpf_colaborador($this->option->get_id_cpf_colaborador($str),$str));
        return FALSE;
    else:
    	$this->form_validation->set_message('verify_cpf','Já existe colaborador com este %s cadastrado');
        return FALSE;
    endif;

	}

	public function verify_new($str){

	if ($this->option->get_verify_new_cpf_colaborador($str)):
        return TRUE;
    else:
    	$this->form_validation->set_message('verify_new','Já existe colaborador com este %s cadastrado');
        return FALSE;
    endif;
	}
}