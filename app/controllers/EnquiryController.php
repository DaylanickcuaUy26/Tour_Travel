<?php
class EnquiryController extends Controller {
    public function index() {
        $data = [
            'error' => $_SESSION['error'] ?? null,
            'msg' => $_SESSION['msg'] ?? null
        ];
        unset($_SESSION['error'], $_SESSION['msg']);
        $this->view('enquiry/index', $data);
    }

    public function submit() {
        if (isset($_POST['submit1'])) {
            $fname = $_POST['fname'];
            $email = $_POST['email'];
            $mobile = $_POST['mobileno'];
            $subject = $_POST['subject'];
            $description = $_POST['description'];

            $enquiryModel = $this->model('EnquiryModel');
            $lastInsertId = $enquiryModel->createEnquiry($fname, $email, $mobile, $subject, $description);

            if ($lastInsertId) {
                $_SESSION['msg'] = "Bạn đã gửi yêu cầu thành công";
            } else {
                $_SESSION['error'] = "Có lỗi xảy ra. Vui lòng thử lại";
            }
        }
        header('location:' . BASE_URL . 'enquiry');
        exit;
    }
}
