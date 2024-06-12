<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laporan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function laporan_buku()
    {
        $data['judul'] = 'Laporan Data Buku';
        $data['user'] = $this->ModelUser->cekData(['email' => $this->session->userdata('email')])->row_array();
        $data['buku'] = $this->ModelBuku->getBuku()->result_array();
        $data['kategori'] = $this->ModelBuku->getKategori()->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('buku/laporan_buku', $data);
        $this->load->view('templates/footer');
    }

    public function cetak_laporan_buku()
    {
        $data['buku'] = $this->ModelBuku->getBuku()->result_array();
        $data['kategori'] = $this->ModelBuku->getKategori()->result_array();

        $this->load->view('buku/laporan_print_buku', $data);
    }

    
    public function laporan_buku_pdf()
    {
        // Get book data from Model
        $data['buku'] = $this->ModelBuku->getBuku()->result_array();

        // Include Dompdf library
        $sroot = $_SERVER['DOCUMENT_ROOT'];
        include $sroot . "/pustaka-booking/application/third_party/dompdf/autoload.inc.php";

        // Create Dompdf instance
        $dompdf = new Dompdf\Dompdf();

        // Load the view for PDF generation
        $this->load->view('buku/laporan_pdf_buku', $data);

        // Set paper size and orientation
        $paper_size = 'A4'; // Paper size
        $orientation = 'landscape'; // Landscape or portrait

        // Get output HTML
        $html = $this->output->get_output();

        // Set paper and render PDF
        $dompdf->set_paper($paper_size, $orientation);
        $dompdf->load_html($html);
        $dompdf->render();

        // Stream PDF for download
        $dompdf->stream("laporan_data_buku.pdf", array('Attachment' => 0));
        // File name for the generated PDF
    }

    public function export_excel()
    {
    $data = array('title'=>'Laporan Buku',
    'buku'=> $this->ModelBuku->getBuku()->result_array());
    $this->load->view('buku/export_excel_buku',$data);

    }
    public function laporan_pinjam()
    {
    $data['judul'] = 'Laporan Data Peminjaman';
    $data['user'] = $this->ModelUser->cekData(['email' => $this->session->userdata('email')])->row_array();
    $data['laporan'] = $this->db->query("SELECT * FROM pinjam p, detail_pinjam d, buku b, user u WHERE d.id_buku = b.id AND p.id_user = u.id AND p.no_pinjam = d.no_pinjam")->result_array();
    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar');
    $this->load->view('templates/topbar', $data);
    $this->load->view('pinjam/laporan-pinjam', $data);
    $this->load->view('templates/footer');
    }
    public function cetak_laporan_pinjam()
    {
    $data['laporan'] = $this->db->query("select * from pinjam p, detail_pinjam d, buku b, user u where d.id_buku=b.id and p.id_user=u.id and p.no_pinjam=d.no_pinjam")->result_array();
    $this->load->view('pinjam/laporan-print-pinjam', $data);
    }
    public function laporan_pinjam_pdf()
    { {
        $data['laporan'] = $this->db->query("select *from pinjam p,detail_pinjam d,buku b,user u where d.id_buku=b.id and p.id_user=u.id and p.no_pinjam=d.no_pinjam")->result_array(); 
        $sroot=$_SERVER ['DOCUMENT_ROOT']; 
        include $sroot . "/pustaka-booking/application/third_party/dompdf/autoload.inc.php";
        $dompdf= new Dompdf\Dompdf();

        $this->load->view('pinjam/laporan-pdf-pinjam',$data);

        $paper_size = 'A4'; // ukuran kertas 
        $orientation = 'landscape'; // tpe format kertas potrait atau landscape 
        $html = $this->output->get_output(); 

        $dompdf->set_paper($paper_size,$orientation);
        // // Convert to PDF 
        $dompdf->load_html($html);
        $dompdf->render();
        $dompdf->stream("laporan_data_peminjaman.pdf",array('Attachment' => 0));
        }
   
    }
    public function export_excel_pinjam()
    {
        $data = array(
            'title'=> 'Laporan Data Peminjaman Buku',
            'laporan'=> $this->db->query("select * from pinjam p,detail_pinjam d,buku b,user u where d.id_buku=b.id and p.id_user=u.id and p.no_pinjam=d.no_pinjam")->result_array()
        ); 
        $this->load->view('pinjam/export-excel-pinjam',$data); 
   
    }

    public function laporan_anggota()
        {
            $data['judul'] = 'Laporan Data Anggota';
            $data['user'] = $this->ModelUser->cekData(['email' => $this->session->userdata('email')])->row_array();
            $data['anggota'] = $this->ModelUser->getUserWhere(['role_id => 2'])->result_array();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('member/laporan_anggota', $data);
            $this->load->view('templates/footer');
        }

        public function Cetak_laporan_anggota()
        {
            $data['anggota'] = $this->ModelUser->getUserWhere(['role_id => 2'])->result_array();

            $this->load->view('member/laporan_print_anggota', $data);
        }
        
        public function laporan_anggota_pdf()
        {
            $data['anggota'] = $this->ModelUser->getUserWhere(['role_id => 2'])->result_array();
    
            $sroot = $_SERVER['DOCUMENT_ROOT'];
            include $sroot . "/pustaka-booking/application/third_party/dompdf/autoload.inc.php";
            $dompdf = new Dompdf\Dompdf();
            $this->load->view('member/laporan_anggota_pdf', $data);
    
            $paper_size = 'A4'; // ukuran kertas
            $orientation = 'landscape'; // tipe format kertas potrait atau landscape
            $html = $this->output->get_output();
            $dompdf->set_paper($paper_size, $orientation);
    
            // Convert to PDF
            $dompdf->load_html($html);
            $dompdf->render();
            $dompdf->stream("laporan_data_anggota.pdf", array('Attachment' => 0));
            // nama file pdf yang dihasilkan
        }

        public function export_excel_anggota()
        {
            $data['judul'] = 'Laporan Data Anggota';
            $data['anggota'] = $this->ModelUser->getUserWhere(['role_id => 2'])->result_array();
            $this->load->view('member/export_excel_anggota', $data);
        }
}