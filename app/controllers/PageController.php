<?php
class PageController extends Controller {
    public function index($type = '') {
        $pageModel = $this->model('PageModel');
        $page = $pageModel->getPageByType($type);

        $titleMap = [
            'aboutus' => 'Giới thiệu',
            'privacy' => 'Chính sách bảo mật',
            'terms' => 'Điều khoản sử dụng',
            'contact' => 'Liên hệ',
        ];
        $titleText = $titleMap[$type] ?? ucfirst($type);

        $content = '';
        if ($page) {
            $content = $page->detail;
            $content = preg_replace('/<FONT[^>]*>/i', '', $content);
            $content = str_replace('</FONT>', '', $content);
            $content = preg_replace('/<P align=[^>]*>/i', '<p>', $content);
            $content = str_replace('</P>', '</p>', $content);
            $content = preg_replace('/<STRONG>/i', '<strong>', $content);
            $content = str_replace('</STRONG>', '</strong>', $content);
        }

        $data = [
            'title' => $titleText,
            'content' => $content,
        ];

        $this->view('page/index', $data);
    }
}
