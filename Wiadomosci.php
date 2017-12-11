<?php
class Wiadomosci extends CI_Controller {
  public function __construct() {
    parent::__construct();
    $this->load->model('wiadomosciM');
  }

  public function index() {
    $this->wiadomosciM->sprawdz();
    $data['rozmowy']=$this->wiadomosciM->wczytajRozmowy();
    $data['tytul']='Wiadomości';
    $this->load->view('szablon/start',$data);
    $this->load->view('szablon/menu');
    $this->load->view('wiadomosci/index');
    $this->load->view('szablon/info');
    $this->load->view('szablon/koniec');
  }

  public function rozmowa($id=false) {
    if(!$id) show_404();
    $this->wiadomosciM->sprawdz();
    $this->form_validation->set_rules('tresc','Treść wiadomosci','required');
    if($this->form_validation->run()) {
      $this->wiadomosciM->wyslijWiadomosc($id);
      redirect('wiadomosci/rozmowa/'.$id);
    }
    $data['wiadomosci']=$this->wiadomosciM->wczytajWiadomosci($id);
    $data['id']=$id;
    $data['tytul']='Rozmowa';
    $this->load->view('szablon/start',$data);
    $this->load->view('szablon/menu');
    $this->load->view('wiadomosci/rozmowa');
    $this->load->view('szablon/info');
    $this->load->view('szablon/koniec');
  }
}
