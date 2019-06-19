<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;
use app\admin\controller\Admin;
use org\util\Pagination;
use org\util\Upload;

/**
 * @title 系统附件
 */
class SystemRes extends Admin {

    private $res_dir;
    private $res_http;
    private $ext_arr;
    private $file_size;

    function _initialize() {
        parent::_initialize();
        $this->res_dir = APP_DIR . '/uploads/';
        $this->res_http = APP_URL . '/uploads/';
        //设置默认的文件大小
        $this->file_size = trim(config("upload.ALLOW_FILE_SIZE"));
        if (!is_numeric($this->file_size)) {
            $this->file_size = 1024 * 1024;
        }
        $image_ext = str_replace(['，', ' '], [',', ','], trim(config('upload.ALLOW_IMAGE_EXT')));
        $flash_ext = str_replace(['，', ' '], [',', ','], trim(config('upload.ALLOW_FLASH_EXT')));
        $media_ext = str_replace(['，', ' '], [',', ','], trim(config('upload.ALLOW_MEDIA_EXT')));
        $file_ext = str_replace(['，', ' '], [',', ','], trim(config('upload.ALLOW_FILE_EXT')));
        //设置默认的文件格式
        if (empty($image_ext) && empty($flash_ext) && empty($media_ext) && empty($file_ext)) {
            $this->ext_arr = [
                'image' => ['gif', 'jpg', 'jpeg', 'png', 'bmp'],
                'flash' => ['swf', 'flv'],
                'media' => ['swf', 'flv', 'mp3', 'wav', 'wma', 'wmv', 'mid', 'mp4', 'rm', 'rmvb'],
                'file' => ['doc', 'docx', 'xls', 'xlsx', 'ppt', 'txt', 'zip', 'rar', 'gz', 'bz2'],
            ];
        } else {
            $this->ext_arr = [
                'image' => explode(',', $image_ext),
                'flash' => explode(',', $flash_ext),
                'media' => explode(',', $media_ext),
                'file' => explode(',', $file_ext),
            ];
        }
        $this->assign('file_size', $this->file_size);
        $this->assign('ext_arr', $this->ext_arr);
    }
    

    /**
     * @title 列表
     */
    public function index() {
        $category = input('get.category', 'image');
        $category = empty($category) ? 'image' : $category;
        $this->_get_list($category);
        $this->assign('category', $category);
        return $this->fetch();
    }

    /**
     * @title 上传
     */
    public function index_upload() {
        $autoname = input('get.autoname', 1);
        $folder_this = input('get.category', 'image');
        $this->assign('category', $folder_this);
        $directory = input('get.directory');
        // Make sure we have the correct directory
        if ($directory) {
            $directory = rtrim($this->res_dir . $folder_this . '/' . str_replace(['../', '..\\', '..'], '', $directory), '/');
        } else {
            $directory = $this->res_dir . $folder_this;
        }
        $files = request()->file('files');
        if ($files) {
            $count = 0;
            foreach ($files as $file) {
                $file_info = $file->getInfo();
                if (!$autoname) {
                    if (preg_match('/[\x{4e00}-\x{9fa5}]/u', $file_info["name"]) > 0) {
                        $count ++;
                        continue;
                    }
                }
                // 移动到框架应用根目录/public/uploads/ 目录下
                if ($file) {
                    if ($autoname) {
                        $info = $file->validate(['size' => $this->file_size, 'ext' => $this->ext_arr[$folder_this]])->rule('uniqid')->move($directory);
                    } else {
                        $info = $file->validate(['size' => $this->file_size, 'ext' => $this->ext_arr[$folder_this]])->move($directory, '');
                    }
                    if ($file->getError()) {
                        $this->error($file->getError());
                    }
                }
            }
            if ($count) {
                $this->success('忽略了 ' . $count . ' 个文件');
            } else {
                $this->success('');
            }
        } else {
            $this->error('没有上传任何文件');
        }
        //调用THINKPHP的上传组件 结束
    }

    /**
     * @title 删除
     */
    public function index_delete() {
        $folder = input('get.category', 'image');
        $this->assign('category', $folder);
        //删除照片的照片，同样要把缓存cache文件夹的所有文件也要一并删除
        $paths = input('post.path/a');
        if (empty($paths)) {
            $this->error('没有选择任何文件');
        }
        // Loop through each path
        foreach ($paths as $path) {
            $path = rtrim($this->res_dir . str_replace(['../', '..\\', '..'], '', $path), '/');
            //用于支持删除中文文件
            $path = mb_convert_encoding($path, 'GB2312', 'UTF-8');
            // If path is just a file delete it
            if (is_file($path)) {
                unlink($path);
                $this->_delete_subfile($path, $folder);
                // If path is a directory beging deleting each file and sub folder
            } elseif (is_dir($path)) {
                $files = [];
                // Make path into an array
                $path = [$path . '*'];
                // While the path array is still populated keep looping through
                while (count($path) != 0) {
                    $next = array_shift($path);
                    foreach (glob($next) as $file) {
                        // If directory add to path array
                        if (is_dir($file)) {
                            $path[] = $file . '/*';
                        }
                        // Add the file to the files to be deleted array
                        $files[] = $file;
                    }
                }
                // Reverse sort the file array
                rsort($files);
                foreach ($files as $file) {
                    // If file just delete
                    if (is_file($file)) {
                        unlink($file);
                        $this->_delete_subfile($file, $folder);
                        // If directory use the remove directory 
                    } elseif (is_dir($file)) {
                        rmdir($file);
                    }
                }
            }
        }
        $this->success('删除完成');
    }

