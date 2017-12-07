<?php
class Aukcje extends CI_Controller {
  public function __construct() {
    parent::__construct();
    $this->load->model('aukcjeM');
  }

  public function index() {
    $data['tytul']='Aukcje';
    $data['id']=false;
    $data['aukcje']=$this->aukcjeM->wczytajWszystkieAukcje();
    $this->load->view('szablon/start',$data);
    $this->load->view('szablon/menu');
    $this->load->view('aukcje/index');
    $this->load->view('szablon/koniec');
  }

  public function szczegoly($id=false) {
    if(!$id) show_404();
    if(!($data['aukcja']=$this->aukcjeM->wczytajAukcje($id))) show_404();
    $data['tytul']='Aukcja - '.$data['aukcja']['nazwaAukcji'];
    if($this->input->post('podbij')) {
      if($this->aukcjeM->czyAktywna($id)) {
        if($this->aukcjeM->podbij($id)) redirect('aukcje/szczegoly/'.$id);
      }
    }
    $this->load->view('szablon/start',$data);
    $this->load->view('szablon/menu');
    $this->load->view('aukcje/szczegoly');
    $this->load->view('szablon/info');
    $this->load->view('szablon/koniec');
  }
}
