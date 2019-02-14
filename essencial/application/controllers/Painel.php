<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Painel extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('option_model','option');
	}

	public function index(){
		redirect('painel/home','refresh');
	}

	public function home(){
		verifica_login();
		$var =  $this->option->get_count_empresa();
		if($var==null){
		$dados['Maior']='Sem colaborador cadastrado';	
		}
		else{
		$dados['Maior']=$this->option->get_n_empresa($var);
		}
		$dados['Ultcolaborador']=$this->option->get_ult_colaborador();
		$dados['Ultempresa']=$this->option->get_ult_empresa();
		$dados['QEmpresas']=$this->option->get_qtd_empresa();
		$dados['QColaboradores']=$this->option->get_qtd_colaborador();
		$dados['User'] = $this->session->userdata('user_login');
		$dados['Total'] = $dados['QColaboradores'] + $dados['QEmpresas'];
		$this->load->view('painel/home',$dados);	
	}

	public function logout(){
		$this->session->unset_userdata('logged');
		$this->session->unset_userdata('user_login');
		$this->session->unset_userdata('user_email');
		set_msg('<p>Você saiu do sistema!</p>');
		redirect('login/login');
	}

	public function perfil(){
		verifica_login();
		$dados['User'] = $this->session->userdata('user_login');
		$dados['Email'] = $this->session->userdata('user_email');
		$this->load->view('painel/perfil',$dados);	
	}

	public function configuracoes(){
		verifica_login();
		$this->form_validation->set_rules('email','Email','trim|required|valid_email',array(
                'required'      => 'Insira o %s.',
                'valid_email'   => 'Insira %s válido'
        ));
		$this->form_validation->set_rules('senha','Senha','trim|required|min_length[6]',array(
                'required'      => 'Insira a %s.',
                'min_length'	=> 'Mínimo de 6 dígitos para a %s'
        ));
        if($this->form_validation->run() == FALSE):
			if(validation_errors()):
				set_msg(validation_errors());
			endif;
		else:
			$dados_form = $this->input->post();
			//login e email antigos
			$login = $this->session->userdata('user_login');
			$email = $this->session->userdata('user_email');
			if(password_verify($dados_form['senha'], $this->option->get_senha($login))):
						//ssenha ok
						$this->option->update($login,$dados_form['email']);
						set_msg('<p>Email Alterado com Sucesso</p>');
						$this->session->set_userdata('user_email',$dados_form['email']);
						redirect('painel/configuracoes','refresh');	
					else:
						//senha incorreta
						set_msg('<p>Senha Incorreta</p>');
					endif;

		endif;
		$dados['User'] = $this->session->userdata('user_login');
		$dados['Email'] = $this->session->userdata('user_email');
		$this->load->view('painel/configuracoes',$dados);	
	}
	public function userconfig(){
		verifica_login();
		$this->form_validation->set_rules('usuario','Usuário','trim|required|callback_verify_user',array(
                'required'      => 'Insira o %s.',
                'valid_email'   => 'Insira %s válido'
        ));
		$this->form_validation->set_rules('senha','Senha','trim|required|min_length[6]',array(
                'required'      => 'Insira a %s.',
                'min_length'	=> 'Mínimo de 6 dígitos para a %s'
        ));
        if($this->form_validation->run() == FALSE):
			if(validation_errors()):
				set_msg(validation_errors());
			endif;
		else:
			$dados_form = $this->input->post();
			//login e email antigos
			$login = $this->session->userdata('user_login');
			$email = $this->session->userdata('user_email');
			if(password_verify($dados_form['senha'], $this->option->get_senha($login))):
						//ssenha ok
						$this->option->update_nome($login,$dados_form['usuario']);
						set_msg('<p>Usuário Alterado com Sucesso</p>');
						$this->session->set_userdata('user_login',$dados_form['usuario']);
						redirect('painel/userconfig','refresh');	
					else:
						//senha incorreta
						set_msg('<p>Senha Incorreta</p>');
					endif;

		endif;
		$dados['User'] = $this->session->userdata('user_login');
		$dados['Email'] = $this->session->userdata('user_email');
		$this->load->view('painel/userconfig',$dados);	
	}

	public function verify_user($str){

	if ($this->option->get_verify_user($this->option->get_id_user($str),$this->session->userdata('user_login'))):
        return TRUE;
    else:
    	$this->form_validation->set_message('verify_user','Já existe este %s cadastrado');
        return FALSE;
    endif;

	}
}
