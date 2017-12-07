<?php
class Rejestracja extends CI_Controller {
  public function __construct() {
    parent::__construct();
    $this->load->model('rejestracjaM');
  }

  public function index() {
    if($this->rejestracjaM->jestZalogowany()) redirect(site_url());
    $this->form_validation->set_rules('login','Login','required|is_unique[uzytkownicy.login]');
    $this->form_validation->set_rules('haslo1','Hasło','required');
    $this->form_validation->set_rules('haslo2','Powtórz hasło','required|matches[haslo1]');
    $this->form_validation->set_rules('imie','Imię','required');
    $this->form_validation->set_rules('nazwisko','Nazwisko','required');
    if($this->form_validation->run()) {
      $this->rejestracjaM->dodajUzytkownika();
      redirect('rejestracja');
    }
    $data['tytul']='Rejestracja';
    $this->load->view('szablon/start',$data);
    $this->load->view('szablon/menu');
    $this->load->view('rejestracja/index');
    $this->load->view('szablon/info');
    $this->load->view('szablon/koniec');
  }
}
