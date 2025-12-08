<?php
class IssueController extends Controller {
    public function index() {
        if (strlen($_SESSION['login']) == 0) {
            header('location:' . BASE_URL);
            exit;
        }

        $issueModel = $this->model('IssueModel');
        $issues = $issueModel->getIssuesByUserEmail($_SESSION['login']);

        $data = [
            'issues' => $issues,
            'error' => $_SESSION['error'] ?? null,
            'msg' => $_SESSION['msg'] ?? null
        ];
        unset($_SESSION['error'], $_SESSION['msg']);

        $this->view('issue/index', $data);
    }

    public function submit() {
        if (strlen($_SESSION['login']) == 0) {
            header('location:' . BASE_URL);
            exit;
        }

        if (isset($_POST['submit'])) {
            $issue = trim($_POST['issue']);
            $description = trim($_POST['description']);
            $email = $_SESSION['login'];

            if (!empty($issue) && !empty($description)) {
                $issueModel = $this->model('IssueModel');
                $lastInsertId = $issueModel->createIssue($email, $issue, $description);

                if ($lastInsertId) {
                    $_SESSION['msg'] = "Yêu cầu hỗ trợ của bạn đã được gửi. Chúng tôi sẽ phản hồi sớm nhất có thể.";
                } else {
                    $_SESSION['error'] = "Không thể lưu yêu cầu. Vui lòng thử lại.";
                }
            } else {
                $_SESSION['error'] = "Vui lòng điền đầy đủ thông tin.";
            }
        }
        header('location:' . BASE_URL . 'issue');
        exit;
    }
}
