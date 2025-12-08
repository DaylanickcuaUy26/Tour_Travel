<?php
class UserController extends Controller {
    public function logout() {
        $_SESSION['login'] = '';
        session_unset();
        session_destroy();
        header('location:' . BASE_URL);
        exit;
    }

    public function profile() {
        if (strlen($_SESSION['login']) == 0) {
            header('location:' . BASE_URL);
            exit;
        }

        $userModel = $this->model('UserModel');
        $user = $userModel->getUserByEmail($_SESSION['login']);

        $data = [
            'user' => $user,
            'error' => $_SESSION['error'] ?? null,
            'msg' => $_SESSION['msg'] ?? null
        ];
        unset($_SESSION['error'], $_SESSION['msg']);

        $this->view('user/profile', $data);
    }

    public function updateProfile() {
        if (strlen($_SESSION['login']) == 0) {
            header('location:' . BASE_URL);
            exit;
        }

        if (isset($_POST['submit'])) {
            $name = $_POST['name'];
            $mobileno = $_POST['mobileno'];
            $email = $_SESSION['login'];

            $userModel = $this->model('UserModel');
            if ($userModel->updateUserProfile($email, $name, $mobileno)) {
                $_SESSION['msg'] = "Hồ sơ đã được cập nhật";
            } else {
                $_SESSION['error'] = "Có lỗi xảy ra. Vui lòng thử lại";
            }
        }
        header('location:' . BASE_URL . 'user/profile');
        exit;
    }

    public function changePassword() {
        if (strlen($_SESSION['login']) == 0) {
            header('location:' . BASE_URL);
            exit;
        }

        $data = [
            'error' => $_SESSION['error'] ?? null,
            'msg' => $_SESSION['msg'] ?? null
        ];
        unset($_SESSION['error'], $_SESSION['msg']);

        $this->view('user/change-password', $data);
    }

    public function updatePassword() {
        if (strlen($_SESSION['login']) == 0) {
            header('location:' . BASE_URL);
            exit;
        }

        if (isset($_POST['submit5'])) {
            $password = md5($_POST['password']);
            $newpassword = md5($_POST['newpassword']);
            $email = $_SESSION['login'];

            $userModel = $this->model('UserModel');

            if ($userModel->checkPassword($email, $password)) {
                if ($userModel->updatePassword($email, $newpassword)) {
                    $_SESSION['msg'] = "Cập nhật mật khẩu thành công";
                } else {
                    $_SESSION['error'] = "Có lỗi xảy ra. Vui lòng thử lại";
                }
            } else {
                $_SESSION['error'] = "Mật khẩu hiện tại không chính xác";
            }
        }
        header('location:' . BASE_URL . 'user/change-password');
        exit;
    }

    public function forgotPassword() {
        $data = [
            'error' => $_SESSION['error'] ?? null,
            'msg' => $_SESSION['msg'] ?? null
        ];
        unset($_SESSION['error'], $_SESSION['msg']);

        $this->view('user/forgot-password', $data);
    }

    public function resetPassword() {
        if (isset($_POST['submit'])) {
            $contact = $_POST['mobile'];
            $email = $_POST['email'];
            $newpassword = md5($_POST['newpassword']);

            $userModel = $this->model('UserModel');

            if ($userModel->checkUserByEmailAndMobile($email, $contact)) {
                if ($userModel->resetPassword($email, $contact, $newpassword)) {
                    $_SESSION['msg'] = "Đặt lại mật khẩu thành công";
                } else {
                    $_SESSION['error'] = "Có lỗi xảy ra. Vui lòng thử lại";
                }
            } else {
                $_SESSION['error'] = "Email hoặc số điện thoại không hợp lệ";
            }
        }
        header('location:' . BASE_URL . 'user/forgot-password');
        exit;
    }

    public function checkAvailability() {
        header('Content-Type: application/json');
        $response = ['available' => false, 'message' => ''];

        if (!empty($_POST["emailid"])) {
            $email = $_POST["emailid"];
            if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
                $response['message'] = "Lỗi: Bạn đã nhập email không hợp lệ.";
            } else {
                $userModel = $this->model('UserModel');
                if ($userModel->checkEmailAvailability($email)) {
                    $response['message'] = "Email đã tồn tại.";
                } else {
                    $response['available'] = true;
                    $response['message'] = "Email có thể được dùng để đăng ký.";
                }
            }
        }
        echo json_encode($response);
    }

    public function signup() {
        if (isset($_POST['submit'])) {
            $fname = $_POST['fname'];
            $mnumber = $_POST['mobilenumber'];
            $email = $_POST['email'];
            $password = md5($_POST['password']);

            $userModel = $this->model('UserModel');
            $lastInsertId = $userModel->createUser($fname, $mnumber, $email, $password);

            if ($lastInsertId) {
                $_SESSION['msg'] = "Bạn đã đăng ký thành công. Bây giờ bạn có thể đăng nhập.";
            } else {
                $_SESSION['msg'] = "Có lỗi xảy ra. Vui lòng thử lại.";
            }
            header('location:' . BASE_URL . 'thankyou');
            exit;
        }
        header('location:' . BASE_URL);
        exit;
    }

    public function login() {
        if (isset($_POST['signin'])) {
            $email = $_POST['email'];
            $password = md5($_POST['password']);

            $userModel = $this->model('UserModel');
            if ($userModel->checkPassword($email, $password)) {
                $_SESSION['login'] = $_POST['email'];
                header('location:' . BASE_URL . 'package');
                exit;
            } else {
                $_SESSION['error'] = "Thông tin không hợp lệ";
                header('location:' . BASE_URL);
                exit;
            }
        }
        header('location:' . BASE_URL);
        exit;
    }
}