    /**
     * @title 文件夹
     */
    public function index_folder() {
        $folder_this = input('get.category', 'image');
        $this->assign('category', $folder_this);
        $directory = input('get.directory');
        $folder = input('post.folder');
        if (empty($folder)) {
            $this->error('文件夹名称为空');
        } else {
            // Make sure we have the correct directory
            if ($directory) {
                $directory = rtrim($this->res_dir . $folder_this . '/' . str_replace(['../', '..\\', '..'], '', $directory), '/');
            } else {
                $directory = $this->res_dir . $folder_this;
            }
            // Check its a directory
            if (!is_dir($directory)) {
                mkdir($directory, '0777');
            }
            // Sanitize the folder name
            $folder = str_replace(['../', '..\\', '..'], '', preg_replace('/^.+[\\\\\\/]/', '', html_entity_decode($folder)));
            // Validate the filename length
            if ((mb_strlen($folder) < 1) || (mb_strlen($folder) > 128)) {
                $this->error('文件夹名称不符合要求');
            }
            // Check if directory already exists or not
            if (is_dir($directory . '/' . $folder)) {
                $this->error('文件夹已存在');
            }
            $encode = mb_detect_encoding($folder, ["ASCII", 'UTF-8', "GB2312", "GBK", 'BIG5']);
            $folder = mb_convert_encoding($folder, 'GB2312', $encode);
            //$folder
            mkdir($directory . '/' . $folder, 0777);
            $this->success('创建完成');
        }
    }

