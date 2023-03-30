<?php
class Test extends Controller{

    public $dethimodel;
    public $chitietde;
    public $ketquamodel;

    public function __construct()
    {
        $this->dethimodel = $this->model("DeThiModel");
        $this->chitietde = $this->model("ChiTietDeThiModel");
        $this->ketquamodel = $this->model("KetQuaModel");
        parent::__construct();
    }

    public function default()
    {
        $this->view("main_layout", [
            "Page" => "test",
            "Title" => "Đề kiểm tra",
            "Plugin" => [
                "notify" => 1
            ],
            "Script" => "test"
        ]);
    }

    public function add()
    {
        $this->view("main_layout", [
            "Page" => "add_update_test",
            "Title" => "Tạo đề kiểm tra",
            "Plugin" => [
                "datepicker" => 1,
                "flatpickr" => 1,
                "select" => 1,
                "notify" => 1
            ],
            "Script" => "action_test",
            "Action" => "create"
        ]);
    }

    public function update($made)
    {
        $this->view("main_layout", [
            "Page" => "add_update_test",
            "Title" => "Cập nhật đề kiểm tra",
            "Plugin" => [
                "datepicker" => 1,
                "flatpickr" => 1,
                "select" => 1,
                "notify" => 1
            ],
            "Script" => "action_test",
            "Action" => "update"
        ]);
    }

    public function start($made)
    {
        $this->view("main_layout",[
            "Page" => "vao_thi",
            "Title" => "Bắt đầu thi",
            "Test" => $this->dethimodel->getById($made),
            "Script" => "vaothi"
        ]);
    }

    public function detail($made)
    {
        $this->view("main_layout",[
            "Page" => "test_detail",
            "Title" => "Danh sách đã thi"
        ]);
    }

    public function select($made)
    {
        $check = $this->dethimodel->getById($made);
        if($check) {
            $this->view('main_layout',[
                "Page" => "select_question",
                "Title" => "Chọn câu hỏi",
                "Script" => "select_question",
                "Plugin" => [
                    "notify" => 1
                ],
            ]);
        } else {
            $this->view("single_layout", [
                "Page" => "error/page_404",
                "Title" => "Lỗi !"
            ]);
        }
    }

    public function taketest($made)
    {
        AuthCore::checkAuthentication();
        $user_id = $_SESSION['user_id'];
        $check = $this->ketquamodel->getMaKQ($made,$user_id);
        $infoTest = $this->dethimodel->getById($made);
        $now = new DateTime();
        $timestart = new DateTime($infoTest['thoigianbatdau']);
        $timeend = new DateTime($infoTest['thoigianketthuc']);
        if($check != '' && $now >= $timestart && $now <= $timeend) {
            $this->view("single_layout",[
                "Page" => "de_thi",
                "Title" => "Làm bài kiểm tra",
                "Made" => $made,
                "Script" => "de_thi",
                "Plugin" => [
                    "sweetalert2" => 1
                ]
            ]);
        } else {
            header("Location: ../start/$made");
        }
    }

    public function addTest()
    {
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            $mamonhoc = $_POST['mamonhoc'];
            $nguoitao = $_SESSION['user_id'];
            $tende = $_POST['tende'];
            $thoigianthi = $_POST['thoigianthi'];
            $thoigianbatdau = $_POST['thoigianbatdau'];
            $thoigianketthuc = $_POST['thoigianketthuc'];
            $socaude = $_POST['socaude'];
            $socautb = $_POST['socautb'];
            $socaukho = $_POST['socaukho'];
            $chuong = $_POST['chuong'];
            $loaide = $_POST['loaide'];
            $xemdiem = $_POST['xemdiem'];
            $xemdapan = $_POST['xemdapan'];
            $xembailam = $_POST['xembailam'];
            $daocauhoi = $_POST['daocauhoi'];
            $daodapan = $_POST['daodapan'];
            $tudongnop = $_POST['tudongnop'];
            $manhom = $_POST['manhom'];
            $result = $this->dethimodel->create($mamonhoc,$nguoitao,$tende,$thoigianthi,$thoigianbatdau,$thoigianketthuc,$xembailam,$xemdiem,$xemdapan,$daocauhoi,$daodapan, $tudongnop,$loaide,$socaude,$socautb,$socaukho,$chuong,$manhom);
            echo $result;
        }
    }

    public function updateTest()
    {
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            $made = $_POST['made'];
            $mamonhoc = $_POST['mamonhoc'];
            $tende = $_POST['tende'];
            $thoigianthi = $_POST['thoigianthi'];
            $thoigianbatdau = $_POST['thoigianbatdau'];
            $thoigianketthuc = $_POST['thoigianketthuc'];
            $socaude = $_POST['socaude'];
            $socautb = $_POST['socautb'];
            $socaukho = $_POST['socaukho'];
            $chuong = $_POST['chuong'];
            $loaide = $_POST['loaide'];
            $xemdiem = $_POST['xemdiem'];
            $xemdapan = $_POST['xemdapan'];
            $xembailam = $_POST['xembailam'];
            $daocauhoi = $_POST['daocauhoi'];
            $daodapan = $_POST['daodapan'];
            $tudongnop = $_POST['tudongnop'];
            $manhom = $_POST['manhom'];
            $result = $this->dethimodel->update($made,$mamonhoc,$tende,$thoigianthi,$thoigianbatdau,$thoigianketthuc,$xembailam,$xemdiem,$xemdapan,$daocauhoi,$daodapan, $tudongnop,$loaide,$socaude,$socautb,$socaukho,$chuong,$manhom);
            echo $result;
        }
    }

    public function getData()
    {
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            $user_id = $_SESSION['user_id'];
            $result = $this->dethimodel->getAll($user_id);
            echo json_encode($result);
        }
    }

    public function getDetail()
    {
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            $made = $_POST['made'];
            $result = $this->dethimodel->getById($made);
            echo json_encode($result);
        }
    }

    public function getTestGroup()
    {
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            $manhom = $_POST['manhom'];
            $result = $this->dethimodel->getListTestGroup($manhom);
            echo json_encode($result);
        }
    }

    public function addDetail()
    {
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            $made = $_POST['made'];
            $cauhoi = $_POST['cauhoi'];
            $result = $this->chitietde->createMultiple($made,$cauhoi);
            echo json_encode($result);
        }
    }

    public function getQuestion()
    {
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            $made = $_POST['made'];;
            $result = $this->dethimodel->getQuestionOfTest($made);
            echo json_encode($result);
        }
    }
}

?>