<?php
class Logowanie extends CI_Controller {
  public function __construct() {
    parent::__construct();
    $this->load->model('logowanieM');
  }

  public function index() {
    if($this->logowanieM->jestZalogowany()) redirect(site_url());
    $this->form_validation->set_rules('login','Login','required');
    $this->form_validation->set_rules('haslo','Hasło','required');
    if($this->form_validation->run()) {
      $this->logowanieM->zaloguj();
      redirect('logowanie');
    }
    $data['tytul']='Logowanie';
    $this->load->view('szablon/start',$data);
    $this->load->view('szablon/menu');
    $this->load->view('logowanie/index');
    $this->load->view('szablon/info');
    $this->load->view('szablon/koniec');
  }
}