    /**
     * @title 按页加载目录
     */
    public function _get_list($folder = 'image', $action = '') {
        empty($action) && $action = 'index';
        $data['category'] = $folder;
        $filter = implode(',', $this->ext_arr[$folder]);
        $filter_name = input('get.filter_name', '');
        if ($filter_name) {
            $filter_name = rtrim(str_replace(['../', '..\\', '..', '*'], '', input('get.filter_name')), '/');
        }
        // Make sure we have the correct directory
        if (isset($_GET['directory'])) {
            $directory = rtrim($this->res_dir . $folder . '/' . str_replace(['../', '..\\', '..'], '', $_GET['directory']), '/');
        } else {
            $directory = $this->res_dir . $folder;
        }
        // page
        $data['page'] = input('param.page', 1);
        $data['images'] = [];
        // Get directories
        $directories = glob($directory . '/*' . $filter_name . '*', GLOB_ONLYDIR);
        if (!$directories) {
            $directories = [];
        }
        // Get files
        $files = glob($directory . '/*' . $filter_name . '*.{' . $filter . '}', GLOB_BRACE);
        arsort($files);
        if (!$files) {
            $files = [];
        }
        // Merge directories and files
        $images = array_merge($directories, $files);
        // Get total number of files and directories
        $image_total = count($images);
        // Split the array based on current page number and max number of items per page of 10
        $images = array_splice($images, ($data['page'] - 1) * 18, 18);
        foreach ($images as $image) {
            
            $name = str_split(preg_replace('/^.+[\\\\\\/]/', '', $image), 255);
            if (is_dir($image)) {
                $url = '';
                $tmp = filemtime($image);
                $time = date('Y-m-d H:i:s', $tmp);
                //$name
                $encode = mb_detect_encoding($image, ["ASCII", 'UTF-8', "GB2312", "GBK", 'BIG5']);
                $name = mb_convert_encoding($name[0], 'UTF-8', $encode);
                $image = mb_convert_encoding($image, 'UTF-8', $encode);
                $data['images'][] = array(
                    'time' => $time,
                    'thumb' => '',
                    'name' => $name,
                    'category' => 'directory',
                    'path' => mb_substr($image, mb_strlen($this->res_dir)),
                    'href' => url($action) . '?category=' . $folder . '&hidden=' . input('get.hidden', '') . '&thumb=' . input('get.thumb', '') . '&directory=' . mb_substr($image, mb_strlen($this->res_dir . $folder . '/'))
                );
            } elseif (is_file($image)) {
                // Find which protocol to use to pass the full image link back
                $server = $this->res_http;
                if ($folder == 'image') {
                    $thumb = img_resize(mb_substr($image, mb_strlen($this->res_dir)), 200, 0);
                } else {
                    $thumb = '<i class="fa fa-file fa-5x"></i>';
                }
                $tmp = filemtime($image);
                $time = date('Y-m-d H:i:s', $tmp);
                $tmp_size = filesize($image);
                $size = format_bytes($tmp_size);
                $encode = mb_detect_encoding($image, ["ASCII", 'UTF-8', "GB2312", "GBK", 'BIG5']);
                $name = mb_convert_encoding($name[0], 'UTF-8', $encode);
                $image = mb_convert_encoding($image, 'UTF-8', $encode);
                $thumb = mb_convert_encoding($thumb, 'UTF-8', $encode);
                $data['images'][] = array(
                    'time' => $time,
                    'size' => $size,
                    'thumb' => $thumb,
                    'name' => $name,
                    'category' => 'image',
                    'path' => mb_substr($image, mb_strlen($this->res_dir)),
                    'href' => $server . '' . mb_substr($image, mb_strlen($this->res_dir))
                );
            }
        }
        //用于搜索
        $data['filter_name'] = $filter_name;
        //用于文件夹
        $data['directory'] = input('get.directory', '', 'urldecode');
        // Return the hidden ID for the file manager to set the value
        $data['hidden'] = input('get.hidden', '');
        // Return the thumb for the file manager to show a thumb
        $data['thumb'] = input('get.thumb', '');
        // Parent
        $url = '';
        $directory = '';
        if (isset($_GET['directory'])) {
            $pos = strrpos($_GET['directory'], '/');
            if ($pos) {
                $directory = substr($_GET['directory'], 0, $pos);
            }
        }
        $data['parent'] = url($action) . '?category=' . input('get.category', '') . '&hidden=' . input('get.hidden', '') . '&thumb=' . input('get.thumb', '') . '&directory=' . $directory;
        // Refresh
        $url = '';
        //用于页面刷新
        $data['refresh'] = url($action) . '?hidden=' . input('get.hidden', '') . '&thumb=' . input('get.thumb', '') . '&directory=' . $data['directory'];
        $url = '';
        if (isset($_GET['directory'])) {
            $url .= '&directory=' . html_entity_decode($_GET['directory'], ENT_QUOTES, 'UTF-8');
        }
        if ($filter_name) {
            $url .= '&filter_name=' . html_entity_decode($filter_name, ENT_QUOTES, 'UTF-8');
        }
        // print_r($data);exit;
        $pagination = new Pagination();
        $pagination->total = $image_total;
        $pagination->page = $data['page'];
        $pagination->limit = 18;
        $pagination->url = url($action, ['page' => '{page}', 'filter_name'=>$data['filter_name'], 'hidden' => $data['hidden'], 'thumb' => $data['thumb'], 'directory' => $data['directory']]);
        $this->assign('pagination', $pagination->render());
        $this->assign('folder', $folder);
        $this->assign('data', $data);
    }

    //delete cache images
    function _delete_subfile($file, $folder) {
        $cache_path = str_replace(strrchr($file, '.'), '', $file);
        $cache_ext = strrchr($file, '.');
        $cache_path = str_replace($folder . '/', 'cache/' . $folder . '/', $cache_path);
        $cache_files_array = glob('' . $cache_path . '-*' . $cache_ext . '');
        foreach ($cache_files_array as $cache_file) {
            $cache_file = mb_convert_encoding($cache_file, 'GB2312', 'UTF-8');
            unlink($cache_file);
        }
    }

    /**
     * @title 循环删除目录和文件函数
     * @param type $dirName
     */
    function _del_dir_and_file($dirName) {
        if ($handle = opendir("$dirName")) {
            while (false !== ( $item = readdir($handle) )) {
                if ($item != "." && $item != "..") {
                    if (is_dir("$dirName/$item")) {
                        $this->_del_dir_and_file("$dirName/$item");
                    } else {
                        if (!unlink("$dirName/$item"))
                            return "删除文件： $dirName/$item 失败\n";
                    }
                }
            }
            closedir($handle);
            if (!rmdir($dirName))
                return "删除目录： $dirName 失败\n";
        }
    }

    /**
     * @title 循环目录下的所有文件但保留目录
     * @param type $dirName
     */
    function _del_file_under_dir($dirName = "") {
        if ($handle = opendir("$dirName")) {
            while (false !== ( $item = readdir($handle) )) {
                if ($item != "." && $item != "..") {
                    if (is_dir("$dirName/$item")) {
                        $this->_del_file_under_dir("$dirName/$item");
                    } else {
                        if (!unlink("$dirName/$item"))
                            return "删除文件： $dirName/$item 失败\n";
                    }
                }
            }
            closedir($handle);
        }
    }

    /**
     * @title 清理CACHE
     */
    public function clear() {
        $cache_files_array = glob($this->res_dir . 'cache/*');
        foreach ($cache_files_array as $cache_file) {
            $this->_del_dir_and_file($cache_file);
        }
        $this->success('清理完成');
    }

}
