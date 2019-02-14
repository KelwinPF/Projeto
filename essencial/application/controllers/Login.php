<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('option_model','option');
	
	}

	public function index(){
		if($this->option->get_qtd() == true):
			redirect('login/login','refresh');
		else:
			redirect('login/instalar','refresh');
		endif;
	}

	public function instalar(){
		$this->form_validation->set_rules('login','Login','trim|required|min_length[5]|is_unique[user.user_nome]',array(
                'required'      => 'Insira o %s.',
                'is_unique'     => '%s existente, tente outro.',
                'min_length'	=> 'Mínimo de 5 dígitos para o %s'
        ));
		$this->form_validation->set_rules('email','Email','trim|required|valid_email',array(
                'required'      => 'Insira o %s.',
                'valid_email'   => 'Insira %s válido'
        ));
		$this->form_validation->set_rules('senha','Senha','trim|required|min_length[6]',array(
                'required'      => 'Insira a %s.',
                'min_length'	=> 'Mínimo de 6 dígitos para a %s'
        ));
		$this->form_validation->set_rules('senha2','Senha','trim|required|min_length[6]|matches[senha]',array(
                'required'      => 'Insira a confirmação de %s.',
                'matches'     => '%s não conicide',
                'min_length'	=> 'Mínimo de 6 dígitos para a confirmação de %s'
        ));

		if($this->form_validation->run() == FALSE):
			if(validation_errors()):
				set_msg(validation_errors());
			endif;
		else:
			$dados_form = $this->input->post();

				$inserido = $this->option->insert_user($dados_form['login'],$dados_form['email'],password_hash($dados_form['senha'],PASSWORD_DEFAULT));
			
				if($inserido != null):
					set_msg('<p>Usuário cadastrado com Sucesso</p>');
					redirect('login/login','refresh');
				endif;
		endif;
		//carregar a view
		$dados['titulo'] = 'Realizar Cadastro';
		$dados['h2'] = 'Realizar Cadastro';
		$this->load->view('painel/login',$dados);

	}

	public function login(){
		$this->form_validation->set_rules('login','Login','trim|required|min_length[5]',array(
                'required'      => 'Insira o %s.',
                'min_length'	=> 'Mínimo de 5 dígitos para o %s'
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
				if($this->option->get_user($dados_form['login']) == $dados_form['login']):
					//usuario existe
					if(password_verify($dados_form['senha'], $this->option->get_senha($dados_form['login']))):
						//ssenha ok
						$this->session->set_userdata('logged',true);
						$this->session->set_userdata('user_login',$dados_form['login']);
						$this->session->set_userdata('user_email',$this->option->get_email($dados_form['login']));
						//redirecionar
						redirect('painel/home','refresh');	
					else:
						//senha incorreta
						set_msg('<p>Senha Incorreta!</p>');
					endif;
				else:
					set_msg('<p>Usuário Não Existente!</p>');
				endif;
		endif;

		if($this->session->userdata('logged') == true):
			redirect('painel/home','refresh');
		endif;

        $dados['titulo'] = 'Login';
		$dados['h2'] = 'Login';
		$this->load->view('painel/loginh',$dados);
		}

}
